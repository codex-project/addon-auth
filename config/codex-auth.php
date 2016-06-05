<?php

return [

    'enable_https' => false,


    // If true, the providers data will be set as services.{provider} and the redirect url will be configured automaticly
//    'merge_providers' => true,
//
//    'providers' => [
//        'github' => [
//            'client_id'     => env('CODEX_GITHUB_ID', ''),
//            'client_secret' => env('CODEX_GITHUB_SECRET', '')
//        ],
//        'bitbucket' => [
//            'client_id'     => env('CODEX_BITBUCKET_ID', ''),
//            'client_secret' => env('CODEX_BITBUCKET_SECRET', '')
//        ]
//    ],

    'default_project_config' => [
        'hooks' => [
            'auth' => [
                'provider' => null,
                'allow' => [
                    'groups' => [],
                    'users' => [],
                ]
            ]
        ]
    ]
];
