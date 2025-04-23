<?php

class Assets
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function view_assets()
    {

        $sql = 'SELECT itamsdb.it_asset_tbl.id, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, maindb.departments.dept_name, maindb.locations.location, itamsdb.status_tbl.stat_name FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.form_type=? AND itamsdb.it_asset_tbl.stat_id !=2 AND itamsdb.it_asset_tbl.stat_id !=4 AND itamsdb.it_asset_tbl.stat_id !=3 AND itamsdb.it_asset_tbl.status != 0 ORDER BY itamsdb.it_asset_tbl.id DESC';
        $view_asset = $this->conn->prepare($sql);

        $view_asset->bindParam(1, $this->form_type);

        $view_asset->execute();
        return $view_asset;
    }

    public function add_assets()
    {

        $sql = "INSERT INTO it_asset_tbl SET form_type=?, bar_no=?, item_desc=?, acct_name=?, user=?, dept_id=?, location_id=?, bldg_lvl=?, stat_id=?, remarks=?, created_by_id=?, created_at=?, status=1";
        $add_asset = $this->conn->prepare($sql);

        $current_datetime = date('Y-m-d H:i:s');

        $add_asset->bindParam(1, $this->form_type);
        $add_asset->bindParam(2, $this->bar_no);
        $add_asset->bindParam(3, $this->item_desc);
        $add_asset->bindParam(4, $this->acct_name);
        $add_asset->bindParam(5, $this->user);
        $add_asset->bindParam(6, $this->dept);
        $add_asset->bindParam(7, $this->location);
        $add_asset->bindParam(8, $this->bldg_lvl);
        $add_asset->bindParam(9, $this->stat);
        $add_asset->bindParam(10, $this->remarks);
        $add_asset->bindParam(11, $this->created_by);
        $add_asset->bindParam(12, $current_datetime);

        if ($add_asset->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_assets()
    {

        $sql = "SELECT itamsdb.it_asset_tbl.stat_id, itamsdb.it_asset_tbl.location_id, itamsdb.it_asset_tbl.dept_id, itamsdb.it_asset_tbl.id, CONCAT(maindb.users.firstname, ' ', maindb.users.lastname) AS full_name, itamsdb.it_asset_tbl.created_at, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, itamsdb.it_asset_tbl.user, maindb.departments.dept_name, maindb.locations.location, itamsdb.it_asset_tbl.bldg_lvl, itamsdb.status_tbl.stat_name, itamsdb.it_asset_tbl.remarks FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.users, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.created_by_id = maindb.users.id AND itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.id =?";
        $get_asset = $this->conn->prepare($sql);

        $get_asset->bindParam(1, $this->id);

        $get_asset->execute();
        return $get_asset;
    }

    public function view_defectives()
    {
        $sql = 'SELECT itamsdb.it_asset_tbl.id, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, maindb.departments.dept_name, maindb.locations.location, itamsdb.status_tbl.stat_name FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.status != 0 AND (itamsdb.it_asset_tbl.stat_id = 2 OR itamsdb.it_asset_tbl.stat_id = 3) ORDER BY itamsdb.it_asset_tbl.id DESC';
        $view_defective = $this->conn->prepare($sql);

        $view_defective->execute();
        return $view_defective;
    }

    public function view_scraps()
    {
        $sql = 'SELECT itamsdb.it_asset_tbl.id, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, maindb.departments.dept_name, maindb.locations.location, itamsdb.status_tbl.stat_name FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.stat_id =4 AND itamsdb.it_asset_tbl.status != 0 ORDER BY itamsdb.it_asset_tbl.id DESC';
        $view_scrap = $this->conn->prepare($sql);

        $view_scrap->execute();
        return $view_scrap;
    }

    public function count_good_conditions()
    {

        $sql = 'SELECT COUNT(stat_id) as good_condition FROM it_asset_tbl WHERE stat_id=1 AND status != 0';
        $count_good_condition = $this->conn->prepare($sql);

        $count_good_condition->execute();
        return $count_good_condition;
    }

    public function count_storage_rooms()
    {

        $sql = 'SELECT COUNT(stat_id) as storage_room FROM it_asset_tbl WHERE stat_id=3 AND status != 0';
        $count_storage_room = $this->conn->prepare($sql);

        $count_storage_room->execute();
        return $count_storage_room;
    }

    public function count_defectives()
    {

        $sql = 'SELECT COUNT(stat_id) as defective FROM it_asset_tbl WHERE stat_id=2 AND status != 0';
        $count_defective = $this->conn->prepare($sql);

        $count_defective->execute();
        return $count_defective;
    }

    public function count_scraps()
    {

        $sql = 'SELECT COUNT(stat_id) as scrap FROM it_asset_tbl WHERE stat_id=4 AND status != 0';
        $count_scrap = $this->conn->prepare($sql);

        $count_scrap->execute();
        return $count_scrap;
    }

    public function increment_barcodes()
    {
        $sql = "SELECT MAX(bar_no) AS max_barcode FROM it_asset_tbl WHERE form_type = ?";
        $increment_barcode = $this->conn->prepare($sql);

        $increment_barcode->bindParam(1, $this->form_type);

        $increment_barcode->execute();
        return $increment_barcode;
    }

    public function verify_barcodes()
    {
        $sql = "SELECT COUNT(bar_no) AS barcode FROM it_asset_tbl WHERE bar_no = ?";
        $verify_barcode = $this->conn->prepare($sql);

        $verify_barcode->bindParam(1, $this->bar_no);

        $verify_barcode->execute();
        return $verify_barcode;
    }

    public function update_assets()
    {

        $sql = "UPDATE it_asset_tbl SET item_desc=?, acct_name=?, user=?, dept_id=?, location_id=?, bldg_lvl=?, stat_id=?, remarks=?, created_at=? WHERE id=?";
        $update_asset = $this->conn->prepare($sql);

        $current_datetime = date('Y-m-d H:i:s');

        $update_asset->bindParam(1, $this->item_desc);
        $update_asset->bindParam(2, $this->acct_name);
        $update_asset->bindParam(3, $this->user);
        $update_asset->bindParam(4, $this->dept);
        $update_asset->bindParam(5, $this->location);
        $update_asset->bindParam(6, $this->bldg_lvl);
        $update_asset->bindParam(7, $this->stat);
        $update_asset->bindParam(8, $this->remarks);
        $update_asset->bindParam(9, $current_datetime);
        $update_asset->bindParam(10, $this->id);

        if ($update_asset->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function select_barcodes()
    {
        $sql = "SELECT id, bar_no FROM it_asset_tbl WHERE status != 0 GROUP BY bar_no";
        $select_barcode = $this->conn->prepare($sql);

        $select_barcode->execute();
        return $select_barcode;
    }

    public function select_descriptions()
    {
        $sql = "SELECT id, item_desc FROM it_asset_tbl WHERE status != 0 GROUP BY item_desc";
        $select_description = $this->conn->prepare($sql);

        $select_description->execute();
        return $select_description;
    }

    public function select_accountables()
    {
        $sql = "SELECT id, acct_name FROM it_asset_tbl WHERE status != 0 GROUP BY acct_name";
        $select_accountable = $this->conn->prepare($sql);

        $select_accountable->execute();
        return $select_accountable;
    }

    public function getAll_usingBarcodes()
    {

        $sql = "SELECT itamsdb.it_asset_tbl.stat_id, itamsdb.it_asset_tbl.location_id, itamsdb.it_asset_tbl.dept_id, itamsdb.it_asset_tbl.id, CONCAT(maindb.users.firstname, ' ', maindb.users.lastname) AS full_name, itamsdb.it_asset_tbl.created_at, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, itamsdb.it_asset_tbl.user, maindb.departments.dept_name, maindb.locations.location, itamsdb.it_asset_tbl.bldg_lvl, itamsdb.status_tbl.stat_name, itamsdb.it_asset_tbl.remarks FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.users, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.created_by_id = maindb.users.id AND itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.bar_no=? AND itamsdb.it_asset_tbl.status != 0";
        $getAll_usingBarcode = $this->conn->prepare($sql);

        $getAll_usingBarcode->bindParam(1, $this->bar_no);

        $getAll_usingBarcode->execute();
        return $getAll_usingBarcode;
    }

    public function getAll_usingDescriptions()
    {

        $sql = "SELECT itamsdb.it_asset_tbl.stat_id, itamsdb.it_asset_tbl.location_id, itamsdb.it_asset_tbl.dept_id, itamsdb.it_asset_tbl.id, CONCAT(maindb.users.firstname, ' ', maindb.users.lastname) AS full_name, itamsdb.it_asset_tbl.created_at, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, itamsdb.it_asset_tbl.user, maindb.departments.dept_name, maindb.locations.location, itamsdb.it_asset_tbl.bldg_lvl, itamsdb.status_tbl.stat_name, itamsdb.it_asset_tbl.remarks FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.users, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.created_by_id = maindb.users.id AND itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.item_desc=? AND itamsdb.it_asset_tbl.status != 0";
        $getAll_usingDescription = $this->conn->prepare($sql);

        $getAll_usingDescription->bindParam(1, $this->item_desc);

        $getAll_usingDescription->execute();
        return $getAll_usingDescription;
    }

    public function getAll_usingAccts()
    {

        $sql = "SELECT itamsdb.it_asset_tbl.stat_id, itamsdb.it_asset_tbl.location_id, itamsdb.it_asset_tbl.dept_id, itamsdb.it_asset_tbl.id, CONCAT(maindb.users.firstname, ' ', maindb.users.lastname) AS full_name, itamsdb.it_asset_tbl.created_at, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, itamsdb.it_asset_tbl.user, maindb.departments.dept_name, maindb.locations.location, itamsdb.it_asset_tbl.bldg_lvl, itamsdb.status_tbl.stat_name, itamsdb.it_asset_tbl.remarks FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.users, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.created_by_id = maindb.users.id AND itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.acct_name=? AND itamsdb.it_asset_tbl.status != 0";
        $getAll_usingacct = $this->conn->prepare($sql);

        $getAll_usingacct->bindParam(1, $this->acct);

        $getAll_usingacct->execute();
        return $getAll_usingacct;
    }

    public function getAll_usingDepartments()
    {

        $sql = "SELECT itamsdb.it_asset_tbl.stat_id, itamsdb.it_asset_tbl.location_id, itamsdb.it_asset_tbl.dept_id, itamsdb.it_asset_tbl.id, CONCAT(maindb.users.firstname, ' ', maindb.users.lastname) AS full_name, itamsdb.it_asset_tbl.created_at, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, itamsdb.it_asset_tbl.user, maindb.departments.dept_name, maindb.locations.location, itamsdb.it_asset_tbl.bldg_lvl, itamsdb.status_tbl.stat_name, itamsdb.it_asset_tbl.remarks FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.users, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.created_by_id = maindb.users.id AND itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.dept_id=? AND itamsdb.it_asset_tbl.status != 0";
        $getAll_usingDepartment = $this->conn->prepare($sql);

        $getAll_usingDepartment->bindParam(1, $this->dept_id);

        $getAll_usingDepartment->execute();
        return $getAll_usingDepartment;
    }

    public function getAll_usingLocations()
    {

        $sql = "SELECT itamsdb.it_asset_tbl.stat_id, itamsdb.it_asset_tbl.location_id, itamsdb.it_asset_tbl.dept_id, itamsdb.it_asset_tbl.id, CONCAT(maindb.users.firstname, ' ', maindb.users.lastname) AS full_name, itamsdb.it_asset_tbl.created_at, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, itamsdb.it_asset_tbl.user, maindb.departments.dept_name, maindb.locations.location, itamsdb.it_asset_tbl.bldg_lvl, itamsdb.status_tbl.stat_name, itamsdb.it_asset_tbl.remarks FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.users, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.created_by_id = maindb.users.id AND itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.location_id=? AND itamsdb.it_asset_tbl.status != 0";
        $getAll_usingLocation = $this->conn->prepare($sql);

        $getAll_usingLocation->bindParam(1, $this->location_id);

        $getAll_usingLocation->execute();
        return $getAll_usingLocation;
    }

    public function getAll_usingStats()
    {

        $sql = "SELECT itamsdb.it_asset_tbl.stat_id, itamsdb.it_asset_tbl.location_id, itamsdb.it_asset_tbl.dept_id, itamsdb.it_asset_tbl.id, CONCAT(maindb.users.firstname, ' ', maindb.users.lastname) AS full_name, itamsdb.it_asset_tbl.created_at, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, itamsdb.it_asset_tbl.user, maindb.departments.dept_name, maindb.locations.location, itamsdb.it_asset_tbl.bldg_lvl, itamsdb.status_tbl.stat_name, itamsdb.it_asset_tbl.remarks FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.users, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.created_by_id = maindb.users.id AND itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.stat_id=? AND itamsdb.it_asset_tbl.status != 0";
        $getAll_usingStat = $this->conn->prepare($sql);

        $getAll_usingStat->bindParam(1, $this->stat_id);

        $getAll_usingStat->execute();
        return $getAll_usingStat;
    }

    public function search_barcodes()
    {
        $sql = "SELECT itamsdb.it_asset_tbl.stat_id, itamsdb.it_asset_tbl.id, itamsdb.it_asset_tbl.bar_no, itamsdb.it_asset_tbl.item_desc, itamsdb.it_asset_tbl.acct_name, maindb.departments.dept_name, maindb.locations.location, itamsdb.status_tbl.stat_name FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.departments, maindb.locations WHERE itamsdb.it_asset_tbl.dept_id = maindb.departments.id AND itamsdb.it_asset_tbl.location_id = maindb.locations.id AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id AND itamsdb.it_asset_tbl.bar_no LIKE ? AND itamsdb.it_asset_tbl.status != 0 ORDER BY itamsdb.it_asset_tbl.id DESC";
        $search_barcode = $this->conn->prepare($sql);

        $search = "%" . $this->bar_no . "%";
        $search_barcode->bindParam(1, $search);

        $search_barcode->execute();
        return $search_barcode;
    }

    public function verify_updateAssets()
    {
        $sql = "SELECT COUNT(*) FROM it_asset_tbl WHERE item_desc = ? AND acct_name = ? AND user = ? AND dept_id = ? AND location_id = ? AND bldg_lvl = ? AND stat_id = ? AND remarks = ? AND id=? AND status != 0";
        $verify_updateAsset = $this->conn->prepare($sql);

        $verify_updateAsset->bindParam(1, $this->item_desc);
        $verify_updateAsset->bindParam(2, $this->acct_name);
        $verify_updateAsset->bindParam(3, $this->user);
        $verify_updateAsset->bindParam(4, $this->dept);
        $verify_updateAsset->bindParam(5, $this->location);
        $verify_updateAsset->bindParam(6, $this->bldg_lvl);
        $verify_updateAsset->bindParam(7, $this->stat);
        $verify_updateAsset->bindParam(8, $this->remarks);
        $verify_updateAsset->bindParam(9, $this->id);

        $verify_updateAsset->execute();
        return $verify_updateAsset;
    }
}
