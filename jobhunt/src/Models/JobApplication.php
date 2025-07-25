<?php

namespace Firesphere\JobHunt\Models;

use DOMDocument;
use Firesphere\JobHunt\Controllers\ApplicationPageController;
use Firesphere\JobHunt\Forms\TagForm;
use Firesphere\JobHunt\Pages\ApplicationPage;
use LeKoala\FormElements\BsTagsMultiField;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\ArrayList;
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
use SilverStripe\View\ArrayData;

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
 * @property bool $Draft
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
        'Draft'           => DBBoolean::class . '(false)'
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
        if (Controller::curr()->IsSharePage) {
            return '';
        }
        $form = TagForm::create($this->ID);
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
        if ($this->Status()->AutoHide || $this->Status()->ID === ApplicationPageController::getDraftId()) {
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
        $multiplier = $diffTime >= DBDatetime::now() ? -1 : 1;
        [$diff] = explode(' ', $diffTime->TimeDiffIn('days'));
        $diff = (int)$diff * $multiplier;

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

    public function getTimeLine()
    {
        $return = ArrayList::create();
        /** @var DataList|StatusUpdate[] $updates */
        $updates = $this->StatusUpdates();
        /** @var DBDate $startDate */
        $startDate = $this->dbObject('ApplicationDate');
        // @todo set last day to +7 from last status, if last status has AutoHide
        $today = DBDatetime::now();
        if ($this->Status()->AutoHide && $updates->exists()) {
            /** @var DBDatetime $today */
            $today = $updates->last()->dbObject('Created');
            $today->modify('+2 days');
        } elseif ($this->Status()->AutoHide) {
            $today = $this->dbObject('LastEdited');
        }

        $diff = $today->getTimestamp() - $startDate->getTimestamp();
        $totalDays = round($diff / 86400);
        $status = Status::create(['Status' => 'Applied']);
        $startBar = 0;
        $cent = 100;
        foreach ($updates as $update) {
            $updateCreated = $update->dbObject('Created')->getTimestamp();
            $days = round(($updateCreated - $startDate->getTimestamp()) / 86400);
            $percentage = round(($days / $totalDays) * 100);
            $cent -= $percentage;
            $item = [
                'Status'   => $status->Status,
                'Colour'   => $status->getColourStyle(),
                'Size'     => $percentage,
                'Start'    => $startBar,
                'End'      => $startBar + $percentage,
                'StartDay' => $startDate->format('d MMM yyyy'),
                'EndDay'   => $update->dbObject('Created')->format('d MMM yyyy')
            ];
            $startBar += $percentage;
            $return->push($item);
            $startDate = $update->dbObject('Created');
            $status = $update->Status();
        }
        $item = [
            'Status'   => $this->Status()->Status,
            'Colour'   => $this->Status()->getColourStyle(),
            'Size'     => $cent,
            'Start'    => $startBar,
            'End'      => 100,
            'StartDay' => $startDate->format('d MMM yyyy'),
            'EndDay'   => $this->Status()->AutoHide ? $today->format('d MMM yyyy') : 'Unknown'
        ];
        $return->push($item);
        return $return;
    }
}
