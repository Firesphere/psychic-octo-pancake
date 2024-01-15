<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\MoodPageController;
use IntlDateFormatter;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Pages\MoodPage
 *
 */
class MoodPage extends \Page
{
    private static $table_name = 'MoodPage';
    private static $controller_name = MoodPageController::class;
    private static $defaults = [
        'CanViewType' => 'LoggedInUsers'
    ];

    public function moods()
    {
        $user = Security::getCurrentUser();

        $moods = $user->Moods()
            ->filter([
                'Created:GreaterThan' => date('Y-m-d 00:00:00', strtotime('-1 month'))
            ]);

        $return = [];
        $formatter = IntlDateFormatter::create($user->getLocale(), \IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE);
        foreach ($moods as $mood) {
            $date = $formatter->format($mood->dbObject('Created')->getTimestamp());
            $return[$date] = $mood->Mood;
        }

        return [
            'labels' => array_keys($return),
            'values' => array_values($return)
        ];
    }
}
