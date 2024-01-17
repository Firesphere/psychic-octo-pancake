<?php

namespace Firesphere\App\Pages;

use Firesphere\App\Controllers\ContactPageController;
use Firesphere\App\Models\Contact;
use Page;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\DataList;

/**
 * Class \Firesphere\Dev\Pages\ContactPage
 *
 * @method DataList|Contact[] Contacts()
 */
class ContactPage extends Page
{
    private static $table_name = 'ContactPage';
    private static $has_many = [
        'Contacts' => Contact::class . '.ContactPage'
    ];
    public $hasLayout = true;

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $recordEditor = new GridFieldConfig_RecordEditor();

        $fields->addFieldToTab(
            'Root.Submissions',
            GridField::create('Contacts', 'Submissions', Contact::get(), $recordEditor)
        );

        return $fields;
    }

    public function getControllerName()
    {
        return ContactPageController::class;
    }
}
