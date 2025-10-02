<?php

require_once '../config/dbcon.php';
require_once '../objects/assets.obj.php';

$database = new Connection();
$db = $database->connect();

$verify_updateAsset = new Assets($db);

$verify_updateAsset->item_desc = $_POST['upd_item_desc'];
$verify_updateAsset->acct_name = $_POST['upd_acct_name'];
$verify_updateAsset->user = $_POST['upd_user'];
$verify_updateAsset->dept = $_POST['upd_dept'];
$verify_updateAsset->location = $_POST['upd_location'];
$verify_updateAsset->bldg_lvl = $_POST['upd_bldg_lvl'];
$verify_updateAsset->stat = $_POST['upd_stat'];
$verify_updateAsset->remarks = $_POST['upd_remarks'];
$verify_updateAsset->fileName = $_POST['fileName'];
$verify_updateAsset->id = $_POST['upd_id'];

$verify = $verify_updateAsset->verify_updateAssets();

if ($verify->fetchColumn() > 0) {
    echo 1;
} else {
    echo 0;
}
