<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Models\InterviewPreparation
 *
 * @property int $UserID
 * @method Member User()
 * @method Interview Interview()
 * @method DataList|QuestionAnswer[] QuestionAnswers()
 */
class InterviewPreparation extends DataObject
{

    private static $table_name = 'InterviewPreparation';

    private static $db = [
    ];

    private static $belongs_to = [
        'Interview' => Interview::class
    ];

    private static $has_one = [
        'User' => Member::class,
    ];

    private static $has_many = [
        'QuestionAnswers' => QuestionAnswer::class,
    ];
}
