<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\SankeyPageController;
use Firesphere\JobHunt\Extensions\MemberExtension;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Models\StatusUpdate;
use Page;
use SilverStripe\ORM\DataList;
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
    public $StatusList;

    public function sankeyFlow()
    {
        /** @var Member|MemberExtension $user */
        $user = Security::getCurrentUser();

        $applications = $user->JobApplications()->filter(['Archived' => false]);
        foreach ($applications as $application) {
            $has = [];
            if (!$application->StatusUpdates()->count() && !$application->Interviews()->count()) {
                $this->countFlow(1, $application->StatusID, $has);
            } else {
                $currentFlow = 1; // We've not started yet, so everything is at least "applied"
                /** @var DataList|StatusUpdate[] $updates */
                $updates = $application->StatusUpdates()->Sort('Created ASC');
                foreach ($updates as $update) {
                    if ($update->StatusID === $currentFlow) {
                        continue;
                    }
                    $currentFlow = $this->countFlow($currentFlow, $update->StatusID, $has);
                }
                if ($update->StatusID !== $application->StatusID) {
                    $this->countFlow($update->StatusID, $application->StatusID, $has);
                }
            }
        }

        /** @var DataList|Status[] $colours */
        $stats = Status::get();
        $colours = Status::set_colour_map();
        $colour = [];
        $status = $stats->map('ID', 'Status')->toArray();
        foreach ($stats as $stat) {
            $colour[$stat->ID] = $colours[$stat->getColourStyle()];
        }
        foreach ($this->fromTo as $fromto) {
            if (!in_array($fromto['from'], $status) || !in_array($fromto['to'], $status)) {
                $from = explode('.', $fromto['from']);
                $to = explode('.', $fromto['to']);
                $status[$fromto['from']] = $status[$from[0]];
                $status[$fromto['to']] = $status[$to[0]];
                $colour[$fromto['from']] = $colour[$from[0]];
                $colour[$fromto['to']] = $colour[$to[0]];
            }
        }

        return ['values' => $this->getFromTo(), 'labels' => $status, 'colours' => $colour];
    }

    private function countFlow($from, $to, &$has)
    {
        if (array_key_exists($to, $has)) {
            $has[$to]++;
            $to .= '.' . $has[$to];
        } else {
            $has[$to] = 1;
        }
        if ($from !== $to) {
            foreach ($this->fromTo as $flow) {
                if ($flow['to'] === $from && $flow['from'] === $to) {
                    $has[$to]++;
                    $to .= '.' . $has[$to];
                }
            }
        }
        foreach ($this->fromTo as $key => &$flow) {
            if ($flow['from'] === $from && $flow['to'] === $to) {
                $flow['flow']++;

                return $to;
            }
        }
        unset($flow);
        $this->fromTo[] = [
            'from' => $from,
            'to'   => $to,
            'flow' => 1
        ];

        return $to;
    }

    public function getFromTo()
    {
        $orderMap = Status::get()->map('ID', 'SortOrder')->toArray();
        $fromTo = $this->fromTo;
        usort($fromTo, function ($a, $b) use ($orderMap) {
            $afrom = explode('.', $a['from']);
            $ato = explode('.', $a['to']);
            $bfrom = explode('.', $b['from']);
            $bto = explode('.', $b['to']);
            $retval = $orderMap[$afrom[0]] <=> $orderMap[$bfrom[0]];
            if ($retval === 0) {
                $retval = $orderMap[$ato[0]] <=> $orderMap[$bto[0]];
            }
            if ($retval === 0) {
                $retval = $a['flow'] <=> $b['flow'];
            }

            return $retval;
        });

        return $fromTo;
    }
}
