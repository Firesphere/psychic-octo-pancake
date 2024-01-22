<?php

namespace Firesphere\JobHunt\Controllers;

use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;

/**
 * Class \Firesphere\JobHunt\Controllers\ICSController
 *
 */
class ICSController extends Controller
{

    public function index(HTTPRequest $request)
    {
        $header = $request->getHeader('Authorization');

    }

}
