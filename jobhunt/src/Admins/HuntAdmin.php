<?php

namespace Firesphere\JobHunt\Admins;

use Firesphere\JobHunt\Models\InterviewQuestion;
use Firesphere\JobHunt\Models\Status;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class \Firesphere\JobHunt\Admins\HuntAdmin
 *
 */
class HuntAdmin extends ModelAdmin
{
    private static $url_segment = 'jobhuntadmin';

    private static $menu_title = 'Job hunt';

    private static $managed_models = [
        Status::class,
        InterviewQuestion::class
    ];
}
