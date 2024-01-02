<?php

namespace Firesphere\JobHunt\Controllers;

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
        Requirements::javascript('//cdn.jsdelivr.net/npm/chart.js');
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
