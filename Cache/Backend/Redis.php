<?php
/**
 * plusPHP FrameWork
 * @File name: Redis.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/13
 * @Time: 17:26
 * @Description: 缓存后端储存适配器(Redis)
 */


namespace plusPHP\Cache\Backend;


use plusPHP\Cache\Backend;
use plusPHP\Cache\BackendInterface;
use plusPHP\Cache\FrontendInterface;

class Redis extends Backend implements BackendInterface
{

    /**
     * @description Redis链接对象
     * @var \Redis
     */
    protected $_redis;

    public function __construct(FrontendInterface $frontend, $option = null)
    {
        if (empty($option['host'])) {
            $option['host'] = '127.0.0.1';
        }

        if (empty($option['port'])) {
            $option['port'] = 6379;
        }

        if (empty($option['index'])) {
            $options['index'] = 0;
        }

        if (empty($option['persistent'])) {
            $option['persistent'] = false;
        }

        if (empty($option['statsKey'])) {
            $option['statsKey'] = '';
        }

        if (empty($option['auth'])) {
            $option['auth'] = '';
        }

        parent::__construct($frontend, $option);
    }

    /**
     * effective
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @param string $keyName
     * @throws \Exception
     * @return bool
     */
    public function effective($keyName): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }
        $redis = $this->link();
        return (bool) $redis->exists($keyName);
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
        $redis = $this->link();
        $option = $this->getOption();

        is_numeric($content) ? $preparedContent = $content
            : $preparedContent = $this->getFrontend()->serialize($content);

        $success = $redis->set($keyName, $preparedContent);

        if (!$success) {
            throw new \Exception('Failed storing the data in redis!');
        }

		if ($lifetime >= 1) {
            $redis->settimeout($keyName, $lifetime);
		}

        if ($option['statsKey'] != '') {
            $redis->sAdd($option['statsKey'], $keyName);
		}
        return (bool) $redis->exists($keyName);
    }

    /**
     * delete
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @param string $keyName
     * @throws \Exception
     * @return bool
     */
    public function delete($keyName): bool
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }

        $redis = $this->link();
		$option = $this->getOption();

		if (!isset($option['statsKey'])) {
            throw new \Exception('Unexpected inconsistency in options');
        }

		if ($option['statsKey'] != '') {
            $redis->sRem($option['statsKey'], $keyName);
		}
		return (bool)$redis->delete($keyName);
    }

    /**
     * get
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @param string $keyName
     * @throws \Exception
     * @return bool|mixed|null|string
     */
    public function get($keyName)
    {
        if (empty($keyName) && !is_string($keyName)) {
            throw new \InvalidArgumentException('The cache key name must be a string!');
        }

        $redis = $this->link();
        $cachedContent = $redis->get($keyName);

		if ($cachedContent === false) {
            return null;
        }

		if (is_numeric($cachedContent)) {
			return $cachedContent;
		}
		return $this->getFrontend()->deserialize($cachedContent);
    }

    /**
     * link
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @throws \Exception
     * @return \Redis
     */
    protected function link(): \Redis
    {
        if (empty($this->_redis)) {
            $option = $this->getOption();
            $redis = new \Redis();

            if (empty($option['host']) || empty($option['port']) || !isset($option['persistent'])) {
                throw new \InvalidArgumentException('Unexpected inconsistency in options!');
            }

            if ($option['persistent']) {
                $success = $redis->pconnect($option['host'], $option['port']);
            } else {
                $success = $redis->connect($option['host'], $option['port']);
            }

            if (!$success) {
                throw new \InvalidArgumentException('Could not connect to the Redis server ' . $option['host'] . ':' . $option['port']);
            }

            if (!empty($option['auth'])) {
                $success = $redis->auth($option['auth']);

                if (!$success) {
                    throw new \Exception('Failed to authenticate with the Redis server!');
                }
            }

            if ($option['index'] && $option['index'] > 0) {
                $success = $redis->select($option['index']);

                if (!$success) {
                    throw new \Exception('Redis server selected database failed!');
                }
            }
            $this->_redis = $redis;
        }
        return $this->_redis;
    }

}