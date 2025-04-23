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
    $old_value = '<b>Description:</b> ' . $old['item_desc'] . ' <br> <b>Accountable:</b> ' . $old['acct_name'] . ' <br> <b>User:</b> ' . $old['user'] . ' <br> <b>Department:</b> ' . $old['dept_name'] . ' <br> <b>Location:</b> ' . $old['location'] . ' <br> <b>Building Level:</b> ' . $old['bldg_lvl'] . ' <br> <b>Status:</b> ' . $old['stat_name'] . ' <br> <b>Remarks:</b> ' . $old['remarks'];

    //New value
    $new_value = '<b>Description:</b> ' . ucwords($_POST['upd_item_desc']) . ' <br> <b>Accountable:</b> ' . ucwords($_POST['upd_acct_name']) . ' <br> <b>User:</b> ' . ucwords($_POST['upd_user']) . ' <br> <b>Department:</b> ' . $_POST['upd_dept_text'] . ' <br> <b>Location:</b> ' . $_POST['upd_location_text'] . ' <br> <b>Building Level:</b> ' . ucwords($_POST['upd_bldg_lvl']) . ' <br> <b>Status:</b> ' . $_POST['upd_stat_text'] . ' <br> <b>Remarks:</b> ' . ucwords($_POST['upd_remarks']);

    //Save to audit_tbl
    $add_audit->asset_id = $_POST['upd_id'];
    $add_audit->old_value = $old_value;
    $add_audit->new_value = $new_value;
    $add_audit->user = $_SESSION['user_id'];

    $add = $add_audit->add_audits();

    if ($add) {

        // Update asset data
        $update_asset->item_desc = ucwords($_POST['upd_item_desc']);
        $update_asset->acct_name = ucwords($_POST['upd_acct_name']);
        $update_asset->user = ucwords($_POST['upd_user']);
        $update_asset->dept = $_POST['upd_dept'];
        $update_asset->location = $_POST['upd_location'];
        $update_asset->bldg_lvl = ucwords($_POST['upd_bldg_lvl']);
        $update_asset->stat = $_POST['upd_stat'];
        $update_asset->remarks = ucwords($_POST['upd_remarks']);
        $update_asset->id = $_POST['upd_id'];

        $update = $update_asset->update_assets();

        echo $update ? 1 : 0;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
