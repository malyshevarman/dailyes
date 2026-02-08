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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'vkontakte' => [
        'active' => env('VKONTAKTE_ACTIVE'),
        'client_id' => env('VKONTAKTE_CLIENT_ID'),
        'client_secret' => env('VKONTAKTE_CLIENT_SECRET'),
        'redirect' => env('VKONTAKTE_REDIRECT'),
    ],

    'facebook' => [
        'active' => env('FACEBOOK_ACTIVE'),
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
        'scopes' => [],
        'with' => [],
        'fields' => [],
    ],

    'odnoklassniki' => [
        'active' => env('ODNOKLASSNIKI_ACTIVE'),
        'client_id' => env('ODNOKLASSNIKI_CLIENT_ID'),
        'client_public' => env('ODNOKLASSNIKI_CLIENT_PUBLIC'),
        'client_secret' => env('ODNOKLASSNIKI_CLIENT_SECRET'),
        'redirect' => env('ODNOKLASSNIKI_REDIRECT'),
    ],

    'instagram' => [
        'active' => env('INSTAGRAM_ACTIVE'),
        'client_id' => env('INSTAGRAM_CLIENT_ID'),
        'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
        'redirect' => env('INSTAGRAM_REDIRECT'),
        'with' => ['hl' => 'en'],
    ],

];
