<?php

namespace Firesphere\JobHunt\Extensions;

use DNADesign\Elemental\Models\BaseElement;
use DNADesign\Elemental\Models\ElementalArea;
use Psr\SimpleCache\CacheInterface;
use SilverStripe\Core\Extension;
use SilverStripe\Core\Injector\Injector;

/**
 * Class \Firesphere\JobHunt\Extensions\ElementExtension
 *
 * @property BaseElement|ElementalArea|ElementExtension $owner
 */
class ElementExtension extends Extension
{

    public function onAfterWrite()
    {
        $caches = ['.ElementalArea', '.BaseElement'];
        foreach ($caches as $cache) {
            $cache = Injector::inst()->get(CacheInterface::class . $cache);
            $cache->clear();
        }
    }
}
