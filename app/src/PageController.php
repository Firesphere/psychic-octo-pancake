<?php

namespace {

    use Cashware\Bootswatcher\SiteConfigTheme;
    use Firesphere\AdblockWarning\Extensions\SiteConfigExtension;
    use Firesphere\ModuleHelpers\Extensions\PageControllerExtension;
    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\SiteConfig\SiteConfig;
    use SilverStripe\View\Requirements;

    /**
 * Class \PageController
 *
 * @property Page $dataRecord
 * @method Page data()
 * @mixin PageControllerExtension
 */
    class PageController extends ContentController
    {
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
            $SiteConfig = SiteConfig::current_site_config();
//<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
            Requirements::css('//cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css');
            Requirements::css('_resources/themes/jobhunt/dist/css/main.css');
            Requirements::css('_resources/themes/jobhunt/dist/css/' . $SiteConfig->Theme . '.min.css');
            Requirements::javascript('//cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js');
            Requirements::javascript('_resources/themes/jobhunt/dist/js/main.js');
        }
    }
}
