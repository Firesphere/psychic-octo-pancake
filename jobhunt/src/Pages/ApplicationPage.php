<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\ApplicationPageController;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\Security\Security;

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
