<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\ApplicationPageController;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Pages\ApplicationPage
 *
 */
class ApplicationPage extends \Page
{
    private static $controller_name = ApplicationPageController::class;

    private static $defaults = [
        'CanViewType' => 'LoggedInUsers'
    ];

    public function getApplications()
    {
        return Security::getCurrentUser()->JobApplications();
    }

    public function onBeforeWrite()
    {
        $this->CanViewType = 'LoggedInUsers';
        parent::onBeforeWrite();
    }

}
