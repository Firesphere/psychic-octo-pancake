<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\ArchivePageController;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Pages\ArchivePage
 *
 */
class ArchivePage extends ApplicationPage
{

    private static $table_name = 'ArchivePage';

    private static $controller_name = ArchivePageController::class;

    public function getApplications($archived = true)
    {
        return parent::getApplications(true);
    }
}
