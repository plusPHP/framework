<?php
/**
 * plusPHP FrameWork
 * @File name: Session.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/17
 * @Time: 10:16
 * @Description: session类
 */

namespace plusPHP\Http;


class Session implements SessionInterface
{

    /**
     * @description 字段描述
     * @var SessionLockInterface
     */
    protected $_lock;

    /**
     * @description session前缀
     * @var string
     */
    protected $_prefix = null;


    public function get(string $name, string $prefix)
    {
        // TODO: Implement get() method.
    }

    public function delete(string $name, string $prefix = null)
    {
        // TODO: Implement delete() method.
    }

    public function set(string $name, $value, string $prefix = null)
    {
        // TODO: Implement set() method.
    }

    public function has(string $name, string $prefix = null)
    {
        // TODO: Implement has() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function destroy()
    {
        // TODO: Implement destroy() method.
    }

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function pause()
    {
        // TODO: Implement pause() method.
    }

    public function prefix(string $prefix)
    {
        $this->_prefix = $prefix;
    }

    public function resetSID($delete = false)
    {
        session_regenerate_id($delete);
    }

    public function setHandle(\SessionHandlerInterface $handler)
    {
        // TODO: Implement setHandle() method.
    }

    public function setLock(SessionLockInterface $lock)
    {
        $this->_lock = $lock;
        return $this;
    }

    /**
     * getPrefixName
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 返回带前缀的key名
     * @param $prefix
     * @param $name
     * @return string
     */
    protected function getPrefixName($prefix, $name)
    {
        if ($prefix === false) {
            return $name;
        }

        if ($prefix != '') {
            return $prefix.$name;
        }
        return isset($this->_prefix) ? $this->_prefix . $name : $name;
    }


}