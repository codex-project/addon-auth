<?php

return [

    'route_prefix' => 'auth',

    'enable_https' => false,

    'drivers' => [ 'github', 'bitbucket' ],

    // If true, the providers data will be set as services.{provider} and the redirect url will be configured automaticly
//    'merge_providers' => true,

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
