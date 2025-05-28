<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Pages\KanbanPage;
use Firesphere\JobHunt\Pages\ShareMyPage;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\ShareMyPageController
 *
 * @property ShareMyPage $dataRecord
 * @method ShareMyPage data()
 * @mixin ShareMyPage
 */
/**
 * Class \Firesphere\JobHunt\Controllers\ShareMyPageController
 *
 * @property ShareMyPage $dataRecord
 * @method ShareMyPage data()
 * @mixin ShareMyPage
 */
class ShareMyPageController extends KanbanPageController
{
    private static $allowed_actions = [
        'board'
    ];
    protected $IsSharePage = true;

    public function init()
    {
        $params = $this->getURLParams();
        if (!$params['Action'] || !$params['ID']) {
            $this->redirect('/');
        }
        \PageController::init();
        Requirements::block('_resources/themes/jobhunt/dist/js/kanban.js');
        if (Security::getCurrentUser()) {
            $this->redirect(KanbanPage::get()->first()->getAbsoluteLiveLink());
        }
        $member = $this->CurrentUser();
        if (!$member) {
            return $this->redirect('/');
        }
        $firstName = Security::getCurrentUser()->FirstName;
        $this->dataRecord->Title = "Shared kanboard view for $firstName";
        return $this;
    }

    public function CurrentUser()
    {
        $shareKey = $this->getURLParams()['ID'];
        if (!Security::getCurrentUser()) {
            $viewMember = Member::get()->filter(['ShareKey' => $shareKey])->first();
            Security::setCurrentUser($viewMember);
        }

        return Security::getCurrentUser();
    }

    public function board()
    {
        return $this;
    }
}
