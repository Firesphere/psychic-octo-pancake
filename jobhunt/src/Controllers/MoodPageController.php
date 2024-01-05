<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Pages\MoodPage;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\MoodPageController
 *
 * @property MoodPage $dataRecord
 * @method MoodPage data()
 * @mixin MoodPage
 */
class MoodPageController extends \PageController
{

    public function init()
    {
        Requirements::javascript('_resources/themes/jobhunt/dist/js/charts.js');
        $js = $this->getChartScript();
        Requirements::insertHeadTags("<script type='text/javascript'>window.chart = $js</script>");
        parent::init();
    }

    private function getChartScript()
    {
        $data = $this->dataRecord->moods();

        return json_encode([
            'labels' => array_keys($data),
            'values' => array_values($data)
        ], JSON_THROW_ON_ERROR);
    }
}
