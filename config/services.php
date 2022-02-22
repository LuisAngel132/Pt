<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
     */

    'mailgun'   => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses'       => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe'    => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook'  => [
        'client_id'     => config('app.env') == 'production' ? env('PRODUCTION_FACEBOOK_ID') : env('SANDBOX_FACEBOOK_ID'),
        'client_secret' => config('app.env') == 'production' ? env('PRODUCTION_FACEBOOK_SECRET') : env('SANDBOX_FACEBOOK_SECRET'),
        'redirect'      => config('app.env') == 'production' ? env('PRODUCTION_FACEBOOK_URL') : env('SANDBOX_FACEBOOK_URL'),
    ],

    'twitter'   => [
        'client_id'     => config('app.env') == 'production' ? env('PRODUCTION_TWITTER_ID') : env('SANDBOX_TWITTER_ID'),
        'client_secret' => config('app.env') == 'production' ? env('PRODUCTION_TWITTER_SECRET') : env('SANDBOX_TWITTER_SECRET'),
        'redirect'      => config('app.env') == 'production' ? env('PRODUCTION_TWITTER_URL') : env('SANDBOX_TWITTER_URL'),
    ],

    'paypal'    => [
        'enviroment'     => config('app.env') == 'production' ? 'production' : 'sandbox',
        'sandbox_key'    => env('SANDBOX_PAYPAL_KEY'),
        'production_key' => env('PRODUCTION_PAYPAL_KEY'),
    ],

    'openpay' => [
        'id'      => config('app.env') == 'production' ? env('PRODUCTION_OPENPAY_ID') : env('SANDBOX_OPENPAY_ID'),
        'api_key' => config('app.env') == 'production' ? env('PRODUCTION_OPENPAY_API_KEY') : env('SANDBOX_OPENPAY_API_KEY'),
        'mode'    => config('app.env') == 'production' ? env('PRODUCTION_OPENPAY_MODE') : env('SANDBOX_OPENPAY_MODE'),
    ],

];
