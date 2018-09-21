<?php
namespace App\Core\Model\Connection;

use App\Core\Model\Connection;

class PDOMysqlConnection extends \PDO implements Connection {

    public function rawQuery($query)
    {
        // TODO: Implement rawQuery() method.
    }

    public function preparedQuery($query, array $params)
    {
        // TODO: Implement preparedQuery() method.
    }

    public function describeTable($tableName)
    {
        // TODO: Implement describeTable() method.
    }

    public function select(array $fields = ['*'])
    {
        // TODO: Implement select() method.
    }

    public function from($from)
    {
        // TODO: Implement from() method.
    }

    public function where(array $where)
    {
        // TODO: Implement where() method.
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }
}