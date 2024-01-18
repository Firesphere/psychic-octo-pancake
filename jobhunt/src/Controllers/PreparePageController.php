<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\InterviewPreparation;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Controllers\PreparePageController
 *
 * @property PreparePage $dataRecord
 * @method PreparePage data()
 * @mixin PreparePage
 */
class PreparePageController extends \PageController
{
    protected $Preparation;

    private static $allowed_actions = [
        'save',
        'view'
    ];

    protected function init()
    {
        parent::init();
    }

    public function save(HTTPRequest $request)
    {

    }

    public function view(HTTPRequest $request)
    {
        $user = Security::getCurrentUser();
        if (!$user) {
            $this->httpError(403);

            return $this;
        }
        $this->Preparation = InterviewPreparation::get()
            ->filter(['ID' => $request->param('ID'), 'UserID' => $user->ID])
            ->first();

        if (!$this->Preparation) {
            $this->httpError(404);

            return $this;
        }

        return $this;
    }
}
