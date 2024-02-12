<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\CompanyPageController;

/**
 * Class \Firesphere\JobHunt\Pages\CompanyPage
 *
 */
class CompanyPage extends \Page
{
    private static $table_name = 'CompanyPage';
    private static $controller_name = CompanyPageController::class;
    private static $defaults = [
        'CanViewType' => 'LoggedInUsers'
    ];

}
