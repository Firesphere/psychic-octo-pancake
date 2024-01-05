<?php

namespace Firesphere\JobHunt\Controllers;

use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\SankeyPageController
 *
 * @property SankeyPage $dataRecord
 * @method SankeyPage data()
 * @mixin SankeyPage
 */
class SankeyPageController extends \PageController
{
    private static $allowed_actions = [
        'getChartData' => '->isLoggedIn()'
    ];

    public function init()
    {
        Requirements::javascript('_resources/themes/jobhunt/dist/js/charts.js');
        parent::init();
    }

    public function getChartData()
    {
        $data = $this->dataRecord->sankeyFlow();

        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    protected function isLoggedIn()
    {
        return Security::getCurrentUser() !== null;
    }

}
