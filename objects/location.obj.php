<?php

class Location
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function select_locations() {
        
        $sql = "SELECT id, location FROM locations WHERE status != 0";
        $select_department = $this->conn->prepare($sql);
        $select_department->execute();

        return $select_department;
    }
}