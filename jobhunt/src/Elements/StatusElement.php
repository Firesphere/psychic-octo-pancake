<?php

namespace Firesphere\JobHunt\Elements;

use DNADesign\Elemental\Models\ElementContent;
use Firesphere\JobHunt\Models\Status;

/**
 * Class \Firesphere\JobHunt\Elements\StatusElement
 *
 */
class StatusElement extends ElementContent
{
    private static $table_name = 'StatusElement';

    private static $singular_name = 'Status Element';

    private static $plural_name = 'Status Elements';

    /**
     * @deprecated 5.4.0 use class_description instead.
     */
    private static $description = 'Element displaying statuses';

    private static $class_description = 'Element displaying statusses';


    public function getSummary()
    {
        return "Displays the status summaries as a list";
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Status');
    }

    public function getStatusses()
    {
        return Status::get();
    }
}
