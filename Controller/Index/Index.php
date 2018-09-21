<?php

namespace Controller\Index;

use App\Core\Controller\Action;
use Model\Student;

class Index extends Action
{
    protected $_student;
    protected $_config;

    public function __construct(
        \Model\Student $student,
        \App\Core\Configuration\ConfigurationManager $config,
        \App\Core\Model\Connection $connection
    )
    {
        $this->_employees = $student;
        $this->_config = $config;

        $stm = $connection->select(['name', 'age'])
            ->from('student')
            ->where([
                ['id', 1, 'equal'],
                ['name', 'Minh', 'equal', 'or'],
                ['age', 15, 'greater']
            ]);
        $stm->execute();
    }

    public function execute()
    {
        $data = [
            'name' => 'Minh',
            'age' => 18
        ];
        $cols = implode(', ', array_keys($data));
        $values = array_values($data);
        $queryPlaceholder = substr(str_repeat('?,', count($values)), 0, -1);
        echo '<pre>';
        print_r($queryPlaceholder);
        echo '</pre>';
    }
}