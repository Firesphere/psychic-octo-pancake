<?php

namespace Firesphere\Notebook\Pages;

use Firesphere\Notebook\Controllers\NotebookPageController;

/**
 * Class \Firesphere\Notebook\Pages\NotebookPage
 *
 */
class NotebookPage extends \Page
{
    private static $table_name = 'NotebookPage';

    private static $controller_name = NotebookPageController::class;
    private static $defaults = [
        'CanViewType' => 'LoggedInUsers'
    ];

    public function onBeforeWrite()
    {
        $this->CanViewType = 'LoggedInUsers';
        parent::onBeforeWrite();
    }
}
