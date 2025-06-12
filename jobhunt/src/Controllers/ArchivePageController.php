<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Pages\ApplicationPage;
use Firesphere\JobHunt\Pages\ArchivePage;

/**
 * Class \Firesphere\JobHunt\Controllers\ArchivePageController
 *
 * @property ArchivePage $dataRecord
 * @method ArchivePage data()
 * @mixin ArchivePage
 */
class ArchivePageController extends ApplicationPageController
{

    public function init()
    {
        $this->HasShowAll = true;
        parent::init();
    }
}
