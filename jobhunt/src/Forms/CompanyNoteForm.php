<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\CompanyNote;
use Firesphere\JobHunt\Models\CompanyNoteType;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\SelectionGroup;
use SilverStripe\Forms\SingleSelectField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

class CompanyNoteForm extends Form
{

    public const DEFAULT_NAME = 'CompanyNoteForm';

    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME)
    {
        $this->controller = $controller;
        $fieldList = FieldList::create([
            TextField::create('Title', 'Title'),
            $drop = DropdownField::create('NoteTypeID', 'Topic', CompanyNoteType::get()->map('ID', 'Type')->toArray()),
            $checks = OptionsetField::create('Score', 'Score', [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5]),
            TextareaField::create('Note', 'Note'),
            CheckboxField::create('Anonymous', 'Anonymous note?', true),
            HiddenField::create('CompanyID', 'CompanyID', $controller->getRequest()->param('OtherID'))
        ]);
        $checks->addExtraClass('mt-2 form-check-inline');
        $drop->addExtraClass('form-select');
        $drop->setEmptyString('-- Select a topic for this review --');
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Submit')
        ]);
        $formAction->addExtraClass('btn btn-primary');

        $required = RequiredFields::create('Title', 'NoteTypeID', 'Note', 'Score');

        parent::__construct($controller, $name, $fieldList, $actions, $required);
    }

    public function submit($data, $form)
    {
        $note = CompanyNote::create();
        $form->saveInto($note);
        $note->write();
        return json_encode(['success' => true, 'form' => false]);
    }
}
