<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Extensions\MemberExtension;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Controllers\FilterController
 *
 */
class FilterController extends Controller
{
    private static $url_segment = 'applicationfilter';

    public function index(HTTPRequest $request)
    {
        /** @var Member|MemberExtension|null $user */
        $user = Security::getCurrentUser();
        if (!$user) {
            $this->httpError(403);
        }

        $filter = [];
        if ($request->postVar('type') === 'companyfilter') {
            $filter['Company.Name:PartialMatch'] = $request->postVar('search');
        }
        if ($request->postVar('type') === 'rolefilter') {
            $filter['Role:PartialMatch'] = $request->postVar('search');
        }

        $this->Applications = $user->JobApplications()
            ->filter($filter);

        if ($user->ViewStyle === 'Table') {
            $html = $this->renderWith('Includes\ApplicationRow');
        } else {
            $html = $this->renderWith('Includes\ApplicationCards');
        }
        $body = json_encode(['result' => $html->getValue()]);
        $this->getResponse()->addHeader('content-type', 'application/json');
        $this->getResponse()->setBody($body);

        return $this->getResponse();
    }
}
