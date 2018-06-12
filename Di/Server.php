<?php
/**
 * plusPHP FrameWork
 * @File name: Server.php
 * @Author: Naizui_ycx
 * @Email: chenxi2511@qq.com
 * @Date: 2018/6/9
 * @Time: 11:01
 * @Description: 服务实体类
 */
namespace plusPHP\Di;

use plusPHP\Di;

class Server
{

    /**
     * @description 是否已解析默认参数
     * @var bool
     */
    protected $_isResolveDefaultArgs = false;

    /**
     * @description 默认注入的参数类型
     * @var array
     */
    protected $_default = null;

    /**
     * @description 服务类的反射对象
     * @var \ReflectionClass
     */
    protected $_classReflection;

    /**
     * @description 服务名称
     * @var string
     */
    protected $_name;

    /**
     * Server constructor.
     * @param $name
     * @param $definition
     * @throws \ReflectionException
     */
    public function __construct($name, $definition)
    {
        $_temp = [];
        if (is_string($definition)) {
            $_temp['class'] = (string)$definition;
        } elseif (is_array($definition)) {
            $_temp = $definition;
        } else {
            throw new \InvalidArgumentException(sprintf('Unsupported container %s service definition format!', $name));
        }

        if (empty($_temp['class']) || !is_string($_temp['class']) || !class_exists($_temp['class'])) {
            throw  new \InvalidArgumentException(sprintf('The lack of %s service class name or service class does not exist!', $name));
        }

        $ref = new \ReflectionClass($_temp['class']);

        if (!$ref->isInstantiable()) {
            throw new \InvalidArgumentException(sprintf('%s Service class %s cannot be instantiated!', $name, $_temp['class']));
        }

        if (!empty($_temp['arguments'])) {
            if (!is_array($_temp['arguments'])) {
                throw new \InvalidArgumentException(sprintf('%s Service %s class parameter must be an array!', $name, $_temp['class']));
            }

            $this->_default = $_temp['arguments'];
        }

        $this->_name = $name;
        $this->_classReflection = $ref;
    }

    /**
     * resolve
     * @date 2018/6/9
     * @author Naizui_ycx chenxi2511@qq.com
     * @description 解析参数并实例化服务
     * @param $parameters
     * @return string
     */
    public function resolve($parameters)
    {
        if ($parameters != null) {
            $args = $this->parseArgs($parameters);
        }

        if (!isset($args)) {
            if (!$this->_isResolveDefaultArgs && $this->_default != null) {
                $this->_default = $this->parseArgs($this->_default);
                $this->_isResolveDefaultArgs = true;
            }
            $args = $this->_default;
        }

        if (!empty($args)) {
            return $this->_classReflection->newInstanceArgs($args);
        } else {
            return $this->_classReflection->newInstance();
        }
    }


    protected function parseArgs($arguments)
    {
        if (empty($arguments)) {
            return false;
        }

        $argTypes = ['parameter', 'server'];
        $args = [];

        foreach ($arguments as $item) {
            if (empty($item['type']) || !is_string($item['type']) || !in_array($item['type'], $argTypes)) {
                throw new \InvalidArgumentException(sprintf('%s Service class parameter types do not support!', $this->_name));
            }

            if ($item['type'] == 'parameter') {
                if (!isset($item['value'])) {
                    $args[] = null;
                } else {
                    $args[] = $item['value'];
                }
                continue;
            }

            if ($item['type'] == 'server') {
                if (empty($item['name']) || !is_string($item['name'])) {
                    throw new \InvalidArgumentException(sprintf('%s Service class parameter service name error!', $this->_name));
                }

                if (isset($item['arguments'])) {
                    $args[] = Di::getContainer()->get($item['name'], $item['arguments']);
                } else {
                    $args[] = Di::getContainer()->get($item['name']);
                }

                continue;
            }
        }

        return $args;
    }

}