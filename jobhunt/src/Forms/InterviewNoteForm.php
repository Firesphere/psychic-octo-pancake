<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\InterviewNote;
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

class InterviewNoteForm extends Form
{
    public const DEFAULT_NAME = 'InterviewNoteForm';

    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME)
    {
        $user = Security::getCurrentUser();
        if (!$user) {
            throw new PermissionFailureException('You need to be logged in.');
        }

        $params = $controller->getURLParams();
        $hiddenField = 'InterviewID';
        if ($params['ID'] === 'edit') {
            $hiddenField = 'ID';
        }

        $fields = FieldList::create([
            $title = TextField::create('Title', 'Question/Title'),
            $text = TextareaField::create('Note'),
            //            $int = TextField::create('Interviewers.Name', 'Interviewer name'),
            HiddenField::create($hiddenField, $hiddenField, $params['OtherID'])
        ]);
        $title->setDescription('Title, question or other "thing" you might want to ask, or remember');
        //        $int->setDescription('Optional, if this question is asked by an interviewer, you can record who it was');
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');

        $validator = RequiredFields::create(['Title', 'Note']);

        parent::__construct($controller, $name, $fields, $actions, $validator);
        if ($params['ID'] === 'edit') {
            /** @var InterviewNote $data */
            $data = InterviewNote::get()->filter([
                'ID'                                      => $params['OtherID'],
                'ApplicationInterview.Application.UserID' => $user->ID
            ])->first();
            $this->loadDataFrom($data);
            $deleteLink = sprintf("<a href='%s' class='btn btn-warning my-3'>delete</a>", $data->deleteLink());
            $actions->push(
                $deleteButton = LiteralField::create('delete', $deleteLink)
            );
        }
    }

    public function submit($data, $form)
    {
        $user = Security::getCurrentUser();
        if (!$user) {
            $this->controller->httpError(403);

            return;
        }
        if ($data['ID']) {
            $note = InterviewNote::get()->filter([
                'ID'                                      => $data['ID'],
                'ApplicationInterview.Application.UserID' => $user->ID
            ])->first();
            if ($note) {
                unset($data['ID']);
                $note->update($data);
            }
        } else {
            $note = InterviewNote::create();
            $form->saveInto($note);
        }
        $note->write();

        return json_encode(['success' => true, 'form' => false]);
    }
}
