<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Forms\ApplicationForm;
use Firesphere\JobHunt\Forms\InterviewForm;
use Firesphere\JobHunt\Forms\NoteForm;
use Firesphere\JobHunt\Forms\StatusUpdateForm;
use Firesphere\JobHunt\Models\ApplicationNote;
use Firesphere\JobHunt\Models\BaseNote;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\InterviewNote;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\StatusUpdate;
use SilverStripe\Control\Controller;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Controllers\FormHandler
 *
 */
class FormHandler extends Controller
{
    private static $url_segment = 'formhandling';
    private static $allowed_actions = [
        'ApplicationForm',
        'InterviewForm',
        'StatusUpdateForm',
        'NoteForm'
    ];
    /**
     * @var JobApplication
     */
    protected $application;
    /**
     * @var BaseNote|ApplicationNote|InterviewNote
     */
    protected $note;
    /**
     * @var StatusUpdate
     */
    protected $statusUpdate;

    /**
     * @var Interview
     */
    protected $interview;

    public function init()
    {
        parent::init();
        if (!Security::getCurrentUser()) {
            $this->httpError(403);

            return;
        }
        $this->getResponse()->addHeader('content-type', 'application/json');
    }

    public function ApplicationForm()
    {
        $form = ApplicationForm::create($this);
        if ($this->getRequest()->isGET()) {
            return json_encode(['success' => true, 'form' => $form->forAjaxTemplate()->getValue()]);
        }

        return $form;
    }

    public function InterviewForm()
    {
        $form = InterviewForm::create($this);
        if ($this->getRequest()->isGET()) {
            return json_encode(['success' => true, 'form' => $form->forAjaxTemplate()->getValue()]);
        }

        return $form;
    }

    public function StatusUpdateForm()
    {
        $form = StatusUpdateForm::create($this);
        if ($this->getRequest()->isGET()) {
            return json_encode(['success' => true, 'form' => $form->forTemplate()->getValue()]);
        }

        return $form;
    }

    public function NoteForm()
    {
        $form = NoteForm::create($this);
        if ($this->getRequest()->isGET()) {
            return json_encode(['success' => true, 'form' => $form->forTemplate()->getValue()]);
        }

        return $form;

    }


    /**
     * @return JobApplication
     */
    public function getApplication(): JobApplication
    {
        return $this->application;
    }

    /**
     * @param JobApplication $application
     */
    public function setApplication($application): void
    {
        $this->application = $application;
    }

    /**
     * @return BaseNote
     */
    public function getNote(): BaseNote
    {
        return $this->note;
    }

    /**
     * @param BaseNote $note
     */
    public function setNote($note): void
    {
        $this->note = $note;
    }

    /**
     * @return StatusUpdate
     */
    public function getStatusUpdate(): StatusUpdate
    {
        return $this->statusUpdate;
    }

    /**
     * @param StatusUpdate $statusUpdate
     */
    public function setStatusUpdate($statusUpdate): void
    {
        $this->statusUpdate = $statusUpdate;
    }

    public function getInterview(): Interview
    {
        return $this->interview;
    }

    public function setInterview(Interview $interview): void
    {
        $this->interview = $interview;
    }
}
