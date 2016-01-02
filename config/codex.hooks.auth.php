<?php

return [
    'providers' => [ 'github', 'bitbucket', 'google' ],

    'default_project_config' => [
        'hooks' => [
            'auth' => [
                'allow' => [ ]
            ]
        ]
    ]
];
