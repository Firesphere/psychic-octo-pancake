<?php

namespace Firesphere\JobHunt\Extensions;

use Firesphere\JobHunt\Models\BaseNote;
use Firesphere\JobHunt\Models\ExcludedStatus;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\StateOfMind;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Models\StatusUpdate;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Extensions\MemberExtension
 *
 * @property Member|MemberExtension $owner
 * @property string $CV
 * @property bool $PublicCV
 * @property string $URLSegment
 * @property bool $HideClosed
 * @property string $ViewStyle
 * @method DataList|JobApplication[] JobApplications()
 * @method DataList|BaseNote[] Notes()
 * @method DataList|StateOfMind[] Moods()
 * @method DataList|ExcludedStatus[] ExcludedStatus()
 */
class MemberExtension extends DataExtension
{
    private static $db = [
        'CV'         => DBText::class,
        'PublicCV'   => DBBoolean::class . '(false)',
        'URLSegment' => DBVarchar::class,
        'HideClosed' => DBBoolean::class . '(false)',
        'ViewStyle'  => DBEnum::class . '("Table,Card", "Table")'
    ];

    private static $has_many = [
        'JobApplications' => JobApplication::class . '.User',
        'Notes'           => BaseNote::class . '.Owner',
        'Moods'           => StateOfMind::class . '.User',
        'ExcludedStatus'  => ExcludedStatus::class . '.User'
    ];

    private static $indexes = [
        'URLSegment' => true,
    ];

    protected static $_job_applications;
    protected static $_job_application_ids;

    public function onBeforeWrite()
    {
        if (!$this->owner->URLSegment) {
            $this->owner->URLSegment = SiteTree::singleton()->generateURLSegment(sprintf('%s %s', $this->owner->FirstName, $this->owner->Surname));
        }
        parent::onBeforeWrite();
    }

    public function hasMood()
    {
        $mood = $this->owner->Moods()->filter(['Created:StartsWith' => date('Y-m-d')]);
        if ($mood->count()) {
            return $mood->last()->Mood;
        }

        return false;
    }

    public function getInterviews()
    {
        if (!self::$_job_applications) {
            self::$_job_applications = $this->owner->JobApplications();
            self::$_job_application_ids = self::$_job_applications->column('ID');
        }
        return Interview::get()->filter([
            'ApplicationID' => self::$_job_application_ids
        ]);
    }

    public function getStatusUpdates()
    {
        if (!self::$_job_applications) {
            self::$_job_applications = $this->owner->JobApplications();
            self::$_job_application_ids = self::$_job_applications->column('ID');
        }
        return StatusUpdate::get()->filter([
            'JobApplicationID' => self::$_job_application_ids,
            'Hidden'           => false
        ]);
    }

    public function getStatusNumbers()
    {
        if (!self::$_job_applications) {
            self::$_job_applications = $this->owner->JobApplications();
            self::$_job_application_ids = self::$_job_applications->column('ID');
        }
        $applications = self::$_job_applications->shuffle();

        $return = [];
        $statusMap = Status::getIdMap();
        foreach ($applications as $application) {
            $status = $statusMap[$application->StatusID];
            $return[$status] = isset($return[$status]) ? $return[$status] + 1 : 1;
        }

        return $return;
    }

    public function getOpenOutstanding()
    {
        $numbers = $this->getStatusNumbers();
        return self::$_job_applications->filter('Status.AutoHide', false);
    }
}
