<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\JobHunt\Models\Company
 *
 * @property string $Name
 * @property string $Address
 * @property string $Country
 * @property string $Email
 * @property string $Link
 * @method DataList|JobApplication[] Jobs()
 * @method DataList|Interviewer[] Employees()
 */
class Company extends DataObject
{
    private static $table_name = 'Company';

    private static $db = [
        'Name'    => DBVarchar::class,
        'Address' => DBText::class,
        'Country' => DBVarchar::class,
        'Email'   => DBVarchar::class,
        'Link'    => DBVarchar::class,
    ];

    private static $has_many = [
        'Jobs'      => JobApplication::class . '.Company',
        'Employees' => Interviewer::class . '.Company'
    ];

    private static $cascade_deletes = [
        'Employees'
    ];

    public static function findOrCreate($name)
    {
        $exists = self::get()->filter(['Name' => $name])->first();

        if ($exists) {
            return $exists->ID;
        }

        return self::create(['Name' => $name])->write();
    }
}
