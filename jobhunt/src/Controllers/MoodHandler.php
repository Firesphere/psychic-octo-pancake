<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\StateOfMind;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Controllers\MoodHandler
 *
 */
class MoodHandler extends Controller
{

    /**
     * @param HTTPRequest $request
     * @return string|void
     */
    public function index($request)
    {
        $response = $this->getResponse();
        $response->addHeader('content-type', 'application/json');
        $member = Security::getCurrentUser();
        if (!$request->isPost() || !$member) {
            $response->setStatusCode(403);
            $response->setBody(json_encode(['error' => true]));

            return $response;
        }

        if ($member->HasMood()) {
            $response->setBody(json_encode(['error' => true, 'mood' => $member->hasMood()]));

            return $response;
        }

        $body = json_decode($request->getBody(), true);

        StateOfMind::create([
            'Mood'   => $body['mood'],
            'UserID' => $member->ID
        ])->write();

        $response->setBody(json_encode(['error' => false, 'mood' => $body['mood']]));

        return $response;
    }
}
