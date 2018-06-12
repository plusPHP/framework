<?php
/**
 * plusPHP FrameWork
 * @File name: Di.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/8
 * @Time: 13:45
 * @Description: 依赖注入容器类
 */

namespace plusPHP;

use plusPHP\Di\Server;
use plusPHP\Events\EventsAwareInterface;
use plusPHP\Events\ManagerInterface;

class Di implements DiInterface, EventsAwareInterface
{

    /**
     * @description 事件管理器
     * @var ManagerInterface
     */
    protected $_eventsManager = null;

    /**
     * @description 服务
     * @var array
     */
    protected $_service = null;

    /**
     * @description 共享服务实例
     * @var array
     */
    protected $_sharedInstances = null;

    /**
     * @description 容器
     * @var DiInterface
     */
    protected static $_container = null;

    /**
     * Di constructor.
     */
    public function __construct()
    {
        if (!self::$_container instanceof self) {
            self::$_container = $this;
        }
    }


    public function getShare(string $name, array $parameters = null)
    {
        if (isset($this->_sharedInstances[$name])) {
            return $this->_sharedInstances[$name];
        }

        if (isset($this->_service[$name]) && $this->_service[$name]['shared']) {
            $server = $this->_service[$name]['server'];
            $instance = null;
            if ($server instanceof \Closure) {
                $instance = call_user_func($server);
            } elseif ($server instanceof Server) {
                $instance = $server->resolve($parameters);
            }
            $this->_sharedInstances[$name] = $instance;
            return $instance;
        } else {
            throw new \UnexpectedValueException(sprintf('Undefined share services %s!', $name));
        }
    }

    public function get(string $name, array $parameters = null)
    {
        if (isset($this->_sharedInstances[$name])) {
            return $this->_sharedInstances[$name];
        }

        $this->_eventsManager &&
        $this->_eventsManager->mark('di:beforeServiceResolve', $this, [
            'name' => $name,
            'parameters' => $parameters
        ]);

        if (isset($this->_service[$name])) {
            $server = $this->_service[$name]['server'];
            $instance = null;

            if ($server instanceof \Closure) {
                $instance = call_user_func($server);
            } elseif ($server instanceof Server) {
                $instance = $server->resolve($parameters);
            }

            if ($this->_service[$name]['shared']) {
                $this->_sharedInstances[$name] = $instance;
            }

            $this->_eventsManager &&
            $this->_eventsManager->mark('di:afterServiceResolve', $this, $instance);
            return $instance;
        } else {
            throw new \UnexpectedValueException(sprintf('Undefined services %s!', $name));
        }
    }

    public function set(string $name, $definition, bool $shared = false)
    {
        if (empty($definition)) {
            throw new \InvalidArgumentException('Unsupported container service definition format!');
        }

        if (is_object($definition)) {

            if ($definition instanceof \Closure) {
                $this->_service[$name] = [
                    'server' => $definition,
                    'shared' => $shared,
                ];
            } else {
                $this->_sharedInstances[$name] = $definition;
            }

        } else {
            $this->_service[$name] = [
                'server' => new Server($name, $definition),
                'shared' => $shared
            ];
        }

    }

    public function setShared(string $name, $definition)
    {
        return $this->set($name, $definition, true);
    }

    public function reset()
    {
        $this->_service = null;
        $this->_sharedInstances = null;
    }

    public function has(string $name): bool
    {
        return isset($this->_service[$name]);
    }

    public function attempt(string $name, $definition, bool $shared = false)
    {
        if (!$this->has($name)) {
            return $this->set($name, $definition, $shared);
        } else {
            return null;
        }
    }

    public function remove(string $name)
    {
        unset($this->_service[$name], $this->_sharedInstances[$name]);
    }

    public static function getContainer(): DiInterface
    {
        if (!self::$_container instanceof self) {
            self::$_container = new self();
        }
        return self::$_container;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }


    public function offsetGet($offset)
    {
        return $this->get($offset);
    }


    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }


    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }


    public function setEventsManager(ManagerInterface $eventsManager)
    {
        $this->_eventsManager = $eventsManager;
    }


    public function getEventsManager(): ManagerInterface
    {
        return $this->_eventsManager;
    }

}