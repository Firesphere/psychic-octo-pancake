<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Pages\SankeyPage;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Controllers\SankeyPageController
 *
 * @property SankeyPage $dataRecord
 * @method SankeyPage data()
 * @mixin SankeyPage
 */
class SankeyPageController extends MoodPageController
{
    private static $allowed_actions = [
        'getChartData'
    ];
    public function getChartData()
    {
        $data = $this->dataRecord->sankeyFlow();

        return json_encode($data, JSON_THROW_ON_ERROR);
    }
}
