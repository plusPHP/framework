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

    public function setHandle();

    public function get($name);

    public function set($name, $value, $prefix);

    public function prefix($prefix);

    public function init();

    public function setLock();

    public function lock();

    public function unlock();

    public function has($name, $prefix);

    public function clear();

    public function delete($name, $prefix);

    public function destroy();

    public function resetSID();

    public function pause();

}