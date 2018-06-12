<?php
/**
 * plusPHP FrameWork
 * @File name: HttpServerTimeoutException.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/7
 * @Time: 22:07
 * @Description: 服务器超时异常
 */
namespace plusPHP\Exception;


class HttpServerTimeoutException extends HttpException
{

    protected $_httpCode = 502;

    protected $_httpContents = [
        'title' => 'SERVER TIME OUT',
        'content' => 'SERVER TIME OUT!'
    ];


    public function resetContent()
    {
        parent::resetContent(); // TODO: Change the autogenerated stub
        $this->setContents([
            'title' => 'SERVER TIME OUT',
            'content' => 'SERVER TIME OUT!'
        ]);
    }

}