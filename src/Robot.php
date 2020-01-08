<?php

namespace Lee2son\DingTalkRobot;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class Robot
{
    /**
     * @var array 机器人配置
     */
    protected $config = [];

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var array 记录所有的应用配置
     */
    public static $robots = [];

    /**
     * @var string 默认使用的配置
     */
    public static $default = 'default';

    /**
     * @var Robot[]
     */
    protected static $instances = [];

    /**
     * Robot constructor.
     * @param array $config
     */
    function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string|null $name
     * @return Robot
     * @throws Exception
     */
    public static function instance($name = null)
    {
        $name = $name ?: static::$default;
        if(!isset(static::$robots[$name])) {
            throw new Exception("\"{$name}\" not found.");
        }

        if(!isset(static::$instances[$name])) {
            $config = static::$robots[$name];
            static::$instances[$name] = new static(static::$robots[$name]);
        }

        return static::$instances[$name];
    }
    
    /**
     * 获取请求客户端
     * @return ClientInterface
     */
    protected function getClient()
    {
        if(!$this->client) {
            $this->client = new Client([]);
        }

        return $this->client;
    }

    /**
     * @link https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq
     * @param $message
     * @param true|array|string $at
     * @throws \GuzzleHttp\Exception\GuzzleException|Exception
     * @return array
     */
    public function sendMessage($message, $at = [])
    {
        $webhook = $this->config['webhook'];
        if(@$this->config['sign_type'] === 'sign') {
            $data['timestamp'] = time() . '000';
            $data['sign'] = base64_encode(hash_hmac('sha256', "{$data['timestamp']}\n{$this->config['secret']}", $this->config['secret'], true));
            $webhook .= (strpos($webhook, '?') === false ? '?' : '&') . http_build_query($data);
        }

        if($at === true) {
            $message['at']['isAtAll'] = true;
        } elseif (is_string($at)) {
            $at = array_filter(explode(',', $at));
        }

        if (is_array($at) && count($at) > 0) {
            $message['at']['atMobiles'] = $at;
        }

        $response = $this->getClient()->post($webhook, array_merge($this->config['options'] ?? [], [
            'json' => $message,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]));

        $data = \GuzzleHttp\json_decode($response->getBody(), true);
        if($data['errcode'] !== 0) {
            throw new \Anfeng\Pass\ApiException($data['errmsg'], $data['errcode']);
        }

        return $data;
    }

    /**
     * 发送文本消息
     * @param string $content 消息内容
     * @param true|array $at
     * @throws \GuzzleHttp\Exception\GuzzleException|Exception
     * @return array
     */
    public function sendTextMessage($content, $at = [])
    {
        return $this->sendMessage([
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ]
        ], $at);
    }

    /**
     * @param string $title 消息标题
     * @param string $text 消息内容。如果太长只会部分展示
     * @param string $picUrl 点击消息跳转的URL
     * @param string $messageUrl 图片URL
     * @param true|array $at
     * @throws \GuzzleHttp\Exception\GuzzleException|Exception
     * @return array
     */
    public function sendLinkMessage($title, $text, $messageUrl, $picUrl = "", $at = [])
    {
        return $this->sendMessage([
            'msgtype' => 'link',
            'link' => [
                'title' => $title,
                'text' => $text,
                'picUrl' => $picUrl,
                'messageUrl' => $messageUrl,
            ]
        ], $at);
    }

    /**
     * @param string $title 首屏会话透出的展示内容
     * @param string $text markdown格式的消息
     * @param string $singleTitle 单个按钮的方案。
     * @param string $singleUrl 点击singleTitle按钮触发的URL
     * @param string $btnOrientation 0-按钮竖直排列，1-按钮横向排列
     * @param string $hideAvatar 0-正常发消息者头像，1-隐藏发消息者头像
     * @throws \GuzzleHttp\Exception\GuzzleException|Exception
     * @return array
     */
    public function sendActionCardMessage($title, $text, string $singleTitle, string $singleUrl, $btnOrientation, string $hideAvatar)
    {
        return $this->sendMessage([
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'singleTitle' => $singleTitle,
                'singleURL' => $singleUrl,
                'btnOrientation' => $btnOrientation,
                'hideAvatar' => $hideAvatar,

            ]
        ]);
    }

    /**
     * @param $title 首屏会话透出的展示内容
     * @param $text markdown格式的消息
     * @param array $btns 按钮的信息：title-按钮方案，actionURL-点击按钮触发的URL
     * @param $btnOrientation 0-按钮竖直排列，1-按钮横向排列
     * @param $hideAvatar 0-正常发消息者头像，1-隐藏发消息者头像
     * @throws \GuzzleHttp\Exception\GuzzleException|Exception
     * @return array
     */
    public function sendActionCardBtnMessage($title, $text, array $btns, $btnOrientation, string $hideAvatar)
    {
        return $this->sendMessage([
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'btns' => $btns,
                'btnOrientation' => $btnOrientation,
                'hideAvatar' => $hideAvatar,

            ]
        ]);
    }

    /**
     * @param array $links 按钮的信息：title-单条信息文本，messageURL-点击单条信息到跳转链接，picURL-单条信息后面图片的URL
     * @throws \GuzzleHttp\Exception\GuzzleException|Exception
     * @return array
     */
    public function sendFeedCardMessage(array $links)
    {
        return $this->sendMessage([
            'msgtype' => 'feedCard',
            'feedCard' => [
                'links' => $links,

            ]
        ]);
    }
}