<?php
session_start();

require_once '../config/dbcon.php';
require_once '../objects/audits.obj.php';
require_once '../objects/assets.obj.php';

$database = new Connection();
$db = $database->connect();

$get_asset = new Assets($db);
$add_audit = new Audits($db);
$update_asset = new Assets($db);

//Get ID
$get_asset->id = $_POST['upd_id'];

$get = $get_asset->get_assets();
$old = $get->fetch(PDO::FETCH_ASSOC);

if ($old) {

    //Old value
    $old_value = '<b class="text-info">Description:</b> ' . $old['item_desc'] . ' <br> <b class="text-info">Accountable:</b> ' . $old['acct_name'] . ' <br> <b class="text-info">User:</b> ' . $old['user'] . ' <br> <b class="text-info">Department:</b> ' . $old['dept_name'] . ' <br> <b class="text-info">Location:</b> ' . $old['location'] . ' <br> <b class="text-info">Building Level:</b> ' . $old['bldg_lvl'] . ' <br> <b class="text-info">Status:</b> ' . $old['stat_name'] . ' <br> <b class="text-info">Remarks:</b> ' . $old['remarks'] . ' <br> <b class="text-info">Reason:</b> ' . $old['reason'];

    //New value
    $new_value = '<b class="text-info">Description:</b> ' . strtoupper($_POST['upd_item_desc']) . ' <br> <b class="text-info">Accountable:</b> ' . strtoupper($_POST['upd_acct_name']) . ' <br> <b class="text-info">User:</b> ' . strtoupper($_POST['upd_user']) . ' <br> <b class="text-info">Department:</b> ' . $_POST['upd_dept_text'] . ' <br> <b class="text-info">Location:</b> ' . $_POST['upd_location_text'] . ' <br> <b class="text-info">Building Level:</b> ' . strtoupper($_POST['upd_bldg_lvl']) . ' <br> <b class="text-info">Status:</b> ' . $_POST['upd_stat_text'] . ' <br> <b class="text-info">Remarks:</b> ' . strtoupper($_POST['upd_remarks']) . ' <br> <b class="text-info">Reason:</b> ' . strtoupper($_POST['upd_reason']);

    //Save to audit_tbl
    $add_audit->asset_id = $_POST['upd_id'];
    $add_audit->old_value = $old_value;
    $add_audit->new_value = $new_value;
    $add_audit->user = $_SESSION['user_id'];

    $add = $add_audit->add_audits();

    if ($add) {

        // Update asset data
        $update_asset->item_desc = strtoupper($_POST['upd_item_desc']);
        $update_asset->acct_name = strtoupper($_POST['upd_acct_name']);
        $update_asset->user = strtoupper($_POST['upd_user']);
        $update_asset->dept = strtoupper($_POST['upd_dept']);
        $update_asset->location = strtoupper($_POST['upd_location']);
        $update_asset->bldg_lvl = strtoupper($_POST['upd_bldg_lvl']);
        $update_asset->stat = $_POST['upd_stat'];
        $update_asset->remarks = strtoupper($_POST['upd_remarks']);
        $update_asset->upd_reason = strtoupper($_POST['upd_reason']);
        $update_asset->id = $_POST['upd_id'];

        //Check if file uploaded
        if (isset($_FILES['upd_img_file']) && is_uploaded_file($_FILES['upd_img_file']['tmp_name'])) {

            $update_asset->upd_img_name = basename($_FILES['upd_img_file']['name']);
            $target = "/usr/share/it-ams/uploads/" . basename($_FILES['upd_img_file']['name']);
            move_uploaded_file($_FILES['upd_img_file']['tmp_name'], $target);
        } else {
            $update_asset->upd_img_name = null;
        }

        $update = $update_asset->update_assets();

        echo $update ? 1 : 0;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
