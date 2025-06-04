<?php

namespace {

    use Cashware\Bootswatcher\SiteConfigTheme;
    use Firesphere\AdblockWarning\Extensions\SiteConfigExtension;
    use Firesphere\JobHunt\Extensions\MemberExtension;
    use Firesphere\JobHunt\Models\Company;
    use Firesphere\ModuleHelpers\Extensions\PageControllerExtension;
    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\Core\Environment;
    use SilverStripe\Dev\Debug;
    use SilverStripe\Security\Member;
    use SilverStripe\Security\Security;
    use SilverStripe\SiteConfig\SiteConfig;
    use SilverStripe\View\Requirements;
    use Symbiote\MemberProfiles\Pages\MemberProfilePage;

    /**
 * Class \PageController
 *
 * @property Page $dataRecord
 * @method Page data()
 * @mixin PageControllerExtension
 */
    class PageController extends ContentController
    {
        protected $CompaniesList;
        protected $CompanyCacheKey;
        protected $SecondaryNav;
        /**
         * An array of actions that can be accessed via a request. Each array element should be an action name, and the
         * permissions or conditions required to allow the user to access it.
         *
         * <code>
         * [
         *     'action', // anyone can access this action
         *     'action' => true, // same as above
         *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
         *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
         * ];
         * </code>
         *
         * @var array
         */
        private static $allowed_actions = [];

        protected function init()
        {
            parent::init();
            Requirements::block("silverstripe/admin: thirdparty/jquery/jquery.js");
            Requirements::block("symbiote/silverstripe-memberprofiles: client/javascript/ConfirmedPasswordField.js");
            /** @var SiteConfigExtension|SiteConfigTheme $SiteConfig */
            Requirements::css('//cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css');
            Requirements::css('_resources/themes/jobhunt/dist/css/main.css');
            Requirements::javascript('_resources/themes/jobhunt/dist/js/main.js');
            Requirements::block('https://hcaptcha.com/1/api.js?hl=en');
            Requirements::javascript('_resources/themes/jobhunt/dist/api.js');

            if (Security::getCurrentUser()) {
                $this->SecondaryNav = MemberProfilePage::get()->first()->Children();
                /** @var Member|MemberExtension $user */
                $user = Security::getCurrentUser();
                $userApplicationIds = $user->JobApplications()->columnUnique('ID');
                if (!count($userApplicationIds)) {
                    $userApplicationIds[] = -1;
                }
                $cFilter = [
                    'Applications.ID' => $userApplicationIds,
                ];
//                $countryname = Environment::getEnv("GEOIP_COUNTRY_CODE");
//                if (!empty($countryname) && $countryname !== 'N/A') {
//                    $cFilter['Country'] = [null, $countryname];
//                }
                $companies = Company::get()
                    ->filterAny($cFilter);
                $this->CompanyCacheKey = sprintf("%d-%d", $user->ID, $companies->count());
                $this->CompaniesList = $companies;
            }
        }

        public function getYear($year)
        {
            $now = date('Y');
            if ((int)$year === (int)$now) {
                return $now;
            }

            return sprintf('%s - %s', $year, $now);
        }
    }
}
