<?php
/**
 * plusPHP FrameWork
 * @File name: Yaml.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/5/11
 * @Time: 13:45
 * @Description: 配置(Yaml文件)
 */
namespace plusPHP\Config\Adapter;

use plusPHP\Config\Config;
use plusPHP\Config\ConfigInterface;

class Yaml extends Config
{

    public function __construct(string $yamlFilePath, array $callbacks = null, ConfigInterface ...$configs)
    {
        $ndocs = 0;

		if (!extension_loaded('yaml')) {
			throw new \Exception('Yaml extension not loaded');
		}

        if ($callbacks !== null) {
            $yamlConfig = yaml_parse_file($yamlFilePath, 0, $ndocs, $callbacks);
		} else {
            $yamlConfig = yaml_parse_file($yamlFilePath);
		}

        call_user_func_array('parent::__construct', array_merge([$yamlConfig], $configs));
    }

}