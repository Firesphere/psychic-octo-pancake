<?php

namespace Firesphere\Notebook\Forms;

use Firesphere\Notebook\Controllers\NotebookPageController;
use Firesphere\Notebook\Models\Note;
use SilverStripe\Control\HTTPResponse_Exception;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Security\Security;

class NotebookForm extends Form
{

    const DEFAULT_NAME = 'NotebookForm';

    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME)
    {
        $fields = FieldList::create([
            TextField::create('Title', 'Title'),
            HTMLEditorField::create('Content', 'Note'),
            HiddenField::create('ID', 'ID')
        ]);
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');
        $validator = RequiredFields::create(['Title', 'Content']);
        parent::__construct($controller, $name, $fields, $actions, $validator);
        if ($controller instanceof NotebookPageController && $controller->getNote()) {
            $this->loadDataFrom($controller->getNote());
        }
        $this->addExtraClass('collapse');
    }

    /**
     * @param self $form
     * @param $data
     * @return void
     * @throws HTTPResponse_Exception
     * @throws ValidationException
     */
    public function submit($data, $form)
    {
        if (!empty($data['ID'])) {
            $note = Note::get()->filter([
                'ID'       => $data['ID'],
                'MemberID' => Security::getCurrentUser()->ID
            ])->first();
            unset($data['ID']);
            if (!$note) {
                throw new HTTPResponse_Exception('Note not found', 404);
            }
            $note->update($data);
        } else {
            $note = Note::create();
            $form->saveInto($note);
        }
        $note->MemberID = Security::getCurrentUser()->ID;
        $note->write();

        $this->controller->redirectBack();
    }
}
