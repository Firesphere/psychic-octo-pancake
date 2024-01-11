<?php

namespace Firesphere\JobHunt\Forms;

use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\Validator;

class InterviewNoteForm extends Form
{

    const DEFAULT_NAME = 'InterviewNoteForm';

    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME)
    {
        $fields = FieldList::create([
            $title = TextField::create('Title', 'Question/Title'),
            $text = TextareaField::create('Note'),
            $int = TextField::create('Interviewers.Name', 'Interviewer name')
        ]);
        $title->setDescription('Title, question or other "thing" you might want to ask, or answer');
        $int->setDescription('Optional, if this question is asked by an interviewer, you can record who it was');
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');

        $validator = RequiredFields::create(['Title', 'Note']);

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }
}
