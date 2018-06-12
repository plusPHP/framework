<?php
/**
 * plusPHP FrameWork
 * @File name: Igbinary.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/11
 * @Time: 17:52
 * @Description: 文件描述
 */

namespace plusPHP\Cache\Frontend;

use plusPHP\Cache\FrontendInterface;

class Igbinary implements FrontendInterface
{

    public function serialize($data)
    {
        return igbinary_serialize($data);
    }

    public function deserialize($data)
    {
        if (is_numeric($data)) {
            return $data;
        }
        return igbinary_unserialize($data);
    }

}