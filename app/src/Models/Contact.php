<?php

namespace Firesphere\App\Models;

use Firesphere\App\Pages\ContactPage;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\App\Models\Contact
 *
 * @property string $Name
 * @property string $Email
 * @property string $Message
 * @property bool $Spam
 * @property int $ContactPageID
 * @method ContactPage ContactPage()
 */
class Contact extends DataObject
{
    private static $table_name = 'Contact';

    private static $db = [
        'Name'    => DBVarchar::class,
        'Email'   => DBVarchar::class,
        'Message' => DBText::class,
        'Spam'    => DBBoolean::class
    ];

    private static $summary_fields = [
        'Name',
        'Created',
        'Email',
        'Message',
    ];

    private static $has_one = [
        'ContactPage' => ContactPage::class
    ];

    public function canCreate($member = null, $context = [])
    {
        return false;
    }

    public function canEdit($member = null)
    {
        return false;
    }
}
