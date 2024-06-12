<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'pretix' => [
        'token' => env('PRETIX_TOKEN'),
    ],

    'pretalx' => [
        'token' => env('PRETALX_TOKEN'),
    ],

];
