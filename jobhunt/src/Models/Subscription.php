<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\JobHunt\Models\Subscription
 *
 * @property string $Title
 * @property string $Description
 * @property string $Features
 * @property int $Price
 * @property string $URLSegment
 */
class Subscription extends DataObject
{
    private static $table_name = 'Subscription';

    private static $db = [
        'Title'       => DBVarchar::class,
        'Description' => DBHTMLText::class,
        'Features'    => DBHTMLText::class,
        'Price'       => DBInt::class,
        'URLSegment'  => DBVarchar::class
    ];

    private static $indexes = [
        'URLSegment' => true
    ];

    public function onBeforeWrite()
    {
        if (!$this->URLSegment || $this->isChanged('Title')) {
            $this->URLSegment = SiteTree::singleton()->generateURLSegment($this->Title);
        }
        parent::onBeforeWrite();
    }
}
