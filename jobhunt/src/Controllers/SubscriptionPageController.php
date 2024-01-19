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
        'PayPalForm',
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

    public function PayPalForm()
    {
        $this->method = 'PayPal_Express';

        return $this->PayForm();
    }

    protected function PayForm()
    {
        $factory = GatewayFieldsFactory::create($this->method);

        $form = Form::create(
            $this,
            "PayPalForm",
            $factory->getFields(),
            FieldList::create(
                $actions = FormAction::create(
                "doSubmit",
                "Pay with PayPal"
            ))
        );

        $actions->addExtraClass('btn btn-primary');

        return $form;
    }

    public function doSubmit($data, $form)
    {
        error_reporting(E_ALL & ~E_USER_DEPRECATED);        // Create the payment object. We pass the desired success
        // and failure URLs as parameter to the payment
        $payment = Payment::create()
            ->init($this->method, 100, "NZD")
            ->setSuccessUrl($this->Link('complete'))
            ->setFailureUrl($this->Link() . "?message=payment cancelled");

        // Save it to the database to generate an ID
        $payment->write();

        $response = ServiceFactory::create()
            ->getService($payment, ServiceFactory::INTENT_PAYMENT)
            ->initiate($data);

        return $response->redirectOrRespond();
    }

    public function complete(HTTPRequest $request)
    {
        print_r($request);

        return $this;
    }
}
