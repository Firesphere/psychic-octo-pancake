<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\ManyManyList;

/**
 * Class \Firesphere\JobHunt\Models\ApplicationInterview
 *
 * @property string $DateTime
 * @property int $Duration
 * @property int $ApplicationID
 * @method JobApplication Application()
 * @method DataList|InterviewNote[] Notes()
 * @method ManyManyList|Interviewer[] Interviewers()
 */
class Interview extends DataObject
{
    private static $table_name = 'Interview';

    private static $db = [
        'DateTime' => DBDatetime::class,
        'Duration' => DBInt::class
    ];

    private static $has_one = [
        'Application' => JobApplication::class,
    ];

    private static $many_many = [
        'Interviewers' => Interviewer::class,
    ];
    private static $has_many = [
        'Notes' => InterviewNote::class
    ];

}
