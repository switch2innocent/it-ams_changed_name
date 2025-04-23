<?php

class Department
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function select_departments() {
        
        $sql = "SELECT id, dept_name FROM departments WHERE status != 0";
        $select_department = $this->conn->prepare($sql);
        $select_department->execute();

        return $select_department;
    }
}