<?php
/**
 * plusPHP FrameWork
 * @File name: ManagerInterface.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/7
 * @Time: 22:23
 * @Description: 事件管理器接口
 */

namespace plusPHP\Events;

interface ManagerInterface
{
    /**
     * mount
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 在埋点挂载一个事件监听器
     * @param string $eventType
     * @param object|callable $handler
     * @param int $priority
     * @return mixed
     */
    public function mount(string $eventType, $handler, int $priority = 100);

    /**
     * remove
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 删除一个埋点上当前挂载的事件监听器
     * @param string $eventType
     * @return mixed
     */
    public function remove(string $eventType);

    /**
     * removeAll
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 删除所有埋点上当前挂载的事件监听器
     * @return mixed
     */
    public function removeAll();

    /**
     * hasMonitor
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断特定埋点上是否挂载监听器
     * @param string $eventType
     * @return mixed
     */
    public function hasMonitor(string $eventType);


    /**
     * mark
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 标记一个事件埋点
     * @param string $eventType
     * @param object $source
     * @param null $data
     * @param bool $cancelable
     * @return mixed
     */
    public function mark(string $eventType, $source, $data = null, bool $cancelable = true);


    /**
     * getResponses
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 返回当前已执行的所有监听器的执行结果
     * @return mixed
     */
    public function getResponses();

}