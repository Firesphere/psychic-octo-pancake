<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Models\StatusUpdate;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\PermissionFailureException;
use SilverStripe\Security\Security;

class StatusUpdateForm extends Form
{
    public const DEFAULT_NAME = 'StatusUpdateForm';

    public function __construct(RequestHandler $controller = null)
    {
        $user = Security::getCurrentUser();
        if (!$user) {
            throw new PermissionFailureException('You need to be logged in.');
        }

        $hiddenType = 'JobApplicationID';
        $params = $controller->getURLParams();
        if ($params['ID'] === 'edit') {
            $hiddenType = 'ID';
        }
        $name = self::DEFAULT_NAME;
        $fields = FieldList::create([
            TextField::create('Title', 'Title'),
            TextareaField::create('Note', 'Note'),
            $status = DropdownField::create('StatusID', 'Status', Status::get()->map('ID', 'Status')->toArray()),
            HiddenField::create($hiddenType, $hiddenType, $params['OtherID']),
        ]);
        $status->addExtraClass('form-select');
        $status->setEmptyString('-- Select status --');
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');
        $validator = RequiredFields::create(['Title', 'Note', 'StatusID']);
        parent::__construct($controller, $name, $fields, $actions, $validator);
        if ($params['ID'] === 'edit') {
            $status = StatusUpdate::get()->filter(['ID' => $params['OtherID'], 'JobApplication.UserID' => $user->ID])->first();
            $this->loadDataFrom($status);
            $deleteLink = sprintf("<a href='%s' class='btn btn-warning my-3'>delete</a>", $status->deleteLink());
            $actions->push(
                $deleteButton = LiteralField::create('delete', $deleteLink)
            );

        }
    }

    /**
     * @param array $data
     * @param Form $form
     * @return false|string
     * @throws PermissionFailureException
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function submit($data, $form)
    {
        $isNew = false;
        if (isset($data['JobApplicationID'])) {
            $update = StatusUpdate::create();
            /** @var JobApplication $application */
            $application = JobApplication::get_by_id($data['JobApplicationID']);
            if ($application->UserID !== Security::getCurrentUser()->ID) {
                throw new PermissionFailureException('User does not own this application');
            }

            $application->StatusID = $data['StatusID'];
            $application->write();
            $appId = $application->ID;
            $isNew = true;
        } elseif (isset($data['ID'])) {
            $update = StatusUpdate::get_by_id($data['ID']);
            if ($update->JobApplication()->UserID !== Security::getCurrentUser()->ID) {
                throw new PermissionFailureException('User does not own this application');
            }
            $appId = $update->JobApplicationID;
        }
        $form->saveInto($update);
        $update->JobApplicationID = $appId;
        $update->OwnerID = Security::getCurrentUser()->ID;
        $update->write();
        $returnForm = false;

        if ($isNew && $update->Status()->Status === 'Interview') {
            $this->controller->setApplication($update->JobApplication());
            $this->controller->setURLParams([
                'Action'  => InterviewForm::DEFAULT_NAME,
                'ID'      => 'add',
                'OtherID' => $update->JobApplicationID
            ]);
            $returnForm = InterviewForm::create($this->controller);
        }
        if ($returnForm && $this->controller->getRequest()->isAjax()) {
            return json_encode(['success' => true, 'form' => $returnForm->forAjaxTemplate()->getValue()]);
        }

        $this->controller->flashMessage('Status update saved', 'success');

        return json_encode(['success' => true, 'form' => false]);
    }
}
