<?php

namespace Firesphere\JobHunt\Models;

use Firesphere\JobHunt\Pages\ApplicationPage;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\ManyManyList;

/**
 * Class \Firesphere\JobHunt\Models\ApplicationInterview
 *
 * @property string $DateTime
 * @property int $Duration
 * @property int $ApplicationID
 * @property int $StatusUpdateID
 * @method JobApplication Application()
 * @method StatusUpdate StatusUpdate()
 * @method DataList|InterviewNote[] Notes()
 * @method ManyManyList|Interviewer[] Interviewers()
 */
class Interview extends DataObject
{
    private static $table_name = 'Interview';

    private static $db = [
        'DateTime' => DBDatetime::class,
        'Duration' => DBInt::class
    ];

    private static $has_one = [
        'Application'  => JobApplication::class,
        'StatusUpdate' => StatusUpdate::class,
    ];

    private static $many_many = [
        'Interviewers' => Interviewer::class
    ];
    private static $has_many = [
        'Notes' => InterviewNote::class . '.ApplicationInterview'
    ];

    private static $summary_fields = [
        'Application.User.FirstName',
        'DateTime.Nice',
        'StatusUpdate.ID'
    ];

    private static $cascade_deletes = [
        'Notes',
        'StatusUpdate'
    ];

    public function onBeforeWrite()
    {
        if (!$this->isInDB()) {
            $status = Status::get()->filter(['Status' => 'Interview'])->first();
            $this->Application()->StatusID = $status->ID;
            $this->Application()->write();
        }
        parent::onBeforeWrite(); // TODO: Change the autogenerated stub
    }

    public function deleteLink()
    {
        $page = ApplicationPage::get()->first();

        $delete = sprintf('delete/interview/%d', $this->ID);

        return $page->Link($delete);
    }
}
