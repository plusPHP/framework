<?php
/**
 * plusPHP FrameWork
 * @File name: Helper.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/7
 * @Time: 23:38
 * @Description: 助手函数文件
 */
if (!function_exists('dir_exists')) {
    /**
     * dir_exists
     * @date 2018/5/19
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断文件夹是否存在，如果mk参数为true则在不存在时去创建文件夹，并在创建成功时返回true
     * @param $dir
     * @param bool $mk
     * @param int $mode
     * @return bool
     */
    function dir_exists($dir, $mk = true, $mode = 0777)
    {
        if (is_dir($dir)) {
            return true;
        }

        if ($mk && mkdir($dir, $mode, true)) {
            return true;
        }else{
            return false;
        }
    }
}

if (!function_exists('is_assoc')) {
    /**
     * is_assoc
     * @date 2018/5/26
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断一个数组是否为关联数组
     * @param array $array
     * @return bool
     */
    function is_assoc(array $array)
    {
        return array_diff(array_keys($array), range(0, count($array))) ? true : false;
    }
}

if (!function_exists('get_array_value')) {
    /**
     * get_array_value
     * @date 2018/5/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 解析string并返回相应的数组值
     * @param $string string
     * @param $value mixed
     * @param $default
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
     * echo parse_dot_key_from_array('db.host', $array); // localhost
     * echo parse_dot_key_from_array('db.user.name', $array); // root
     *</code>
     */
    function get_array_value(string $string, array $value, $default = null)
    {
        $pos = strpos($string, '.');
        if ($pos === false) {
            if (isset($value[$string])) {
                return $value[$string];
            } else {
                return $default;
            }
        }

        $key = substr($string, 0, $pos);
        $string = substr($string, $pos + 1);

        if (isset($value[$key])) {
            return get_array_value($string, $value[$key]);
        } else {
            return $default;
        }
    }
}

if (!function_exists('set_array_value')) {
    /**
     * set_array_value
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 解析string并设置相应的数组值
     * @param array $array
     * @param string $string
     * @param $value
     */
    function set_array_value(array &$array, string $string, $value)
    {
        $pos = strpos($string, '.');
        if ($pos === false) {
            $array[$string] = $value;
        } else {
            $key = substr($string, 0, $pos);
            $string = substr($string, $pos + 1);

            if (strlen($string) == $pos + 2) {
                $array[$key][] = $value;
            } else {
                if (!isset($array[$key])) {
                    $array[$key] = [];
                }
                set_array_value($array[$key], $string, $value);
            }
        }
    }
}