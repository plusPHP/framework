<?php
/**
 * plusPHP FrameWork
 * @File name: Wincache.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/11
 * @Time: 15:18
 * @Description: 缓存后端储存适配器(wincache)
 */
namespace plusPHP\Cache\Backend;

use plusPHP\Cache\Backend;
use plusPHP\Cache\BackendInterface;
use plusPHP\Cache\FrontendInterface;

class Wincache extends Backend implements BackendInterface
{


    public function __construct(FrontendInterface $frontend, $option = null)
    {
        parent::__construct($frontend, $option);
    }


    public function get($keyName, $notExpired = true)
    {
        $cachedContent = wincache_ucache_get($keyName, $success);
        if ($success === false) {
            return null;
        }
        return $this->getFrontend()->deserialize($cachedContent);
    }


    public function delete($keyName, $notExpired = true): bool
    {
        return wincache_ucache_delete($keyName);
    }


    public function effective($keyName, $notExpired = true): bool
    {
        return wincache_ucache_exists($keyName);
    }


    public function save($keyName, $content, int $lifetime = null): bool
    {
        $data = $this->getFrontend()->serialize($content);
        return wincache_ucache_set($keyName, $data, $lifetime);
    }

}