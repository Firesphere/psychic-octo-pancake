<?php

namespace Firesphere\JobHunt\Forms;

use Firesphere\JobHunt\Models\Status;

class CloseForm extends StatusUpdateForm
{
    public const DEFAULT_NAME = 'CloseForm';

    public function getFieldList($hiddenType, $params)
    {
        $statuss = Status::get()->filter(['AutoHide' => true])
            ->map('ID', 'Status')
            ->toArray();
        $fields = parent::getFieldList($hiddenType, $params);
        $fields->dataFieldByName('StatusID')
            ->setSource($statuss);

        return $fields;
    }
}
