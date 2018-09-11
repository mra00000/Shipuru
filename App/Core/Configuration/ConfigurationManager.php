<?php
namespace App\Core\Configuration;

class ConfigurationManager {
    protected $_configuration = [];

    public function __call($name, $arguments)
    {
        $factor = [];
        preg_match_all('/[A-Z]?[a-z]*/', $name, $factor);
        array_pop($factor[0]);
        $factor = $factor[0];

        $opt = array_shift($factor);
        $factor = array_map(function($e) {
            return strtolower($e);
        }, $factor);
        $paramName = implode('_', $factor);

        switch ($opt) {
            case 'get':
                return $this->get($paramName);
                break;
            case 'set':
                $this->set($paramName, $arguments[0]);
                break;
            case 'setMultiple':
                foreach ($arguments as $key => $value) {
                    $this->set($key, $value);
                }
        }
    }

    public function get($name) {
        return $this->_configuration[$name];
    }

    public function set($name, $value) {
        $this->_configuration[$name] = $value;
    }
}