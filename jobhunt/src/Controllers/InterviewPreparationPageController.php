<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Pages\InterviewPreparationPage;
use SilverStripe\Security\Security;

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
        'save'
    ];

    protected function init()
    {
        parent::init();
        $user = Security::getCurrentUser();
        $params = $this->getRequest()->params();
        // No user or action, return
        if (empty($params['Action']) || empty($params['ID']) || !$user) {
            $this->redirectBack();
        }
        $this->Interview = Interview::get()->filter(['ID' => $params['ID'], 'UserID' => $user->ID])->first();
        if (!$this->Interview) {
            $this->redirectBack();
        }
    }

    public function prepare()
    {
        // Do things here, like put the form, and allow for more questions
    }

    public function PreparationForm()
    {
        // Actual form for a single question here
    }
}
