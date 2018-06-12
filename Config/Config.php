<?php
/**
 * plusPHP FrameWork
 * @File name: Config.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/5/11
 * @Time: 9:39
 * @Description: 配置(本地数组)
 */

namespace plusPHP\Config;

class Config implements ConfigInterface
{

    protected $config = [];
    protected $undefined = false;

    public function __construct(array $configArray = [], ConfigInterface ...$configs)
    {
        $this->setAllConfig($configArray);
        if (count($configs)) {
            call_user_func_array([$this, 'merge'], $configs);
        }
    }

    public function getAllConfig(): array
    {
        return $this->_cast($this->config);
    }

    public function getConfig($name, $defaultValue = null)
    {
        $value = $this->_parseIniString($name, $this->config);

        if ($this->undefined) {
            $this->undefined = false;
            return $defaultValue;
        } else {
            return $this->_cast($value);
        }
    }

    public function setAllConfig(array $config): ConfigInterface
    {
        $this->config = $config;
        return $this;
    }

    public function setConfig($name, $value, $onlyUndefined = false): ConfigInterface
    {
        if ($onlyUndefined) {
            isset($this->config[$name]) ?: $this->config[$name] = $value;
        } else {
            $this->config[$name] = $value;
        }
        return $this;
    }

    public function merge(ConfigInterface ...$configs): ConfigInterface
    {
        foreach ($configs as $config) {
            $this->config = array_merge($this->config, $config->getAllConfig());
        }
        return $this;
    }

    public function count()
    {
        return count($this->config);
    }

    public function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->config[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->config[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }

    /**
     * _cast
     * @date 2018/5/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 对配置数据进行解码
     * @param $ini mixed 配置数据
     * @return mixed
     */
    protected function _cast($ini)
    {
        if (is_array($ini)) {
            foreach ($ini as $key => $value) {
                $ini[$key] = $this->_cast($value);
            }
        }

        if (is_string($ini)) {
            $_ini = strtolower($ini);
            //todo Decode true
            if ($_ini === 'true' || $_ini === 'yes' || $_ini === 'on') {
                return true;
            }

            //todo Decode false
            if ($_ini === 'false' || $_ini === 'no' || $_ini === 'off') {
                return false;
            }

            //todo Decode null
            if ($_ini === 'null') {
                return null;
            }

            //todo Decode float/int
            if (is_numeric($ini)) {
                if (preg_match("/[.]+/", $ini)) {
                    return (double)$ini;
                } else {
                    return (int)$ini;
                }
            }
        }
        return $ini;
    }

    /**
     * _parseIniString
     * @date 2018/5/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 解析string并返回相应的配置值
     * @param $string string
     * @param $value mixed 配置值
     * @return mixed
     *<code>
     * $array = [
     *      'db' => [
     *          'host' => 'localhost',
     *          'user' => [
     *              'name' => 'root',
     *              'password' =>  '123456',
     *          ]
     *      ]
     * ];
     * echo $this->_parseIniString('db.host', $array); // localhost
     * echo $this->_parseIniString('db.user.name', $array); // root
     *</code>
     */
    protected function _parseIniString($string, $value)
    {
        $pos = strpos($string, '.');

        if ($pos === false) {

            if (isset($value[$string])) {
                return $value[$string];
            } else {
                $this->undefined = true;
                return false;
            }

        }

        $key = substr($string, 0, $pos);
        $string = substr($string, $pos + 1);

        if (isset($value[$key])) {
            return $this->_parseIniString($string, $value[$key]);
        } else {
            $this->undefined = true;
            return false;
        }

    }

}