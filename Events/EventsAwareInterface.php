<?php
/**
 * plusPHP FrameWork
 * @File name: EventsAwareInterface.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/8
 * @Time: 14:20
 * @Description: 事件感知接口
 */

namespace plusPHP\Events;


interface EventsAwareInterface
{

    /**
     * setEventsManager
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 设置事件管理器
     * @param ManagerInterface $eventsManager
     * @return mixed
     */
    public function setEventsManager(ManagerInterface $eventsManager);

    /**
     * getEventsManager
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取事件管理器
     * @return ManagerInterface
     */
    public function getEventsManager(): ManagerInterface;

}