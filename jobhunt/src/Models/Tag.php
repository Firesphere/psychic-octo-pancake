<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Models\Tag
 *
 * @property string $Title
 * @property int $UserID
 * @method Member User()
 * @method ManyManyList|JobApplication[] Applications()
 */
class Tag extends DataObject
{
    private static $table_name = 'Tag';

    private static $db = [
        'Title' => DBVarchar::class
    ];

    private static $has_one = [
        'User' => Member::class,
    ];

    private static $belongs_many_many = [
        'Applications' => JobApplication::class . '.Tags',
    ];
}
