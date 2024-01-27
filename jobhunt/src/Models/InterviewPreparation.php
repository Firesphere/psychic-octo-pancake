<?php

namespace Firesphere\JobHunt\Models;

use Firesphere\JobHunt\Pages\InterviewPreparationPage;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Models\InterviewPreparation
 *
 * @property int $UserID
 * @property int $InterviewID
 * @method Member User()
 * @method Interview Interview()
 * @method DataList|QuestionAnswer[] QuestionAnswers()
 */
class InterviewPreparation extends DataObject
{

    private static $table_name = 'InterviewPreparation';

    private static $db = [
    ];

    private static $has_one = [
        'User'      => Member::class,
        'Interview' => Interview::class
    ];

    private static $has_many = [
        'QuestionAnswers' => QuestionAnswer::class,
    ];

    public function Link()
    {
        $page = InterviewPreparationPage::get()->first();

        return $page->Link('prepare/' . $this->ID);
    }
}
