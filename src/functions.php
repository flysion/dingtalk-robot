<?php

namespace Lee2son\DingTalkRobot;

/**
 * 获取一个 robot 实例
 *
 * @param string|null $name
 * @return Robot
 * @throws
 */
function robot($name = null)
{
    return Robot::instance($name);
}