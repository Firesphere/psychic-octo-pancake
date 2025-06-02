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
use Ramsey\Uuid\Uuid;
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
 * @property string $ShareKey
 * @method DataList|JobApplication[] JobApplications()
 * @method DataList|BaseNote[] Notes()
 * @method DataList|StateOfMind[] Moods()
 * @method DataList|ExcludedStatus[] ExcludedStatus()
 * @method DataList|Tag[] Tags()
 */
class MemberExtension extends DataExtension
{
    protected static $_job_applications;
    protected static $_job_application_ids;
    private static $db = [
        'CV'         => DBText::class,
        'PublicCV'   => DBBoolean::class . '(false)',
        'URLSegment' => DBVarchar::class,
        'HideClosed' => DBBoolean::class . '(false)',
        'ViewStyle'  => DBEnum::class . '("Table,Card", "Table")',
        'ShareKey'   => DBVarchar::class,
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

    /**
     * @return mixed
     */
    public static function getJobApplicationIds()
    {
        self::set_job_applications();

        return self::$_job_application_ids;
    }

    public static function set_job_applications()
    {
        if (!self::$_job_applications) {
            self::$_job_applications = Security::getCurrentUser()->JobApplications()->filter(['Archived' => false]);
            self::$_job_application_ids = self::$_job_applications->column('ID');
        }
    }

    public function onBeforeWrite()
    {
        if (!$this->owner->URLSegment) {
            $this->owner->URLSegment = SiteTree::singleton()->generateURLSegment(sprintf('%s %s', $this->owner->FirstName, $this->owner->Surname));
        }
        if (!$this->owner->ShareKey) {
            $uuid = Uuid::uuid4();
            $this->owner->ShareKey = $uuid->toString();
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
        self::set_job_applications();

        if (self::$_job_applications->count()) {
            $result = Interview::get()->filter([
                'ApplicationID' => self::$_job_application_ids,
            ]);
            if ($result->count()) {
                return $result;
            }
        }

        return ArrayList::create();
    }

    public function getStatusUpdates()
    {
        self::set_job_applications();

        if (self::$_job_applications->count()) {
            $result = StatusUpdate::get()->filter([
                'JobApplicationID' => self::$_job_application_ids,
                'Hidden'           => false
            ]);
            if ($result->count()) {
                return $result;
            }
        }

        return ArrayList::create();
    }

    public function getStatusNumbers()
    {
        self::set_job_applications();

        $return = [];
        $unshuffled = [];
        if (self::$_job_applications->count()) {
            $statusMap = Status::getIdMap();
            foreach (self::$_job_applications as $application) {
                $status = $statusMap[$application->StatusID];
                $unshuffled[$status] = isset($unshuffled[$status]) ? $unshuffled[$status] + 1 : 1;
            }
        }
        $keys = array_keys($unshuffled);
        shuffle($keys);

        foreach ($keys as $key) {
            $return[$key] = $unshuffled[$key];
        }
        return $return;
    }

    public function getOpenOutstanding()
    {
        self::set_job_applications();
        if (self::$_job_applications->count()) {
            $result = self::$_job_applications->filter(['Status.AutoHide' => false, 'Archived' => false]);
            if ($result->count()) {
                return $result;
            }
        }

        return ArrayList::create([JobApplication::create()]);
    }

    public function getCanEditCompany()
    {
        return $this->owner->inGroups(["administrators", "legacy", "subscriber"]);
    }

    public function getAppliedJobApplications()
    {
        self::set_job_applications();
        if (self::$_job_applications->count()) {
            $result = self::$_job_applications->filter(['Status.Status' => 'Applied', 'Archived' => false]);
            if ($result->count()) {
                return $result;
            }
        }

        return ArrayList::create([JobApplication::create()]);
    }

    public function getActiveApplications()
    {
        self::set_job_applications();
        if (self::$_job_applications->count()) {
            $result = self::$_job_applications->filter(['Archived' => false]);
            if ($result->count()) {
                return $result;
            }
        }
        return ArrayList::create([JobApplication::create()]);
    }

    public function getFollowUp()
    {
        self::set_job_applications();
        if (self::$_job_applications->count()) {
            $result = self::$_job_applications
                ->filter([
                    'Status.AutoHide'              => false,
                    'Archived'                     => false,
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
            if ($result->count()) {
                return $result;
            }
        }
        return ArrayList::create([JobApplication::create()]);
    }

    public function getClosedJobApplications()
    {
        self::set_job_applications();
        if (self::$_job_applications->count()) {

            $result = self::$_job_applications->filter(['Status.AutoHide' => true, 'Archived' => false]);
            if ($result->count()) {
                return $result;
            }
        }
        return ArrayList::create([JobApplication::create()]);
    }

    public function getInProgress()
    {
        self::set_job_applications();

        if (self::$_job_applications->count()) {
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
            $result = $list->exclude(['ID' => $int]);
            if ($result->count()) {
                return $result;
            }
        }
        return ArrayList::create([JobApplication::create()]);
    }

    public function getPostInterview()
    {
        self::set_job_applications();
        if (self::$_job_applications->count()) {
            $int = Interview::get()
                ->filter([
                    'ApplicationID'        => self::$_job_application_ids,
                    'DateTime:GreaterThan' => date('Y-m-d H:i:s')
                ])
                ->column('ApplicationID');
            if (!count($int)) {
                $int = [-1];
            }

            $result = self::$_job_applications
                ->filter([
                    'Status.Status' => 'Interview'
                ])
                ->exclude([
                    'ID' => $int
                ]);

            if ($result->count()) {
                return $result;
            }
        }
        return ArrayList::create([JobApplication::create()]);
    }

    public function getPreInterview()
    {
        self::set_job_applications();
        if (self::$_job_applications->count()) {

            $int = Interview::get()
                ->filter([
                    'DateTime:GreaterThan' => date('Y-m-d H:i:s'),
                    'ApplicationID'        => self::$_job_application_ids
                ])
                ->column('ApplicationID');

            $int = count($int) ? $int : [-1];

            $result = self::$_job_applications
                ->filter([
                    'Status.Status' => 'Interview',
                    'ID'            => $int
                ]);
            if ($result->count()) {
                return $result;
            }
        }
        return ArrayList::create([JobApplication::create()]);
    }
}
