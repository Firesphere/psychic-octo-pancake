<?php

namespace Firesphere\App\Controllers;

use Firesphere\App\Models\Contact;
use PageController;
use SilverStripe\Control\Email\Email;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ValidationException;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\View\Requirements;
use X3dgoo\HCaptcha\Forms\HCaptchaField;

/**
 * Class \Firesphere\App\Controllers\ContactPageController
 *
 */
class ContactPageController extends PageController
{
    private static $allowed_actions = [
        'ContactForm',
        'submit'
    ];

    public function init()
    {
        parent::init();
    }

    public function ContactForm()
    {
        $fields = FieldList::create([
            $name = TextField::create('Name', 'Name'),
            $email = EmailField::create('Email', 'Email address'),
            $msg = TextareaField::create('Message', 'Message'),
            $spam = HCaptchaField::create('Spam')
        ]);

        $actions = FieldList::create([
            $submit = FormAction::create('submit', 'Submit')
        ]);

        $required = RequiredFields::create([
            'Name', 'Email', 'Message'
        ]);

        $submit->addExtraClass('btn btn-primary');

        return Form::create($this, __FUNCTION__, $fields, $actions, $required);
    }

    /**
     * @param $data
     * @param Form $form
     * @return HTTPResponse
     * @throws ValidationException
     */
    public function submit($data, $form)
    {
        $contact = Contact::create();

        $form->saveInto($contact);

        $contact->ContactPageID = $this->dataRecord->ID;

        $contact->write();

        $this->flashMessage('Thank you for your inquiry', 'success');

        $mail = Email::create();
        $mail->setFrom('website@firesphere.dev', 'Website');
        $mail->setReplyTo($data['Email'], $data['Name']);
        $mail->setTo('simon@firesphere.dev');
        $mail->setSubject('Jobhunt contact');
        $mail->setHTMLTemplate('WebsiteContact');
        $mail->setData($data);
        $mail->send();

        return $this->redirectBack();
    }
}
