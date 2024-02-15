<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Models\CompanyNote
 *
 * @property bool $Anonymous
 * @property string $Score
 * @property int $CompanyID
 * @property int $NoteTypeID
 * @property int $UserID
 * @method Company Company()
 * @method CompanyNoteType NoteType()
 * @method Member User()
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
        'User'     => Member::class,
    ];
}
