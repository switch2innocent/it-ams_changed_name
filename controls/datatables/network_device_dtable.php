<?php
require_once '../../config/dbcon.php';
require_once '../../objects/assets.obj.php';

$database = new Connection();
$db = $database->connect();
$view_asset = new Assets($db);

//Ensure clean JSON output
header('Content-Type: application/json; charset=utf-8');
error_reporting(0); //Hide notices/warnings in production

$columns = array(
    0 => 'itamsdb.it_asset_tbl.bar_no',
    1 => 'itamsdb.it_asset_tbl.item_desc',
    2 => 'itamsdb.it_asset_tbl.acct_name',
    3 => 'itamsdb.it_asset_tbl.user',
    4 => 'maindb.departments.dept_name',
    5 => 'maindb.locations.location',
    6 => 'itamsdb.status_tbl.stat_name',
    7 => 'action',
);

//Base query
$sql = 'SELECT itamsdb.it_asset_tbl.id, 
itamsdb.it_asset_tbl.bar_no, 
itamsdb.it_asset_tbl.item_desc, 
itamsdb.it_asset_tbl.acct_name, 
itamsdb.it_asset_tbl.user, 
maindb.departments.dept_name, 
maindb.locations.location, 
itamsdb.status_tbl.stat_name 

FROM itamsdb.it_asset_tbl, itamsdb.status_tbl, maindb.departments, maindb.locations 

WHERE itamsdb.it_asset_tbl.dept_id = maindb.departments.id 
AND itamsdb.it_asset_tbl.location_id = maindb.locations.id 
AND itamsdb.it_asset_tbl.stat_id = itamsdb.status_tbl.id 
AND itamsdb.it_asset_tbl.form_type="Network Device" 
AND itamsdb.it_asset_tbl.stat_id !=2 
AND itamsdb.it_asset_tbl.stat_id !=4 
AND itamsdb.it_asset_tbl.stat_id !=3 
AND itamsdb.it_asset_tbl.status != 0';

//Search filter
if (!empty($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " AND (
        itamsdb.it_asset_tbl.bar_no LIKE '%$search_value%' OR
        itamsdb.it_asset_tbl.item_desc LIKE '%$search_value%' OR
        itamsdb.it_asset_tbl.acct_name LIKE '%$search_value%' OR
        itamsdb.it_asset_tbl.user LIKE '%$search_value%' OR
        maindb.departments.dept_name LIKE '%$search_value%' OR
        maindb.locations.location LIKE '%$search_value%' OR
        itamsdb.status_tbl.stat_name LIKE '%$search_value%'
    )";
}

//Ordering
if (isset($_POST['order'])) {
    $column_index = $_POST['order'][0]['column'];
    $order_dir = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $columns[$column_index] . " " . $order_dir;
} else {
    $sql .= " ORDER BY itamsdb.it_asset_tbl.id DESC";
}

//Pagination
if (isset($_POST['start']) && isset($_POST['length'])) {
    $start = intval($_POST['start']);
    $length = intval($_POST['length']);
    $sql .= " LIMIT $start, $length";
}

//Fetch data
$view = $view_asset->view_assets($sql);
$data = [];

while ($row = $view->fetch(PDO::FETCH_ASSOC)) {
    $action = '<center>
        <div class="dropdown">
            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow" href="#" role="button" data-toggle="dropdown">
                <i class="dw dw-more"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                <a class="dropdown-item view" href="#" data-id="' . $row['id'] . '"><i class="dw dw-eye"></i> View</a>
                <a class="dropdown-item edit" href="#" data-id="' . $row['id'] . '"><i class="dw dw-edit2"></i> Edit</a>
            </div>
        </div>
    </center>';

    $data[] = [
        $row['bar_no'],
        strtoupper($row['item_desc']),
        strtoupper($row['acct_name']),
        strtoupper($row['user']),
        strtoupper($row['dept_name']),
        strtoupper($row['location']),
        strtoupper($row['stat_name']),
        $action
    ];
}

//Total records
$total_all_rows = $view_asset->view_assets(str_replace("LIMIT $start, $length", "", $sql))->rowCount();

$output = [
    'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
    'recordsTotal' => $total_all_rows,
    'recordsFiltered' => $total_all_rows,
    'data' => $data
];

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
