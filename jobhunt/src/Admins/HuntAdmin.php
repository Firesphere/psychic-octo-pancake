<?php

namespace Firesphere\JobHunt\Admins;

use Firesphere\JobHunt\Models\Company;
use Firesphere\JobHunt\Models\CompanyNoteType;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Models\Tag;
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
        Tag::class,
        CompanyNoteType::class,
    ];
}
