<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\JobHunt\Models\CompanyNoteType
 *
 * @property string $Type
 * @method DataList|CompanyNote[] CompanyNotes()
 */
class CompanyNoteType extends DataObject
{
    private static $table_name = 'CompanyNoteType';

    private static $db = [
        'Type' => DBVarchar::class,
    ];

    private static $has_many = [
        'CompanyNotes' => CompanyNote::class . '.NoteType',
    ];

    private static $summary_fields = [
        'Type',
        'CompanyNotes.Count'
    ];

    private static $default_records = [
        ['Type' => 'Interview'],
        ['Type' => 'General'],
        ['Type' => 'Work'],
        ['Type' => 'Culture'],
        ['Type' => 'Other']
    ];

}
