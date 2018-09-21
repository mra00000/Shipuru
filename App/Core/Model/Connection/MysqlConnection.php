<?php

namespace App\Core\Model\Connection;

use App\Core\Configuration\ConfigurationManager;
use App\Core\Model\Connection;

class MysqlConnection extends \mysqli implements Connection
{
    protected $comparisons = [
        'equal' => '=',
        'not_equal' => '<>',
        'not_equal_other' => '!=',
        'less' => '<',
        'less_or_equal' => '<=',
        'greater' => '>',
        'greater_or_equal' => '>=',
        'like' => 'like',
        'in' => 'in',
        'not_in' => 'not in',
        'between' => 'between',
        'not_between' => 'not between',
    ];

    private $_queryData = [
        'select' => false,
        'from' => false,
        'where' => false,
        'offset' => false
    ];

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
        $type = $this->initTypes($params);
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

    private function initTypes(array $params)
    {
        $count = count($params);
        $sample = 's';
        return str_repeat($sample, $count);
    }

    private function formatResult(\mysqli_result $result)
    {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    }

    public function select($fields = '*')
    {
        $this->_queryData['select'] = $fields;
        return $this;
    }

    public function from($from)
    {
        $this->_queryData['from'] = $from;
        return $this;
    }

    public function where(array $where)
    {
        if (!is_array($where[0])) $where = [$where];
        $this->_queryData['where'] = $where;
        return $this;
    }

    public function execute()
    {
        $params = [];

        $select = $this->_queryData['select'];
        if (is_array($select)) $select = implode(',', $select);
        $select = 'select ' . $select;

        $from = 'from ';
        if (is_string($this->_queryData['from']))
            $from .= $this->_queryData['from'];

        $where = '';
        if ($this->_queryData['where']) {
            $where = 'where';
            $next = '';
            foreach ($this->_queryData['where'] as $cond) {
                $next = (isset($cond[3])) ? $cond[3] : 'and';
                $where .= " {$cond[0]} {$this->comparisons[$cond[2]]} ? {$next}";
                array_push($params, $cond[1]);
            }
            $where = substr($where, 0, -strlen($next));
        }

        $query = $select . ' ' . $from . ' ' . $where;
        echo '<pre>';
        echo $query . '<br>';
        print_r($params);
        echo '</pre>';
        die();
        return $this->preparedQuery($query, $params);
    }
}