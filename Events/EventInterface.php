<?php
/**
 * plusPHP FrameWork
 * @File name: EventInterface.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/7
 * @Time: 23:20
 * @Description: 事件接口
 */

namespace plusPHP\Events;


interface EventInterface
{

    /**
     * EventInterface constructor.
     * @param string $eventName
     * @param $source
     * @param null $data
     * @param bool $cancelable
     */
    public function __construct(string $eventName, $source, $data = null, bool $cancelable = true);

    /**
     * setData
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 设置事件数据
     * @param $data
     * @return mixed
     */
    public function setData($data);

    /**
     * setEventName
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 设置事件类型
     * @param string $eventName
     * @return mixed
     */
    public function setEventName(string $eventName);

    /**
     * getEventName
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取事件类型
     * @return string
     */
    public function getEventName(): string;

    /**
     * getData
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取事件数据
     * @return mixed
     */
    public function getData();

    /**
     * getSource
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取事件源对象
     * @return mixed
     */
    public function getSource();

    /**
     * stop
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 停止事件执行
     * @return mixed
     */
    public function stop();

    /**
     * isCancelable
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 是否允许停止事件
     * @return mixed
     */
    public function isCancelable();

    /**
     * isStopped
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 事件是否已经停止执行
     * @return mixed
     */
    public function isStopped();

}