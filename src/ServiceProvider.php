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
        Robot::$callback = function (\GuzzleHttp\TransferStats $stats, $options, $name, array $config, $logData, $logMessage) {
            $logOptions = $config['log'] ?? null;
            if($logOptions && $logOptions['enable']) {
                if($stats->hasResponse()) {
                    \Illuminate\Support\Facades\Log::channel($logOptions['channel'])->info($logMessage, $logData);
                } else {
                    \Illuminate\Support\Facades\Log::channel($logOptions['channel'])->error($logMessage, $logData);
                }
            }
        };
    }
}