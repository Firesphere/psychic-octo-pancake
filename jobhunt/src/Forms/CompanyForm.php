<?php

namespace Firesphere\JobHunt\Forms;

use Dynamic\CountryDropdownField\Fields\CountryDropdownField;
use Firesphere\JobHunt\Models\Company;
use SilverStripe\Assets\Folder;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
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
        $company = Company::get_by_id($params['OtherID']);
        $resizedLogo = $company && $company->LogoID ? $company->Logo()->FitMax(200, 200)->forTemplate() : 'None';
        $fields = FieldList::create([
            $nameField = TextField::create('Name', 'Company name'),
            $address = TextareaField::create('Address', 'Address'),
            $country = CountryDropdownField::create('Country', 'Country'),
            EmailField::create('Email', 'Generic contact email address'),
            TextField::create('Link', 'Website URL'),
            $ethics = DropdownField::create('Ethics', 'Ethics', Company::$colour_map),
            LiteralField::create('CurrentLogo', '<div class="col"><br />' . $resizedLogo . '</div>'),
            $logo = FileField::create('Logo', 'Logo' . ($resizedLogo ? ' replacement (leave empty if none)' : '')),
            HiddenField::create('ID', 'ID', $params['OtherID'])
        ]);
        $address->setRows(3);
        $nameField->setDisabled(true);
        $ethics->addExtraClass('form-select');
        $country->addExtraClass('form-select');
        $country->setEmptyString('-- Select a country --');
        $logo->addExtraClass('form-control');

        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');

        $validator = RequiredFields::create('Ethics');

        parent::__construct($controller, $name, $fields, $actions, $validator);
        $data = Company::get_by_id($params['OtherID']);
        $data = $data ?? [];
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
