<?php
/**
 * plusPHP FrameWork
 * @File name: InjectionAwareInterface.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/14
 * @Time: 16:20
 * @Description: 容器注入感知接口
 */


namespace plusPHP\Di;


use plusPHP\DiInterface;

interface InjectionAwareInterface
{

    public function setDi(DiInterface $di);

    public function getDi(): DiInterface;

}