<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Models\CompanyNote
 *
 * @property bool $Anonymous
 * @property string $Score
 * @property int $CompanyID
 * @property int $NoteTypeID
 * @method Company Company()
 * @method CompanyNoteType NoteType()
 */
class CompanyNote extends BaseNote
{
    private static $table_name = 'CompanyNote';

    private static $db = [
        'Anonymous' => DBBoolean::class . '(true)',
        'Score'     => DBEnum::class . '("1,2,3,4,5,N/A","N/A")',
    ];
    private static $has_one = [
        'Company'  => Company::class,
        'NoteType' => CompanyNoteType::class,
    ];
}
