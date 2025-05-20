<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\Company;
use Firesphere\JobHunt\Pages\CompanyPage;
use Firesphere\OpenStreetmaps\Extensions\SiteConfigExtension;
use Firesphere\OpenStreetmaps\Services\OpenStreetmapService;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Environment;
use SilverStripe\ORM\ArrayList;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;

/**
 * Class \Firesphere\JobHunt\Controllers\CompanyPageController
 *
 * @property CompanyPage $dataRecord
 * @method CompanyPage data()
 * @mixin CompanyPage
 */
class CompanyPageController extends \PageController
{
    private static $allowed_actions = [
        'details'
    ];
    protected $company;

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    public function details(HTTPRequest $request)
    {


        return $this;
    }

    protected function init()
    {
        parent::init();
        if (!$this->getRequest()->param('Action')) {
            $this->httpError(404);
        }
        $this->company = Company::get()->filter(['Slug' => $this->getRequest()->param('ID')])->first();

        if (!$this->company) {
            $this->httpError(404);
        }
        Requirements::javascript('firesphere/openstreetmaps:dist/js/main.js');
        Requirements::css('firesphere/openstreetmaps:dist/css/main.css');
        Requirements::css('//api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css');
        $service = new OpenStreetmapService();
        if ($this->company->Locations()->exists()) {
            $list = ArrayList::create();
            foreach ($this->company->Locations() as $loc) {
                $loc->URL = $loc->Company()->Link;
                $loc->Address = nl2br($loc->Address);
                $list->push($loc);
            }
            /** @var SiteConfig|SiteConfigExtension $sc */
            $sc = SiteConfig::current_site_config();
            $sc->CenterLat = $list->First()->Latitude;
            $sc->CenterLng = $list->First()->Longitude;
            $service->addLocations($list);
        }
    }
}
