<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\ShareMyPageController;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Pages\ShareMyPage
 *
 */
/**
 * Class \Firesphere\JobHunt\Pages\ShareMyPage
 *
 */
class ShareMyPage extends KanbanPage
{
    private static $controller_name = ShareMyPageController::class;

    public static function my_share_link()
    {
        $user = Security::getCurrentUser();
        if (!$user->ShareKey) {
            $user->onBeforeWrite();
            $user->write();
        }
        return self::get()->first()->AbsoluteLink('board/' . $user->ShareKey);
    }
}
