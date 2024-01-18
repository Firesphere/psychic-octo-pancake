<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Models\InterviewAnswer
 *
 * @property string $Content
 * @property int $QuestionID
 * @property int $PreparationID
 * @method InterviewQuestion Question()
 * @method InterviewPreparation Preparation()
 */
class InterviewAnswer extends DataObject
{
    private static $table_name = 'InterviewAnswer';

    private static $db = [
        'Content' => DBHTMLText::class
    ];

    private static $has_one = [
        'Question'    => InterviewQuestion::class,
        'Preparation' => InterviewPreparation::class
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
