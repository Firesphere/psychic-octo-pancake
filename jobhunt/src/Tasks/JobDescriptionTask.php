<?php

namespace Firesphere\JobHunt\Tasks;

use Firesphere\JobHunt\Models\JobApplication;
use GuzzleHttp\Client;
use SilverStripe\Dev\BuildTask;

class JobDescriptionTask extends BuildTask
{

    public function run($request)
    {
        $applications = JobApplication::get()
            ->filter([
                'JobDescription' => null,
                'Link:not' => ['', null]
            ])
        ->orderBy('Created DESC');
        foreach ($applications as $application) {
            $client = new Client();
            $result = $client->request('GET', $application->Link, [
                'headers' => [
                    'User-Agent' => "Mozilla/5.0 (X11; Linux x86_64; rv:141.0) Gecko/20100101 Firefox/141.0",
                ]
            ]);

            print_r($result->getBody());
            exit;
        }

    }
}
