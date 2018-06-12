<?php
/**
 * plusPHP FrameWork
 * @File name: Manager.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/7
 * @Time: 22:20
 * @Description: 事件管理器
 */
namespace plusPHP\Events;

class Manager implements ManagerInterface
{

    protected $_responses;

    protected $_events;


    public function hasMonitor(string $eventType)
    {
        return isset($this->_events[$eventType]);
    }


    public function mark(string $eventType, $source, $data = null, bool $cancelable = true)
    {

        $events = $this->_events;
        if (!is_array($events)) {
            return null;
        }

        if (strpos($eventType, ':') === 0) {
            throw new \Exception('Invalid event type ' . $eventType);
        }

        $eventParts = explode(':', $eventType);
        $type = $eventParts[0]; //TODO 事件类型
        $eventName = $eventParts[1]; //TODO 事件名
        $event = null; //TODO 当前事件对象
        $status = null; //TODO 事件执行状态
        $this->_responses = null; //TODO 重置当前事件监听器返回值

        if (isset($events[$type]) && $fireEvents = $events[$type]) {
            if ($fireEvents instanceof \SplPriorityQueue) {
                //TODO 创建事件对象，保存事件上下文信息
                $event = new Event($eventName, $source, $data, $cancelable);
                $status = $this->markQueue($fireEvents, $event);
            }
        }

        if (isset($events[$eventType]) && $fireEvents = $events[$eventType]) {
            if ($fireEvents instanceof \SplPriorityQueue) {
                //TODO 创建事件对象，保存事件上下文信息
                if ($event == null) {
                    $event = new Event($eventName, $source, $data, $cancelable);
                }
                $status = $this->markQueue($fireEvents, $event);
            }
		}

		return $status;
    }


    protected function markQueue(\SplPriorityQueue $queue, EventInterface $event)
    {
        $status = null; //TODO 监听器执行状态
        $source = $event->getSource(); //TODO 当前事件源对象
        $data = $event->getData(); //TODO 当前事件数据
        $eventName = $event->getEventName(); //TODO 当前事件名

        $iterator = clone $queue;
        $iterator->top();
        while ($iterator->valid()) {
            $handler = $iterator->current();
            $iterator->next();

            if ($handler instanceof \Closure) {
                $status = call_user_func_array($handler, [$event, $source, $data]);
                $this->_responses[] = $status;
                //TODO 如果事件可停止并且已经停止，则跳出事件执行队列
                if ($event->isCancelable() && $event->isStopped()) {
                    break;
                }
            } else {
                if (method_exists($handler, $eventName)) {
                    //TODO 执行事件处理方法
                    $status = $handler->{$eventName}($event, $source, $data);
                    $this->_responses[] = $status;
                    //TODO 如果事件可停止并且已经停止，则跳出事件执行队列
                    if ($event->isCancelable() && $event->isStopped()) {
                        break;
                    }
                }
            }
        }

        return $status;
    }


    public function mount(string $eventType, $handler, int $priority = 100)
    {
        if (!is_object($handler)) {
            throw new \Exception("Event handler must be an Object");
        }

        $priorityQueue = isset($this->_events[$eventType]) ? $this->_events[$eventType] : null;

        if (!$priorityQueue instanceof \SplPriorityQueue) {
            //TODO 创建一个优先队列
            $priorityQueue = new \SplPriorityQueue();
            $priorityQueue->setExtractFlags(\SplPriorityQueue::EXTR_DATA);
        }
        //TODO 插入一个事件监听者，并设置优先级
        $priorityQueue->insert($handler, $priority);

        if (!isset($this->_events[$eventType])) {
            $this->_events[$eventType] = $priorityQueue;
        }
    }


    public function remove(string $eventType)
    {
        $this->_events[$eventType] = null;
    }

    public function removeAll()
    {
        $this->_events = null;
    }

    public function getResponses()
    {
        return $this->_responses;
    }

}