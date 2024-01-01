<?php

namespace {

    use SilverStripe\CMS\Model\SiteTree;

    /**
 * Class \Page
 *
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
