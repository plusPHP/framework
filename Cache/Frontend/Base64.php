<?php
/**
 * plusPHP FrameWork
 * @File name: Base64.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/11
 * @Time: 17:34
 * @Description: 文件描述
 */
namespace plusPHP\Cache\Frontend;

use plusPHP\Cache\FrontendInterface;

class Base64 implements FrontendInterface
{

    public function serialize($data)
    {
        return base64_encode($data);
    }

    public function deserialize($data)
    {
        return base64_decode($data);
    }

}