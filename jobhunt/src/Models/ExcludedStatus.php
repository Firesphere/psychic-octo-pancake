<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Models\ExcludedStatus
 *
 * @property int $UserID
 * @property int $StatusID
 * @method Member User()
 * @method Status Status()
 */
class ExcludedStatus extends DataObject
{

    private static $table_name = 'ExcludedStatus';

    private static $has_one = [
        'User'   => Member::class,
        'Status' => Status::class,
    ];
}
