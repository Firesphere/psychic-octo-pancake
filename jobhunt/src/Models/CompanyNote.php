<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Models\CompanyNote
 *
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

    private static $has_one = [
        'Company'  => Company::class,
        'NoteType' => CompanyNoteType::class,
        'User'     => Member::class,
    ];
}
