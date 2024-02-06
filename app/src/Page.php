<?php

namespace {

    use Firesphere\CSPHeaders\Extensions\PageExtension;
    use Firesphere\CSPHeaders\Models\CSPDomain;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\ORM\ManyManyList;

    /**
 * Class \Page
 *
 * @property bool $HasMap
 * @property bool $AllowCSSInline
 * @property bool $AllowJSInline
 * @method ManyManyList|CSPDomain[] CSPDomains()
 * @mixin PageExtension
 */
    class Page extends SiteTree
    {
        private static $db = [];

        private static $has_one = [];
    }
}
