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
        $sql = "SELECT itamsdb.status_tbl.id, itamsdb.status_tbl.stat_name
                FROM itamsdb.status_tbl, maindb.access
                WHERE maindb.access.user_id = ? AND maindb.access.system_id = 16 AND maindb.access.role_id = ? AND maindb.access.role = ?
                AND (
                    maindb.access.role = 1 AND itamsdb.status_tbl.id IN (1,2,3,4)
                    OR maindb.access.role = 2 AND itamsdb.status_tbl.id = 1
                );";

        $select_st = $this->conn->prepare($sql);

        $select_st->bindParam(1, $this->user_id);
        $select_st->bindParam(2, $this->role_id);
        $select_st->bindParam(3, $this->role);

        // $select_stat->role_id = $_SESSION['access_role_id'];

        $select_st->execute();
        return $select_st;
    }

    public function view_status()
    {

        $sql = "SELECT id, stat_name FROM status_tbl WHERE status != 0";
        $select_department = $this->conn->prepare($sql);
        $select_department->execute();

        return $select_department;
    }
}
