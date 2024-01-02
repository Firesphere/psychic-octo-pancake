<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\ApplicationNote;
use Firesphere\JobHunt\Models\StatusUpdate;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\Validator;
use SilverStripe\Security\Security;

class NoteForm extends Form
{
    const DEFAULT_NAME = 'NoteForm';

    public function __construct(RequestHandler $controller = null)
    {
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
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');
        $validator = RequiredFields::create(['Title', 'Note']);

        parent::__construct($controller, $name, $fields, $actions, $validator);
        if ($params['ID'] === 'edit') {
            $user = Security::getCurrentUser();
            $status = ApplicationNote::get(['ID' => $params['OtherID'], 'JobApplication.OwnerID' => $user->ID])->first();
            $this->loadDataFrom($status);
        }

    }
}
