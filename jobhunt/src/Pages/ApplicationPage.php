<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\ApplicationPageController;
use Firesphere\JobHunt\Controllers\ArchivePageController;
use Firesphere\JobHunt\Extensions\MemberExtension;
use Firesphere\JobHunt\Models\Status;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Pages\ApplicationPage
 *
 */
class ApplicationPage extends \Page
{
    private static $table_name = 'ApplicationPage';
    private static $controller_name = ApplicationPageController::class;

    private static $defaults = [
        'CanViewType' => 'LoggedInUsers'
    ];

    public function onBeforeWrite()
    {
        $this->CanViewType = 'LoggedInUsers';
        parent::onBeforeWrite();
    }

    public function getShareLink()
    {
        return ShareMyPage::my_share_link('table');
    }

    public function getCompanyList($cached = true)
    {
        $controller = Controller::curr();
        if ($cached && $controller->Companies) {
            return $controller->Companies;
        }
        /** @var MemberExtension|Member $user */
        $user = Security::getCurrentUser();
        if ($user->JobApplications()->Count()) {
            $controller->Companies = $controller->CompaniesList
                ->filter(['Applications.Archived' => false])
                ->sort('Name ASC');

            if ($controller->getRequest()->getVar('company')) {
                $companyID = $controller->getRequest()->getVar('company');
                $controller->ActiveCompany = $controller->Companies->filter(['ID' => $companyID])->first();
            }

            return $controller->Companies;

        }

        return ArrayList::create();
    }

    public function getStatusFilters()
    {
        return Status::get();
    }

    public function getApplications($archived = false)
    {
        $controller = Controller::curr();
        $user = Security::getCurrentUser();

        $applications = $user->JobApplications();
        $applications = $applications->filter($controller->filter)
            ->exclude(['Archived' => !$archived])
            ->sort($controller->sort);

        $list = PaginatedList::create($applications, $controller->getRequest());
        if ($user->ViewStyle === 'Card') {
            $list->setPageLength(12);
        }

        return $list;
    }

    public function getApplicationsLink($segment = null)
    {
        if ($this instanceof ArchivePage) {
            return $this->Parent()->Link($segment);
        }

        return $this->Link($segment);
    }

    public function getArchivedLink()
    {
        if ($this instanceof ArchivePage) {
            return $this->Link();
        }
        return $this->Children()->first()->Link();
    }

}
