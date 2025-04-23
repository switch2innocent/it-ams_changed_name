<?php

require_once '../config/dbcon.php';
require_once '../objects/assets.obj.php';

$database = new Connection();
$db = $database->connect();

$verify_barcode = new Assets($db);

$verify_barcode->bar_no = $_POST['barcode_no'];

$verify = $verify_barcode->verify_barcodes();
if ($verify->fetchColumn() > 0) {
    echo 1;
} else {
    echo 0;
}
