<?php
/**
 * plusPHP FrameWork
 * @File name: Resquest.php.
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/14
 * @Time: 13:59
 * @Description: http请求接口
 */


namespace plusPHP\Http;

class Request implements RequestInterface
{

    /**
     * @description 请求方法
     * @var string
     */
    protected $_method = null;

    /**
     * @description 当前请求协议http/https
     * @var string
     */
    protected $_scheme = null;

    /**
     * @description put请求参数
     * @var array
     */
    protected $_PUT = null;

    /**
     * @description delete请求参数
     * @var array
     */
    protected $_DELETE = null;

    /**
     * @description 客户端请求头
     * @var array
     */
    protected $_headers = null;

    /**
     * @description 客户端ip
     * @var string
     */
    protected $_clientIp = null;

    /**
     * @description 当前Uri
     * @var string
     */
    protected $_uri = null;

    /**
     * @description 当前主机
     * @var string
     */
    protected $_host = null;

    /**
     * @description 当前端口号
     * @var int
     */
    protected $_port = null;


    public function getInput($name = '', $default = null)
    {
        if ($this->isPut()) {
            return $this->variableFrom(array_merge($_REQUEST, $this->getPut()),
                $name, $default);
        }

        if ($this->isDelete()) {
            return $this->variableFrom(array_merge($_REQUEST, $this->getDelete()),
                $name, $default);
        }
        return $this->variableFrom($_REQUEST, $name, $default);
    }


    public function get($name = '', $default = null)
    {
        return $this->variableFrom($_GET, $name, $default);
    }


    public function getPost($name = '', $default = null)
    {
        return $this->variableFrom($_POST, $name, $default);
    }


    public function getPut($name = '', $default = null)
    {
        if ($this->_PUT == null) {
            $this->isPut() ?
                parse_str($this->getRawBody(), $this->_PUT)
                : $this->_PUT = array();
        }
        return $this->variableFrom($this->_PUT, $name, $default);
    }


    public function getDelete($name = '', $default = null)
    {
        if ($this->_DELETE == null) {
            $this->isDelete() ?
                parse_str($this->getRawBody(), $this->_DELETE)
                : $this->_DELETE = array();
        }
        return $this->variableFrom($this->_DELETE, $name, $default);
    }


    public function getHeader($name = '', $default = null)
    {
        return $this->variableFrom($this->getAllHeaders(), $name, $default);
    }


    public function getServer($name = '', $default = null)
    {
        return $this->variableFrom($_SERVER, $name, $default);
    }


    public function getRawBody()
    {
        return file_get_contents('php://input', false, null, -1, $_SERVER['CONTENT_LENGTH']);
    }


