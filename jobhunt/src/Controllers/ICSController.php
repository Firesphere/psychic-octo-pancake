<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\Interview;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Member;
use SilverStripe\Security\PermissionFailureException;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Enums\Classification;

/**
 * Class \Firesphere\JobHunt\Controllers\ICSController
 *
 */
class ICSController extends Controller
{
    private static $allowed_actions = [
        'ical'
    ];

    public function ical(HTTPRequest $request)
    {
        $header = $request->param('ID');
        if (!$header) {
            $this->httpError(403);
        }
        $user = Member::get()->filter(['APIKey' => $header])->first();
//        Calendar::create()->
        $ics = Calendar::create('Interviews');
        $interviews = Interview::get()->filter(['Application.UserID' => $user->ID]);
        $events = [];
        foreach ($interviews as $interview) {
            $application = $interview->Application();
            $company = $application->Company();
            $startTime = new \DateTime($interview->DateTime);
            $duration = 60;
            if ($interview->Duration) {
                $duration = $interview->Duration;
            }
            $interval = new \DateInterval('PT' . $duration . 'M');
            $endTime = $startTime->add($interval);
            $event = Event::create('Interview at ' . $company->Name)
                ->startsAt(new \DateTime($interview->DateTime))
                ->endsAt($endTime)
                ->classification(Classification::private());
            if ($company->Address) {
                $event->address($company->Address);
                $event->addressName($company->Name);
            }
            $events[] = $event;
        }
        $ics->event($events);

        $response = $this->getResponse();
        $response->addHeader('content-type', 'text/calendar');

        return $response;
    }

}
