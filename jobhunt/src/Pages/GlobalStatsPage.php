<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\GlobalStatsPageController;

/**
 * Class \Firesphere\JobHunt\Pages\GlobalStatsPage
 *
 */
class GlobalStatsPage extends \Page
{
    private static $table_name = 'GlobalStatsPage';

    private static $controller_name = GlobalStatsPageController::class;
}
