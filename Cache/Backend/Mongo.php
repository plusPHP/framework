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

    /**
     * @description MongoDb对象
     * @var \MongoCollection
     */
    protected $_link;

    /**
     * Mongo constructor.
     * @param FrontendInterface $frontend
     * @param null $option
     */
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

    /**
     * get
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @param string $keyName
     * @throws \Exception
     * @throws \MongoConnectionException
     * @return bool|mixed|null
     */
    public function get($keyName)
    {
        $conditions['key'] = $keyName;
        $conditions['time'] = ['$gt' => time()];
        $document = $this->getLink()->findOne($conditions);
        if (is_array($document)) {
            if (isset($document['data']) && $cachedContent = $document['data']) {
                if (is_numeric($cachedContent)) {
                    return $cachedContent;
                }
                return $this->getFrontend()->deserialize($cachedContent);
            } else {
                return false;
            }
        }
        return null;
    }

    /**
     * delete
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @param string $keyName
     * @throws \Exception
     * @throws \MongoConnectionException
     * @throws \MongoCursorException
     * @throws \MongoCursorTimeoutException
     * @return bool
     */
    public function delete($keyName): bool
    {
        $this->getLink()->remove(['key' => $keyName]);
        if (((int)rand()) % 100 == 0) {
            $this->gc();
        }
        return true;
    }


    public function getFrontend(): FrontendInterface
    {
        return $this->_frontend;
    }


    public function getOption()
    {
        return $this->_option;
    }

    /**
     * save
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 保存缓存
     * @param string $keyName
     * @param $content
     * @param int|null $lifetime
     * @throws \Exception
     * @throws \MongoConnectionException
     * @throws \MongoCursorException
     * @throws \MongoCursorTimeoutException
     * @throws \MongoException
     * @return bool
     */
    public function save($keyName, $content, int $lifetime = null): bool
    {
        $collection = $this->getLink();
        $timestamp = time() + intval($lifetime);
        $conditions['key'] = $keyName;
        $document = $collection->findOne($conditions);

        if (is_array($document)) {
            $document['time'] = $timestamp;
            $document['data'] = $this->getFrontend()->serialize($content);
            return $collection->update(['_id' => $document['_id']], $document);
        } else {
            $data['key'] = $keyName;
            $data['time'] = $timestamp;
            $data['data'] = $this->getFrontend()->serialize($content);
            return $collection->insert($data);
        }
    }

    /**
     * effective
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @param string $keyName
     * @throws \Exception
     * @throws \MongoConnectionException
     * @return bool
     */
    public function effective($keyName): bool
    {
        if (!empty($keyName) && is_string($keyName)) {
            return $this->getLink()->count(['key' => $keyName, 'time' => ['$gt' => time()]]) > 0;
        }
        return false;
    }

    /**
     * getLink
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取Mongo对象
     * @throws \Exception
     * @throws \MongoConnectionException
     * @return \MongoCollection
     */
    protected function getLink(): \MongoCollection
    {
        $mongo = $this->_link;
        if (is_object($mongo)) {
            return $mongo;
        } else {
            $option = $this->_option;
            if (empty($option['mongo']) && $option['mongo'] instanceof \MongoClient) {
                $mongo = $option['mongo'];
            } else {
                $server = $option['server'];
                if (empty($server) || is_string($server)) {
                    throw new \InvalidArgumentException("The MongoDb server parameter must be a correct Mongo host!");
                }
                $mongo = new \MongoClient($server);
            }
        }

        $database = $option['db'];
        if (!empty($database) || is_string($database)) {
            throw new \InvalidArgumentException('The backend requires a valid MongoDB db!');
        }

        $collection = $option['collection'];
        if (empty($collection) || is_string($collection)) {
            throw new \InvalidArgumentException("The backend requires a valid MongoDB collection!");
        }

        $link = $mongo->selectDb($database)->selectCollection($collection);
        $this->_link = $link;
    }

    /**
     * gc
     * @date 2018/6/13
     * @author Naizui_ycx chenxi2511@qq.com
     * @throws \Exception
     * @throws \MongoConnectionException
     * @throws \MongoCursorException
     * @throws \MongoCursorTimeoutException
     * @return array|bool
     */
    protected function gc()
    {
        return $this->getLink()->remove(['time' => ['$lt' => time()]]);
    }

}