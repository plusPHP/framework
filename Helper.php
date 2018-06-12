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