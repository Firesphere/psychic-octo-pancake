<?php

namespace Firesphere\JobHunt\Models;

use Firesphere\JobHunt\Extensions\OSMExtension;
use Firesphere\JobHunt\Pages\CompanyPage;
use Firesphere\OpenStreetmaps\Models\Location;
use GuzzleHttp\Client;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Environment;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class \Firesphere\JobHunt\Models\Company
 *
 * @property string $Name
 * @property string $Address
 * @property string $Country
 * @property string $Email
 * @property string $Link
 * @property string $Ethics
 * @property string $Slug
 * @property int $LogoID
 * @method Image Logo()
 * @method DataList|JobApplication[] Applications()
 * @method DataList|Interviewer[] Employees()
 * @method DataList|Location[] Locations()
 * @method DataList|CompanyNote[] Notes()
 */
class Company extends DataObject
{
    public static $colour_map = [
        'success' => 'Great',
        'info'    => 'Good',
        'primary' => 'Neutral',
        'danger'  => 'Not good',
        'warning' => 'Bad'
    ];
    private static $table_name = 'Company';
    private static $db = [
        'Name'    => DBVarchar::class,
        'Address' => DBText::class,
        'Country' => DBVarchar::class,
        'Email'   => DBVarchar::class,
        'Link'    => DBVarchar::class,
        'Ethics'  => DBEnum::class . '("success,info,primary,danger,warning", "info")',
        'Slug'    => DBVarchar::class,
    ];
    private static $has_one = [
        'Logo' => Image::class,
    ];

    private static $has_many = [
        'Applications' => JobApplication::class . '.Company',
        'Employees'    => Interviewer::class . '.Company',
        'Locations'    => Location::class . '.Company',
        'Notes'        => CompanyNote::class . '.Company',
    ];

    private static $owns = [
        'Logo',
    ];

    private static $cascade_deletes = [
        'Employees'
    ];

    private static $summary_fields = [
        'Name',
        'Email',
        'Link',
        'Slug'
    ];

    private static $indexes = [
        'Name' => true,
        'Slug' => true
    ];

    public static function findOrCreate($name)
    {
        $slug = SiteTree::singleton()->generateURLSegment($name);
        $exists = self::get()->filter(['Slug' => $slug])->first();

        if ($exists) {
            return $exists->ID;
        }

        return self::create(['Name' => $name, 'Slug' => $slug])->write();
    }

    public function onBeforeWrite()
    {
        if (!$this->Slug) {
            $this->Slug = SiteTree::singleton()->generateURLSegment($this->Name);
        }

        parent::onBeforeWrite();
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();
        $access_token = Environment::getEnv('MAPBOX_TOKEN');
        if ($access_token && $this->Country && $this->Address) {
            $client = new Client([
                'base_uri' => 'https://api.mapbox.com/geocoding/v5/mapbox.places/',
                'query'    => [
                    'access_token' => $access_token
                ]
            ]);
            $result = $client->get(urlencode($this->Address . ' ' . $this->Country) . '.json');

            if ((int)$result->getStatusCode() === 200) {
                $result = json_decode($result->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
                $data = [
                    'Name'      => $this->Name,
                    'Address'   => $this->Address,
                    'Country'   => $this->Country,
                    'URL'       => $this->Link,
                    'Latitude'  => $result['features'][0]['center'][1],
                    'Longitude' => $result['features'][0]['center'][0],
                ];
                /** @var Location|OSMExtension $location */
                if (!$this->Locations()->count()) {
                    $location = Location::create($data);
                } else {
                    $location = $this->Locations()->first();
                    $location->update($data);
                }
                $location->CompanyID = $this->ID;
                $location->write();
                try {
                    foreach ($result['features'][0]['context'] as $feature) {
                        if (str_starts_with($feature['id'], 'place') || str_starts_with($feature['id'], 'locality')) {
                            $location->City = $feature['text'];
                            break;
                        }
                    }
                    $location->write();
                } catch (\Exception $e) {
                    // No-op
                }
            }
        }
    }

    public function getEthicsToString()
    {
        return self::$colour_map[$this->Ethics] ?? 'info';
    }

    public function getEthicalLegend()
    {
        return ArrayList::create(self::$colour_map);
    }

    public function getInternalLink()
    {
        $page = CompanyPage::get()->first();

        if (!$page) {
            return '/';
        }

        return $page->Link('details/' . $this->Slug);
    }
}
