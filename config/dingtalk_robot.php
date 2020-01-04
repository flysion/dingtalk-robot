<?php

return [
    'default' => 'robot1',

    'robots' => [
        'robot1' => [
            'webhook' => 'https://oapi.dingtalk.com/robot/send?access_token=xxxxxxxx',
            // The "GuzzleHttp" options
            // http://docs.guzzlephp.org/en/stable/request-options.html
            'options' => [
                'verify' => false,
            ],
            'sign_type' => 'sign',
            'secret' => 'xxxxxxxxxxx',
        ],

        'robot2' => [
            'webhook' => 'https://oapi.dingtalk.com/robot/send?access_token=xxxxxxxx',
            // The "GuzzleHttp" options
            // http://docs.guzzlephp.org/en/stable/request-options.html
            'options' => [
                'verify' => false,
            ],
        ]
    ],
];