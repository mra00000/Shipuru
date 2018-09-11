<?php
namespace Model\Resource;

use App\Core\Model\Connection;

class Employees extends \App\Core\Model\Resource\SimpleModel {
    protected $_tableName = 'employees';
    protected $_idFieldName = 'emp_no';

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }
}