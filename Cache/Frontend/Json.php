<?php
/**
 * plusPHP FrameWork
 * @File name: Json.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/11
 * @Time: 17:31
 * @Description: 文件描述
 */
namespace plusPHP\Cache\Frontend;

use plusPHP\Cache\FrontendInterface;

class Json implements FrontendInterface
{

    public function deserialize($data)
    {
        return json_decode($data);
    }


    public function serialize($data)
    {
        return json_encode($data);
    }

}