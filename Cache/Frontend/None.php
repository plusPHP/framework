<?php
/**
 * plusPHP FrameWork
 * @File name: None.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/11
 * @Time: 17:49
 * @Description: 文件描述
 */
namespace plusPHP\Cache\Frontend;

use plusPHP\Cache\FrontendInterface;

class None implements FrontendInterface
{

    public function serialize($data)
    {
        return $data;
    }

    public function deserialize($data)
    {
        return $data;
    }

}