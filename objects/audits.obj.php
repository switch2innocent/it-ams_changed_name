<?php

class Audits
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add_audits()
    {

        $sql = "INSERT INTO audit_tbl SET asset_id=?, old_value=?, new_value=?, user_id=?, changed_at=?, status=1";
        $add_audit = $this->conn->prepare($sql);

        $current_datetime = date('Y-m-d H:i:s');

        $add_audit->bindParam(1, $this->asset_id);
        $add_audit->bindParam(2, $this->old_value);
        $add_audit->bindParam(3, $this->new_value);
        $add_audit->bindParam(4, $this->user);
        $add_audit->bindParam(5, $current_datetime);

        if ($add_audit->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_historys()
    {
        $sql = "SELECT itamsdb.audit_tbl.changed_at, itamsdb.audit_tbl.old_value, itamsdb.audit_tbl.new_value, CONCAT(maindb.users.firstname, ' ', maindb.users.lastname) AS full_name FROM itamsdb.audit_tbl, maindb.users WHERE itamsdb.audit_tbl.user_id = maindb.users.id AND itamsdb.audit_tbl.asset_id=? ORDER BY itamsdb.audit_tbl.id DESC";
        $get_history = $this->conn->prepare($sql);

        $get_history->bindParam(1, $this->asset_id);

        $get_history->execute();
        return $get_history;
    }
}
