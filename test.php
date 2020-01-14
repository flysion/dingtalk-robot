<?php

include_once __DIR__ . '/vendor/autoload.php';

\Anfeng\Operate\Api::$apps = [
    'default' => [
        'base_url' => 'https://operate.anfeng.com',
        'app_id' => '9001',
        'app_secret' => '46151dc878fe1288e0ded067987080ce',
        'log' => [
            'channel' => '',
            'level' => 'debug'
        ]
    ]
];

\Anfeng\Operate\Api::$callback = function (\GuzzleHttp\TransferStats $stats, $options, $name, array $config, $logData, $logMessage) {
    var_dump($logMessage, $logData);
};

\Anfeng\Operate\api()->repack(1, 2, 3, 4, 5, 6, 7);