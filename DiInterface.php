<?php
/**
 * plusPHP FrameWork
 * @File name: DiInterface.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/8
 * @Time: 13:46
 * @Description: 依赖注入容器接口
 */
namespace plusPHP;

interface DiInterface extends \ArrayAccess
{

    /**
     * get
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 从容器中获取一个服务
     * @param string $name
     * @param null|array $parameters
     * @return mixed
     */
    public function get(string $name, array $parameters = null);

    /**
     * set
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 向容器中注册一个服务
     * @param string $name
     * @param mixed $definition
     * @param bool $shared
     * @return mixed
     */
    public function set(string $name, $definition, bool $shared = false);

    /**
     * setShared
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 向容器中注册一个共享服务，即单例模式
     * @param string $name
     * @param mixed $definition
     * @return mixed
     */
    public function setShared(string $name, $definition);


    /**
     * remove
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 删除容器中指定的服务
     * @param string $name
     * @return mixed
     */
    public function remove(string $name);

    /**
     * has
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断服务是否存在
     * @param string $name
     * @return bool
     */
    public function has(string $name) : bool;

    /**
     * attempt
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 当容器中存在同名服务时则不注入，反之注入服务
     * @param string $name
     * @param $definition
     * @param bool $shared
     * @return mixed
     */
    public function attempt(string $name, $definition, bool $shared = false);

    /**
     * getShare
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 从容器中获取一个共享服务
     * @param string $name
     * @param null|array $parameters
     * @return mixed
     */
    public function getShare(string $name, array $parameters = null);

    /**
     * reset
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 重置依赖容器
     * @return mixed
     */
    public function reset();

    /**
     * getContainer
     * @date 2018/6/8
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取全局容器
     * @return mixed
     */
    public static function getContainer() : DiInterface;

}