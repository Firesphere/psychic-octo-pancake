<?php

namespace Firesphere\JobHunt\Forms;

use Dynamic\CountryDropdownField\Fields\CountryDropdownField;
use Firesphere\JobHunt\Models\Company;
use SilverStripe\Assets\Folder;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Security;

class CompanyForm extends Form
{
    public const DEFAULT_NAME = 'CompanyForm';

    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME)
    {
        Folder::find_or_make('company-logos');
        $params = $controller->getURLParams();
        $user = Security::getCurrentUser();
        // You can't directly add a company
        if (!$user) {
            return;
        }
        $fields = FieldList::create([
            TextField::create('Name', 'Company name'),
            $address = TextareaField::create('Address', 'Address'),
            $country = CountryDropdownField::create('Country', 'Country'),
            $email = EmailField::create('Email', 'Generic contact email address'),
            $link = TextField::create('Link', 'Website URL'),
            //            $logo = FileAttachmentField::create('Logo'),
            HiddenField::create('ID', 'ID', $params['OtherID'])
        ]);
        $address->setRows(3);
        $country->addExtraClass('form-select');
//        $logo->addExtraClass('form-control');
//        $logo->setAllowedFileCategories('image');
//        $logo->setFolderName('company-logos');
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');

        $validator = RequiredFields::create('Name', 'Address', 'Country');

        parent::__construct($controller, $name, $fields, $actions, $validator);
        $data = Company::get_by_id($params['OtherID']);
        $this->loadDataFrom($data);
    }

    public function submit($data, $form)
    {
        $company = Company::get_by_id($data['ID']);
        $form->saveInto($company);
        $company->write();

        return json_encode(['success' => true, 'form' => false]);
    }
}
