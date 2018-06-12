<?php
/**
 * plusPHP FrameWork
 * @File name: HttpServerErrorException.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/7
 * @Time: 22:03
 * @Description: 服务器内部错误异常
 */

namespace plusPHP\Exception;


class HttpServerErrorException extends HttpException
{

    protected $_httpCode = 500;

    protected $_httpContents = [
        'title' => 'SERVER INTERNAL ERROR',
        'content' => 'SERVER INTERNAL ERROR!'
    ];


    public function resetContent()
    {
        parent::resetContent(); // TODO: Change the autogenerated stub
        $this->setContents([
            'title' => 'SERVER INTERNAL ERROR',
            'content' => 'SERVER INTERNAL ERROR!'
        ]);
    }

}