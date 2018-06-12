<?php
/**
 * plusPHP FrameWork
 * @File name: Multiple.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/11
 * @Time: 13:57
 * @Description: 多级缓存
 */

namespace plusPHP\Cache;

class Multiple
{

    /**
     * @description 字段描述
     * @var BackendInterface BackendInterface[]
     */
    protected $_backends;

    /**
     * Multiple constructor.
     * @param BackendInterface[] ...$backends
     */
    public function __construct(BackendInterface ...$backends)
    {
        $this->_backends = $backends;
    }

    /**
     * push
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 向多级缓存中插入新的一级缓存
     * @param BackendInterface $backend
     * @return $this
     */
    public function push(BackendInterface $backend)
    {
        $this->_backends[] = $backend;
        return $this;
    }

    /**
     * get
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取缓存
     * @param $keyName
     * @param bool $notExpired
     * @return mixed|null
     */
    public function get($keyName, $notExpired = false)
    {
        foreach ($this->_backends as $backend) {
            $content = $backend->get($keyName, $notExpired);
            if ($content != null) {
                return $content;
            }
        }
        return null;
    }

    /**
     * save
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 保存缓存
     * @param $keyName
     * @param $content
     * @param int $lifetime
     */
    public function save($keyName, $content, int $lifetime)
    {
        foreach ($this->_backends as $backend) {
            $content = $backend->save($keyName, $content, $lifetime);
        }
    }

    /**
     * delete
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 删除缓存
     * @param $keyName
     * @param bool $notExpired
     * @return bool
     */
    public function delete($keyName, $notExpired = false): bool
    {
        foreach ($this->_backends as $backend) {
            $backend->delete($keyName, $notExpired);
        }
        return true;
    }

    /**
     * exists
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断缓存是否存在
     * @param $keyName
     * @param bool $notExpired
     * @return bool
     */
    public function exists($keyName, $notExpired = false): bool
    {
        foreach ($this->_backends as $backend) {
            if ($backend->exists($keyName, $notExpired)) {
                return true;
            }
        }
        return false;
    }


}