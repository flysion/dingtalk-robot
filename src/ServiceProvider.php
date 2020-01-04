<?php

namespace Lee2son\DingTalkRobot;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/dingtalk_robot.php', 'dingtalk_robot');

        $this->publishes([
            __DIR__ . '/../config/dingtalk_robot.php' => $this->app->config_path('dingtalk_robot.php')
        ], 'dingtalk_robot');

        $this->initApi();
    }

    /**
     * 初始化 API
     */
    public function initApi()
    {
        $config = $this->app->config('dingtalk_robot');

        Robot::$default = $config['default'];
        Robot::$robots = $config['robots'];
    }
}