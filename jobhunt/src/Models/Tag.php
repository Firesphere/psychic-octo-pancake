<?php

namespace Firesphere\JobHunt\Models;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Class \Firesphere\JobHunt\Models\Tag
 *
 * @property string $Title
 * @property string $Segment
 * @property int $UserID
 * @method Member User()
 * @method ManyManyList|JobApplication[] Applications()
 */
class Tag extends DataObject
{
    private static $table_name = 'Tag';

    private static $db = [
        'Title'   => DBVarchar::class,
        'Segment' => DBVarchar::class,
    ];

    private static $has_one = [
        'User' => Member::class,
    ];

    private static $belongs_many_many = [
        'Applications' => JobApplication::class . '.Tags',
    ];

    public static function findOrCreate($title)
    {
        $user = Security::getCurrentUser();
        $filter = [
            'UserID' => $user->ID
        ];
        if ((int)$title) {
            $filter['ID'] = $title;
        } else {
            $segment = SiteTree::create()->generateURLSegment($title);
            $filter['Segment'] = $segment;
        }
        $exist = self::get()->filter($filter);
        if ($exist->count()) {
            return $exist->first();
        }

        $new = self::create([
            'UserID'  => $user->ID,
            'Title'   => $title,
            'Segment' => $segment
        ]);
        $new->write();

        return $new;
    }
}
