<?php

namespace App\Core\Model;

class SimpleModel
{
    protected $_data = [];
    protected $_id = false;
    protected $_tableName;
    protected $_resourceModel;
    protected $_changed = false;

    public function __construct(Resource\SimpleModel $_resourceModel)
    {
        $this->_resourceModel = $_resourceModel;
    }

    public function __call($name, $arguments)
    {
        $factor = [];
        preg_match_all('/[A-Z]?[a-z]*/', $name, $factor);
        array_pop($factor[0]);
        $factor = $factor[0];

        $opt = array_shift($factor);
        $factor = array_map(function ($e) {
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

    public function get($name)
    {
        return $this->_data[$name];
    }

    public function set($name, $value)
    {
        $this->_changed = true;
        $this->_data[$name] = $value;
    }

    public function isChanged()
    {
        return $this->_changed;
    }

    public function setChanged($changed)
    {
        $this->_changed = $changed;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getData()
    {
        return $this->_data;
    }

    public function setData($data) {
        $this->_changed = true;
        $this->_data = $data;
    }

//    public function getById($id) {
//        return $this->_resourceModel->getById($id);
//    }
//
//    public function save() {
//        return $this->_resourceModel->save($this);
//    }
//
//    public function newRecord() {
//        $className = get_class($this);
//        return new $className($this->_resourceModel);
//    }
//
//    public function join($tabkeName, array $conditions) {
//        return $this->_resourceModel->join($tabkeName, $conditions);
//    }
}