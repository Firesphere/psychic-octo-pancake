<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Extensions\MemberExtension;
use Firesphere\JobHunt\Models\ApplicationNote;
use Firesphere\JobHunt\Models\Company;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\InterviewNote;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\Status;
use Firesphere\JobHunt\Models\StatusUpdate;
use Firesphere\JobHunt\Models\Tag;
use Firesphere\JobHunt\Pages\ApplicationPage;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\Security\Member;
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
    private static $allowed_actions = [
        'application',
        'delete',
        'TagForm',
        'tags',
        'drafts'
    ];
    public static $draftId;
    protected $HasFilter;
    protected $HasShowAll;
    protected $SortDirection;
    protected $sort = ['ApplicationDate' => 'DESC', 'Created' => 'DESC'];
    protected $filter = [];
    protected $JobApplication;
    protected $ActiveCompany;
    protected $Companies;
    protected $FavLink;
    /**
     * @var true
     */
    protected $FavSet;

    /**
     * @return mixed
     */
    public static function getDraftId()
    {
        if (!self::$draftId) {
            self::$draftId = Status::get()->filter(['Status' => 'Draft'])->first()?->ID;
        }

        return self::$draftId;
    }

    /**
     * @param mixed $draftId
     */
    public static function setDraftId($draftId): void
    {
        self::$draftId = $draftId;
    }

    public function init()
    {
        if (!Security::getCurrentUser()) {
            $this->httpError(403);
        }
        self::$draftId = Status::get()->filter(['Status' => 'Draft'])->first()?->ID;

        Requirements::javascript('silverstripe/admin:client/dist/tinymce/tinymce.min.js');
        parent::init();
        $this->FavLink = Status::create(['Status' => 'Favourites', 'Colour' => 'success']);

        $requestFilter = $this->getRequest()->getVar('filter');
        if ($requestFilter) {
            foreach (JobApplication::$filters as $filterfield => $type) {
                if (array_key_exists($filterfield, $requestFilter)) {
                    $this->filter[$filterfield] = $requestFilter[$filterfield];
                    $this->HasFilter = true;
                }
            }
        } else {
            $this->HasShowAll = $this->getRequest()->getVar('showall') ?? false;
            if (Security::getCurrentUser()->HideClosed && !$this->HasShowAll) {
                $closed = Status::get()->filter(['AutoHide' => true])->column('ID');
                $this->filter['StatusID:Not'] = $closed;
            }
        }
        if ($this->getRequest()->getVar('fav')) {
            $this->filter['Favourite'] = true;
            $this->FavSet = true;
        }
        if ($this->getRequest()->getVar('sort')) {
            $requestsort = $this->getRequest()->getVar('sort');
            foreach (JobApplication::$sort as $sortfield) {
                if (array_key_exists($sortfield, $requestsort)) {
                    $direction = strtoupper($requestsort[$sortfield]);
                    $this->sort = [$sortfield => $direction === 'ASC' ? 'ASC' : 'DESC'];
                    $this->SortDirection = $sortfield . $direction;
                }
            }
        }
        if ($this->getRequest()->getVar('company')) {
            $this->filter['CompanyID'] = $this->getRequest()->getVar('company');
            unset($this->filter['StatusID:Not']);
            $this->getCompanyList(false);
        }
    }

    public function getCompanyList($cached = true)
    {
        if ($cached && $this->Companies) {
            return $this->Companies;
        }
        /** @var MemberExtension|Member $user */
        $user = Security::getCurrentUser();
        if ($user->JobApplications()->Count()) {
            $this->Companies = $this->CompaniesList
                ->filter(['Applications.Archived' => false])
                ->sort('Name ASC');

            if ($this->getRequest()->getVar('company')) {
                $companyID = $this->getRequest()->getVar('company');
                $this->ActiveCompany = $this->Companies->filter(['ID' => $companyID])->first();
            }

            return $this->Companies;

        }

        return ArrayList::create();
    }

    public function getStatusFilters()
    {
        return Status::get();
    }

    public function getApplications()
    {
        $user = Security::getCurrentUser();

        $applications = $user->JobApplications();
        $applications = $applications->filter($this->filter)
            ->exclude(['Archived' => true])
            ->sort($this->sort);

        $list = PaginatedList::create($applications, $this->getRequest());
        if ($user->ViewStyle === 'Card') {
            $list->setPageLength(12);
        }

        return $list;
    }

    public function drafts()
    {
        $this->filter["Status.ID"] = self::getDraftId();
        return $this;
    }


    public function application()
    {
        $params = $this->getURLParams();
        $application = JobApplication::get()->filter([
            'ID'     => $params['ID'],
            'UserID' => Security::getCurrentUser()->ID
        ]);

        if (!$application || !$application->exists()) {
            $this->httpError(404, 'No job application found');
        }
        $this->JobApplication = $application->first();

        return $this;
    }

    public function delete(HTTPRequest $request)
    {
        $user = Security::getCurrentUser();

        $params = $this->getURLParams();
        $types = [
            'application'     => [
                'name'   => 'application',
                'class'  => JobApplication::class,
                'filter' => [
                    'ID'     => $params['OtherID'],
                    'UserID' => $user->ID
                ]
            ],
            'interview'       => [
                'name'   => 'interview',
                'class'  => Interview::class,
                'filter' => [
                    'ID'                 => $params['OtherID'],
                    'Application.UserID' => $user->ID
                ]
            ],
            'status'          => [
                'name'   => 'status update',
                'class'  => StatusUpdate::class,
                'filter' => [
                    'ID'                    => $params['OtherID'],
                    'JobApplication.UserID' => $user->ID
                ]
            ],
            'applicationnote' => [
                'name'   => 'application note',
                'class'  => ApplicationNote::class,
                'filter' => [
                    'ID'                    => $params['OtherID'],
                    'JobApplication.UserID' => $user->ID
                ]
            ],
            'interviewnote'   => [
                'name'   => 'interview note',
                'class'  => InterviewNote::class,
                'filter' => [
                    'ID'                           => $params['OtherID'],
                    'Interview.Application.UserID' => $user->ID
                ]
            ],
        ];
        if (!array_key_exists($params['ID'], $types)) {
            $this->httpError(404);

            return;
        }
        $type = $params['ID'];
        $class = $types[$type]['class'];
        $toDelete = $class::get()->filter($types[$type]['filter'])->first();

        if ($toDelete) {
            $toDelete->delete();
        }

        $this->flashMessage(sprintf('%s removed', ucfirst($types[$type]['name'])), 'warning');

        return $this->redirect($this->dataRecord->Link());
    }

    public function getShowAll()
    {
        $vars = $this->getRequest()->getVars();
        if (!isset($vars['showall'])) {
            $vars['showall'] = true;
        } else {
            unset($vars['showall']);
        }

        return http_build_query($vars);
    }

    public function tags(HTTPRequest $request)
    {
        $filter = [];
        if ($request->getVar('query')) {
            $filter['Title:PartialMatch'] = $request->getVar('query');
        }
        $tags = Tag::get()->filter($filter)->map('ID', 'Title')->toArray();

        return json_encode($tags);
    }

    public function TagForm()
    {
    }
}
