<?php

namespace Firesphere\JobHunt\Extensions;

use Firesphere\JobHunt\Models\Company;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataExtension;

/**
 * Class \Firesphere\JobHunt\Extensions\ImageExtension
 *
 * @property Image|ImageExtension $owner
 * @method Company Company()
 */
class ImageExtension extends DataExtension
{
    private static $belongs_to = [
        'Company' => Company::class . '.Logo'
    ];
}
