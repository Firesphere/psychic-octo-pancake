<?php

namespace Firesphere\JobHunt\Extensions;

use Firesphere\JobHunt\Models\Company;
use Firesphere\OpenStreetmaps\Models\Location;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBBoolean;

/**
 * Class \Firesphere\JobHunt\Extensions\OSMExtension
 *
 * @property Location|OSMExtension $owner
 * @property bool $Primary
 * @property int $CompanyID
 * @method Company Company()
 */
class OSMExtension extends DataExtension
{
    private static $db = [
        'Primary' => DBBoolean::class,
    ];
    private static $has_one = [
        'Company' => Company::class
    ];
}
