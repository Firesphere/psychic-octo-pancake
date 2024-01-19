<?php

namespace Firesphere\JobHunt\Admins;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Omnipay\Model\Payment;

/**
 * Class \Firesphere\JobHunt\Admins\PaymentAdmin
 *
 */
class SubscriptionAdmin extends ModelAdmin
{

    private static $managed_models = [
        Payment::class
    ];

    private static $url_segment = 'payment-admin';

    private static $menu_title = 'Payments';
}
