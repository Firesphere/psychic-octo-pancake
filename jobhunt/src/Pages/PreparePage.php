<?php

namespace Firesphere\JobHunt\Pages;

use Firesphere\JobHunt\Controllers\PreparePageController;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Pages\PreparePage
 *
 */
class PreparePage extends \Page
{
    private static $table_name = 'PreparePage';

    private static $controller_name = PreparePageController::class;

    public function canCreate($member = null, $context = [])
    {
        $member = $member ?? Security::getCurrentUser();

        if ($member->inGroups(['Subscribers', 'Legacy'])) {
            return true;
        }

        return parent::canCreate($member, $context);
    }

    public function canEdit($member = null)
    {
        $member = $member ?? Security::getCurrentUser();

        if ($member->inGroups(['Subscribers', 'Legacy'])) {
            return true;
        }

        return parent::canEdit($member);
    }

    public function canView($member = null)
    {
        $member = $member ?? Security::getCurrentUser();

        if ($member->inGroups(['Subscribers', 'Legacy'])) {
            return true;
        }

        return parent::canView($member);
    }

    public function canDelete($member = null)
    {
        $member = $member ?? Security::getCurrentUser();

        if ($member->inGroups(['Subscribers', 'Legacy'])) {
            return true;
        }

        return parent::canDelete($member);
    }
}
