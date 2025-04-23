<?php

session_start();

require_once '../config/dbcon.php';
require_once '../objects/assets.obj.php';

$database = new Connection();
$db = $database->connect();

$add_asset = new Assets($db);

$add_asset->form_type = $_POST['form_type'];
$add_asset->bar_no = $_POST['barcode_no'];
$add_asset->item_desc = ucwords($_POST['item_desc']);
$add_asset->acct_name = ucwords($_POST['account_name']);
$add_asset->user = ucwords($_POST['user']);
$add_asset->dept = $_POST['dept'];
$add_asset->location = $_POST['loc'];
$add_asset->bldg_lvl = ucwords($_POST['bldg_level']);
$add_asset->stat = $_POST['status'];
$add_asset->remarks = ucwords($_POST['remarks']);
$add_asset->created_by = $_SESSION['user_id'];

$add = $add_asset->add_assets();

if ($add) {
    echo 1;
} else {
    echo 0;
}
