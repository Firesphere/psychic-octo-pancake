<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\Tag;
use LeKoala\FormElements\BsTagsMultiField;
use SilverStripe\Control\Controller;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\Validator;
use SilverStripe\Security\Security;

class TagForm extends Form
{
    public const DEFAULT_NAME = 'TagForm';

    public function __construct($id)
    {
        $controller = Controller::curr();
        $fields = FieldList::create([
            /** @var BsTagsMultiField $fieldTag */
            $fieldTag = BsTagsMultiField::create("Tags", ''),
            HiddenField::create("action_submit", '✅'),
            HiddenField::create('ID', 'ID', $id),
        ]);
        $fieldConfig = $fieldTag->getConfigAsJson();
        $myConfig = [
            'allowNew'      => "true",
            'Separator'     => " |,",
            'noCache'       => "false",
            'addOnBlur'     => "true",
            'allowMultiple' => "true",
        ];
        $fieldTag->replaceConfig(array_merge(json_decode($fieldConfig), $myConfig));
        $fieldTag->setAttribute('placeholder', 'Tags');
        if ($id !== -1) {
            $user = Security::getCurrentUser()->Tags();
            $fieldTag->setSource($user->map('ID', 'Title')->toArray());
            $application = JobApplication::get()->filter(['ID' => $id])->first();
            $currentTags = $application->Tags();//->column('ID');
            $fieldTag->setValue($currentTags);
        }
        $action = FieldList::create();
        $this->setFormAction('/home/TagForm');
        parent::__construct($controller, self::DEFAULT_NAME, $fields, $action);
    }

    public function submit($data, $form)
    {
        $data['Tags'] = $data['Tags'] ?? [];
        $user = Security::getCurrentUser();
        $application = JobApplication::get()->filter([
            'ID' => $data['ID'],
            'UserID' => $user->ID
        ])->first();
        $application->Tags()->removeAll();
        foreach ($data['Tags'] as $tag) {
            $foundTag = Tag::findOrCreate($tag);
            $foundTag->Applications()->add($application);
            $foundTag->write();
        }

        return json_encode(['success' => true]);
    }
}
