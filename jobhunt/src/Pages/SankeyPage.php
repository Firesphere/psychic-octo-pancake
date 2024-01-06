<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\SankeyPageController;
use Firesphere\JobHunt\Extensions\MemberExtension;
use Firesphere\JobHunt\Models\Status;
use Page;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\Map;
use SilverStripe\ORM\SS_List;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Pages\SankeyPage
 *
 */
class SankeyPage extends Page
{
    private static $table_name = 'SankeyPage';
    private static $controller_name = SankeyPageController::class;
    private static $defaults = [
        'CanViewType' => 'LoggedInUsers'
    ];

    protected $fromTo = [];

    public function sankeyFlow()
    {
        /** @var Member|MemberExtension $user */
        $user = Security::getCurrentUser();

        $applications = $user->JobApplications();
        foreach ($applications as $application) {
            if (!$application->StatusUpdates()->count() && !$application->Interviews()->count()) {
                $this->countFlow(1, $application->StatusID);
            } else {
                $currentFlow = 1; // We've not started yet, so everything is at least "applied"
                $updates = $application->StatusUpdates()->map('Created', 'StatusID')->toArray();
                foreach ($updates as $when => $update) {
                    if ($update === $currentFlow) {
                        continue;
                    }
                    $this->countFlow($currentFlow, $update);
                    $currentFlow = $update;
                }
                if ($update !== $application->StatusID) {
                    $this->countFlow($update, $application->StatusID);
                }
            }
        }

        /** @var DataList|Status[] $colours */
        $colours = Status::get();
        $colour = [];
        $status = [];
        foreach ($colours as $stat) {
//            $colour[$stat->ID] = $stat->getColourStyle();
            $status[$stat->ID] = $stat->Status;
        }
        return ['values' => $this->fromTo, 'labels' => $status, 'colours' => $colour];
    }

    private function countFlow($from, $to)
    {
        foreach ($this->fromTo as $key => &$flow) {
            if ($flow['from'] === $from && $flow['to'] === $to) {
                $flow['flow']++;
                return;
            }
        }
        $this->fromTo[] = [
            'from' => $from,
            'to'   => $to,
            'flow' => 1
        ];

    }
}
