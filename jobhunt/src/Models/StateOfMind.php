<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Models\StateOfMind
 *
 * @property int $Mood
 * @property int $UserID
 * @method Member User()
 */
class StateOfMind extends DataObject
{

    private static $table_name = 'StateOfMind';

    private static $db = [
        'Mood' => DBInt::class
    ];

    private static $has_one = [
        'User' => Member::class,
    ];
}
