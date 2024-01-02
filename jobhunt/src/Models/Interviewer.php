<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\ORM\ManyManyList;

/**
 * Class \Firesphere\JobHunt\Models\Interviewers
 *
 * @property string $Name
 * @property string $Email
 * @property string $Role
 * @property int $CompanyID
 * @method Company Company()
 * @method ManyManyList|Interview[] Interviews()
 */
class Interviewer extends DataObject
{
    private static $table_name = 'Interviewer';

    private static $db = [
        'Name'  => DBVarchar::class,
        'Email' => DBVarchar::class,
        'Role'  => DBVarchar::class
    ];

    private static $has_one = [
        'Company' => Company::class
    ];

    private static $belongs_many_many = [
        'Interviews' => Interview::class . '.Interviewers'
    ];

}
