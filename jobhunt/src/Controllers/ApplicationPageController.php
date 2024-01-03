<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Pages\ApplicationPage;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\ApplicationPageController
 *
 * @property ApplicationPage $dataRecord
 * @method ApplicationPage data()
 * @mixin ApplicationPage
 */
class ApplicationPageController extends \PageController
{
    public $HasFilter;
    private static $allowed_actions = [
        'application'
    ];

    public function init()
    {
        Requirements::javascript('silverstripe/admin:client/dist/tinymce/tinymce.min.js');
        Requirements::css('silverstripe/admin:client/dist/styles/editor.css');
        parent::init();
        $this->HasFilter = !empty($this->getRequest()->getVar('filter'));
    }

    public function getStatusFilters()
    {
        return Status::get();
    }

    public function getApplications()
    {
        $applications = Security::getCurrentUser()->JobApplications();

        $filter = [];
        if ($this->getRequest()->getVar('filter')) {
            $requestFilter = $this->getRequest()->getVar('filter');
            foreach (JobApplication::$filters as $filterfield => $type) {
                if (array_key_exists($filterfield, $requestFilter)) {
                    $filter[$filterfield] = $requestFilter[$filterfield];
                }
            }
        }

        $applications = $applications->filter($filter);

        return PaginatedList::create($applications, $this->getRequest());
    }


    public function application()
    {
        $params = $this->getURLParams();
        $this->Application = $params['ID'];
    }

}
