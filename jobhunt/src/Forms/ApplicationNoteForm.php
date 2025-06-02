<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\ApplicationNote;
use Firesphere\JobHunt\Models\JobApplication;
use SilverStripe\Control\RequestHandler;
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

class ApplicationNoteForm extends Form
{
    public const DEFAULT_NAME = 'ApplicationNoteForm';

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
            HiddenField::create($hiddenType, $hiddenType, $params['OtherID'])
        ]);
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save'),
        ]);
        $formAction->addExtraClass('btn btn-primary');
        $validator = RequiredFields::create(['Title']);

        parent::__construct($controller, $name, $fields, $actions, $validator);
        if ($params['ID'] === 'edit') {
            $note = ApplicationNote::get()->filter(['ID' => $params['OtherID'], 'JobApplication.UserID' => $user->ID])->first();
            $this->loadDataFrom($note);
            $deleteLink = sprintf("<a href='%s' class='btn btn-warning my-3'>delete</a>", $note->deleteLink());
            $actions->push(
                $deleteButton = LiteralField::create('delete', $deleteLink)
            );
        }
    }

    public function submit($data, $form)
    {
        $userId = Security::getCurrentUser();
        if (!empty($data['ID'])) {
            $note = ApplicationNote::get_by_id($data['ID']);
            if ($note->JobApplication()->UserID !== $userId->ID) {
                throw new PermissionFailureException('User does not own this application');
            }
            $note->update($data);
        } else {
            $application = JobApplication::get_by_id($data['JobApplicationID']);
            if ($application->UserID !== $userId->ID) {
                throw new PermissionFailureException('User does not own this application');
            }

            $note = ApplicationNote::create($data);
        }
        $note->OwnerID = $userId->ID;
        $note->write();

        $this->controller->flashMessage('Note saved', 'success');

        return json_encode(['success' => true, 'form' => false]);
    }
}
