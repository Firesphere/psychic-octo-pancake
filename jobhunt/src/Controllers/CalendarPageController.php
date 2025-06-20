<?php

namespace Firesphere\JobHunt\Controllers;

use DateTime;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Pages\CalendarPage;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\CalendarPageController
 *
 * @property CalendarPage $dataRecord
 * @method CalendarPage data()
 * @mixin CalendarPage
 */
class CalendarPageController extends \PageController
{
    protected $Month;
    protected $Year;

    public function init()
    {
        parent::init();
        Requirements::css('_resources/themes/jobhunt/dist/css/calendar.css');
        $this->Month = date('F');
        $this->Year = date('Y');
    }

    public function getDays()
    {
        $list = ArrayList::create();
        $i = -2;
        while ($i <= 3) {
            $m = date('m', strtotime($i . ' months'));
            $y = date('Y', strtotime($i . ' months'));
            $data = ArrayData::create([
                'Year'  => $y,
                'Month' => date('F', strtotime('01-' . $m . '-2020')),
                'Cal'   => $this->getCalendarForMonth($m, $y)
            ]);
            $list->push($data);
            $i++;
        }

        return $list;
    }

    public function getCalendarForMonth($month, $year)
    {
        $user = Security::getCurrentUser();
        $list = ArrayList::create();

        $date = new DateTime(sprintf('%s-%s-01', $year, $month));
        $firstDayOfMonth = $date->format('N');
        $date->modify('last day of this month');
        $lastDayOfMonth = $date->format('d');
        $i = 1;

        while ($i < $firstDayOfMonth) {
            $list->push(
                ArrayData::create(['Empty' => true])
            );
            $i++;
        }
        $i = 1;
        $interviewFilter = [
            'Application.UserID'   => $user->ID,
            'Application.Archived' => false,
            'DateTime:Date:month'  => (int)$month,
            'DateTime:Date:year'   => (int)$year
        ];
        $applicationsFilter = [
            'UserID'                     => $user->ID,
            'Archived'                   => false,
            'ApplicationDate:Date:month' => (int)$month,
            'ApplicationDate:Date:year'  => (int)$year,
        ];
        [$monthInterviews, $monthInterviewCount, $interviewDays] = $this->getMonthData(Interview::class, $interviewFilter, 'DateTime');
        [$monthApplications, $monthApplicationCount, $applicationDays] = $this->getMonthData(JobApplication::class, $applicationsFilter, 'ApplicationDate');
        while ($i <= $lastDayOfMonth) {
            $data = [
                'Day'          => $i,
                'Today'        => ((int)date('j') === $i && (int)date('n') === (int)$month),
                'Interviews'   => null,
                'Applications' => null,
            ];
            if ($monthInterviewCount && in_array($i, $interviewDays)) {
                $data['Interviews'] = $monthInterviews
                    ->filter([
                        'DateTime:Date:day' => $i
                    ]);
            }
            if ($monthApplicationCount && in_array($i, $applicationDays)) {
                $data['Applications'] = $monthApplications
                    ->filter([
                        'ApplicationDate:Date:day' => $i
                    ]);
            }
            $list->push(ArrayData::create($data));
            $i++;
        }

        return $list;
    }

    /**
     * @param string $className
     * @param array $filter
     * @param string $col
     * @return array
     */
    public function getMonthData($className, $filter, $col): array
    {
        $monthItems = $className::get()
            ->filter($filter);

        $monthItemsCount = $monthItems->count();
        $itemDays = [];
        if ($monthItemsCount > 0) {
            $dates = $monthItems->column($col);
            foreach ($dates as $item) {
                $itemDays[] = date('d', strtotime($item));
            }
        }
        return [$monthItems, $monthItemsCount, $itemDays];
    }
}
