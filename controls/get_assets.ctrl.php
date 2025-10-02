<?php
session_start();

require_once '../config/dbcon.php';
require_once '../config/dbconn_main.php';
require_once '../objects/assets.obj.php';
require_once '../objects/status.obj.php';
require_once '../objects/department.obj.php';
require_once '../objects/location.obj.php';
require_once '../objects/audits.obj.php';
require_once '../objects/users.obj.php';

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
$select_stat->user_id = $_SESSION['access_user_id'];
$select_stat->role_id = $_SESSION['access_role_id'];
$select_stat->role = $_SESSION['role'];

$get = $get_asset->get_assets();
$select_st = $select_stat->select_status();
$select = $select_department->select_departments();
$select_loc = $select_location->select_locations();
$view = $view_history->get_historys();

while ($row = $get->fetch(PDO::FETCH_ASSOC)) {

	echo '
    	<!-- Default Basic Forms Start -->
					<form id="assetForm" enctype="multipart/form-data">
						<div class="row">
						
							<!-- Column 1 -->
							<div class="col-md-4">
								<div class="form-group">
									<label for="barcode_no"><i class="icon-copy dw dw-barcode"></i> Barcode </label>
									<input class="form-control" type="text" id="upd_id" value="' . $row['id'] . '" hidden>
									<input class="form-control ui input" type="number" placeholder="Barcode No." id="upd_bar_no" value="' . $row['bar_no'] . '" readonly>
								</div>
								<div class="form-group">
									<label for="item_description"><i class="icon-copy dw dw-file"></i> Description </label>
									<textarea class="form-control ui input restrict" placeholder="Description..." id="upd_item_desc" ' . ($row['stat_id'] == 4 ? 'readonly' : '') . '>' . $row['item_desc'] . '</textarea>
								</div>
								<div class="form-group position-relative">
									<label for="accountable_name"><i class="icon-copy dw dw-user"></i> Accountable </label>
									<br/>
									      <select class="form-control ui input restrict" style="width: 240px;" id="upd_acct_name" ' . ($row['stat_id'] == 4 ? 'disabled' : '') . '>
                                        <option value="' . $row['acct_name'] . '">' . $row['acct_name'] . '</option>';
	$select_acct_name = new Users($dbMain);

	$select_acct = $select_acct_name->select_users();
	while ($row6 = $select_acct->fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="' . $row6['fullname'] . '">' . $row6['fullname'] . '</option>';
	}
	echo '</select>
								</div>
								<div class="form-group position-relative">
									<label for="user"><i class="icon-copy dw dw-user-2"></i> User </label>
									<br/>
								   <select class="form-control ui input restrict" style="width: 240px;" id="upd_user">
                                      <option value="' . $row['user'] . '">' . $row['user'] . '</option>';

	$select_user = new Users($dbMain);

	$select_u = $select_user->select_users();
	while ($row7 = $select_u->fetch(PDO::FETCH_ASSOC)) {
		echo '<option value="' . $row7['fullname'] . '">' . $row7['fullname'] . '</option>';
	}
	echo '</select>
								</div>
							</div>

							<!-- Column 2 -->
							<div class="col-md-4">
								<div class="form-group position-relative">
									<label for="department"><i class="icon-copy dw dw-building"></i> Department </label>
									<br/>
									<select style="width: 240px;" class="custom-select ui dropdown" id="upd_dept" ' . ($row['stat_id'] == 4 ? 'disabled' : '') . '>
                    <option value="' . (int)$row['dept_id'] . '">' . $row['dept_name'] . '</option>';
	while ($row3 = $select->fetch(PDO::FETCH_ASSOC)) {
		if ((int)$row3['id'] !== (int)$row['dept_id']) {
			echo '<option value="' . (int)$row3['id'] . '">' . $row3['dept_name'] . '</option>';
		}
	}
	echo '</select>
								</div>
								<div class="form-group position-relative">
									<label for="location"><i class="icon-copy dw dw-map"></i> Location </label>
									<br/>
									<select style="width: 240px;" class="custom-select ui dropdown" id="upd_location" ' . ($row['stat_id'] == 4 ? 'disabled' : '') . '>
                    <option value="' . (int)$row['location_id'] . '">' . $row['location'] . '</option>';
	while ($row4 = $select_loc->fetch(PDO::FETCH_ASSOC)) {
		if ((int)$row4['id'] !== (int)$row['location_id']) {
			echo '<option value="' . (int)$row4['id'] . '">' . $row4['location'] . '</option>';
		}
	}
	echo '</select>
								</div>
								<div class="form-group">
									<label for="bldg_level"><i class="icon-copy dw dw-layers"></i> Building Level </label>
									<input class="form-control ui input restrict" type="text" placeholder="Building Level..." id="upd_bldg_lvl" value="' . $row['bldg_lvl'] . '" ' . ($row['stat_id'] == 4 ? 'readonly' : '') . '>
								</div>
								<div class="form-group">
									<label for="remarks"><i class="icon-copy dw dw-comment"></i> Remarks </label>
									<textarea class="form-control ui input restrict" placeholder="Remarks..." id="upd_remarks" ' . ($row['stat_id'] == 4 ? 'readonly' : '') . '>' . $row['remarks'] . '</textarea>
								</div>
							</div>

							<!-- Column 3 -->
							<div class="col-md-4">
								<div class="form-group">
									<label for="status"><i class="icon-copy dw dw-check"></i> Status </label>
									<select class="custom-select ui dropdown" id="upd_stat" ' . ($row['stat_id'] == 4 ? 'disabled' : '') . '>
                    <option value="' . (int)$row['stat_id'] . '" selected>' . $row['stat_name'] . '</option>';

	while ($row2 = $select_st->fetch(PDO::FETCH_ASSOC)) {
		if ((int)$row2['id'] !== (int)$row['stat_id']) {
			echo '<option value="' . (int)$row2['id'] . '">' . $row2['stat_name'] . '</option>';
		}
	}
	echo '</select>
								</div>

								<div class="form-group">
									<label for="upload_img"><i class="icon-copy dw dw-upload"></i> Upload Image </label>
									<div class="ui input">
										<input type="file" class="form-control-file border" id="upd_upload_img" name="upd_upload_img" accept="image/*" onchange="upd_previewImage(event)" required>
									</div>
									<br><br>
									<label for="imagePreview"><i class="icon-copy dw dw-eye"></i> Preview <span class="text-success">*</span></label>
									<div id="imagePreview" class="mt-2 text-center">
										<img id="upd_preview" src="uploads/' . htmlspecialchars($row['img_name']) . '" alt="Image Preview" style="max-width:100%; height:auto; border-radius:10px; border:1px solid #ddd; padding:5px; box-shadow:0 2px 8px rgba(0,0,0,0.1);" />
									</div>
								</div>
							
							</div>
							
								<div class="col-md-12">
								<div class="form-group reason" style="display: none;">
		<label for="reason"><i class="icon-copy dw dw-comment"></i> Reason <span class="text-danger">*</span></label>
		<textarea class="form-control ui input restrict" name="reason" id="upd_reason" rows="3" placeholder="Reason..." required></textarea>
	</div>
								</div>
						
						</div>
					</form>
					<!-- Default Basic Forms End -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" ' . ($row['stat_id'] == 4 ? 'hidden' : '') . ' onclick="updateAssets()">Update</button>
                        </div>
    ';
}
