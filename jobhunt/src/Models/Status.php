<?php

namespace Firesphere\JobHunt\Models;

use Heyday\ColorPalette\Fields\ColorPaletteField;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class \Firesphere\JobHunt\Models\ApplicationStatus
 *
 * @property string $Status
 * @property string $Colour
 * @method DataList|JobApplication[] Applications()
 * @method DataList|StatusUpdate[] StatusUpdates()
 */
class Status extends DataObject
{

    private static $table_name = 'ApplicationStatus';

    private static $db = [
        'Status' => DBVarchar::class,
        'Colour' => DBVarchar::class,
    ];

    private static $has_many = [
        'Applications'  => JobApplication::class . '.Status',
        'StatusUpdates' => StatusUpdate::class . '.Status'
    ];

    private static $summary_fields = [
        'Status',
        'Colour'
    ];

    private static $default_records = [
        ['Status' => 'Applied'],
        ['Status' => 'Interview'],
        ['Status' => 'Response'],
        ['Status' => 'Invited'],
        ['Status' => 'Accepted'],
        ['Status' => 'Rejected - company'],
        ['Status' => 'Rejected - me'],
        ['Status' => 'Closed'],
        ['Status' => 'Ghosted'],
        ['Status' => 'Withdrawn']
    ];


    private static $colours = [
        'primary'   => '--bs-primary',
        'secondary' => '--bs-secondary',
        'success'   => '--bs-success',
        'danger'    => '--bs-danger',
        'warning'   => '--bs-warning',
        'info'      => '--bs-info',
        'light'     => '--bs-light',
        'dark'      => '--bs-dark',
        'link'      => '--bs-link',
    ];

    private static $colourmap = [
        ''                   => 'primary',
        'Applied'            => 'primary',
        'Interview'          => 'secondary',
        'Accepted'           => 'success',
        'Rejected - company' => 'danger',
        'Rejected - me'      => 'warning',
        'Invited'            => 'info',
        'Response'           => 'info',
        'Closed'             => 'dark',
        'Ghosted'            => 'dark',
        'Withdrawn'          => 'warning'
    ];


    public function getCMSFields()
    {
        if (!$this->Colour) {
            $this->Colour = self::$colourmap[$this->Status];
        }
        // Funky hack to get the colours :D
        $style = SiteConfig::current_site_config()->Theme;
        $style = file_get_contents(Director::baseFolder() . "/themes/jobhunt/dist/css/" . $style . '.min.css');
        $parser = new \CSSParser();
        $parser->read_from_string($style);
        $colours = ($parser->find_parent_by_property('--bs-primary')[0]["*/:root,[data-bs-theme=light]"]);
        foreach (static::$colours as $key => &$value) {
            if (isset($colours[$value])) {
                $value = $colours[$value];
            }
        }
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main',
            ColorPaletteField::create('Colour', 'Colour', static::$colours)
        );

        return $fields;
    }

    public function getColourStyle()
    {
        if (!$this->Colour) {
            return static::$colourmap[$this->Status];
        }

        return $this->Colour;
    }
}
