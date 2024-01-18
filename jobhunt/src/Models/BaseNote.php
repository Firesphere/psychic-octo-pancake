<?php

namespace Firesphere\JobHunt\Models;

use Firesphere\JobHunt\Pages\ApplicationPage;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Models\ApplicationNote
 *
 * @property string $Title
 * @property string $Note
 * @property int $OwnerID
 * @method Member Owner()
 */
class BaseNote extends DataObject
{
    protected static $deleteList = [
        InterviewNote::class   => 'interviewnote',
        ApplicationNote::class => 'applicationnote',
        StatusUpdate::class    => 'status'
    ];
    private static $table_name = 'BaseNote';
    private static $db = [
        'Title' => DBVarchar::class,
        'Note'  => DBText::class
    ];
    private static $has_one = [
        'Owner' => Member::class,
    ];

    public function deleteLink()
    {
        /** @var ApplicationPage $page */
        $page = ApplicationPage::get()->first();
        $deletePart = sprintf('delete/%s/%d', self::$deleteList[static::class], $this->ID);

        return $page->Link($deletePart);
    }

    public function onBeforeWrite()
    {
        $this->OwnerID = Security::getCurrentUser()->ID;
        parent::onBeforeWrite();
    }
}
