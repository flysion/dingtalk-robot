<?php

return [
    'default' => 'robot1',

    'robots' => [
        'robot1' => [
            'webhook' => 'https://oapi.dingtalk.com/robot/send?access_token=xxxxxxxx',
            'sign' => true,
            'secret' => 'xxxxxxxxxxx',
        ],

        'robot2' => [
            'webhook' => 'https://oapi.dingtalk.com/robot/send?access_token=xxxxxxxx',
        ]
    ],
];