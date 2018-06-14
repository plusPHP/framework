<?php
/**
 * plusPHP FrameWork
 * @File name: Memcached.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/14
 * @Time: 9:17
 * @Description: 缓存后端储存适配器(Memcached)
 */


namespace plusPHP\Cache\Backend;


use plusPHP\Cache\Backend;
use plusPHP\Cache\BackendInterface;
use plusPHP\Cache\FrontendInterface;

class Memcached extends Backend implements BackendInterface
{

    /**
     * @description Memcached对象
     * @var \Memcached
     */
    protected $_memcached;


    public function __construct(FrontendInterface $frontend, $option = null)
    {
        if (!isset($option['servers'])) {
            $option['servers'][] = ['host' => '127.0.0.1', 'port' => 11211, 'weight' => 1];
        }

        if (!isset($option['statsKey'])) {
            $option['statsKey'] = '';
        }
        parent::__construct($frontend, $option);
    }


    public function get($keyName)
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        $memcache = $this->link();
        $cachedContent = $memcache->get($keyName);
		if (!$cachedContent) {
            return null;
        }

		if (is_numeric($cachedContent)) {
			return $cachedContent;
		} else {
            return $this->getFrontend()->serialize($cachedContent);
		}
    }


    public function delete($keyName): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        $memcache = $this->link();
        $option = $this->getOption();

        if (!isset($option['statsKey'])) {
            throw new \InvalidArgumentException('Unexpected inconsistency in options');
        }

		if ($option['statsKey'] != '') {
            $keys = $memcache->get($option['statsKey']);
			if (is_array($keys)) {
                unset($keys[$option['statsKey']]);
                $memcache->set($option['statsKey'], $keys);
			}
		}
		return $memcache->delete($keyName);
    }


    public function save($keyName, $content, int $lifetime = null): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        $memcache = $this->link();
        $option = $this->getOption();
        if (!is_numeric($content)) {
            $preparedContent = $this->getFrontend()->serialize($content);
		} else {
            $preparedContent = $content;
		}
        $success = $memcache->set($keyName, $preparedContent, $lifetime);
        if (!$success) {
            throw new \RuntimeException('Failed storing data in memcached, error code: ' . $memcache->getResultCode());
		}

        if (!isset($option['statsKey'])) {
            throw new \InvalidArgumentException('Unexpected inconsistency in options!');
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


    public function effective($keyName): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        $memcache = $this->link();
        if ($memcache->get($keyName)) {
            return true;
        } else {
            return false;
        }
    }


    protected function link(): \Memcached
    {
        if (empty($this->_memcached)) {
            $option = $this->getOption();
            if (empty($option['persistent_id'])) {
                $option['persistent_id'] = 'plusPHP_cache';
            }
            $memcached = new \Memcached($option['persistent_id']);
            if (empty($memcached->getServerList())) {
                if (empty($option['servers']) || !is_array($option['servers'])) {
                    throw new \InvalidArgumentException('Servers options must be an array!');
                }

                if (!isset($option['client'])) {
                    $option['client'] = [];
                }

                if (!is_array($option['client'])) {
                    throw new \InvalidArgumentException('Client options must be an array!');
                }

                if (!$memcached->setOptions($option['client'])) {
                    throw new \RuntimeException('Cannot set to Memcached options!');
                }

                if (!$memcached->addServers($option['servers'])) {
                    throw new \RuntimeException('Cannot connect to Memcached server');
                }
            }
            $this->_memcached = $memcached;
        }
        return $this->_memcached;
    }


}