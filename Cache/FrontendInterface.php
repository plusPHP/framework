<?php
/**
 * plusPHP FrameWork
 * @File name: FrontendInterface.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/11
 * @Time: 11:15
 * @Description: 缓存前端数据序列化适配器接口
 */

namespace plusPHP\Cache;

interface FrontendInterface
{

    /**
     * serialize
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 序列化需要缓存的数据
     * @param $data
     * @return mixed
     */
    public function serialize($data);

    /**
     * deserialize
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 对已经序列化的数据进行反序列化操作
     * @param $data
     * @return mixed
     */
    public function deserialize($data);

}