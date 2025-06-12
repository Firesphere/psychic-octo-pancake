<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\Status;
use SilverStripe\ORM\DataList;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\GlobalStatsPageController
 *
 * @property GlobalStatsPage $dataRecord
 * @method GlobalStatsPage data()
 * @mixin GlobalStatsPage
 */
class GlobalStatsPageController extends \PageController
{

    private static $allowed_actions = [
        'getstats'
    ];

    public function init()
    {
        parent::init();
        Requirements::javascript('_resources/themes/jobhunt/dist/js/charts.js');

    }

    public function getStats()
    {
        /** @var DataList|Status[] $ghost */
        $ghost = Status::get()->filter(['AutoHide' => true]);
        $totalApplications = JobApplication::get()->count();
        $result = [];
        $labels = [];
        $colors = [];
        foreach ($ghost as $status) {
            $labels[] = $status->Status;
            $labels[] = $status->Status . ' %';
            $result[] = $status->Applications()->count();
            $result[] = number_format(($status->Applications()->count() / $totalApplications) * 100, 2);
            $colors[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $colors[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }
        $labels[] = 'Unanswered';
        $unansCount = JobApplication::get()
            ->filter([
                'ApplicationDate:LessThan' => date('Y-m-d 00:00', strtotime("-30 days"))
            ])
            ->filterByCallback(function ($item) {
                return $item->StatusUpdates()->count() === 0;
            })->count();
        $result[] = $unansCount;
        $labels[] = 'Unanswered %';
        $result[] = number_format(($unansCount / $totalApplications) * 100, 2);
        $colors[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        $colors[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        return json_encode([
            'type' => 'bar',
            'data' => [
                'labels'   => $labels,
                'datasets' => [
                    [
                        'label'           => 'Outcomes',
                        'data'            => $result,
                        'backgroundColor' => $colors
                    ]
                ]
            ]
        ]);
    }
}
