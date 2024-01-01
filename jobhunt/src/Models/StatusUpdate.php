<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\JobHunt\Models\StatusUpdate
 *
 * @property int $StatusID
 * @property int $JobApplicationID
 * @method Status Status()
 * @method JobApplication JobApplication()
 */
class StatusUpdate extends BaseNote
{

    private static $table_name = 'StatusUpdate';

    private static $has_one = [
        'Status'         => Status::class,
        'JobApplication' => JobApplication::class
    ];
}
