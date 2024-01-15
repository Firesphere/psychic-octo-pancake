<?php

namespace Firesphere\Notebook\Models;

use Firesphere\Notebook\Pages\NotebookPage;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\Notebook\Models\Note
 *
 * @property string $Title
 * @property string $Content
 * @property int $MemberID
 * @method Member Member()
 */
class Note extends DataObject
{
    private static $table_name = 'NotebookNote';

    private static $db = [
        'Title'   => DBVarchar::class,
        'Content' => DBHTMLText::class
    ];

    private static $has_one = [
        'Member' => Member::class
    ];

    public function getLink()
    {
        $page = NotebookPage::get()->first();
        if (!$page) {
            return false;
        }
        return $page->Link('view/' . $this->ID);
    }

    public function getDeleteLink()
    {
        $page = NotebookPage::get()->first();
        if (!$page) {
            return false;
        }
        return $page->Link('delete/' . $this->ID);
    }
}
