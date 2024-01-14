<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\ApplicationPageController;

/**
 * Class \Firesphere\JobHunt\Pages\ApplicationPage
 *
 */
class ApplicationPage extends \Page
{
    private static $table_name = 'ApplicationPage';
    private static $controller_name = ApplicationPageController::class;

    private static $defaults = [
        'CanViewType' => 'LoggedInUsers'
    ];

    public function onBeforeWrite()
    {
        $this->CanViewType = 'LoggedInUsers';
        parent::onBeforeWrite();
    }
}
