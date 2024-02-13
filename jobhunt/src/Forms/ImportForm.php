<?php

namespace Firesphere\JobHunt\Forms;

use SilverStripe\Assets\Folder;
use SilverStripe\Control\RequestHandler;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Security\PermissionFailureException;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;

class ImportForm extends Form
{
    public const DEFAULT_NAME = 'ImportForm';

    public const HELPTEXT = '<p>For a CSV to be imported successfully, it must be formatted as below</p>
<pre>Company,Role,ApplicationDate,Status,Interview,Note
"TestCompany","Tester","15-06-2023","Applied","30-06-2023 12:00:00;02-07-2023 10:00:00","This is a note"
</pre>
<a href="%s" title="download example csv">Example CSV</a>
<p>The Interview field can contain multiple date-times, separated by a <code>;</code><br />If no status supplied, "Applied" will be used.
Interview and Note are optional fields.</p>';

    public function __construct(RequestHandler $controller = null, $name = self::DEFAULT_NAME)
    {
        $user = Security::getCurrentUser();
        if (!$user) {
            throw new PermissionFailureException('You need to be logged in.');
        }
        $config = SiteConfig::current_site_config();

        $fields = FieldList::create(
            LiteralField::create('help', sprintf(self::HELPTEXT, $config->DemoCSV()->Link())),
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
        $session = $this->controller->getRequest()->getSession();
        if ($session->get('CSV_HEADER') && $session->get('broken_too')) {
            $mapForm = MappingForm::create($this->controller);

            return json_encode(['success' => true, 'form' => $mapForm->forAjaxTemplate()->getValue()]);
        }
        $attachment = $data['Attachment'];
        if (!is_array($attachment)) {
            $this->controller->httpError(405);

            return;
        }

        /** Load CSV $csvAsArray */
        $csvAsArray = array_map('str_getcsv', file($attachment['tmp_name']));
        $columnNames = $csvAsArray[0];
        $session->set('CSV_HEADER', $columnNames);
        $mapForm = MappingForm::create($this->controller);
        $path = PUBLIC_PATH . DIRECTORY_SEPARATOR . ASSETS_DIR . '/.protected/' . $user->ID;
        if (!$path) {
            Folder::find_or_make($path);
        }
        $uniqueID = uniqid('csvupload', true);
        $tmpFile = file_put_contents($path . '/' . $uniqueID . '.csv', file_get_contents($attachment['tmp_name']));
        $session->set('TMP_FILE', $path . '/' . $uniqueID . '.csv');

        //        array_walk($csvAsArray, function (&$a) use ($csvAsArray) {
        //            $a = array_combine($csvAsArray[0], $a);
        //        });
        //        array_shift($csvAsArray); # remove column header
        //        $defaultStatus = Status::get()->filter(['Status' => 'Applied'])->first();
        //        $count = 0;
        //        foreach ($csvAsArray as $application) {
        //            if (!is_array($application) ||
        //                empty($application['Company']) ||
        //                empty($application['Role']) ||
        //                empty($application['ApplicationDate'])
        //            ) {
        //                continue;
        //            }
        //            $count++;
        //            foreach ($application as $key => &$value) {
        //                $value = trim($value);
        //            }
        //            unset($value);
        //            $status = Status::get()->filter(['Status' => trim($application['Status'])])->first();
        //            $company = Company::findOrCreate($application['Company']);
        //            $jobApplication = JobApplication::create([
        //                'Role'            => Convert::raw2sql($application['Role']),
        //                'ApplicationDate' => date('Y-m-d', strtotime($application['ApplicationDate'])),
        //                'Link'            => Convert::raw2sql($application['Link'] ?? ''),
        //                'StatusID'        => $status ? $status->ID : $defaultStatus->ID,
        //                'UserID'          => $user->ID,
        //                'CompanyID'       => $company
        //            ]);
        //            $jobApplication->write();
        //            if (!empty($application['Interview'])) {
        //                $dates = explode(';', $application['Interview']);
        //                foreach ($dates as $date) {
        //                    if (!(bool)strtotime($date)) {
        //                        continue;
        //                    }
        //                    $interview = Interview::create([
        //                        'DateTime'      => date('Y-m-d H:i:s', strtotime($date)),
        //                        'ApplicationID' => $jobApplication->ID
        //                    ]);
        //                    $interview->write();
        //                }
        //            }
        //            if (!empty($application['Note'])) {
        //                $note = ApplicationNote::create([
        //                    'Title'            => 'From import: ' . date('Y-m-d'),
        //                    'Note'             => Convert::raw2sql(strip_tags($application['Note'])),
        //                    'JobApplicationID' => $jobApplication->ID,
        //                ]);
        //                $note->write();
        //            }
        //        }

        unlink($attachment['tmp_name']);

        //        $this->controller->flashMessage('Imported ' . $count . ' applications', 'success');

        return json_encode(['success' => true, 'form' => $mapForm->forAjaxTemplate()->getValue()]);
    }
}
