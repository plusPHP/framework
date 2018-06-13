<?php
/**
 * plusPHP FrameWork
 * @File name: Memcache.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/13
 * @Time: 21:35
 * @Description: 缓存后端储存适配器(Memcache)
 */

namespace plusPHP\Cache\Backend;


use plusPHP\Cache\Backend;
use plusPHP\Cache\BackendInterface;
use plusPHP\Cache\FrontendInterface;

class Memcache extends Backend implements BackendInterface
{

    /**
     * @description Memcache对象
     * @var \Memcache
     */
    protected $_memcache;


    public function __construct(FrontendInterface $frontend, $option = null)
    {
        if (!isset($option['host'])) {
            $option['host'] = '127.0.0.1';
        }

        if (!isset($option['port'])) {
            $option['port'] = 11211;
        }

        if (!isset($option['persistent'])) {
            $option['persistent'] = false;
        }

        if (!isset($option['statsKey'])) {
            $option['statsKey'] = '';
        }
        parent::__construct($frontend, $option);
    }

    /**
     * delete
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @param $keyName
     * @throws \Exception
     * @return bool
     */
    public function delete($keyName): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        $memcache = $this->link();
        $option = $this->getOption();
        if ($option['statsKey'] != '') {
            $keys = $memcache->get($option['statsKey']);
            if (is_array($keys)) {
                unset($keys[$keyName]);
                $memcache->set($option['statsKey'], $keys);
            }
        }
        return $memcache->delete($keyName);
    }

    /**
     * effective
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @param $keyName
     * @throws \Exception
     * @return bool
     */
    public function effective($keyName): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        $memcache = $this->link();
        if (!$memcache->get($keyName)) {
            return false;
        }
        return true;
    }

    /**
     * get
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @param $keyName
     * @throws \Exception
     * @return array|mixed|null|string
     */
    public function get($keyName)
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        $memcache = $this->link();
        $cachedContent = $memcache->get($keyName);

        if ($cachedContent === false) {
            return null;
        }

        if (is_numeric($cachedContent)) {
            return $cachedContent;
        }
        return $this->getFrontend()->deserialize($cachedContent);
    }

    /**
     * save
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @param string $keyName
     * @param $content
     * @param int|null $lifetime
     * @throws \Exception
     * @return bool
     */
    public function save($keyName, $content, int $lifetime = null): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        $memcache = $this->link();
        $option = $this->getOption();

        is_numeric($content) ? $preparedContent = $content
            : $preparedContent = $this->getFrontend()->serialize($content);
        $success = $memcache->set($keyName, $preparedContent, 0, $lifetime);

        if (!$success) {
            throw new \Exception('Failed storing data in memcached');
        }

        if ($option['statsKey'] != '') {
            $keys = $memcache->get($option['statsKey']);
            if (!is_array($keys)) {
                $keys = [];
            }

            if (!isset($keys[$keyName])) {
                $keys[$keyName] = $lifetime;
                $memcache->set($option['statsKey'], $keys);
            }
        }
        return $success;
    }

    /**
     * link
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @throws \Exception
     * @return \Memcache
     */
    protected function link(): \Memcache
    {
        $option = $this->getOption();
        if (empty($option['host']) || empty($option['port']) || empty($option['persistent'])) {
            throw new \Exception("Unexpected inconsistency in options");
        }

        $memcache = new \Memcache();

        if ($option['persistent']) {
            $success = $memcache->pconnect($option['host'], $option['port']);
        } else {
            $success = $memcache->connect($option['host'], $option['port']);
        }

        if (!$success) {
            throw new \Exception("Cannot connect to Memcached server");
        }

        $this->_memcache = $memcache;
    }

}