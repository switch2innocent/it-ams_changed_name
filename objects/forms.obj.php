<?php

class Forms
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function form_categories()
    {

        $sql = "SELECT * FROM form_categories_tbl WHERE status != 0";
        $form_category = $this->conn->prepare($sql);

        $form_category->execute();
        return $form_category;
    }
}
