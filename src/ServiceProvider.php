<?php

namespace Lee2son\DingTalkRobot;

use Illuminate\Contracts\Support\DeferrableProvider;

class ServiceProvider extends \Illuminate\Support\ServiceProvider implements DeferrableProvider
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
            __DIR__ . '/../config/dingtalk_robot.php' => $this->app->configPath('dingtalk_robot.php')
        ], 'dingtalk-robot');

        $this->initApi();
    }

    /**
     * 初始化 API
     */
    public function initApi()
    {
        $config = $this->app['config']->get('dingtalk_robot');

        Robot::$default = $config['default'];
        Robot::$robots = $config['robots'];

        $this->app->singleton('dingtalk.robot', function($name = null) {
            return robot($name);
        });
    }

    public function provides()
    {
        return [
            'dingtalk.robot'
        ];
    }
}