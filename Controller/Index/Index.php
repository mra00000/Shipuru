<?php
namespace Controller\Index;

use App\Core\Controller\Action;
use Model\Student;

class Index extends Action {
    protected $_employees;
    protected $_config;

    public function __construct(
        \Model\Employees $employees,
        \App\Core\Configuration\ConfigurationManager $config
    ) {
        $this->_employees = $employees;
        $this->_config = $config;
    }

    public function execute()
    {
        echo '<pre>';
        print_r($this->_employees->join('titles', ["emp_no" => "emp_no"]));
        echo '</pre>';
    }
}