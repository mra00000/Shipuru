<?php

namespace App\Core\Model;

interface Connection
{
    public function rawQuery($query);
    public function preparedQuery($query, array $params);
    public function getByFieldName($tableName, $fieldName, $searchValue, array $selectedFields = []);
    public function saveNewRecord($tableName, array $data);
    public function updateRecord($tableName, array $data, array $filter);
    public function describeTable($tableName);
    public function join($sourceTableName, $targetTableName, array $conditions, $mode = 'inner');
}