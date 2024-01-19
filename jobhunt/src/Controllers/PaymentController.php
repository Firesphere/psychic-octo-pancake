<?php

namespace Firesphere\JobHunt\Controllers;

use Firesphere\JobHunt\Models\Subscription;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Environment;
use SilverStripe\Security\Security;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\StripeClient;
use Stripe\Webhook;

/**
 * Class \Firesphere\JobHunt\Controllers\PaymentController
 *
 */
class PaymentController extends Controller
{
    use Configurable;

    private static $allowed_actions = [
        'success',
        'cancel',
        'webhook'
    ];

    private static $subscription_amount_in_cents = 750;

    public function index(HTTPRequest $request)
    {
        $currentUser = Security::getCurrentUser();
        // In dev mode it's easier to just throw things in to yml
        $conf = Director::isDev() ? Subscription::config()->get('Stripe') : ['secretKey' => Environment::getEnv('STRIPE_SK')];
        $stripe = new StripeClient($conf['secretKey']);
        $customer = $stripe->customers->search([
            'query' => "email:'$currentUser->Email'"
        ]);
        $result = $customer->values();
        if (!count($result[1])) {
            $customer = $stripe->customers->create([
                'name'  => Security::getCurrentUser()->getName(),
                'email' => Security::getCurrentUser()->Email
            ]);
        } else {
            $customer = $customer->values()[1][0];
        }
        $checkout_session = $stripe->subscriptions->create([
            'customer' => $customer->id,
            'items'    => [
                [
                    'price_data' => [
                        'currency'    => 'NZD',
                        'product'     => 'prod_POz5Ff6Ek89c22',
                        'unit_amount' => 750,
                        'recurring'   => [
                            'interval'       => 'month',
                            'interval_count' => 1
                        ]
                    ],
                    'quantity'   => 1,

                ]
            ],
            //            'mode'        => 'subscription',
            //            'success_url' => Director::absoluteBaseURL() . '/payment/success',
            //            'cancel_url'  => Director::absoluteBaseURL() . '/payment/cancel',
        ]);

        return $this->redirect(
            $checkout_session->url,
            303
        );
    }

    public function success($request)
    {
        print_r($request);

        return $this;
    }

    public function cancel($request)
    {
        print_r($request);

        return $this;
    }

    public function webhook(HTTPRequest $request)
    {
        $wh_secret = Environment::getEnv('STRIPE_WEBHOOK_SECRET');
        $payload = $request->getBody();
        $sig_header = $request->getHeader('stripe-signature');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $wh_secret);
        } catch (SignatureVerificationException $e) {
            return $this->httpError(400);
        } catch (UnexpectedValueException $e) {
            return $this->httpError(400);
        }

        $id = $event->id;

        switch ($event->type) {
            // case 'charge.refunded':
            case 'charge.succeeded':
//                $stripe->webhookEndpoints->create(charge_succeeded($id, $event);
                break;
            // case 'charge.dispute.closed':
            //   $dispute = $event->data->object;
            // case 'charge.dispute.created':
            //   $dispute = $event->data->object;
            // case 'charge.dispute.funds_withdrawn':
            //   $dispute = $event->data->object;
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return null;
    }
}
