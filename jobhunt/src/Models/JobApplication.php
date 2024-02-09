<?php

namespace Firesphere\JobHunt\Models;

use DOMDocument;
use Firesphere\JobHunt\Pages\ApplicationPage;
use LeKoala\FormElements\BsTagsMultiField;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Security\Member;

/**
 * Class \Firesphere\JobHunt\Models\JobApplication
 *
 * @property string $Role
 * @property string $ApplicationDate
 * @property string $ClosingDate
 * @property string $Link
 * @property int $PayUpper
 * @property int $PayLower
 * @property string $CoverLetter
 * @property bool $Archived
 * @property string $ArchiveDate
 * @property bool $Favourite
 * @property int $UserID
 * @property int $CompanyID
 * @property int $StatusID
 * @method Member User()
 * @method Company Company()
 * @method Status Status()
 * @method DataList|ApplicationNote[] Notes()
 * @method DataList|Interview[] Interviews()
 * @method DataList|StatusUpdate[] StatusUpdates()
 * @method ManyManyList|Tag[] Tags()
 */
class JobApplication extends DataObject
{
    public static $filters = [
        'StatusID' => 'int',
        'Company'  => 'string',
    ];
    public static $sort = [
        'ApplicationDate',
        'Company.Name',
    ];
    private static $table_name = 'JobApplication';
    private static $db = [
        'Role'            => DBVarchar::class,
        'ApplicationDate' => DBDate::class,
        'ClosingDate'     => DBDate::class,
        'Link'            => DBVarchar::class,
        'PayUpper'        => DBInt::class,
        'PayLower'        => DBInt::class,
        'CoverLetter'     => DBHTMLText::class,
        'Archived'        => DBBoolean::class,
        'ArchiveDate'     => DBDate::class,
        'Favourite'       => DBBoolean::class . '(false)',
    ];
    private static $has_one = [
        'User'    => Member::class,
        'Company' => Company::class,
        'Status'  => Status::class
    ];
    private static $cascade_deletes = [
        'Notes',
        'Interviews',
        'StatusUpdates'
    ];
    private static $has_many = [
        'Notes'         => ApplicationNote::class . '.JobApplication',
        'Interviews'    => Interview::class . '.Application',
        'StatusUpdates' => StatusUpdate::class . '.JobApplication',
    ];
    private static $many_many = [
        'Tags' => Tag::class
    ];

    private static $summary_fields = [
        'Company.Name',
        'Role',
        'ApplicationDate'
    ];

    private static $default_sort = 'ApplicationDate DESC, Created DESC';


    public function TagForm()
    {
        $fields = FieldList::create([
            $fieldTag = BsTagsMultiField::create('Tags', 'Tags'),
            HiddenField::create('ID', 'ID', $this->ID)
        ]);

        $page = ApplicationPage::get()->first();
        $fieldTag->setAttribute('data-allow-new', "true");
        $fieldTag->setAttribute('data-server', $page->Link('/tags'));
        $fieldTag->setAttribute('data-separator', " |,|  ");
        $fieldTag->setAttribute('data-config', [
            'noCache'   => "false",
            'addOnBlur' => "true",
        ]);

        $fieldTag->addCallbackMethod('onNewTag', function ($data) {
            print_r('The data:' . $data);
        });

        $action = FieldList::create([
            FormAction::create('submit', ':tick:')
        ]);

        $form = Form::create(Controller::curr(), 'TagForm', $fields, $action);
        $form->setAttribute('id', uniqid('', false));

        return $form;
    }


    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if ($this->CoverLetter) {
            try {
                $dom = new DOMDocument();

                $dom->loadHTML($this->CoverLetter, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $removeTags = ['script', 'style', 'iframe', 'link'];
                foreach ($removeTags as $tag) {
                    $script = $dom->getElementsByTagName($tag);
                    foreach ($script as $item) {
                        $item->parentNode->removeChild($item);
                    }
                }

                $this->CoverLetter = $dom->saveHTML();
            } catch (\Exception $exception) {
                //ignore
            }
        }
    }

    public function InternalLink()
    {
        $page = ApplicationPage::get()->first();

        return $page->Link('application/' . $this->ID);
    }

    public function StatusUpdatesVisibleCount()
    {
        return $this->StatusUpdates()->filter(['Hidden' => false])->count();
    }

    public function getIsOld()
    {
        if ($this->Status()->AutoHide) {
            return $this->Status()->getColourStyle();
        }
        $lastStatus = $this->StatusUpdates()->orderBy('Created ASC')->Last();
        $lastInterview = $this->Interviews()->orderBy('DateTime ASC')->last();
        if ($lastStatus) {
            /** @var int $lastStatus */
            $lastStatus = $lastStatus->dbObject('Created')->getTimestamp();
        }
        if ($lastInterview) {
            /** @var int $lastInterview */
            $lastInterview = $lastInterview->dbObject('DateTime')->getTimestamp();
        }

        $dates = [
            $lastStatus ?? 0,
            $lastInterview ?? 0,
            $this->dbObject('ApplicationDate')->getTimestamp(),
        ];

        $datetime = max(array_values($dates));
        $diffTime = DBDatetime::create();
        $diffTime->setValue(date('Y-m-d H:i:s', $datetime));

        [$diff] = explode(' ', $diffTime->TimeDiffIn('days'));

        $diff = (int)$diff;

        return match (true) {
            $diff < 8 => 'secondary',
            $diff <= 14 => 'info',
            $diff > 14 => 'warning',
            $diff >= 21 => 'danger',
            default => $this->Status()->Colour,
        };
    }

    public function getWeek()
    {
        return 'Week ' . $this->dbObject('ApplicationDate')->format('w; Y');
    }
}
