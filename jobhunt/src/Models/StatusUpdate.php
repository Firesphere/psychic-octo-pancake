<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\FieldType\DBBoolean;

/**
 * Class \Firesphere\JobHunt\Models\StatusUpdate
 *
 * @property bool $Hidden
 * @property int $StatusID
 * @property int $JobApplicationID
 * @method Status Status()
 * @method JobApplication JobApplication()
 * @method Interview Interview()
 */
class StatusUpdate extends BaseNote
{
    private static $table_name = 'StatusUpdate';

    private static $db = [
        'Hidden' => DBBoolean::class . '(false)'
    ];

    private static $belongs_to = [
        'Interview' => Interview::class . '.StatusUpdate',
    ];
    private static $has_one = [
        'Status'         => Status::class,
        'JobApplication' => JobApplication::class,
    ];

    private static $summary_fields = [
        'Title',
        'Status.Status',
        'Hidden.Nice',
        'Owner.FirstName',
        'JobApplication.ID'
    ];
}
