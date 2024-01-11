<?php

namespace Firesphere\JobHunt\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\ConfirmedPasswordField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\Form;
use Symbiote\MemberProfiles\Pages\MemberProfilePageController;

/**
 * Class \Firesphere\JobHunt\Extensions\MemberProfilePageControllerExtension
 *
 * @property MemberProfilePageController|MemberProfilePageControllerExtension $owner
 */
class MemberProfilePageControllerExtension extends Extension
{
    public function updateProfileForm(Form $form)
    {
        $form->addExtraClass('col-8');
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
}
