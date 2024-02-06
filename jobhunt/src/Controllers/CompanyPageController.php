<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\Company;
use SilverStripe\Control\HTTPRequest;

/**
 * Class \Firesphere\JobHunt\Controllers\CompanyPageController
 *
 */
class CompanyPageController extends \PageController
{
    protected $company;

    private static $allowed_actions = [
        'details'
    ];

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    protected function init()
    {
        parent::init();
    }

    public function details(HTTPRequest $request)
    {
        $this->company = Company::get()->filter(['Slug' => $request->param('ID')])->first();

        return $this;
    }
}
