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
    protected $_link;

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

    public function effective($keyName): bool
    {
        // TODO: Implement effective() method.
    }

    public function save($keyName, $content, int $lifetime = null): bool
    {
        // TODO: Implement save() method.
    }

    public function delete($keyName): bool
    {
        // TODO: Implement delete() method.
    }

    public function get($keyName)
    {
        // TODO: Implement get() method.
    }

    protected function link()
    {
        
    }

}