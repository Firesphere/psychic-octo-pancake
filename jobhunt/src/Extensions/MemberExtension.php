<?php

namespace Firesphere\JobHunt\Extensions;

use Firesphere\JobHunt\Models\BaseNote;
use Firesphere\JobHunt\Models\ExcludedStatus;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\StateOfMind;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\FieldType\DBBoolean;
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
        'HideClosed' => DBBoolean::class . '(false)'
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
}
