# dingtalk-robot
Laravel 框架的钉钉机器人发消息插件

## 安装

    composer require lee2son/dingtalk-robot

## 在普通PHP项目中使用：

    include_once __DIR__ . '/vendor/autoload.php';
    
    \Lee2son\DingTalkRobot\Robot::$apps = [
        'example' => [
            'webhook' => 'https://oapi.dingtalk.com/robot/send?access_token=xxxxxxxx',
            // The "GuzzleHttp" options
            // http://docs.guzzlephp.org/en/stable/request-options.html
            'options' => [
                'verify' => false,
            ],
            'sign_type' => 'sign',
            'secret' => 'xxxxxxxxxxx',
        ]
    ];

    \Lee2son\DingTalkRobot\robot('example')->xxxxxxxxx();
    
    // or
    \Lee2son\DingTalkRobot\Robot::$default = 'example';
    \Lee2son\DingTalkRobot\robot()->xxxxxxxxx();
    
    // or
    
    $robot = new \Lee2son\DingTalkRobot\Robot([
        'webhook' => 'https://oapi.dingtalk.com/robot/send?access_token=xxxxxxxx',
        // The "GuzzleHttp" options
        // http://docs.guzzlephp.org/en/stable/request-options.html
        'options' => [
            'verify' => false,
        ],
        'sign_type' => 'sign',
        'secret' => 'xxxxxxxxxxx',
    ]);
    
    $robot->xxxxxxxxx();

        
## 在 Laravel 中使用
配置：
    
    php artisan vendor:publish --tag=dingtalk-robot
    
此时会生成`config/dingtalk_robot.php`，酌情修改。调用方式是一样的

    \Lee2son\DingTalkRobot\robot('example')->xxxxxxxxx();