<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\KanbanPageController;

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

    protected $IsFluid = true;

    public function getShareLink()
    {
        return ShareMyPage::my_share_link();
    }

}
