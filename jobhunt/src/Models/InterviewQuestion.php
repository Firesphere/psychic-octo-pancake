<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\JobHunt\Models\InterviewQuestion
 *
 * @property string $Question
 */
class InterviewQuestion extends DataObject
{
    private static $table_name = 'InterviewQuestion';

    private static $db = [
        'Question' => DBVarchar::class
    ];

    private static $summary_fields = [
        'Question'
    ];
}
