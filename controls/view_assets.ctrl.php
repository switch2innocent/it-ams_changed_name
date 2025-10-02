<?php

session_start();

require_once '../config/dbcon.php';
require_once '../config/dbconn_main.php';
require_once '../objects/assets.obj.php';
require_once '../objects/status.obj.php';
require_once '../objects/department.obj.php';
require_once '../objects/location.obj.php';
require_once '../objects/audits.obj.php';

$database = new Connection();
$db = $database->connect();
$databaseMain = new ConnectionMain();
$dbMain = $databaseMain->connect();

$get_asset = new Assets($db);
$select_stat = new Status($db);
$select_department = new Department($dbMain);
$select_location = new Location($dbMain);
$view_history = new Audits($db);

$get_asset->id = $_POST['id'];
$view_history->asset_id = $_POST['id'];
$select_stat->user_id = $_SESSION['user_id'];

$get = $get_asset->get_assets();
$select_stat = $select_stat->select_status();
$select = $select_department->select_departments();
$select_loc = $select_location->select_locations();
$view = $view_history->get_historys();

while ($row = $get->fetch(PDO::FETCH_ASSOC)) {

    echo '
    <form>
    <label style="font-size: 12px; font-weight: bold;"><i class="fa fa-info-circle"></i> Asset Info</label>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Created By: </label>
                <input class="form-control" type="text" id="upd_id" value="' . $row['id'] . '" hidden>
                <input class="form-control" type="text" placeholder="Created By." id="upd_created_by" value="' . $row['full_name'] . '" readonly>
            </div>
            <div class="form-group col-md-6">
                <label>Date Added: </label>
                <input class="form-control" type="text" placeholder="Date Added." id="upd_created_at" value="' . $row['created_at'] . '" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Barcode: </label>
                <input class="form-control" type="number" placeholder="Barcode No." id="upd_bar_no" value="' . $row['bar_no'] . '" readonly>
            </div>
            <div class="form-group col-md-6">
                <label>Description:</label>
                <textarea class="form-control restrict" placeholder="Description..." id="upd_item_desc" readonly>' . $row['item_desc'] . '</textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Accountable:</label>
                <input class="form-control restrict" type="text" placeholder="Accountable..." id="" value="' . $row['acct_name'] . '" readonly>
            </div>
            <div class="form-group col-md-6">
                <label>User:</label>
                <input class="form-control restrict" type="text" placeholder="User..." id="" value="' . $row['user'] . '" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Department:</label>
                <select class="custom-select" id="" disabled style="color: black; background-color: #f0f0f0; opacity: 1;">
                    <option value="' . $row['dept_id'] . '">' . $row['dept_name'] . '</option>';
    while ($row3 = $select->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row3['id'] . '">' . $row3['dept_name'] . '</option>';
    }
    echo '</select>
            </div>
            <div class="form-group col-md-6">
                <label>Location:</label>
                <select class="custom-select" id="" disabled style="color: black; background-color: #f0f0f0; opacity: 1;">
                    <option value="' . $row['location_id'] . '">' . $row['location'] . '</option>';
    while ($row4 = $select_loc->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row4['id'] . '">' . $row4['location'] . '</option>';
    }
    echo '</select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Building Lvl:</label>
                <input class="form-control restrict" type="text" placeholder="Building Level..." id="upd_bldg_lvl" value="' . $row['bldg_lvl'] . '" readonly>
            </div>
            <div class="form-group col-md-6">
                <label>Status:</label>
                 <select class="custom-select" id="upd_stat" disabled style="color: black; background-color: #f0f0f0; opacity: 1;">
                    <option value="' . $row['stat_id'] . '">' . $row['stat_name'] . '</option>';
    while ($row2 = $select_stat->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row2['id'] . '">' . $row2['stat_name'] . '</option>';
    }
    echo '</select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Remarks:</label>
                <textarea class="form-control restrict" style="height: 300px;" placeholder="Remarks..." id="upd_remarks" readonly>' . $row['remarks'] . '</textarea>
            </div>
            <div class="form-group col-md-6">
                <label>Attach Image: </label>
                </br>
				<img src="uploads/' . htmlspecialchars($row['img_name']) . '" alt="No Image Available" style="width: 100%; height: 300px; border-radius:3px;" />
            </div>
        </div>
    </form>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label style="font-size: 12px; font-weight: bold;"><i class="fa fa-info-circle"></i> Audit Log</label>
            <div style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered">
                    <thead class="thead-light" style="position: sticky; top: 0; z-index: 1; background-color: #f8f9fa;">
                        <tr>
                            <th class="text-center">Date</th>
                            <th >From</th>
                            <th>To</th>
                            <th class="text-center">Updated By</th>
                        </tr>
                    </thead>
                    <tbody>';

    if ($view->rowCount() > 0) {
        while ($row5 = $view->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
                                    <td class="text-center">' . $row5['changed_at'] . '</td>
                                    <td>' . $row5['old_value'] . '</td>
                                    <td>' . $row5['new_value'] . '</td>
                                    <td class="text-center">' . $row5['full_name'] . '</td>
                                </tr>';
        }
    } else {
        echo '<tr><td colspan="4" style="text-align: center;">No history available for this asset.</td></tr>';
    }
    echo '</tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
    ';
}
