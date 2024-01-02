<?php

namespace Firesphere\JobHunt\Tasks;

use Firesphere\JobHunt\Extensions\MemberExtension;
use Firesphere\JobHunt\Models\Company;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Security\Group;
use SilverStripe\Security\Member;

class DeleteDemoData extends BuildTask
{
    public function run($request)
    {
        /** @var Member|MemberExtension $user */
        $user = Group::get()->filter(['Title' => 'Demo'])->first()->Members()->first();

        foreach ($user->JobApplications() as $application) {
            $application->delete();
        }

        $companies = Company::get()->filter(['Applications:Count' => 0]);
        foreach ($companies as $company) {
            $company->delete();
        }

    }
}
