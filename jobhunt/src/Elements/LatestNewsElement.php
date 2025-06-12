<?php

namespace Firesphere\JobHunt\Elements;

use Axllent\Weblog\Model\BlogPost;
use Dynamic\Elements\Features\Elements\ElementFeatures;

/**
 * Class \Firesphere\JobHunt\Elements\LatestNewsElement
 *
 */
class LatestNewsElement extends ElementFeatures
{
    private static $singular_name = 'Latest news block';
    private static $plural_name = 'Latest news blocks';

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Latest News');
    }

    public function getNews()
    {
        return BlogPost::get()
            ->sort('PublishDate DESC')
            ->limit(5);
    }

}
