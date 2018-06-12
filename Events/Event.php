<?php
/**
 * plusPHP FrameWork
 * @File name: Event.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/7
 * @Time: 23:34
 * @Description: 事件类
 */
namespace plusPHP\Events;


class Event implements EventInterface
{

    protected $_eventName;

    protected $_source;

    protected $_data;

    protected $_cancelable;

    protected $_isStopped = false;

    public function __construct(string $eventName, $source, $data = null, bool $cancelable = true)
    {
        $this->setEventName($eventName);
        $this->_source = $source;
        $this->setData($data);
        $this->_cancelable = $cancelable;
    }


    public function getData()
    {
        return $this->_data;
    }


    public function getSource()
    {
        return $this->_source;
    }


    public function getEventName(): string
    {
        return $this->_eventName;
    }


    public function isCancelable()
    {
        return $this->_cancelable;
    }


    public function isStopped()
    {
        return $this->_isStopped;
    }


    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }


    public function setEventName(string $eventName)
    {
        $this->_eventName = $eventName;
        return $this;
    }


    public function stop()
    {
        $this->_isStopped = true;
        return $this;
    }

}