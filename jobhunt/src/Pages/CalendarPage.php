<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\ICal\Extensions\MemberExtension;
use Firesphere\ICal\Services\UUIDService;
use Firesphere\JobHunt\Controllers\CalendarPageController;
use SilverStripe\Control\Director;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Pages\CalendarPage
 *
 */
class CalendarPage extends \Page
{
    private static $table_name = 'CalendarPage';

    private static $controller_name = CalendarPageController::class;

    private static $defaults = [
        'CanViewType' => 'LoggedInUsers'
    ];

    public function getCalendarLink()
    {
        /** @var Member|MemberExtension $user */
        $user = Security::getCurrentUser();
        $uuid = UUIDService::create($user)->generateForMember(false);
        return Director::absoluteURL(sprintf('ical/calendar/%s', $uuid));
    }
}
