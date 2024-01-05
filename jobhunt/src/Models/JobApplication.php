<?php

namespace Firesphere\JobHunt\Models;

use DOMDocument;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Models\JobApplication
 *
 * @property string $Role
 * @property string $ApplicationDate
 * @property string $ClosingDate
 * @property string $Link
 * @property string $CoverLetter
 * @property int $UserID
 * @property int $CompanyID
 * @property int $StatusID
 * @method Member User()
 * @method Company Company()
 * @method Status Status()
 * @method DataList|ApplicationNote[] Notes()
 * @method DataList|Interview[] Interviews()
 * @method DataList|StatusUpdate[] StatusUpdates()
 */
class JobApplication extends DataObject
{
    private static $table_name = 'JobApplication';

    private static $db = [
        'Role'            => DBVarchar::class,
        'ApplicationDate' => DBDate::class,
        'ClosingDate'     => DBDate::class,
        'Link'            => DBVarchar::class,
        'CoverLetter'     => DBHTMLText::class,
    ];

    private static $has_one = [
        'User'    => Member::class,
        'Company' => Company::class,
        'Status'  => Status::class
    ];

    private static $cascade_deletes = [
        'Notes',
        'Interviews',
        'StatusUpdates'
    ];

    private static $has_many = [
        'Notes'         => ApplicationNote::class . '.JobApplication',
        'Interviews'    => Interview::class . '.Application',
        'StatusUpdates' => StatusUpdate::class . '.JobApplication',
    ];

    private static $many_many = [
    ];

    public static $filters = [
        'StatusID' => 'int',
        'Company'  => 'string',
    ];

    public static $sort = [
        'ApplicationDate',
        'Company.Name',
    ];

    public function onBeforeWrite()
    {
        if ($this->CoverLetter) {
            try {
                $dom = new DOMDocument();

                $dom->loadHTML($this->CoverLetter, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $removeTags = ['script', 'style', 'iframe', 'link'];
                foreach ($removeTags as $tag) {
                    $script = $dom->getElementsByTagName($tag);
                    foreach ($script as $item) {
                        $item->parentNode->removeChild($item);
                    }
                }

                $this->CoverLetter = $dom->saveHTML();
            } catch (\Exception $exception) {
                //ignore
            }
        }
        parent::onBeforeWrite();
    }
}
