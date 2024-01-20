<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\JobHunt\Models\Tag
 *
 * @property string $Title
 * @method ManyManyList|JobApplication[] Applications()
 */
class Tag extends DataObject
{
    private static $table_name = 'Tag';

    private static $db = [
        'Title' => DBVarchar::class
    ];

    private static $belongs_many_many = [
        'Applications' => JobApplication::class,
    ];
}
