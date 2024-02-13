<?php

namespace Firesphere\JobHunt\Forms;

use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\Form;

class CompanyNoteForm extends Form
{

    public const DEFAULT_NAME = 'CompanyNoteForm';

    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME)
    {
        parent::__construct();
    }

    public function submit($data, $form)
    {

    }
}
