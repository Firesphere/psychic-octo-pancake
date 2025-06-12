<?php

namespace {

    use DNADesign\Elemental\Extensions\ElementalPageExtension;
    use DNADesign\Elemental\Models\ElementalArea;
    use Firesphere\CSPHeaders\Extensions\PageExtension;
    use Firesphere\CSPHeaders\Models\CSPDomain;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\ORM\DataObject;
    use SilverStripe\ORM\ManyManyList;

    /**
 * Class \Page
 *
 * @property bool $HasMap
 * @property bool $AllowCSSInline
 * @property bool $AllowJSInline
 * @property int $ElementalAreaID
 * @method ElementalArea ElementalArea()
 * @method ManyManyList|CSPDomain[] CSPDomains()
 * @mixin ElementalPageExtension
 * @mixin PageExtension
 */
    class Page extends SiteTree
    {
        private static $db = [];

        private static $has_one = [];

        private static $description = '';
    }
}
