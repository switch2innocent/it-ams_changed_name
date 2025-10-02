<?php

session_start();

require_once '../config/dbcon.php';
require_once '../objects/assets.obj.php';

$database = new Connection();
$db = $database->connect();

$add_asset = new Assets($db);

$add_asset->form_type = $_POST['form_type'];
$add_asset->bar_no = $_POST['barcode_no'];
$add_asset->item_desc = strtoupper($_POST['item_desc']);
$add_asset->acct_name = strtoupper($_POST['account_name']);
$add_asset->user = strtoupper($_POST['user']);
$add_asset->dept = strtoupper($_POST['dept']);
$add_asset->location = strtoupper($_POST['loc']);
$add_asset->bldg_lvl = strtoupper($_POST['bldg_level']);
$add_asset->stat = $_POST['status'];
$add_asset->remarks = strtoupper($_POST['remarks']);
$add_asset->created_by = $_SESSION['user_id'];

//Check if file uploaded
if (isset($_FILES['img_file']) && is_uploaded_file($_FILES['img_file']['tmp_name'])) {

    $add_asset->img_name = basename($_FILES['img_file']['name']);
    $target = "/usr/share/it-ams/uploads/" . basename($_FILES['img_file']['name']);
    move_uploaded_file($_FILES['img_file']['tmp_name'], $target);
} else {
    $add_asset->img_name = null;
}

$add = $add_asset->add_assets();

if ($add) {
    echo 1;
} else {
    echo 0;
}
