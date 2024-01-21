<?php

namespace Firesphere\JobHunt\Controllers;

use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Controllers\FavController
 *
 */
class FavController extends Controller
{
    private static $allowed_actions = [
        'addremove'
    ];

    public function addremove(HTTPRequest $request)
    {
        $application = Security::getCurrentUser()
            ->JobApplications()
            ->filter([
                'ID' => $request->param('ID')
            ])
            ->first();
        if ($application) {
            $application->Favourite = !$application->Favourite;
            $application->write();
        }

        return json_encode(['success' => true]); // For all I care, crash.
    }

}
