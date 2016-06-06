<?php

return [

    'route_prefix' => 'auth',

    'enable_https' => false,

    'drivers' => [ 'github', 'bitbucket' ],

    'error' => [
        'title' => 'Access denied',
        'text'  => 'This project is not public and requires authorization',
    ],


    'providers' => [
        'github'    => [
            'client_id'     => env('CODEX_AUTH_GITHUB_ID', ''),
            'client_secret' => env('CODEX_AUTH_GITHUB_SECRET', ''),
        ],
        'bitbucket' => [
            'client_id'     => env('CODEX_AUTH_BITBUCKET_ID', ''),
            'client_secret' => env('CODEX_AUTH_BITBUCKET_SECRET', ''),
        ],
    ],

    'default_project_config' => [
        'auth' => [
            'enabled' => false,
            'driver'  => null,
            'allow'   => [
                'groups'    => [ ],
                'emails'    => [ ],
                'usernames' => [ ],
            ],
        ],

    ],
];
