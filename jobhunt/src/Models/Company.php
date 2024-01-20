<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\JobHunt\Models\Company
 *
 * @property string $Name
 * @property string $Address
 * @property string $Country
 * @property string $Email
 * @property string $Link
 * @property string $Slug
 * @property int $LogoID
 * @method Image Logo()
 * @method DataList|JobApplication[] Applications()
 * @method DataList|Interviewer[] Employees()
 */
class Company extends DataObject
{
    private static $table_name = 'Company';

    private static $db = [
        'Name'    => DBVarchar::class,
        'Address' => DBText::class,
        'Country' => DBVarchar::class,
        'Email'   => DBVarchar::class,
        'Link'    => DBVarchar::class,
        'Slug'    => DBVarchar::class,
    ];

    private static $has_one = [
        'Logo' => Image::class,
    ];

    private static $has_many = [
        'Applications' => JobApplication::class . '.Company',
        'Employees'    => Interviewer::class . '.Company'
    ];

    private static $owns = [
        'Logo',
    ];

    private static $cascade_deletes = [
        'Employees'
    ];

    private static $summary_fields = [
        'Name',
        'Email',
        'Link',
        'Slug'
    ];

    public static function findOrCreate($name)
    {
        $slug = SiteTree::singleton()->generateURLSegment($name);
        $exists = self::get()->filter(['Slug' => $slug])->first();

        if ($exists) {
            return $exists->ID;
        }

        return self::create(['Name' => $name, 'Slug' => $slug])->write();
    }

    public function onBeforeWrite()
    {
        if (!$this->Slug) {
            $this->Slug = SiteTree::singleton()->generateURLSegment($this->Name);
        }

        parent::onBeforeWrite();
    }
}
