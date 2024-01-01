<?php

namespace Firesphere\JobHunt\Models;

/**
 * Class \Firesphere\JobHunt\Models\ApplicationNote
 *
 * @property int $JobApplicationID
 * @method JobApplication JobApplication()
 */
class ApplicationNote extends BaseNote
{
    private static $table_name = 'ApplicationNote';

    private static $has_one = [
        'JobApplication' => JobApplication::class,
    ];

}
