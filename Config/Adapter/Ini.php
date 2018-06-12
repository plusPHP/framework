<?php
/**
 * plusPHP FrameWork
 * @File name: Ini.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/5/11
 * @Time: 16:38
 * @Description: 配置(Ini文件)
 */
namespace plusPHP\Config\Adapter;

use plusPHP\Config\ConfigInterface;

class Ini
{

    public function __construct(string $iniFilePath, ConfigInterface ...$configs)
    {
        call_user_func_array('parent::__construct', array_merge([$this->_parseIniFile($iniFilePath)], $configs));
    }


    protected function _parseIniFile($iniFilePath)
    {
        return parse_ini_file($iniFilePath, true);
    }

}