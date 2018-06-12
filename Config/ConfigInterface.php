<?php
/**
 * plusPHP FrameWork
 * @File name: ConfigInterface.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/5/11
 * @Time: 10:42
 * @Description: 配置
 */
namespace plusPHP\Config;


interface ConfigInterface extends \ArrayAccess, \Countable
{

    /**
     * getAllConfig
     * @date 2018/5/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前全部配置数据
     * @return array
     */
    public function getAllConfig() : array;

    /**
     * getConfig
     * @date 2018/5/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取单个配置信息
     * @param $name string 配置名
     * @param $defaultValue mixed 默认值
     * @return void
     */
    public function getConfig($name, $defaultValue = null);

    /**
     * setAllConfig
     * @date 2018/5/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 批量设置配置值
     * @param $config array 配置数组
     * @return ConfigInterface 返回当前的配置对象
     */
    public function setAllConfig(array $config) : ConfigInterface;

    /**
     * setConfig
     * @date 2018/5/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 设置单条配置
     * @param $name string 配置名
     * @param $value mixed 配置值
     * @param $onlyUndefined bool 是否覆盖原配置，如果原配置存在
     * @return ConfigInterface 返回当前的配置对象
     */
    public function setConfig($name, $value, $onlyUndefined = false) : ConfigInterface;

    /**
     * merge
     * @date 2018/5/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 合并多个配置
     * @param $configs[] ConfigInterface
     * @return ConfigInterface 返回当前的配置对象(合并后)
     */
    public function merge(ConfigInterface ...$configs) : ConfigInterface;

}