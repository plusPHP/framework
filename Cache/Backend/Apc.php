<?php
/**
 * plusPHP FrameWork
 * @File name: Apc.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/14
 * @Time: 11:15
 * @Description: 缓存后端储存适配器(Apc)
 */


namespace plusPHP\Cache\Backend;


use plusPHP\Cache\Backend;
use plusPHP\Cache\BackendInterface;

class Apc extends Backend implements BackendInterface
{

    public function save($keyName, $content, int $lifetime = null): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }

        if (!is_numeric($content)) {
            $preparedContent = $this->getFrontend()->serialize($content);
		} else {
            $preparedContent =$content;
		}
        return apc_store($keyName, $preparedContent, $lifetime);
    }


    public function effective($keyName): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        if (apc_exists($keyName) !== false) {
            return true;
        } else {
            return false;
        }
    }


    public function get($keyName)
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        $cachedContent = apc_fetch($keyName);
        if (!$cachedContent) {
            return null;
        }

        if (is_numeric($cachedContent)) {
            return $cachedContent;
        } else {
            return $this->getFrontend()->deserialize($cachedContent);
        }
    }


    public function delete($keyName): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        return apc_delete($keyName);
    }

}