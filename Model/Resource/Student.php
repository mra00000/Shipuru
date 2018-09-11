<?php
namespace Model\Resource;

use App\Core\Model\Connection;

class Student extends \App\Core\Model\Resource\SimpleModel
{
    protected $_tableName = 'student';
    protected $_idFieldName = 'id';

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }
}