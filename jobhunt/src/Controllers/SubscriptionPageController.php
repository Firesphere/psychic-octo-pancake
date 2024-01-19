<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\Subscription;
use Firesphere\JobHunt\Pages\SubscriptionPage;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Omnipay\GatewayFieldsFactory;
use SilverStripe\Omnipay\GatewayInfo;
use SilverStripe\Omnipay\Model\Payment;
use SilverStripe\Omnipay\Service\ServiceFactory;

/**
 * Class \Firesphere\JobHunt\Controllers\SubscriptionPageController
 *
 * @property SubscriptionPage $dataRecord
 * @method SubscriptionPage data()
 * @mixin SubscriptionPage
 */
class SubscriptionPageController extends \PageController
{
    protected $method;

    protected $Plans;

    protected $Plan;

    private static $allowed_actions = [
        'plan',
        'complete'
    ];

    protected function init()
    {
        parent::init();

        $this->Plans = Subscription::get();
    }

    public function plan(HTTPRequest $request)
    {
        $plan = Subscription::get()->filter(['URLSegment' => $request->param('ID')])->first();

        if (!$plan) {
            $this->httpError(404);

            return $this;
        }

        $this->Plan = $plan;

        return $this;
    }

    public function complete(HTTPRequest $request)
    {
        print_r($request);

        return $this;
    }
}
