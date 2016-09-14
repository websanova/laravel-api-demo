<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => getenv('FACEBOOK_CLIENT_ID'),
        'client_secret' => getenv('FACEBOOK_CLIENT_SECRET'),
        'redirect' => getenv('FACEBOOK_REDIRECT_URL'),
    ],

    'google' => [
        'client_id' => getenv('GOOGLE_CLIENT_ID'),
        'client_secret' => getenv('GOOGLE_CLIENT_SECRET'),
        'redirect' => getenv('GOOGLE_REDIRECT_URL'),
    ],

    'twitter' => [
        'client_id' => getenv('TWITTER_CLIENT_ID'),
        'client_secret' => getenv('TWITTER_CLIENT_SECRET'),
        'redirect' => getenv('TWITTER_REDIRECT_URL'),
    ],

    'github' => [
        'client_id' => getenv('GITHUB_CLIENT_ID'),
        'client_secret' => getenv('GITHUB_CLIENT_SECRET'),
        'redirect' => getenv('GITHUB_REDIRECT_URL'),
    ],

];
