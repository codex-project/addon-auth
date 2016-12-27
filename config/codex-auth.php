<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
return [

    'route_prefix' => 'auth',

    'enable_https' => false,

    'drivers' => [ 'github', 'bitbucket' ],

    'default_driver' => 'bitbucket',

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
