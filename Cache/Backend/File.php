<?php
/**
 * plusPHP FrameWork
 * @File name: File.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/11
 * @Time: 17:59
 * @Description: 缓存后端储存适配器(文件)
 */
namespace plusPHP\Cache\Backend;

use plusPHP\Cache\BackendInterface;
use plusPHP\Cache\FrontendInterface;

class File implements BackendInterface
{

    /**
     * @description 前端适配器
     * @var FrontendInterface
     */
    protected $_frontend;

    /**
     * @description 缓存路径
     * @var string
     */
    protected $_options;


    public function __construct(FrontendInterface $frontend, $option = null)
    {
        $this->_frontend = $frontend;

        if (!is_array($option) || empty($option['cache_dir']) || !is_string($option['cache_dir'])) {
            throw new \InvalidArgumentException('The file cache setup error is incorrect, and the array cache_dir must be set!');
        }

        $this->_options = $option;
    }


    public function save($keyName, $content, int $lifetime = null) : bool
    {
        $data = $this->getFrontend()->serialize($content);

        if (!(is_string($data) || is_numeric($data) || (is_object($data) && method_exists($data, 'toString')))) {
            throw new \InvalidArgumentException('The file cache data must be a string. Please use the correct cache frontend!');
        }

        if (!$this->dir_exists($this->_options['cache_dir'])) {
            throw new \RuntimeException('The cache folder does not exist, trying to create a failure!');
        }

        $cacheFile = $this->_options['cache_dir'] . $keyName;
        $status = file_put_contents($cacheFile, (time() + $lifetime)."\n".$data);
        return $status;
    }


    public function getOption()
    {
        return $this->_options;
    }

    public function getFrontend(): FrontendInterface
    {
        return $this->_frontend;
    }

    public function effective($keyName) : bool
    {
        if (!$this->dir_exists($this->_options['cache_dir'])) {
            throw new \RuntimeException('The cache folder does not exist, trying to create a failure!');
        }

        $cacheFile = $this->_options['cache_dir'] . $keyName;

        if (!is_file($cacheFile)) {
            return false;
        }

        $fileContent = file_get_contents($cacheFile);

        if (empty($fileContent)) {
            return false;
        }

        $expired = substr($fileContent, 0, 10);

        if (!is_numeric($expired) || $expired <= time()) {
            return false;
        } else {
            return true;
        }
    }


    public function delete($keyName) : bool
    {
        if (!$this->dir_exists($this->_options['cache_dir'])) {
            throw new \RuntimeException('The cache folder does not exist, trying to create a failure!');
        }

        $cacheFile = $this->_options['cache_dir'] . $keyName;

        if (!is_file($cacheFile)) {
             return false;
        }
        return unlink($cacheFile);
    }

    public function get($keyName)
    {
        if (!$this->dir_exists($this->_options['cache_dir'])) {
            throw new \RuntimeException('The cache folder does not exist, trying to create a failure!');
        }

        $cacheFile = $this->_options['cache_dir'] . $keyName;

        if (!is_file($cacheFile)) {
            return false;
        }

        $fileContent = file_get_contents($cacheFile);

        if (empty($fileContent)) {
            return false;
        }

        $expired = substr($fileContent, 0, 10);

        if (!is_numeric($expired) || $expired <= time()) {
            return false;
        } else {
            return $this->getFrontend()->deserialize(substr($fileContent, 11));
        }
    }

    protected function dir_exists($dir, $mk = true, $mode = 0777)
    {
        if (is_dir($dir)) {
            return true;
        }

        if ($mk && mkdir($dir, $mode, true)) {
            return true;
        }else{
            return false;
        }
    }

}