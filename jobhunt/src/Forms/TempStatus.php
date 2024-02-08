<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\Status;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Security\Member;

class TempStatus extends Status
{

    private static $table_name = 'TempStatus';

    private static $db = [
        'Name' => DBVarchar::class,
    ];

    private static $has_one = [
        'User' => Member::class,
    ];
}
