<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Forms\PreparationForm;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\InterviewPreparation;
use Firesphere\JobHunt\Pages\InterviewPreparationPage;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\InterviewPreparationPageController
 *
 * @property InterviewPreparationPage $dataRecord
 * @method InterviewPreparationPage data()
 * @mixin InterviewPreparationPage
 */
class InterviewPreparationPageController extends \PageController
{
    protected $Interview;

    private static $allowed_actions = [
        'prepare',
        'createPrep',
        'save'
    ];

    private static $url_handlers = [
        'create/$ID' => 'createPrep'
    ];

    protected function init()
    {
        parent::init();
        $this->user = Security::getCurrentUser();
        // No user or action, return
        if (!$this->user) {
            $this->httpError(403);
        }
        if ($this->urlParams['ID'] && $this->urlParams['Action'] === 'prepare') {
            $this->Interview = InterviewPreparation::get()->filter(['ID' => $this->urlParams['ID'], 'UserID' => $this->user->ID])->first();
            if (!$this->Interview) {
                $this->redirectBack();
            }
        }
    }

    public function getInterviewList()
    {
        return Interview::get()->filter(['Application.UserID' => $this->user->ID]);
    }

    public function prepare()
    {
        return $this;
    }

    public function PreparationForm()
    {
        $this->PreparationID = $this->getRequest()->param('ID');
        $form = PreparationForm::create($this);

        return $form;
        // Actual form for a single question here
    }

    public function createPrep(HTTPRequest $request)
    {
        $interviewId = $request->param('ID');

        $interview = Interview::get_by_id('ID');

        if (!$interview || $interview->Application()->UserID !== Security::getCurrentUser()->ID) {
            $this->redirectBack();
        }

        $prep = InterviewPreparation::create([
            'InterviewID' => $interviewId,
            'UserID'      => Security::getCurrentUser()->ID
        ]);

        $id = $prep->write();

        $this->setResponse(new HTTPResponse());

        $this->redirect($this->Link('prepare/' . $id));
    }
}
