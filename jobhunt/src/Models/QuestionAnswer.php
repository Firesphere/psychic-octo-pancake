<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\JobHunt\Models\QuestionAnswer
 *
 * @property string $Question
 * @property string $Answer
 * @property string $QASource,
 * @property string $OtherSource
 * @method InterviewPreparation InterviewPreparation()
 */
class QuestionAnswer extends DataObject
{

    private static $table_name = 'QuestionAnswer';

    private static $db = [
        'Question'    => DBVarchar::class,
        'Answer'      => DBText::class,
        'QASource,'   => DBEnum::class . '("Myself,Interviewer,Both,Other","Other")',
        'OtherSource' => DBVarchar::class
    ];

    private static $belongs_to = [
        'InterviewPreparation' => InterviewPreparation::class,
    ];
}
