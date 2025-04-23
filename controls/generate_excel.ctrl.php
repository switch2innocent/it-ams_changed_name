<?php

require_once '../config/dbcon.php';
require_once '../objects/assets.obj.php';

$database = new Connection();
$db = $database->connect();

$get_assets = new Assets($db);

//Clean the string for tab and new line characters
function clean($str)
{
    return str_replace(["\t", "\r", "\n"], ' ', $str);
}

//Function to generate Excel file
function generateExcel($get)
{
    //Set headers to force download
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=it_ams_report.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    //Fetch for validation
    $row = $get->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        header("Location: ../200.php");
        exit;
    }

    //Execute the query again
    $get->execute();

    //Column headers
    echo "Barcode No\tItem Description\tAccountable\tUser\tDepartment\tLocation\tBuilding Level\tStatus\tRemarks\n";

    //Fetch data
    while ($row = $get->fetch(PDO::FETCH_ASSOC)) {
        echo '="' . clean($row['bar_no']) . '"' . "\t" .
            clean($row['item_desc']) . "\t" .
            clean($row['acct_name']) . "\t" .
            clean($row['user']) . "\t" .
            clean($row['dept_name']) . "\t" .
            clean($row['location']) . "\t" .
            clean($row['bldg_lvl']) . "\t" .
            clean($row['stat_name']) . "\t" .
            clean($row['remarks']) . "\n";
    }

    exit;
}

//Check for GET parameters
if (isset($_GET['bar_no'])) {
    $get_assets->bar_no = $_GET['bar_no'];
    $get = $get_assets->getAll_usingBarcodes();

    //Function call
    generateExcel($get);
} else if (isset($_GET['desc'])) {
    $get_assets->item_desc = $_GET['desc'];
    $get = $get_assets->getAll_usingDescriptions();

    //Function call
    generateExcel($get);
} else if (isset($_GET['acct'])) {
    $get_assets->acct = $_GET['acct'];
    $get = $get_assets->getAll_usingAccts();

    //Function call
    generateExcel($get);
} else if (isset($_GET['dept'])) {
    $get_assets->dept_id = $_GET['dept'];
    $get = $get_assets->getAll_usingDepartments();

    //Function call
    generateExcel($get);
} else if (isset($_GET['loc'])) {
    $get_assets->location_id = $_GET['loc'];
    $get = $get_assets->getAll_usingLocations();

    //Function call
    generateExcel($get);
} else if (isset($_GET['stat'])) {
    $get_assets->stat_id = $_GET['stat'];
    $get = $get_assets->getAll_usingStats();

    //Function call
    generateExcel($get);
}
