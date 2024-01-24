<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\KanbanPageController;
use Firesphere\JobHunt\Controllers\MoodPageController;
use IntlDateFormatter;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Pages\KanbanPage
 *
 */
class KanbanPage extends \Page
{
    private static $table_name = 'KanbanPage';
    private static $controller_name = KanbanPageController::class;
    private static $defaults = [
        'CanViewType' => 'LoggedInUsers'
    ];

}
