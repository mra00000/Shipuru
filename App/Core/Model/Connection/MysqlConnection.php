<?php

namespace App\Core\Model\Connection;
use App\Core\Configuration\ConfigurationManager;
use App\Core\Model\Connection;

class MysqlConnection extends \mysqli implements Connection
{
    public function __construct($host, $username, $passwd, $dbname, $port)
    {
        parent::__construct($host, $username, $passwd, $dbname, $port);
    }

    public function rawQuery($query)
    {
        $result = $this->query($query);
        return ($result) ? $this->formatResult($result) : $result;
    }

    public function preparedQuery($query, array $params)
    {
        $type = '';
        foreach($params as $param)
            $type .= gettype($params)[0];
        $statement = $this->prepare($query);
        $statement->bind_param($type, ...$params);
        $statement->execute();
        $result = $statement->get_result();
        return ($result) ? $this->formatResult($result) : $result;
    }

    public function describeTable($tableName)
    {
        $schema = [];
        $result = $this->query("describe {$tableName};");
        return ($result) ? $this->formatResult($result) : $result;
    }

    private function formatResult(\mysqli_result $result) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    }

    public function getByFieldName($tableName, $fieldName, $searchValue, array $selectedFields = [])
    {
        $type = gettype($searchValue)[0];
        $fields = (count($selectedFields) == 0) ? '*' : implode(', ', $selectedFields);
        $statement = $this->prepare("select $fields from $tableName where $fieldName = ?");
        $statement->bind_param($type, $searchValue);
        $statement->execute();
        $result = $statement->get_result();
        return ($result) ? $this->formatResult($result) : $result;
    }

    public function saveNewRecord($tableName, array $data)
    {
        $cols = implode(', ', array_keys($data));
        $values = array_values($data);
        $queryPlaceholder = [];
        $types = '';
        foreach ($values as $value) {
            array_push($queryPlaceholder, '?');
            $types .= gettype($value)[0];
        }
        $queryPlaceholder = implode(', ', $queryPlaceholder);
        $statement = $this->prepare("insert into $tableName ({$cols}) values ({$queryPlaceholder})");
        $statement->bind_param($types, ...$values);
        $statement->execute();
        return $this->insert_id;
    }

    public function updateRecord($tableName, array $data, array $filter)
    {
        $filterTypes = '';
        $filterKeys = [];
        $dataTypes = '';
        $dataKeys = [];
        foreach ($filter as $key => $value) {
            $filterTypes .= gettype($value)[0];
            array_push($filterKeys, "{$key}=?");
        }
        foreach ($data as $key => $value) {
            $dataTypes .= gettype($value)[0];
            array_push($dataKeys, "{$key}=?");
        }
        $filterKeys = implode(' and ', $filterKeys);
        $dataKeys = implode(', ', $dataKeys);
        $query = "update {$tableName} set $dataKeys where $filterKeys";
        $bindParams = array_merge(array_values($data), array_values($filter));
        $statement = $this->prepare($query);
        echo $this->error;

        $statement->bind_param($dataTypes . $filterTypes, ...$bindParams);
        $statement->execute();
    }

    public function join($sourceTableName, $targetTableName, array $conditions, $mode = 'inner')
    {
        $conditionValues = [];
        foreach ($conditions as $key => $value) {
            array_push($conditionValues, "{$sourceTableName}.{$key} = {$targetTableName}.{$value}");
        }
        $conditionValues = implode(' and ', $conditionValues);
        $query = "select {$sourceTableName}.*, {$targetTableName}.* from {$sourceTableName} {$mode} join {$targetTableName} on $conditionValues limit 10";
        $result = $this->query($query);
        return ($result) ? $this->formatResult($result) : $result;
    }
}