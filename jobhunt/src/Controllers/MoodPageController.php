<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Pages\MoodPage;
use SilverStripe\Security\Security;
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
    private static $allowed_actions = [
        'getChartData' => '->isLoggedIn()'
    ];

    public function init()
    {
        parent::init();
        Requirements::javascript('_resources/themes/jobhunt/dist/js/charts.js');
    }

    public function getChartData()
    {
        $data = $this->dataRecord->moods();

        return json_encode([
            'labels' => array_keys($data),
            'values' => array_values($data)
        ], JSON_THROW_ON_ERROR);
    }

    protected function isLoggedIn()
    {
        return Security::getCurrentUser() !== null;
    }
}
