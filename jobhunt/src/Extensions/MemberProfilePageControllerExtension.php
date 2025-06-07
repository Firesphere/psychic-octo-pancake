<?php

namespace Firesphere\JobHunt\Extensions;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\ConfirmedPasswordField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\Form;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;
use Symbiote\MemberProfiles\Pages\MemberProfilePageController;

/**
 * Class \Firesphere\JobHunt\Extensions\MemberProfilePageControllerExtension
 *
 * @property MemberProfilePageController|MemberProfilePageControllerExtension $owner
 */
class MemberProfilePageControllerExtension extends Extension
{
    private static $allowed_actions = [
        'archive'
    ];

    public function onAfterInit()
    {
        Requirements::javascript('silverstripe/admin:thirdparty/jquery-entwine/jquery.entwine.js');
        Requirements::javascript(
            'sheadawson/silverstripe-dependentdropdownfield:client/js/dependentdropdownfield.js'
        );

    }

    public function updateProfileForm(Form $form)
    {
        $form->addExtraClass('col-md-8 col-sm-12');
        //        $form->disableSpamProtection();
        $this->bootstrapForms($form);
    }

    protected function bootstrapForms(Form $form)
    {
        foreach ($form->Fields() as $field) {
            if ($field instanceof CheckboxField) {
                $field->addExtraClass('form-check-input');
            } elseif ($field instanceof DropdownField) {
                $field->addExtraClass('form-select');
            } elseif ($field instanceof ConfirmedPasswordField) {
                foreach ($field->children as $child) {
                    $child->addExtraClass('form-control');
                }
            } else {
                $field->addExtraClass('form-control');
            }
        }
        foreach ($form->Actions() as $action) {
            $action->addExtraClass('btn btn-outline-primary');
        }
    }

    public function updateRegisterForm(Form $form)
    {
        $this->bootstrapForms($form);
    }

    public function archive(HTTPRequest $request)
    {
        if (!$request->isPOST()) {
            $this->owner->redirectBack();

            return $this->owner;
        }
        $user = Security::getCurrentUser();
        if (!$user) {
            $this->owner->httpError(404);

            return $this->owner;
        }
        //        if (!$user->inGroups(['administrators', 'subscriber'])) {
        //            $this->owner->flashMessage('You are not allowed to archive');
        //
        //            $this->owner->redirectBack();
        //
        //            return $this->owner;
        //        }

        $postVars = $request->postVars();

        $token = Form::create()->getSecurityToken()->getValue();

        if (hash_equals($token, $postVars['SecurityID'])) {
            $applications = Security::getCurrentUser()
                ->JobApplications()
                ->filter(['Archived' => false]);
            foreach ($applications as $application) {
                $application->Archived = true;
                $application->ArchiveDate = date('Y-m-d');
                $application->write();
                $application->destroy();
            }
            $this->owner->flashMessage('All applications have been archived', 'success');
        }

        $this->owner->redirectBack();

        return $this->owner;
    }
}
