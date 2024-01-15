<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\ApplicationNote;
use Firesphere\JobHunt\Models\Company;
use Firesphere\JobHunt\Models\Interview;
use Firesphere\JobHunt\Models\JobApplication;
use Firesphere\JobHunt\Models\Status;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Core\Convert;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Security\Security;

class ImportForm extends Form
{
    public const DEFAULT_NAME = 'ImportForm';

    public const HELPTEXT = '<p>For a CSV to be imported successfully, it must be formatted as below</p>
<pre>Company,Role,ApplicationDate,Status,Interview,Note
"TestCompany","Tester","15-06-2023","Applied","30-06-2023 12:00:00;02-07-2023 10:00:00","This is a note"
</pre>
<p>The Interview field can contain multiple date-times, separated by a <code>;</code><br />If no status supplied, "Applied" will be used.
Interview and Note are optional fields.</p>';

    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME)
    {
        $fields = FieldList::create(
            LiteralField::create('help', self::HELPTEXT),
            FileField::create('Attachment', 'Attachments')
        );
        $actions = FieldList::create([
            $formAction = FormAction::create('submit', 'Import')
        ]);
        $formAction->addExtraClass('btn btn-primary');

        parent::__construct($controller, $name, $fields, $actions);
    }

    public function submit($data, $form)
    {
        // If there's no user, exit
        $user = Security::getCurrentUser();
        if (!$user) {
            $this->controller->httpError(403);

            return;
        }
        $attachment = $data['Attachment'];
        if (!is_array($attachment)) {
            $this->controller->httpError(405);

            return;
        }

        /** Load CSV $csvAsArray */
        $csvAsArray = array_map('str_getcsv', file($attachment['tmp_name']));
        array_walk($csvAsArray, function (&$a) use ($csvAsArray) {
            $a = array_combine($csvAsArray[0], $a);
        });
        array_shift($csvAsArray); # remove column header
        $defaultStatus = Status::get()->filter(['Status' => 'Applied'])->first();
        $count = 0;
        foreach ($csvAsArray as $application) {
            if (!is_array($application) ||
                empty($application['Company']) ||
                empty($application['Role']) ||
                empty($application['ApplicationDate'])
            ) {
                continue;
            }
            $count++;
            foreach ($application as $key => &$value) {
                $value = trim($value);
            }
            unset($value);
            $status = Status::get()->filter(['Status' => trim($application['Status'])])->first();
            $company = Company::findOrCreate($application['Company']);
            $jobApplication = JobApplication::create([
                'Role'            => Convert::raw2sql($application['Role']),
                'ApplicationDate' => date('Y-m-d', strtotime($application['ApplicationDate'])),
                'Link'            => Convert::raw2sql($application['Link'] ?? ''),
                'StatusID'        => $status ? $status->ID : $defaultStatus->ID,
                'UserID'          => $user->ID,
                'CompanyID'       => $company
            ]);
            $jobApplication->write();
            if (!empty($application['Interview'])) {
                $dates = explode(';', $application['Interview']);
                foreach ($dates as $date) {
                    if (!(bool)strtotime($date)) {
                        continue;
                    }
                    $interview = Interview::create([
                        'DateTime'      => date('Y-m-d H:i:s', strtotime($date)),
                        'ApplicationID' => $jobApplication->ID
                    ]);
                    $interview->write();
                }
            }
            if (!empty($application['Note'])) {
                $note = ApplicationNote::create([
                    'Title'            => 'From import: ' . date('Y-m-d'),
                    'Note'             => Convert::raw2sql(strip_tags($application['Note'])),
                    'JobApplicationID' => $jobApplication->ID,
                ]);
                $note->write();
            }
        }

        unlink($attachment['tmp_name']);

        $this->controller->flashMessage('Imported ' . $count . ' applications', 'success');

        return json_encode(['success' => true, 'form' => false]);
    }
}
