<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\ShareMyPageController;
use Page;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Pages\ShareMyPage
 *
 */
class ShareMyPage extends Page
{
    private static $controller_name = ShareMyPageController::class;

    public static function my_share_link($type = 'board')
    {
        $user = Security::getCurrentUser();
        if (!$user->ShareKey) {
            $user->onBeforeWrite();
            $user->write();
        }
        return self::get()->first()->AbsoluteLink(sprintf('%s/%s', $type, $user->ShareKey));
    }
}
