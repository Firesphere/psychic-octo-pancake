<?php

namespace Firesphere\JobHunt\Admins;

use Firesphere\JobHunt\Models\Company;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\InterviewQuestion;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Models\StatusUpdate;
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
        Company::class,
    ];
}
