<?php
/**
 * plusPHP FrameWork
 * @File name: SessionInterface.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/17
 * @Time: 9:42
 * @Description: session接口
 */

namespace plusPHP\Http;


interface SessionInterface
{

    /**
     * setHandle
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 设置session处理对象
     * @param \SessionHandlerInterface $handler
     * @return mixed
     */
    public function setHandle(\SessionHandlerInterface $handler);

    /**
     * get
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取一个session值
     * @param string $name
     * @param string $prefix
     * @return mixed
     */
    public function get(string $name, string $prefix);

    /**
     * set
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取一个session值
     * @param string $name
     * @param $value
     * @param string $prefix
     * @return mixed
     */
    public function set(string $name, $value, string $prefix);

    /**
     * prefix
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 设置session前缀
     * @param string $prefix
     * @return mixed
     */
    public function prefix(string $prefix);

    /**
     * init
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 初始化session
     * @return mixed
     */
    public function init();

    /**
     * setLock
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 设置session锁对象
     * @param SessionLockInterface $lock
     * @return mixed
     */
    public function setLock(SessionLockInterface $lock);

    /**
     * has
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断session值是否存在
     * @param string $name
     * @param string $prefix
     * @return bool
     */
    public function has(string $name, string $prefix);

    /**
     * clear
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 清空session数据
     * @return mixed
     */
    public function clear();

    /**
     * delete
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 删除session值
     * @param string $name
     * @param string $prefix
     * @return mixed
     */
    public function delete(string $name, string $prefix);

    /**
     * destroy
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 销毁session
     * @return mixed
     */
    public function destroy();

    /**
     * resetSID
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 重置SID
     * @param bool $delete
     * @return mixed
     */
    public function resetSID($delete = false);

    /**
     * pause
     * @date 2018/6/25
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 暂停session
     * @return mixed
     */
    public function pause();

}