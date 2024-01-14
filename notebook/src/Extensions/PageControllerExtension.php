<?php

namespace Firesphere\Notebook\Extensions;

use Firesphere\Notebook\Forms\NotebookForm;
use Firesphere\Notebook\Pages\NotebookPage;
use PageController;
use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\Notebook\Extensions\PageControllerExtension
 *
 * @property PageController|PageControllerExtension $owner
 */
class PageControllerExtension extends Extension
{
    private static $allowed_actions = [
        'NotebookForm'
    ];

    public function onAfterInit()
    {
        Requirements::javascript('silverstripe/admin:client/dist/tinymce/tinymce.min.js');
        Requirements::css('silverstripe/admin:client/dist/styles/editor.css');
        Requirements::javascript('firesphere/notebook:dist/main.js');
    }

    public function NotebookForm()
    {
        $page = NotebookPage::get()->first();
        if (!$page) {
            return;
        }
        $form = NotebookForm::create($this->owner);
        $form->setFormAction($page->Link('NotebookForm'));
        if ($this->owner->getRequest()->isAjax()) {
            return $form->forAjaxTemplate();
        }

        return $form;
    }

}
