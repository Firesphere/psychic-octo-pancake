<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\InterviewNote;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Models\StatusUpdate;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\Security\PermissionFailureException;
use SilverStripe\Security\Security;

class InterviewForm extends Form
{
    public const DEFAULT_NAME = 'InterviewForm';

    public $notes;

    public function __construct(RequestHandler $controller = null)
    {
        $user = Security::getCurrentUser();
        if (!$user) {
            throw new PermissionFailureException('You need to be logged in.');
        }

        $params = $controller->getURLParams();
        $hiddenField = 'ApplicationID';
        if ($params['ID'] === 'edit') {
            $hiddenField = 'ID';
        }
        $name = self::DEFAULT_NAME;
        $fields = FieldList::create([
            /** @var $dtField DatetimeField */
            $dtField = DatetimeField::create('DateTime', 'When is the interview'),
            TextareaField::create('Note', 'Notes'),
            HiddenField::create($hiddenField, $hiddenField, $params['OtherID'])
        ]);

        $dtField->setDescription('Please make sure to use the full year, month, day with leading zeroes, and 24 hour clock');
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');

        $validator = RequiredFields::create(['DateTime']);

        parent::__construct($controller, $name, $fields, $actions, $validator);
        if ($params['ID'] === 'edit') {
            /** @var Interview $data */
            $data = Interview::get()->filter(['ID' => $params['OtherID'], 'Application.UserID' => $user->ID])->first();
            $this->notes = $data->Notes();
            $this->loadDataFrom($data);
            $deleteLink = sprintf("<div class='ms-3'><a href='%s' class='btn btn-warning my-3'>delete</a></div>", $data->deleteLink());
            $actions->push(
                $deleteButton = LiteralField::create('delete', $deleteLink)
            );

        }
    }

    public function submit($data, $form)
    {
        $userId = Security::getCurrentUser();
        if (!empty($data['ID'])) {
            $interview = Interview::get_by_id($data['ID']);
            if ($interview->Application()->UserID !== $userId->ID) {
                throw new PermissionFailureException('User does not own this application');
            }
            $interview->update($data);
            $application = $interview->Application();
        } else {
            $application = JobApplication::get_by_id($data['ApplicationID']);
            if ($application->UserID !== $userId->ID) {
                throw new PermissionFailureException('User does not own this application');
            }

            $interview = Interview::create($data);
        }
        $interview->write();
        if ($data['Note']) {
            if (!InterviewNote::get()->filter(['Note' => $data['Note']])->count()) {
                $title = sprintf(
                    'Note on %s - %s',
                    DBDatetime::now()->Long(),
                    $interview->Application()->Company()->Name
                );
                $note = InterviewNote::create([
                    'Title'                  => $title,
                    'Note'                   => $data['Note'],
                    'ApplicationInterviewID' => $interview->ID
                ]);
                $note->write();
            }
        }
        /** @var StatusUpdate $last */
        $updates = $application->StatusUpdates()->filter(['Status.Status' => 'Interview']);
        if ($updates->count() !== $application->Interviews()->count()) {
            $interviewStatus = Status::get()->filter(['Status' => 'Interview'])->first();
            $stat = StatusUpdate::create([
                'Title'            => 'Automated update: Interview',
                'StatusID'         => $interviewStatus->ID,
                'JobApplicationID' => $application->ID,
                'Hidden'           => true
            ]);
            $stat->write();
            $interview->StatusUpdateID = $stat->ID;
        } else {
            $interview->StatusUpdateID = $updates->last()->ID;
        }

        $interview->write();

        $this->controller->flashMessage('Interview saved', 'success');

        return json_encode([
            'success' => true,
            'form'    => false
        ], JSON_THROW_ON_ERROR);
    }
}
