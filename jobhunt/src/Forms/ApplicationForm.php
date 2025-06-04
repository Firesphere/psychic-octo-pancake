<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\ApplicationNote;
use Firesphere\JobHunt\Models\Company;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\Status;
use SilverStripe\Control\Director;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\Security\PermissionFailureException;
use SilverStripe\Security\Security;

class ApplicationForm extends Form
{
    public const DEFAULT_NAME = 'ApplicationForm';

    public function __construct(RequestHandler $controller = null)
    {
        $user = Security::getCurrentUser();
        if (!$user) {
            throw new PermissionFailureException('You need to be logged in.');
        }
        $statusses = Status::get();
        $fields = FieldList::create([
            $companyField = TextField::create('Company.Name', 'Company name'),
            TextField::create('Role', 'Role'),
            DateField::create('ApplicationDate', 'Date of applying'),
            DateField::create('ClosingDate', 'Date application window closes'),
            TextField::create('Link', 'Link to application'),
            $paylow = NumericField::create('PayLower', 'Lower pay band'),
            $payUp = NumericField::create('PayUpper', 'Upper pay band'),
            $status = DropdownField::create('StatusID', 'Status', $statusses->map('ID', 'Status')->toArray()),
            HTMLEditorField::create('CoverLetter', 'Cover letter'),
            TextareaField::create('Notes', 'Note')
        ]);
        $companyField->addExtraClass('js-companyfield');
        $companyField->setAttribute("list", "companylist");
        $status->addExtraClass('form-select');
        $status->setEmptyString('-- Select application status --');
        $draftStatus = $statusses->filter(['Status' => 'Draft'])->first()?->ID;
        $status->setAttribute('data-draft', $draftStatus);

        $paylow->addExtraClass('col');
        $payUp->addExtraClass('col');
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');
        $reqFields = ['Company.Name', 'Role', 'StatusID'];
        if ($controller->getRequest()->isPOST()) {
            $statusVar = $controller->getRequest()->postVar('StatusID');
            if ((int)$statusVar !== $draftStatus) {
                $reqFields[] = 'ApplicationDate';
            }
        } else {
            $reqFields[] = 'ApplicationDate';
        }
        $validator = RequiredFields::create($reqFields);
        parent::__construct($controller, self::DEFAULT_NAME, $fields, $actions, $validator);
        $params = $controller->getURLParams();
        if ($params['ID'] === 'edit') {
            $this->fields->push(HiddenField::create('ID', 'ID', $params['ID']));
            $application = JobApplication::get()->filter(['ID' => $params['OtherID'], 'UserID' => $user->ID])->first();
            $this->loadDataFrom($application);
            if ($application->CoverLetter) {
                $this->fields->replaceField('CoverLetter', LiteralField::create(
                    'CoverLetter',
                    sprintf('<div class="col-12 m-1 mt-2"><h6>Cover letter</h6>%s</div>', $application->CoverLetter)
                ));
            }
        }
    }

    public function submit($data, $form)
    {
        $data['CompanyID'] = Company::findOrCreate($data['Company_Name']);
        $data['UserID'] = Security::getCurrentUser()->ID;

        $isNew = true;
        if (!empty($data['ID'])) {
            $application = JobApplication::get_by_id($data['ID']);
            if ($application->UserID !== $data['UserID']) {
                throw new PermissionFailureException('User does not own this application');
            }
            $application->update($data);
            $isNew = false;
        } else {
            $application = JobApplication::create($data);
        }
        $application->write();
        $returnForm = false;
        if ($isNew && $application->Status()->Status === 'Interview') {
            $this->controller->setApplication($application);
            $this->controller->setURLParams([
                'Action'  => InterviewForm::DEFAULT_NAME,
                'ID'      => 'add',
                'OtherID' => $application->ID
            ]);
            $returnForm = InterviewForm::create($this->controller);
        }
        if (!empty($data['Notes'])) {
            if (!ApplicationNote::get()->filter(['Note' => $data['Notes']])->count()) {
                $note = ApplicationNote::create();
                $note->update([
                    'Title'            => sprintf('Note on %s for status %s', DBDatetime::now()->Long(), $application->Status()->Status),
                    'Note'             => $data['Notes'],
                    'JobApplicationID' => $application->ID
                ]);
                $note->write();
            }
        }

        if ($returnForm && $this->controller->getRequest()->isAjax()) {
            return json_encode(['success' => true, 'form' => $returnForm->forAjaxTemplate()->getValue()]);
        }

        $this->controller->flashMessage('Application saved', 'success');

        return json_encode(['success' => true, 'form' => false]);
    }
}
