<?php
/**
 * plusPHP FrameWork
 * @File name: BackendInterface.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/11
 * @Time: 11:10
 * @Description: 缓存后端数据储存适配器接口
 */
namespace plusPHP\Cache;

interface BackendInterface
{

    /**
     * BackendInterface constructor.
     * @param FrontendInterface $frontend
     * @param $option
     */
    public function __construct(FrontendInterface $frontend, $option = null);

    /**
     * getFrontend
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取缓存前端对象
     * @return FrontendInterface
     */
    public function getFrontend() : FrontendInterface;

    /**
     * save
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 保存缓存数据
     * @param $keyName
     * @param $content
     * @param int $lifetime
     * @return bool
     */
    public function save($keyName, $content, int $lifetime = null) : bool;

    /**
     * get
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取缓存数据
     * @param $keyName
     * @return mixed
     */
    public function get($keyName);

    /**
     * delete
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 删除缓存数据
     * @param $keyName
     * @return mixed
     */
    public function delete($keyName) : bool;

    /**
     * exists
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断缓存是否有效
     * @param $keyName
     * @return mixed
     */
    public function effective($keyName) : bool;

    /**
     * setOption
     * @date 2018/6/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 返回缓存后端设置参数
     * @return mixed
     */
    public function getOption();

}