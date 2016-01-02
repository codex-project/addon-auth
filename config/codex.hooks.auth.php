<?php

return [
    'providers' => [ 'github', 'bitbucket' ],

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
