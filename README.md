# dingtalk-robot
Laravel 框架的钉钉机器人发消息插件

# 配置
1. 生成配置文件

    php artisan vendor:publish --tag=dingtalk-robot

2. 修改配置文件：`config/dingtalk_robot.php`

# 使用：
    \Lee2son\DingTalkRobot\robot()->sendTextMessage("hello robot", ['130xxxx1205'])