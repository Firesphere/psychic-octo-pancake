<?php

namespace Firesphere\JobHunt\Controllers;

use DateTime;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Pages\CalendarPage;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Security\Security;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\CalendarPageController
 *
 * @property CalendarPage $dataRecord
 * @method CalendarPage data()
 * @mixin CalendarPage
 */
class CalendarPageController extends \PageController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        Requirements::css('_resources/themes/jobhunt/dist/css/calendar.css');
        $this->Month = date('F');
        $this->Year = date('Y');
    }

    public function getDays()
    {
        $list = ArrayList::create();
        $i = -2;
        while ($i <= 5) {
            $m = date('m', strtotime($i . ' months'));
            $y = date('Y', strtotime($i . ' months'));
            $data = ArrayData::create([
                'Year'  => $y,
                'Month' => date('F', strtotime('01-' . $m . '-2020')),
                'Cal'   => $this->getCalendarForMonth($m, $y)
            ]);
            $list->push($data);
            $i++;
        }

        return $list;
    }

    public function getCalendarForMonth($month, $year)
    {
        $user = Security::getCurrentUser();
        $list = ArrayList::create();
        $filterDate = date($year . '-' . $month . '-');

        $date = new DateTime(sprintf('%s-%s-01', $year, $month));
        $firstDayOfMonth = $date->format('N');
        $date->modify('last day of this month');
        $lastDayOfMonth = $date->format('d');
        $i = 1;

        while ($i < $firstDayOfMonth) {
            $list->push(
                ArrayData::create(['Empty' => true])
            );
            $i++;
        }
        $i = 1;
        while ($i <= $lastDayOfMonth) {
            $data = ['Day' => $i];
            if ((int)date('j') === $i && (int)date('n') === (int)$month) {
                $data['Today'] = true;
            }
            $todayFilter = $filterDate . str_pad($i, 2, '0', STR_PAD_LEFT);
            $data['Interviews'] = Interview::get()->filter([
                'Application.UserID'   => $user->ID,
                'Application.Archived' => false,
                'DateTime:StartsWith'  => $todayFilter
            ]);
            $list->push(ArrayData::create($data));
            $i++;
        }

        return $list;
    }
}
