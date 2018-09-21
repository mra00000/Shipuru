<?php

namespace App\Core\Model\Resource;

use App\Core\Model\Connection;

class SimpleModel
{
    protected $_connection;
    protected $_idFieldName;
    protected $_tableName;
    protected $_schema = [];

    public function __construct(Connection $connection)
    {
        $this->_connection = $connection;
        $this->loadSchema();
    }

    private function loadSchema()
    {
        $this->_schema = $this->_connection->describeTable($this->_tableName);
    }

//    public function getById($id)
//    {
//        $model = false;
//        $data = $this->_connection->getByFieldName($this->_tableName, $this->_idFieldName, $id);
//        if (count($data) > 0) {
//            $model = new \App\Core\Model\SimpleModel($this);
//            $model->setId($id);
//            $model->setData($data[0]);
//            $model->setChanged(false);
//        }
//        return $model;
//    }
//
//    public function save(\App\Core\Model\SimpleModel $model)
//    {
//        $id = $model->getId();
//        $modelData = $model->getData();
//        $saveData = [];
//        foreach ($this->_schema as $field) {
//            $name = $field['Field'];
//            if (array_key_exists($name, $modelData))
//                $saveData[$name] = $modelData[$name];
//        }
//        if ($id) {
//            if ($model->isChanged()) {
//                unset($saveData[$this->_idFieldName]);
//                $this->_connection->updateRecord($this->_tableName, $saveData, [$this->_idFieldName => $id]);
//            }
//        } else {
//            return $this->_connection->saveNewRecord($this->_tableName, $saveData);
//        }
//    }
//
//    public function join($tableName, array $conditions) {
//        return $this->_connection->join($this->_tableName, $tableName, $conditions);
//    }
}