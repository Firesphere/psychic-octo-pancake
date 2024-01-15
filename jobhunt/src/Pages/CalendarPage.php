<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\CalendarPageController;

/**
 * Class \Firesphere\JobHunt\Pages\CalendarPage
 *
 */
class CalendarPage extends \Page
{
    private static $table_name = 'CalendarPage';

    private static $controller_name = CalendarPageController::class;

    private static $defaults = [
        'CanViewType' => 'LoggedInUsers'
    ];
}
