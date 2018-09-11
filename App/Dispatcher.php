<?php
namespace App;

class Dispatcher {
    protected $_requestParams;
    public function __construct(array $requestParams)
    {
        $this->_requestParams = $requestParams;
    }

    public function dispatch()
    {
        $controller = $this->_requestParams['controller'];
        $action = $this->_requestParams['action'];

        $actionClass = "\\Controller\\$controller\\$action";
        $instance = \App\ObjectManager::getObject($actionClass);
        $instance->execute();
    }
}