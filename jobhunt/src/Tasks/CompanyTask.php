<?php

namespace Firesphere\JobHunt\Tasks;

use Firesphere\JobHunt\Models\Company;
use SilverStripe\Dev\BuildTask;

class CompanyTask extends BuildTask
{
    public function run($request)
    {
        $companies = Company::get()->filter(['Slug' => null]);
        foreach ($companies as $company) {
            $company->forceChange(true);
            $company->write();
        }
    }
}
