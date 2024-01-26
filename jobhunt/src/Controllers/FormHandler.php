<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Forms\ApplicationForm;
use Firesphere\JobHunt\Forms\ApplicationNoteForm;
use Firesphere\JobHunt\Forms\CloseForm;
use Firesphere\JobHunt\Forms\CompanyForm;
use Firesphere\JobHunt\Forms\ImportForm;
use Firesphere\JobHunt\Forms\InterviewForm;
use Firesphere\JobHunt\Forms\InterviewNoteForm;
use Firesphere\JobHunt\Forms\StatusUpdateForm;
use Firesphere\JobHunt\Models\ApplicationNote;
use Firesphere\JobHunt\Models\BaseNote;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\InterviewNote;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\StatusUpdate;
use SilverStripe\Control\Controller;
use SilverStripe\Security\Security;
use SilverStripe\View\SSViewer;

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
        'InterviewNoteForm',
        'StatusUpdateForm',
        'ApplicationNoteForm',
        'ImportForm',
        'CompanyForm',
        'CloseForm',
        'PostInterview'
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
            return json_encode(['success' => true, 'form' => $form->forAjaxTemplate()->getValue()], JSON_THROW_ON_ERROR);
        }

        return $form;
    }

    public function InterviewForm()
    {
        $form = InterviewForm::create($this);
        if ($this->getRequest()->isGET()) {
            if ($form->notes) {
                $formHtml = SSViewer::execute_template('Firesphere\\JobHunt\\NoteList', $form);
            } else {
                $formHtml = $form->forAjaxTemplate();
            }

            return json_encode(['success' => true, 'form' => $formHtml->getValue()], JSON_THROW_ON_ERROR);
        }

        return $form;
    }

    public function InterviewNoteForm()
    {
        $form = InterviewNoteForm::create($this);
        if ($this->getRequest()->isGET()) {
            return json_encode(['success' => true, 'form' => $form->forAjaxTemplate()->getValue()], JSON_THROW_ON_ERROR);
        }

        return $form;
    }

    public function StatusUpdateForm()
    {
        $form = StatusUpdateForm::create($this);
        if ($this->getRequest()->isGET()) {
            return json_encode(['success' => true, 'form' => $form->forTemplate()->getValue()], JSON_THROW_ON_ERROR);
        }

        return $form;
    }

    public function PostInterview()
    {
        if ($this->getRequest()->isGET()) {

            $id = $this->getRequest()->param('OtherID');
            $application = JobApplication::get()
                ->filter([
                    'ID'                          => $id,
                    'StatusUpdates.Status.Status' => 'Interview'
                ])->count();

            if (!$application) {
                return json_encode(['success' => false]);
            }
        }

        return $this->StatusUpdateForm();
    }

    public function CloseForm()
    {
        $form = CloseForm::create($this);
        if ($this->getRequest()->isGET()) {
            return json_encode(['success' => true, 'form' => $form->forTemplate()->getValue()], JSON_THROW_ON_ERROR);
        }

        return $form;
    }

    public function CompanyForm()
    {
        if (Security::getCurrentUser()->getCanEditCompany()) {
            $form = CompanyForm::create($this);
            if ($this->getRequest()->isGET()) {
                return json_encode(['success' => true, 'form' => $form->forTemplate()->getValue()], JSON_THROW_ON_ERROR);
            }

            return $form;
        }

        return json_encode(['success' => false, 'form' => false]);
    }

    public function ApplicationNoteForm()
    {
        $form = ApplicationNoteForm::create($this);
        if ($this->getRequest()->isGET()) {
            return json_encode(['success' => true, 'form' => $form->forTemplate()->getValue()]);
        }

        return $form;

    }

    public function ImportForm()
    {
        $form = ImportForm::create($this);
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
