<?php

namespace Cashware\Bootswatcher;

use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;

/**
 * Class \Cashware\Bootswatcher\SiteConfigTheme
 *
 * @property SiteConfig|SiteConfigTheme $owner
 * @property string $Theme
 */
class SiteConfigTheme extends DataExtension
{
    protected static $theme;

    private static $db = [
        'Theme' => 'Enum("default,cerulean,cosmo,cyborg,darkly,flatly,journal,litera,lumen,lux,materia,minty,morph,pulse,quartz,sandstone,simplex,sketchy,slate,solar,spacelab,superhero,united,vapor,yeti,zephyr","default")'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Theme', [
            DropdownField::create('Theme', 'Bootswatch Theme')
                ->setSource(BootswatchDownloader::config()->bootswatch_themes)
        ]);
    }

    public function BootswatchTheme()
    {
        if (!static::$theme) {
            /** @var Member|MemberExtension $user */
            $user = Security::getCurrentUser();
            if ($user && ($user->Theme && $user->Theme !== 'auto')) {
                static::$theme = $user->Theme;
            } else {
                static::$theme = $this->owner->Theme ?? 'default';
            }
        }

        Requirements::themedCSS("dist/css/" . static::$theme . '.min');
    }

    public function requireDefaultRecords()
    {
        $task = Injector::inst()->create(BootswatchDownloader::class);
        $task->run([]);
    }

    public function onBeforeWrite()
    {
        $themes = array_keys(BootswatchDownloader::config()->get('bootswatch_themes'));
        shuffle($themes);
        $theme = array_shift($themes);

        if ($this->owner->Theme === 'default') {
            $this->owner->Theme = $theme;
        }
    }
}
