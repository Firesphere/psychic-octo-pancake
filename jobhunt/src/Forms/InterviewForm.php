<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\ApplicationNote;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\InterviewNote;
use Firesphere\JobHunt\Models\JobApplication;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Security\PermissionFailureException;
use SilverStripe\Security\Security;

class InterviewForm extends Form
{
    const DEFAULT_NAME = 'InterviewForm';

    public function __construct(RequestHandler $controller = null)
    {
        $params = $controller->getURLParams();
        $hiddenField = 'ApplicationID';
        if ($params['ID'] === 'edit') {
            $hiddenField = 'ID';
        }
        $name = self::DEFAULT_NAME;
        $fields = FieldList::create([
            $dtField = DatetimeField::create('DateTime', 'When is the interview'),
            TextareaField::create('Note', 'Notes'),
            HiddenField::create($hiddenField, $hiddenField, $params['OtherID'])
        ]);

        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);

        $formAction->addExtraClass('btn btn-default');

        $validator = RequiredFields::create(['DateTime']);

        parent::__construct($controller, $name, $fields, $actions, $validator);
        if ($params['ID'] === 'edit') {
            $user = Security::getCurrentUser();
            $data = Interview::get(['ID' => $params['OtherID'], 'Application.OwnerID' => $user->ID])->first();
            $this->loadDataFrom($data);
        }

    }

    public function submit($data, $form)
    {
        $userId = Security::getCurrentUser();
        if (!empty($data['ID'])) {
            $interview = Interview::get_by_id($data['ID']);
            if ($interview->Application()->UserID !== $userId) {
                throw new PermissionFailureException('User does not own this application');
            }
            $interview->update($data);
        } else {
            $application = JobApplication::get_by_id($data['ApplicationID']);
            if ($application->UserID !== Security::getCurrentUser()->ID) {
                throw new PermissionFailureException('User does not own this application');
            }

            $interview = Interview::create($data);
        }
        $interview->write();
        if ($data['Note']) {
            if (!InterviewNote::get()->filter(['Note' => $data['Note']])->count()) {
                $title = sprintf('%s - %s',
                    $interview->dbObject('DateTime')->Long(),
                    $interview->Application()->Company()->Name
                );
                /** @var InterviewNote $note */
                $note = InterviewNote::create([
                    'Title'                  => $title,
                    'Note'                   => $data['Note'],
                    'ApplicationInterviewID' => $interview->ID
                ]);
                $note->write();
            }
        }

        return json_encode([
            'success' => true,
            'form'    => false
        ]);
    }
}