    public function getScheme()
    {
        if ($this->_scheme == null) {
            if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') {
                $this->_scheme = 'https';
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https') {
                $this->_scheme = 'https';
            } elseif (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) != 'off') {
                $this->_scheme = 'https';
            } else {
                $this->_scheme = 'http';
            }
        }
        return $this->_scheme;
    }


    public function getMethod()
    {
        if ($this->_method == null) {
            $this->_method = strtoupper($_SERVER['REQUEST_METHOD']);
        }
        return $this->_method;
    }


    public function getUri()
    {
        if ($this->_uri == null) {
            if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
                $this->_uri = $_SERVER['HTTP_X_REWRITE_URL'];
            } elseif (isset($_SERVER['REQUEST_URI'])) {
                $this->_uri = $_SERVER['REQUEST_URI'];
            } elseif (isset($_SERVER['ORIG_PATH_INFO'])) {
                $this->_uri = $_SERVER['ORIG_PATH_INFO'] . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '');
            } else {
                $this->_uri = '/';
            }
        }
        return $this->_uri;
    }


    public function getUrl()
    {
        if ($this->isHttps()) {
            return 'https://' . $this->getHost() . ($this->getPort() != 443 ? ':' . $this->getPort() : '') . $this->getUri();
        } else {
            return 'http://' . $this->getHost() . ($this->getPort() != 80 ? ':' . $this->getPort() : '') . $this->getUri();
        }
    }


    public function getPath()
    {
        return strpos($this->getUri(), '?') ? strstr($this->getUri(), '?', true) : $this->getUri();
    }


    public function getContentType()
    {
        if (isset($_SERVER['CONTENT_TYPE'])) {
            return $_SERVER['CONTENT_TYPE'];
        } else {
            /**
             * @see https://bugs.php.net/bug.php?id=66606
             */
            if (isset($_SERVER['HTTP_CONTENT_TYPE'])) {
                return $_SERVER['HTTP_CONTENT_TYPE'];
            }
        }
        return null;
    }


    public function getPort()
    {
        if ($this->_port == null) {
            $host = $this->getServer('HTTP_HOST');
            if ($host) {
                $pos = strrpos($host, ':');
                if (false !== $pos) {
                    $port = (int)substr($host, $pos + 1);
                } else {
                    $port = 'https' === $this->getScheme() ? 443 : 80;
                }
            }

            if (!isset($port)) {
                $port = (int)$this->getServer('SERVER_PORT');
            }
            $this->_port = $port;
        }
        return $this->_port;
    }


    public function getHost()
    {
        if ($this->_host == null) {
            $host = $this->getServer('HTTP_X_REAL_HOST') ? : $this->getServer('HTTP_HOST');
            $this->_host = strpos($host, ':') ? strstr($host, ':', true) : $host;
        }
        return $this->_host;
    }


    public function getQueryString()
    {
        return $this->getServer('QUERY_STRING');
    }


    public function getFile($onlySuccessful = false): FileInterface
    {

    }


    public function getUserAgent()
    {
        return $this->getServer('HTTP_USER_AGENT', '');
    }


    public function getHttpReferer()
    {
        return $this->getServer('HTTP_REFERER', '');
    }


    public function getClientIp()
    {
        if ($this->_clientIp !== null) {
            return $this->_clientIp;
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $this->_clientIp = $arr[0];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $this->_clientIp = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $this->_clientIp = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $this->_clientIp = filter_var($this->_clientIp, FILTER_VALIDATE_IP) ? $this->_clientIp : false;
        return $this->_clientIp;
    }


    public function has($name): bool
    {
        $data = $_REQUEST;
        if ($this->isPut()) {
            $data = array_merge($_REQUEST, $this->getPut());
        }

        if ($this->isDelete()) {
            $data = array_merge($_REQUEST, $this->getDelete());
        }
        return isset($data[$name]);
    }


    public function hasFile($onlySuccessful = false): bool
    {
        if ($onlySuccessful) {
            $file_array = array_filter($_FILES, function ($file) {
                return $file['error'] == 0;
            });
        } else {
            $file_array = $_FILES;
        }
        return !empty($file_array);
    }


    public function hasPost($name): bool
    {
        return isset($_POST[$name]);
    }


    public function hasGet($name): bool
    {
        return isset($_GET[$name]);
    }


    public function hasPut($name): bool
    {
        $_PUT = $this->getPut();
        return isset($_PUT[$name]);
    }

    public function hasDelete($name): bool
    {
        $_DELETE = $this->getDelete();
        return isset($_DELETE[$name]);
    }


    public function hasServer($name): bool
    {
        return isset($_SERVER[$name]);
    }


    public function isMethod($methods): bool
    {
        if (is_array($methods)) {
            $methods = array_map(function ($method) {
                return strtoupper($method);
            }, $methods);
            return in_array($this->getMethod(), $methods);
        } else {
            return $this->getMethod() == strtoupper($methods);
        }
    }


    public function isPost(): bool
    {
        return $this->isMethod('POST');
    }


    public function isGet(): bool
    {
        return $this->isMethod('GET');
    }


    public function isPut(): bool
    {
        return $this->isMethod('PUT');
    }


    public function isHead(): bool
    {
        return $this->isMethod('HEAD');
    }


    public function isAjax(): bool
    {
        if ($this->isPost() || strtolower($this->getHeader('X-Requested-With')) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }


    public function isDelete(): bool
    {
        return $this->isMethod('DELETE');
    }


    public function isOptions(): bool
    {
        return $this->isMethod('OPTIONS');
    }


    public function isPurge(): bool
    {
        return $this->isMethod('PURGE');
    }


    public function isTrace(): bool
    {
        return $this->isMethod('TRACE');
    }


    public function isConnect(): bool
    {
        return $this->isMethod('CONNECT');
    }


    public function isHttps(): bool
    {
        return $this->getScheme() == 'https';
    }


    public function isHttp(): bool
    {
        return $this->getScheme() == 'http';
    }

    /**
     * 从变量中取出相应的值
     * @param $from mixed 用来取值的变量
     * @param $name mixed 取值键
     * @param $default mixed 默认值
     * @return mixed
     * */
    protected function variableFrom($from, $name, $default)
    {
        if (empty($name)) {
            $_data = $from;
        } else {
            $_data = $this->_parseIniString($name, $from);
        }

        if ($_data === null) {
            return $default;
        } else {
            return $_data;
        }
    }

    /**
     * 返回客户端请求的头信息
     * @return array
     * */
    protected function getAllHeaders()
    {
        if ($this->_headers == null) {
            if (function_exists('getallheaders')) {
                $this->_headers = getallheaders();
            } else {
                $headers = [];
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
                $this->_headers = $headers;
            }
        }
        return $this->_headers;
    }

    /**
     * _parseIniString
     * @date 2018/5/11
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 解析string并返回相应的数组值
     * @param $string string
     * @param $value mixed
     * @return mixed
     *<code>
     * $array = [
     *      'db' => [
     *          'host' => 'localhost',
     *          'user' => [
     *              'name' => 'root',
     *              'password' =>  '123456',
     *          ]
     *      ]
     * ];
     * echo $this->_parseIniString('db.host', $array); // localhost
     * echo $this->_parseIniString('db.user.name', $array); // root
     *</code>
     */
    protected function _parseIniString($string, $value)
    {
        $pos = strpos($string, '.');
        if ($pos === false) {
            if (isset($value[$string])) {
                return $value[$string];
            } else {
                return null;
            }
        }

        $key = substr($string, 0, $pos);
        $string = substr($string, $pos + 1);

        if (isset($value[$key])) {
            return $this->_parseIniString($string, $value[$key]);
        } else {
            return null;
        }
    }

}