<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Extensions\MemberExtension;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Pages\SankeyPage;
use SilverStripe\ORM\GroupedList;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Controllers\SankeyPageController
 *
 * @property SankeyPage $dataRecord
 * @method SankeyPage data()
 * @mixin SankeyPage
 */
class SankeyPageController extends MoodPageController
{
    private static $allowed_actions = [
        'getChartData',
        'getOtherCharts'
    ];

    public function getChartData()
    {
        $data = $this->dataRecord->sankeyFlow();

        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    public function getOtherCharts()
    {
        /** @var Member|MemberExtension $user */
        $user = Security::getCurrentUser();
        if (!$user) {
            $this->httpError(403);
        }

        $applications = $user->JobApplications()->orderBy('ApplicationDate DESC');
        $appIds = $applications->column('ID');
        $list = GroupedList::create($applications);
        $list = $list->groupBy('getWeek');
        $numbers = [];
        $weeks = [];
        $interviews = [];
        foreach ($list as $key => $value) {
            $weeks[] = $key;
            $numbers[] = $value->count();
        }
        $interviewList = Interview::get()->filter(['ApplicationID' => $appIds]);
        $intList = GroupedList::create($interviewList)->groupBy('getWeek');
        foreach ($weeks as $week => $weekNum) {
            [, $weekNumber,] = explode(' ', $weekNum);
            $weekNumber = (int)trim($weekNumber, ';');
            if (array_key_exists($weekNumber, $intList)) {
                $item = $intList[$weekNumber];
                $interviews[] = count($item->items) ?? 0;
            } else {
                $interviews[] = 0;
            }
//            $updates = StatusUpdate::get()->filter(['AutoHide' => false, 'Status.ID:Not' => [1]]);
        }
        $appColour = Status::get()->filter(['Status' => 'Applied'])->first()->getColourStyle();
        $interviewColour = Status::get()->filter(['Status' => 'Interview'])->first()->getColourStyle();
        $colours = Status::set_colour_map();

        $this->getResponse()->addHeader('content-type', 'application/json');

        $data = [
            'labels' => array_reverse($weeks),
            'data'   => [
                'applications' => [
                    'data'            => array_reverse($numbers),
                    'backgroundColor' => $colours[$appColour]
                ],
                'interviews'   => [
                    'data'            => array_reverse($interviews),
                    'backgroundColor' => $colours[$interviewColour],
                ]

            ]
        ];

        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    public function getStatusList()
    {
        return Status::get();
    }
}
