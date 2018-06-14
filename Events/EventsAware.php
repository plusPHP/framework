<?php
/**
 * plusPHP FrameWork
 * @File name: EventsAware.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/14
 * @Time: 16:30
 * @Description: 事件管理器感知
 */


namespace plusPHP\Events;


trait EventsAware
{

    /**
     * @description 字段描述
     * @var ManagerInterface
     */
    protected $_eventsManager;


    public function setEventsManager(ManagerInterface $eventsManager)
    {
        $this->_eventsManager = $eventsManager;
        return $this;
    }


    public function getEventsManager(): ManagerInterface
    {
        return $this->_eventsManager;
    }

}