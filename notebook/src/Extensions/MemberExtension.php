<?php

namespace Firesphere\Notebook\Extensions;

use Firesphere\Notebook\Models\Note;
use SilverStripe\ORM\DataExtension;

/**
 * Class \Firesphere\Notebook\Extensions\MemberExtension
 *
 * @property Member|MemberExtension $owner
 * @method DataList|Note[] NotebookNotes()
 */
class MemberExtension extends DataExtension
{

    private static $has_many = [
        'NotebookNotes' => Note::class . '.Member'
    ];
}
