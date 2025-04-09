<?php

/*
 * This file is part of the Laravel Rave package.
 *
 * (c) templatecookie.com - Zakir Hossen <templatecookie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    'default_language' => env('APP_DEFAULT_LANGUAGE'),
    'timezone' => env('APP_TIMEZONE'),
    'currency' => env('APP_CURRENCY', 'USD'),
    'currency_symbol' => env('APP_CURRENCY_SYMBOL', '$'),
    'currency_symbol_position' => env('APP_CURRENCY_SYMBOL_POSITION', 'left'),

    'set_ip_based_location' => false,

    'paypal_sandbox_client_id' => '',
    'paypal_sandbox_secret' => '',
    'paypal_live_client_id' => '',
    'paypal_live_secret' => '',
    'paypal_mode' => 'live',
    'paypal_active' => true,

    'stripe_key' => '',
    'stripe_secret' => '',
    'stripe_active' => false,

    'razorpay_key' => '',
    'razorpay_secret' => '',
    'razorpay_active' => true,

    'paystack_key' => '',
    'paystack_secret' => '',
    'paystack_payment_url' => "https://api.paystack.co",
    'paystack_merchant' => '',
    'paystack_active' => false,

    'ssl_id' => '',
    'ssl_pass' => '',
    'ssl_active' => true,
    'ssl_mode' => 'sandbox',

    'flw_public_key' => '',
    'flw_secret' => '',
    'flw_secret_hash' => '',
    'flw_active' => true,

    'im_key' => '',
    'im_secret' => '',
    'im_url' => 'https://test.instamojo.com/api/1.1/',
    'im_active' => false,

    'midtrans_merchat_id' => '',
    'midtrans_client_key' => '',
    'midtrans_server_key' => '',
    'midtrans_merchat_id' => '',
    'midtrans_client_key' => '',
    'midtrans_server_key' => '',
    'midtrans_active' => false,
    'midtrans_live_mode' => false,

    'mollie_key' => '',
    'mollie_active' => true,

    'google_analytics' => '',
    'google_analytics_status' => false,

    'indeed_id' => '',
    'indeed_limit' => '10',

    'careerjet_id' => '',
    'careerjet_default_locale' => 'en_US',
    'careerjet_limit' => '50',

    'default_job_provider' => 'indeed',

    'pusher_app_id' => env('PUSHER_APP_ID'),
    'pusher_app_key' => env('PUSHER_APP_KEY'),
    'pusher_app_secret' => env('PUSHER_APP_SECRET'),
    'pusher_host' => env('PUSHER_HOST'),
    'pusher_port' => env('PUSHER_PORT'),
    'pusher_schema' => env('PUSHER_SCHEME', 'https'),
    'pusher_app_cluster' => env('PUSHER_APP_CLUSTER'),

    'Iyzipay_api_key' => 'sandbox-sQFqo1xO9AZub8xmt2CZjVqTTWVVgnbu',
    'Iyzipay_api_secret' => 'sandbox-r9zHFYjfcGPYCV5tQGC0c0glfq05a9wC',
    'Iyzipay_active' => false,
    'Iyzipay_base_url' => 'https://sandbox-api.iyzipay.com',
    'Iyzipay_live_mode' => false,

    'map_show' => true,

];
