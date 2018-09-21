<?php

namespace App\Core\Model;

interface Connection
{
    public function rawQuery($query);

    public function preparedQuery($query, array $params);

    public function describeTable($tableName);

    /**
     * @param array $fields
     * @return Connection
     */
    public function select($fields = '*');

    /**
     * @param $from
     * @return Connection
     */
    public function from($from);

    /**
     * @param array $where
     * @return Connection
     */
    public function where(array $where);

    /**
     * @return array
     */
    public function execute();
}

