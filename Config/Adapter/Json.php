<?php
/**
 * plusPHP FrameWork
 * @File name: Json.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/5/11
 * @Time: 14:05
 * @Description: 配置(Json文件)
 */
namespace plusPHP\Config\Adapter;

use plusPHP\Config\Config;
use plusPHP\Config\ConfigInterface;

class Json extends Config
{

    public function __construct(string $jsonFilePath, ConfigInterface ...$configs)
    {
        call_user_func_array('parent::__construct', array_merge([json_decode(file_get_contents($jsonFilePath), true)], $configs));
    }

}