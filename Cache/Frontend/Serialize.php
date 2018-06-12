<?php
/**
 * plusPHP FrameWork
 * @File name: Serialize.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/11
 * @Time: 17:40
 * @Description: 文件描述
 */

namespace plusPHP\Cache\Frontend;

use plusPHP\Cache\FrontendInterface;

class Serialize implements FrontendInterface
{


    public function deserialize($data)
    {
        if (is_numeric($data) || empty($data)) {
            return $data;
        }
        return unserialize($data);
    }


    public function serialize($data)
    {
        return serialize($data);
    }


}