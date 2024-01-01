<?php

namespace Firesphere\JobHunt\Models;

/**
 * Class \Firesphere\JobHunt\Models\InterviewNote
 *
 * @property int $ApplicationInterviewID
 * @method Interview ApplicationInterview()
 */
class InterviewNote extends BaseNote
{
    private static $table_name = 'InterviewNote';

    private static $has_one = [
        'ApplicationInterview' => Interview::class
    ];
}
