<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\InterviewPreparation;
use Firesphere\JobHunt\Models\QuestionAnswer;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Security;

class PreparationForm extends Form
{
    public const DEFAULT_NAME = 'PreparationForm';

    public function __construct(RequestHandler $controller = null)
    {
        $this->controller = $controller;
        $fields = $this->getFields();
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');

        parent::__construct($controller, self::DEFAULT_NAME, $fields, $actions);
    }

    public function getFields($i = 0)
    {
        return FieldList::create([
            TextField::create("Question[$i]", 'Question'),
            DropdownField::create("QASource[$i]", 'Who would ask this question', QuestionAnswer::singleton()->dbObject('QAType')->EnumValues()),
            TextField::create("Other[$i]", 'Other'),
            TextareaField::create("Answer[$i]", 'Answer'),
            HiddenField::create('InterviewID', 'InterviewID', $this->controller->getRequest()->param('ID'))
        ]);
    }

    public function submit($data, $form)
    {
        // Harden the shit out of this

        $user = Security::getCurrentUser();
        $interview = Interview::get()->filter([
            'UserID' => $user->ID,
            'ID' => $data['InterviewID']]
        )->first();
        if (!$interview || !$user) {
            $this->controller->httpError(403);

            return;
        }
        if (!$interview->Preparation()) {
            $preparation = InterviewPreparation::create([
                'UserID' => $user->ID
            ]);
            $prepId = $preparation->write();
            $interview->PreparationID = $prepId;
            $interview->write();
        }
        $totalAnswers = count($data['Answer']);
        // I'm expecting an array of items here!
        for ($j = 0; $j <= $totalAnswers; $j++) {
            $qa = QuestionAnswer::create([
                'Question'               => $data['Question'][$j],
                'QASource'               => $data['QASource'][$j],
                'Other'                  => $data['Other'][$j],
                'Answer'                 => $data['Answer'][$j],
                'InterviewPreparationID' => $prepId
            ]);
            $qa->write();
        }
    }

}
