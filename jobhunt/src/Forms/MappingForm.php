<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\ApplicationNote;
use Firesphere\JobHunt\Models\Company;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\StatusUpdate;
use Sheadawson\DependentDropdown\Forms\DependentDropdownField;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataObjectSchema;

class MappingForm extends Form
{
    const DEFAULT_NAME = 'MappingForm';

    const SKIP_FIELDS = [
        'ID',
        'Created',
        'LastEdited',
        'ClassName',
        'Hidden',
        'Archived',
        'ArchiveDate',
        'Slug',
    ];

    protected $fieldMap = [];

    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME)
    {
        $session = $controller->getRequest()->getSession()->get('CSV_HEADER');
        $map = $this->getFieldMap(null);
        $fields = [];
        $func = static function ($value) use ($map) {
            return $map[$value];
        };
        $selectMap = array_combine(array_keys($map), array_keys($map));
        foreach ($session as $key => $csvHeader) {
            $rpl = $csvHeader;
            if (empty($csvHeader)) {
                $rpl = "Empty or unparseable field at column " . $key;
            }
            $csvHeaderForForm = preg_replace("/[^A-Za-z0-9]/", '', $rpl);
            $csvHeaderForForm = strtolower($csvHeaderForForm);
            $this->fieldMap[$csvHeaderForForm] = $csvHeader;
            $csvHeader = $rpl;
            $group = FieldGroup::create(
                LiteralField::create('FieldName[' . $csvHeaderForForm . ']', sprintf('<h4 class="col-12">Field: "%s"</h4>', $csvHeader)),
                [
                    $sourceField = DropdownField::create('Type[' . $csvHeaderForForm . ']', 'Base-type of this field', $selectMap),
                    $fieldField = DependentDropdownField::create('Field[' . $csvHeaderForForm . ']', 'Most appropriate field', $func),
                    LiteralField::create('nan', '<br />')
                ]
            );
            $sourceField->addExtraClass('col form-select');
            $fieldField->addExtraClass('col form-select');
            $group->addExtraClass('row');
            $fieldField->setDepends($sourceField);
            $fields[] = $group;
        }


        $fieldList = FieldList::create($fields);
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Save')
        ]);
        $formAction->addExtraClass('btn btn-primary');

        parent::__construct($controller, $name, $fieldList, $actions);
    }

    public function getFieldMap($sourceKey = null)
    {
        if ($sourceKey === false) {
            return [];
        }
        $fieldMap = [
            'Ignored' => [],
        ];
        $manager = DataObjectSchema::singleton();
        $fieldMap['Application'] = $manager->databaseFields(JobApplication::class);
        $fieldMap['Company'] = $manager->databaseFields(Company::class);
        $fieldMap['Interview'] = $manager->databaseFields(Interview::class);
        $fieldMap['ApplicationNote'] = $manager->databaseFields(ApplicationNote::class);
        $fieldMap['StatusUpdate'] = $manager->databaseFields(StatusUpdate::class);

        foreach ($fieldMap as $fieldKey => &$value) {
            foreach (self::SKIP_FIELDS as $skip) {
                if (array_key_exists($skip, $value)) {
                    unset($value[$skip]);
                }
            }
            foreach ($value as $key => $type) {
                if (substr($key, -2) === 'ID') {
                    unset($value[$key]);
                }
            }
            $value = array_combine(array_keys($value), array_keys($value));
        }
        unset($value);

        $fieldMap['StatusUpdate']['StatusID'] = $fieldMap['Application']['StatusID'] = 'Status';

        if ($sourceKey) {
            return $fieldMap[$sourceKey];
        }

        return $fieldMap;
    }

    public function submit($data, $form)
    {
        $file = $this->controller->getRequest()->getSession()->get('TMP_PATH');
        $session = $this->controller->getRequest()->getSession()->get('CSV_HEADER');

        // Handle the mapping and save the shizzle
    }
}
