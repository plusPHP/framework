<?php
/**
 * plusPHP FrameWork
 * @File name: ResponseInterface.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/14
 * @Time: 13:49
 * @Description: http响应类接口
 */


namespace plusPHP\Http;


interface ResponseInterface
{

    public function setStatusCode(int $code, $message = null): ResponseInterface;

    public function setHeader($name, $value);

}