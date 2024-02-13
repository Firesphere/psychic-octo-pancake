<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Pages\KanbanPage;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\KanbanPageController
 *
 * @property KanbanPage $dataRecord
 * @method KanbanPage data()
 * @mixin KanbanPage
 */
class KanbanPageController extends \PageController
{
    private static $allowed_actions = [
        'update'
    ];

    public function init()
    {
        if (!Security::getCurrentUser()) {
            $this->httpError(403);
        }
        parent::init();
        Requirements::javascript('_resources/themes/jobhunt/dist/js/kanban.js');
    }
}
