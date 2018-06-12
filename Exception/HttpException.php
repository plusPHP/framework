<?php
/**
 * plusPHP FrameWork
 * @File name: HttpException.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/7
 * @Time: 21:12
 * @Description: Http应用错误基础类
 */
namespace plusPHP\Exception;

use plusPHP\Exception;

class HttpException extends Exception
{

    /**
     * @description http响应代码
     * @var int
     */
    protected $_httpCode = 500;

    /**
     * @description 页面响应内容数组
     * @var array
     */
    protected $_httpContents = [];

    /**
     * setHttpCode
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 设置http响应代码
     * @param int $code
     * @return void
     */
    public function setHttpCode(int $code)
    {
        $this->_httpCode = $code;
    }

    /**
     * getHttpCode
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取http响应代码
     * @return int
     */
    public function getHttpCode() : int
    {
        return $this->_httpCode;
    }

    /**
     * setContent
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 设置单条响应内容
     * @param string $name
     * @param mixed $content
     * @param bool $onlyNonExistent
     * @return void
     */
    public function setContent(string $name, $content, bool $onlyNonExistent = false)
    {
        if ($onlyNonExistent && isset($this->_httpContents[$name])) {
            return;
        }
        $this->_httpContents[$name] = $content;
    }

    /**
     * resetContent
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 重置响应内容
     * @return void
     */
    public function resetContent()
    {
        $this->_httpContents = [];
    }

    /**
     * setContents
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 批量设置响应内容
     * @param array $contents
     * @return void
     */
    public function setContents(array $contents)
    {
        $this->_httpContents = array_merge($this->_httpContents, $contents);
    }

    /**
     * getContent
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取响应内容
     * @param string $name
     * @return mixed|null
     */
    public function getContent(string $name)
    {
        if (isset($this->_httpContents[$name])) {
            return $this->_httpContents[$name];
        } else {
            return null;
        }
    }

    /**
     * getContents
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取全部响应内容
     * @return array
     */
    public function getContents() : array
    {
        return $this->_httpContents;
    }

    /**
     * removeContent
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 删除某个响应内容
     * @param string $name
     * @return void
     */
    public function removeContent(string $name)
    {
        unset($this->_httpContents[$name]);
    }

    /**
     * emptyContent
     * @date 2018/6/7
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 清空响应内容
     * @return void
     */
    public function emptyContent()
    {
        $this->_httpContents = [];
    }


}