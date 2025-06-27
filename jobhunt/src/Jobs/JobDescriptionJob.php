<?php

namespace Firesphere\JobHunt\Jobs;

use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Tasks\JobDescriptionTask;
use GuzzleHttp\Client;
use SilverStripe\Control\NullHTTPRequest;
use SilverStripe\Core\Injector\Injector;
use Symbiote\QueuedJobs\Services\AbstractQueuedJob;

class JobDescriptionJob extends AbstractQueuedJob
{

    public function getTitle()
    {
        return "Get job descriptions";
    }

    public function process()
    {
        $request = new NullHTTPRequest();
        Injector::inst()->get(JobDescriptionTask::class)->run($request);
    }
}
