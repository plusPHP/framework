<?php
/**
 * plusPHP FrameWork
 * @File name: Mongo.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/12
 * @Time: 11:22
 * @Description: 文件描述
 */

namespace plusPHP\Cache\Backend;

use plusPHP\Cache\BackendInterface;
use plusPHP\Cache\FrontendInterface;

class Mongo implements BackendInterface
{

    /**
     * @description 缓存前端数据序列化适配器对象
     * @var FrontendInterface
     */
    protected $_frontend;

    /**
     * @description Mongo连接配置
     * @var array
     */
    protected $_option;

    public function __construct(FrontendInterface $frontend, $option = null)
    {

        if (!isset($options['mongo'])) {
            if (!isset($options['server'])) {
                throw new \InvalidArgumentException('The parameter "server" is required');
            }
        }

        if (!isset($options['db'])) {
            throw new \InvalidArgumentException('The parameter "db" is required');
        }

        if (!isset($options['collection'])) {
            throw new \InvalidArgumentException('The parameter "collection" is required');
        }

        $this->_frontend = $frontend;
        $this->_option = $option;
    }

    public function get($keyName)
    {
        // TODO: Implement get() method.
    }

    public function delete($keyName): bool
    {
        // TODO: Implement delete() method.
    }

    public function getFrontend(): FrontendInterface
    {
        return $this->_frontend;
    }

    public function getOption()
    {
        return $this->_option;
    }

    public function save($keyName, $content, int $lifetime = null): bool
    {
        // TODO: Implement save() method.
    }

    public function effective($keyName): bool
    {
        // TODO: Implement effective() method.
    }

}