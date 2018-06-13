<?php
/**
 * plusPHP FrameWork
 * @File name: Backend.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/13
 * @Time: 17:33
 * @Description: 缓存后端储存适配器基础类
 */


namespace plusPHP\Cache;


abstract class Backend implements BackendInterface
{

    /**
     * @description 字段描述
     * @var FrontendInterface
     */
    protected $_frontend;

    /**
     * @description 缓存后端配置
     * @var mixed
     */
    protected $_options;


    public function __construct(FrontendInterface $frontend, $option = null)
    {
        $this->_frontend = $frontend;
        $this->_options = $option;
    }


    public function getFrontend(): FrontendInterface
    {
        return $this->_frontend;
    }


    public function getOption()
    {
        return $this->_options;
    }

}