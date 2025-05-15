<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Pages\HomePage;
use Firesphere\JobHunt\Pages\MoodPage;
use Firesphere\JobHunt\Pages\ChartPage;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\Security\Security;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\HomePageController
 *
 * @property HomePage $dataRecord
 * @method HomePage data()
 * @mixin HomePage
 */
class HomePageController extends \PageController
{
    private static $allowed_actions = [
        'getDoughnut',
        'getSankey',
        'getMood'
    ];
    protected $CurrentMonth;

    public function getDoughnut()
    {
        if (!Security::getCurrentUser()) {
            $this->httpError(403);

            return;
        }

        /** @var DataList|Status[] $colours */
        $stats = Status::get();
        $colours = Status::set_colour_map();
        $colour = [];
        $statusCount = Security::getCurrentUser()->getStatusNumbers();
        foreach ($statusCount as $stat => $count) {
            $status = $stats->filter(['Status' => $stat])->first();
            $colour[] = $colours[$status->getColourStyle()];
        }
        unset($colour['link']);

        $response = $this->getResponse();
        $response->addHeader('content-type', 'application/json');

        $response->setBody(json_encode([
            'data'            => array_values($statusCount),
            'labels'          => array_keys($statusCount),
            'backgroundColor' => $colour,
            'hoverOffset'     => 4,
        ], JSON_THROW_ON_ERROR));

        return $response;
    }

    public function getSankey()
    {
        $sankey = ChartPage::singleton();
        $data = $sankey->sankeyFlow();
        $response = $this->getResponse();
        $response->addHeader('content-type', 'application/json');

        $response->setBody(json_encode($data));

        return $response;
    }

    public function getMood()
    {
        $mood = MoodPage::singleton();
        $data = $mood->moods();
        $response = $this->getResponse();
        $response->addHeader('content-type', 'application/json');

        $response->setBody(json_encode($data));

        return $response;
    }

    protected function init()
    {
        if (Security::getCurrentUser()) {
            Requirements::javascript('_resources/themes/jobhunt/dist/js/dashboard.js');
            Requirements::javascript('_resources/themes/jobhunt/dist/js/charts.js');
            Requirements::css('_resources/themes/jobhunt/dist/css/calendar.css');
            $this->CurrentMonth = $this->getMonth();
        }
        parent::init();
    }

    public function getMonth()
    {
        $list = ArrayList::create();
        $page = CalendarPageController::singleton();
        $m = date('m');
        $y = date('Y');
        $data = ArrayData::create([
            'Year'  => $y,
            'Month' => date('F', strtotime('01-' . $m . '-2020')),
            'Cal'   => $page->getCalendarForMonth($m, $y)
        ]);
        $list->push($data);

        return $list;
    }
}
