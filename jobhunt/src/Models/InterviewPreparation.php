<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Models\InterviewPreparation
 *
 * @property string $Title
 * @property int $InterviewID
 * @method Interview Interview()
 * @method DataList|InterviewAnswer[] Answers()
 * @method ManyManyList|InterviewQuestion[] Questions()
 */
class InterviewPreparation extends DataObject
{
    private static $table_name = 'InterviewPreparation';

    private static $db = [
        'Title' => DBVarchar::class
    ];

    private static $has_one = [
        'Interview' => Interview::class,
    ];

    private static $has_many = [
        'Answers' => InterviewAnswer::class . '.Preparation'
    ];

    private static $many_many = [
        'Questions' => InterviewQuestion::class
    ];

    public function canCreate($member = null, $context = [])
    {
        $member = $member ?? Security::getCurrentUser();

        if ($member->inGroups(['Subscribers', 'Legacy'])) {
            return true;
        }

        return parent::canCreate($member, $context);
    }

    public function canEdit($member = null)
    {
        $member = $member ?? Security::getCurrentUser();

        if ($member->inGroups(['Subscribers', 'Legacy'])) {
            return true;
        }

        return parent::canEdit($member);
    }

    public function canView($member = null)
    {
        $member = $member ?? Security::getCurrentUser();

        if ($member->inGroups(['Subscribers', 'Legacy'])) {
            return true;
        }

        return parent::canView($member);
    }

    public function canDelete($member = null)
    {
        $member = $member ?? Security::getCurrentUser();

        if ($member->inGroups(['Subscribers', 'Legacy'])) {
            return true;
        }

        return parent::canDelete($member);
    }
}
