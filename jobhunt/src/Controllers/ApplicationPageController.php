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
    protected $HasFilter;
    protected $SortDirection;
    protected $sort;
    protected $filter;
    private static $allowed_actions = [
        'application'
    ];

    public function init()
    {
        Requirements::javascript('silverstripe/admin:client/dist/tinymce/tinymce.min.js');
        Requirements::css('silverstripe/admin:client/dist/styles/editor.css');
        parent::init();

        $this->filter = [];
        if ($this->getRequest()->getVar('filter')) {
            $requestFilter = $this->getRequest()->getVar('filter');
            foreach (JobApplication::$filters as $filterfield => $type) {
                if (array_key_exists($filterfield, $requestFilter)) {
                    $this->filter[$filterfield] = $requestFilter[$filterfield];
                    $this->HasFilter = true;
                }
            }
        } else {
            if (Security::getCurrentUser()->HideClosed) {
                $closed = Status::get()->filter(['AutoHide' => true])->column('ID');
                $this->filter['StatusID:Not'] = $closed;
            }
        }
        if ($this->getRequest()->getVar('sort')) {
            $requestsort = $this->getRequest()->getVar('sort');
            foreach (JobApplication::$sort as $sortfield) {
                if (array_key_exists($sortfield, $requestsort)) {
                    $direction = strtoupper($requestsort[$sortfield]);
                    $this->sort[$sortfield] = $direction === 'ASC' ? 'ASC' : 'DESC';
                    $this->SortDirection = $sortfield . $direction;
                }
            }
        } else {
            $this->sort = ['ApplicationDate' => 'DESC'];
        }

    }

    public function getStatusFilters()
    {
        return Status::get();
    }

    public function getApplications()
    {
        $applications = Security::getCurrentUser()->JobApplications();

        $applications = $applications->filter($this->filter)->sort($this->sort);

        return PaginatedList::create($applications, $this->getRequest());
    }


    public function application()
    {
        $params = $this->getURLParams();
        $this->Application = JobApplication::get()->filter(['ID' => $params['ID'], 'UserID' => Security::getCurrentUser()->ID]);

        return $this;
    }

}
