<?php

namespace Firesphere\JobHunt\Extensions;

use Firesphere\JobHunt\Models\BaseNote;
use Firesphere\JobHunt\Models\ExcludedStatus;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\StateOfMind;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Models\StatusUpdate;
use Firesphere\JobHunt\Models\Tag;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

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
 * @method DataList|Tag[] Tags()
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
        'ExcludedStatus'  => ExcludedStatus::class . '.User',
        'Tags'            => Tag::class . '.User'
    ];

    private static $indexes = [
        'URLSegment' => true,
    ];

    protected static $_job_applications;
    protected static $_job_application_ids;

    /**
     * @return mixed
     */
    public static function getJobApplicationIds()
    {
        self::set_job_applications();

        return self::$_job_application_ids;
    }

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

    public static function set_job_applications()
    {
        if (!self::$_job_applications) {
            self::$_job_applications = Security::getCurrentUser()->owner->JobApplications()->filter(['Archived' => false]);
            self::$_job_application_ids = self::$_job_applications->column('ID');
        }
    }

    public function getInterviews()
    {
        self::set_job_applications();

        if (self::$_job_applications->count()) {
            return Interview::get()->filter([
                'ApplicationID' => self::$_job_application_ids,
            ]);
        }

        return ArrayList::create();
    }

    public function getStatusUpdates()
    {
        self::set_job_applications();

        if (self::$_job_applications->count()) {
            return StatusUpdate::get()->filter([
                'JobApplicationID' => self::$_job_application_ids,
                'Hidden'           => false
            ]);
        }

        return ArrayList::create();
    }

    public function getStatusNumbers()
    {
        self::set_job_applications();

        $return = [];
        if (self::$_job_applications->count()) {

            $applications = self::$_job_applications->shuffle();

            $statusMap = Status::getIdMap();
            foreach ($applications as $application) {
                $status = $statusMap[$application->StatusID];
                $return[$status] = isset($return[$status]) ? $return[$status] + 1 : 1;
            }
        }

        return $return;
    }

    public function getOpenOutstanding()
    {
        self::set_job_applications();
        if (!self::$_job_applications->count()) {
            return ArrayList::create([JobApplication::create()]);
        }

        if (self::$_job_applications->count()) {
            return self::$_job_applications->filter('Status.AutoHide', false);
        }

        return ArrayList::create();
    }

    public function getCanEditCompany()
    {
        return $this->owner->inGroups(["administrators", "legacy", "subscriber"]);
    }

    public function getAppliedJobApplications()
    {
        self::set_job_applications();
        if (!self::$_job_applications->count()) {
            return ArrayList::create([JobApplication::create()]);
        }

        $list = self::$_job_applications->filter(['Status.Status' => 'Applied']);

        if (!$list->count()) {
            return ArrayList::create([JobApplication::create()]);
        }

        return $list;
    }

    public function getFollowUp()
    {
        self::set_job_applications();
        if (!self::$_job_applications->count()) {
            return ArrayList::create([JobApplication::create()]);
        }

        $list = self::$_job_applications
            ->filter([
                'Status.AutoHide'              => false,
                'Interviews.DateTime:LessThan' => date('Y-m-d H:i:s')
            ])
            ->exclude([
                'Status.Status' => [
                    'Applied',
                    'Interview',
                    'Invited',
                    'Accepted'
                ]
            ]);

        if ($list->count()) {
            return $list;
        }

        return ArrayList::create([JobApplication::create()]);
    }

    public function getClosedJobApplications()
    {
        self::set_job_applications();
        if (!self::$_job_applications->count()) {
            return ArrayList::create([JobApplication::create()]);
        }

        $list = self::$_job_applications->filter(['Status.AutoHide' => true]);

        if (!$list->count()) {
            return ArrayList::create([JobApplication::create()]);
        }

        return $list;
    }

    public function getInProgress()
    {
        self::set_job_applications();

        if (!self::$_job_applications->count()) {
            return ArrayList::create([JobApplication::create()]);
        }
        $list = self::$_job_applications->exclude([
            'Status.Status' => [
                'Applied',
                'Interview',
                'Invited',
                'Accepted'
            ]
        ])
            ->filter(['AutoHide' => false]);

        $int = Interview::get()
            ->filter([
                'ApplicationID' => self::$_job_application_ids,
            ])->column('ApplicationID');

        $int = count($int) ? $int : [-1];
        $list = $list->exclude(['ID' => $int]);

        if ($list->count()) {
            return $list;
        }

        return ArrayList::create([JobApplication::create()]);

    }

    public function getPostInterview()
    {
        self::set_job_applications();
        if (!self::$_job_applications->count()) {
            return ArrayList::create([JobApplication::create()]);
        }
        $int = Interview::get()
            ->filter([
                'ApplicationID'        => self::$_job_application_ids,
                'DateTime:GreaterThan' => date('Y-m-d H:i:s')
            ])
            ->column('ApplicationID');
        if (!count($int)) {
            $int = [-1];
        }

        $return = self::$_job_applications
            ->filter([
                'Status.Status' => 'Interview'
            ])
            ->exclude([
                'ID' => $int
            ]);

        if (!$return->count()) {
            $return = ArrayList::create([JobApplication::create()]);
        }

        return $return;
    }

    public function getPreInterview()
    {
        self::set_job_applications();
        if (!self::$_job_applications->count()) {
            return ArrayList::create([JobApplication::create()]);
        }

        $int = Interview::get()
            ->filter([
                'DateTime:GreaterThan' => date('Y-m-d H:i:s'),
                'ApplicationID'        => self::$_job_application_ids
            ])
            ->column('ApplicationID');

        $int = count($int) ? $int : [-1];

        $return = self::$_job_applications
            ->filter([
                'Status.Status' => 'Interview',
                'ID'            => $int
            ]);
        if (!$return->count()) {
            $return = ArrayList::create([JobApplication::create()]);
        }

        return $return;
    }
}
