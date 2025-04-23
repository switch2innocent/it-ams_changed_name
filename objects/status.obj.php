<?php

class Status
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function select_status()
    {
        $sql = "SELECT itamsdb.status_tbl.id, itamsdb.status_tbl.stat_name, maindb.users.id AS user_id FROM itamsdb.status_tbl, maindb.users WHERE maindb.users.id = ? AND (? = 473 OR itamsdb.status_tbl.id = 1);";

        $select_st = $this->conn->prepare($sql);

        $select_st->bindParam(1, $this->user_id);
        $select_st->bindParam(2, $this->user_id);

        $select_st->execute();
        return $select_st;
    }
}
