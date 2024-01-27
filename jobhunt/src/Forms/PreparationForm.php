<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\InterviewPreparation;
use Firesphere\JobHunt\Models\QuestionAnswer;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
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
        $fields->push(HiddenField::create('ID', 'ID', $this->controller->PreparationID));
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');

        parent::__construct($controller, self::DEFAULT_NAME, $fields, $actions);
    }

    public function getFields($i = 0)
    {
        $fields = FieldList::create([
            LiteralField::create('div', '<div class="current" data-id="' . $i . '">'),
            TextField::create("Question[$i]", 'Question'),
            $source = DropdownField::create("QASource[$i]", 'Who would ask this question', ['Myself', 'Interviewer', 'Both', 'Other']),
            $other = TextField::create("Other[$i]", 'If "Other"'),
            TextareaField::create("Answer[$i]", 'Answer'),
            LiteralField::create('closediv', '</div>'),
            LiteralField::create('nextdiv', '<div class="next"></div>')
        ]);

        $source->setEmptyString('-- Select --');
        $source->addExtraClass('form-select');

        return $fields;
    }

    public function submit($data, $form)
    {
        // Harden the shit out of this

        $user = Security::getCurrentUser();
        $interview = InterviewPreparation::get()->filter([
                'UserID' => $user->ID,
                'ID'     => $data['ID']]
        )->first();
        if (!$interview || !$user) {
            $this->controller->httpError(403);

            return;
        }
        $totalAnswers = count($data['Answer']);
        // I'm expecting an array of items here!
        for ($j = 0; $j <= $totalAnswers; $j++) {
            $qa = QuestionAnswer::create([
                'Question' => $data['Question'][$j],
                'QASource' => $data['QASource'][$j],
                'Other'    => $data['Other'][$j],
                'Answer'   => $data['Answer'][$j],
                'InterviewPreparationID' => $interview->ID
            ]);
            $qa->write();
        }
    }

}
