<?php

namespace Firesphere\JobHunt\Tasks;

use SilverStripe\Dev\BuildTask;
use SilverStripe\Security\Member;

class UUIDTask extends BuildTask
{

    public function run($request)
    {
        $i = 0;
        $users = Member::get()->filter(['UUID' => null]);
        foreach ($users as $user) {
            $user->forceChange(true);
            $user->write();
            $user->destroy();
            $i++;
        }
        $users = Member::get()->filter(['ShareKey' => null]);
        foreach ($users as $user) {
            $user->forceChange(true);
            $user->write();
            $user->destroy();
            $i++;
        }

        echo "Updated $i users";
    }
}
