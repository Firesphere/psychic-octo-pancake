<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Models\StateOfMind
 *
 * @property string $Mood
 * @property int $UserID
 * @method Member User()
 */
class StateOfMind extends DataObject
{

    private static $table_name = 'StateOfMind';

    private static $db = [
        'Mood' => DBEnum::class . '("Bad,Down,Neutral,Good,Happy","Neutral")'
    ];

    private static $has_one = [
        'User' => Member::class,
    ];
}
