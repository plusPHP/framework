<?php
/**
 * plusPHP FrameWork
 * @File name: RequestInterface.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/14
 * @Time: 13:58
 * @Description: http请求接口
 */


namespace plusPHP\Http;


interface RequestInterface
{

    /**
     * getInput
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取输入参数
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function getInput($name, $default = null);

    /**
     * get
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取get请求参数
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function get($name, $default = null);

    /**
     * getPost
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取post请求参数
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function getPost($name, $default = null);

    /**
     * getPut
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取put请求参数
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function getPut($name, $default = null);

    /**
     * getDelete
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取delete请求参数
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function getDelete($name, $default = null);

    /**
     * getHeader
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取请求header
     * @param $header
     * @return mixed
     */
    public function getHeader($header);

    /**
     * getServer
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取$_SERVER变量参数
     * @param $name
     * @return mixed
     */
    public function getServer($name);

    /**
     * getRawBody
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取原始请求数据
     * @return mixed
     */
    public function getRawBody();

    /**
     * getScheme
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前协议http/https
     * @return mixed
     */
    public function getScheme();

    /**
     * getMethod
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前请求方法名
     * @return string
     */
    public function getMethod();

    /**
     * getUri
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前的url
     * @return mixed
     */
    public function getUrl();

    /**
     * getPort
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前端口
     * @return mixed
     */
    public function getPort();

    /**
     * getFile
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前上传的文件
     * @param bool $onlySuccessful
     * @return mixed
     */
    public function getFile($onlySuccessful = false): FileInterface;

    /**
     * getUserAgent
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前的用户代理标识
     * @return mixed
     */
    public function getUserAgent();

    /**
     * getHttpReferer
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前的请求来源
     * @return mixed
     */
    public function getHttpReferer();

    /**
     * getContentType
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取请求内容类型
     * @return string|null
     */
    public function getContentType();

    /**
     * getClientIp
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前用户ip
     * @return mixed
     */
    public function getClientIp();

    /**
     * getHost
     * @date 2018/6/16
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前主机
     * @return mixed
     */
    public function getHost();

    /**
     * getUri
     * @date 2018/6/16
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前页面的uri
     * @return mixed
     */
    public function getUri();

    /**
     * getPath
     * @date 2018/6/16
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前uri，不含QUERY_STRING
     * @return mixed
     */
    public function getPath();

    /**
     * getQueryString
     * @date 2018/6/16
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 获取当前QUERY_STRING
     * @return mixed
     */
    public function getQueryString();

    /**
     * has
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断某个请求参数是否存在
     * @param $name
     * @return bool
     */
    public function has($name): bool;

    /**
     * hasFiles
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否存在上传文件
     * @param bool $onlySuccessful
     * @return bool
     */
    public function hasFile($onlySuccessful = false): bool;

    /**
     * hasPost
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断某个post参数是否存在
     * @param $name
     * @return bool
     */
    public function hasPost($name): bool;

    /**
     * hasGet
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断某个get参数是否存在
     * @param $name
     * @return bool
     */
    public function hasGet($name): bool;

    /**
     * hasPut
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断某个put参数是否存在
     * @param $name
     * @return bool
     */
    public function hasPut($name): bool;

    /**
     * hasDelete
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断某个delete参数是否存在
     * @param $name
     * @return bool
     */
    public function hasDelete($name): bool;

    /**
     * hasServer
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断某个$_SERVER变量是否存在
     * @param $name
     * @return bool
     */
    public function hasServer($name): bool;

    /**
     * isMethod
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断当前请求是否为特定请求
     * @param $methods
     * @return bool
     */
    public function isMethod($methods): bool;

    /**
     * isPost
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为post请求
     * @return bool
     */
    public function isPost(): bool;

    /**
     * isGet
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为get请求
     * @return bool
     */
	public function isGet(): bool;

    /**
     * isPut
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为put请求
     * @return bool
     */
	public function isPut(): bool;

    /**
     * isHead
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为head请求
     * @return bool
     */
	public function isHead(): bool;

    /**
     * isAjax
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为ajax请求
     * @return bool
     */
    public function isAjax(): bool;

    /**
     * isDelete
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为delete请求
     * @return bool
     */
	public function isDelete(): bool;

    /**
     * isOptions
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为option请求
     * @return bool
     */
	public function isOptions(): bool;

    /**
     * isPurge
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是非为purge请求
     * @return bool
     */
	public function isPurge(): bool;

    /**
     * isTrace
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为trace请求
     * @return bool
     */
	public function isTrace(): bool;

    /**
     * isConnect
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为connect请求
     * @return bool
     */
	public function isConnect(): bool;

    /**
     * isSSl
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为https请求
     * @return bool
     */
	public function isHttps(): bool;

    /**
     * isHttp
     * @date 2018/6/14
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 判断是否为http请求
     * @return bool
     */
	public function isHttp(): bool;

}