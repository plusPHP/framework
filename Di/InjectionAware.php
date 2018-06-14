<?php
/**
 * plusPHP FrameWork
 * @File name: InjectionAware.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/14
 * @Time: 16:27
 * @Description: 依赖注入感知
 */


namespace plusPHP\Di;


use plusPHP\DiInterface;

trait InjectionAware
{

    /**
     * @description 依赖容器
     * @var DiInterface
     */
    protected $_di;


    public function setDi(DiInterface $di)
    {
        $this->_di = $di;
        return $this;
    }

    public function getDi(): DiInterface
    {
        return $this->_di;
    }

}