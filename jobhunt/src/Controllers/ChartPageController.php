<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Extensions\MemberExtension;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Pages\ChartPage;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\GroupedList;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Controllers\SankeyPageController
 *
 * @property ChartPage $dataRecord
 * @method ChartPage data()
 * @mixin ChartPage
 */
class ChartPageController extends MoodPageController
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

        $itemList = [];
        $dataSet = ['Totals' => []];
        $labels = [];
        $draftState = Status::get()->filter(['Status' => 'Draft'])->first();
        $applications = $user->JobApplications()
            ->filter(['Archived' => false, 'StatusID:Not' => $draftState->ID])
            ->orderBy('ApplicationDate DESC');
        $appIds = $applications->column('ID');
        $appList = GroupedList::create($applications);
        $itemList['Applications'] = $appList->groupBy('getWeek');

        $interviewList = Interview::get()->filter(['ApplicationID' => $appIds]);
        $itemList['Interviews'] = GroupedList::create($interviewList)->groupBy('getWeek');
        $closeList = $user->JobApplications()->filter(['Status.AutoHide' => true]);
        $itemList['Closed'] = GroupedList::create($closeList)->groupBy('getWeek');

        $today = DBDatetime::now()->Format('y-MM-dd');
        $firstApplication = $applications->last()->dbObject('ApplicationDate')->format('y-MM-dd');
        $todayTimestring = strtotime("previous monday", strtotime($today));
        $startTimestring = strtotime('previous monday', strtotime($firstApplication));

        // Build a list of all the weeks, a tiny hack because the 'getWeek' doesn't return padded weeknums
        while ($startTimestring <= $todayTimestring) {
            $date = 'Week ' . date('W; Y', $startTimestring);
            $weeks[] = str_replace(' 0', ' ', $date); // It's adding a 0;
            $startTimestring = strtotime('+1 week', $startTimestring);
        }
        $lastTotal = 0;

        foreach ($weeks as $key) {
            foreach ($itemList as $type => $value) {
                $dataSet[$type][$key] = !empty($value[$key]) ? count($value[$key]->items) : 0;
            }
            $labels[] = $key;
            $dataSet['Totals'][$key] = $lastTotal + $dataSet['Applications'][$key] - $dataSet['Closed'][$key];
            $lastTotal = $dataSet['Totals'][$key];
        }
        $colours = Status::set_colour_map();

        $this->getResponse()->addHeader('content-type', 'application/json');

        $data = [
            'labels' => $labels,
            'data'   => [
                'applications' => [
                    'data'            => $dataSet['Applications'],
                    'backgroundColor' => $colours['info']
                ],
                'interviews'   => [
                    'data'            => $dataSet['Interviews'],
                    'backgroundColor' => $colours['success'],
                ],
                'closed'       => [
                    'data'            => $dataSet['Closed'],
                    'backgroundColor' => $colours['warning']
                ],
                'outstanding'  => [
                    'data'            => $dataSet['Totals'],
                    'backgroundColor' => $colours['dark']
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
