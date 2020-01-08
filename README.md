# dingtalk-robot
Laravel 框架的钉钉机器人发消息插件

## 在PHP中使用
通过 composer 安装，运行如下命令即可：

    composer require lee2son/dingtalk-robot

配置：

    include_once __DIR__ . '/vendor/autoload.php';
    
    \Lee2son\DingTalkRobot\Robot::$apps = [
        'default' => [
            'base_url' => 'https://pass.liuliang.com',
            'app_id' => '',
            'app_secret' => '',
        ]
    ];
        
调用方式：

    \Lee2son\DingTalkRobot\robot()->xxxxxxxxx();

        
## 在 Laravel 中使用
通过 composer 安装，运行如下命令即可：

    composer require lee2son/dingtalk-robot

配置：
    
    php artisan vendor:publish --tag=dingtalk-robot
    
此时会生成`config/anfeng_pass.php`，酌情修改
        
调用方式：

    \Lee2son\DingTalkRobot\robot()->xxxxxxxxx();