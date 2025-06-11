<?php
session_start();

require_once 'config/dbcon.php';
require_once 'objects/forms.obj.php';
require_once 'objects/assets.obj.php';

$database = new Connection();
$db = $database->connect();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
	header('location: index.php');
	exit;
}
?>
<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Assets Page</title>
	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.semanticui.css">


	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.min.css" rel="stylesheet">

	<style>
		.open-sans-custom {
			font-family: "Open Sans", sans-serif;
			font-optical-sizing: auto;
			font-weight: 400;
			font-style: normal;
			font-variation-settings: "wdth"100;
		}
	</style>


	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>

<body>
	<!-- <div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="vendors/images/itdesk.png" alt="" style="width: 250px; height: auto;"></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div> -->

	<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
			<div class="header-search">
				<form>
					<div class="form-group mb-0">
						<i class="dw dw-search2 search-icon"></i>
						<input type="text" class="form-control search-input" id="search_val" placeholder="Search Barcode Here ...">
						<div class="dropdown">
							<a class="dropdown-toggle no-arrow" href="#" id="search_btn">
								<i class="icon-copy ion-android-done"></i>
							</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="header-right">
			<div class="dashboard-setting user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
						<i class="dw dw-settings2"></i>
					</a>
				</div>
			</div>
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="vendors/images/userlogo.jpg" alt="">
						</span>
						<span class="user-name"><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item" href="settings.php"><i class="dw dw-settings2"></i> Setting</a>
						<a class="dropdown-item" href="index.php"><i class="dw dw-logout"></i> Log Out</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="right-sidebar">
		<div class="sidebar-title">
			<h3 class="weight-600 font-16 text-blue">
				Layout Settings
				<span class="btn-block font-weight-400 font-12">User Interface Settings</span>
			</h3>
			<div class="close-sidebar" data-toggle="right-sidebar-close">
				<i class="icon-copy ion-close-round"></i>
			</div>
		</div>
		<div class="right-sidebar-body customscroll">
			<div class="right-sidebar-body-content">
				<h4 class="weight-600 font-18 pb-10">Header Background</h4>
				<div class="sidebar-btn-group pb-30 mb-10">
					<a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
					<a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
				</div>

				<h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
				<div class="sidebar-btn-group pb-30 mb-10">
					<a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light ">White</a>
					<a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
				</div>

				<h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
				<div class="sidebar-radio-group pb-10 mb-10">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-1" checked="">
						<label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-2">
						<label class="custom-control-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebaricon-3" name="menu-dropdown-icon" class="custom-control-input" value="icon-style-3">
						<label class="custom-control-label" for="sidebaricon-3"><i class="fa fa-angle-double-right"></i></label>
					</div>
				</div>

				<h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
				<div class="sidebar-radio-group pb-30 mb-10">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-1" name="menu-list-icon" class="custom-control-input" value="icon-list-style-1" checked="">
						<label class="custom-control-label" for="sidebariconlist-1"><i class="ion-minus-round"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-2" name="menu-list-icon" class="custom-control-input" value="icon-list-style-2">
						<label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o" aria-hidden="true"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-3" name="menu-list-icon" class="custom-control-input" value="icon-list-style-3">
						<label class="custom-control-label" for="sidebariconlist-3"><i class="dw dw-check"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-4" name="menu-list-icon" class="custom-control-input" value="icon-list-style-4" checked="">
						<label class="custom-control-label" for="sidebariconlist-4"><i class="icon-copy dw dw-next-2"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-5" name="menu-list-icon" class="custom-control-input" value="icon-list-style-5">
						<label class="custom-control-label" for="sidebariconlist-5"><i class="dw dw-fast-forward-1"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-6" name="menu-list-icon" class="custom-control-input" value="icon-list-style-6">
						<label class="custom-control-label" for="sidebariconlist-6"><i class="dw dw-next"></i></label>
					</div>
				</div>

				<div class="reset-options pt-30 text-center">
					<button class="btn btn-danger" id="reset-settings">Reset Settings</button>
				</div>
			</div>
		</div>
	</div>

	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="dashboard.php">
				<img src="vendors/images/amslogo2.png" alt="" class="dark-logo">
				<img src="vendors/images/amswhite.png" alt="" class="light-logo">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li class="dropdown">
						<a href="dashboard.php" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-home"></span></span><span class="mtext">Dashboard</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-library"></span><span class="mtext">Assets</span>
						</a>
						<ul class="submenu">
							<?php
							$form_categ = new Forms($db);

							$form = $form_categ->form_categories();
							while ($row = $form->fetch(PDO::FETCH_ASSOC)) {
								echo '
										<li><a href="assets.php?find=' . $row['form_name'] . '">' . $row['form_name'] . '</a></li>
									';
							}

							?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-paint-brush"></span><span class="mtext">Others</span>
						</a>
						<ul class="submenu">
							<li><a href="defective.php">Defective</a></li>
							<li><a href="scrap.php">Scrap</a></li>
						</ul>
					</li>
					<li>
						<a href="reports.php" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-analytics-11"></span><span class="mtext">Reports</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Assets</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page"><?php echo $_GET['find']; ?></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4"><?php echo $_GET['find']; ?> Table</h4>
						<p class="mb-0">To add new asset <a class="text-primary" href="#" data-toggle="modal" data-target="#addnew_modal">Click Here</a></p>
						<table id="desktop_pc" class="ui celled table pb-20 table-responsive" style="width:100%">
							<thead>
								<tr>
									<th>Barcode</th>
									<th>Description</th>
									<th>Accountable</th>
									<th>Department</th>
									<th>Location</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$view_asset = new Assets($db);

								$view_asset->form_type = isset($_GET['find']) ? $_GET['find'] : null;
								$view = $view_asset->view_assets();

								while ($row2 = $view->fetch(PDO::FETCH_ASSOC)) {
									echo '
										<tr>
											<td>' . $row2['bar_no'] . '</td>
											<td>' . $row2['item_desc'] . '</td>
											<td>' . $row2['acct_name'] . '</td>
											<td>' . $row2['dept_name'] . '</td>
											<td>' . $row2['location'] . '</td>
											<td>' . $row2['stat_name'] . '</td>
											<td>
												<center>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<a class="dropdown-item view" href="#" data-id="' . $row2['id'] . '"><i class="dw dw-eye"></i> View</a>
															<a class="dropdown-item edit" href="#" data-id="' . $row2['id'] . '"><i class="dw dw-edit2"></i> Edit</a>
														</div>
													</div>
												</center>
											</td>
										</tr> 
									';
								}
								?>
							</tbody>
						</table>
					</div>

				</div>
				<!-- Simple Datatable End -->
			</div>
			<div class="footer-wrap pd-20 mb-20 card-box">
				Copyright 2025 © <a href="#">innogroup.com.ph</a>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade bs-example-modal-lg open-sans-custom" id="addnew_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel"><i class="icon-copy dw dw-personal-computer"></i> <?php echo $_GET['find']; ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<!-- Default Basic Forms Start -->
					<form>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">Barcode: <span style="color: red;">*</span></label>
							<div class="col-sm-12 col-md-10">
								<input type="text" class="form-control" id="form_type" value="<?php echo $_GET['find']; ?>" hidden>

								<?php
								$increment_barcode = new Assets($db);
								$increment_barcode->form_type = isset($_GET['find']) ? $_GET['find'] : null;

								$increment = $increment_barcode->increment_barcodes();
								$row3 = $increment->fetch(PDO::FETCH_ASSOC);
								$numericBarcode = (int)substr($row3['max_barcode'], 4);

								if ($_GET['find'] === "AVR UPS") {
									$barcode = "0054" . str_pad($numericBarcode + 1, 4, "0", STR_PAD_LEFT);
								} else if ($_GET['find'] === "Laptop") {
									$barcode = "0052" . str_pad($numericBarcode + 1, 4, "0", STR_PAD_LEFT);
								} else if ($_GET['find'] === "Printer") {
									$barcode = "0051" . str_pad($numericBarcode + 1, 4, "0", STR_PAD_LEFT);
								} else if ($_GET['find'] === "Server") {
									$barcode = "0053" . str_pad($numericBarcode + 1, 4, "0", STR_PAD_LEFT);
								} else if ($_GET['find'] === "Computer Peripheral") {
									$barcode = "0055" . str_pad($numericBarcode + 1, 4, "0", STR_PAD_LEFT);
								} else if ($_GET['find'] === "Network Device") {
									$barcode = "0056" . str_pad($numericBarcode + 1, 4, "0", STR_PAD_LEFT);
								} else if ($_GET['find'] === "Scanner") {
									$barcode = "0057" . str_pad($numericBarcode + 1, 4, "0", STR_PAD_LEFT);
								} else if ($_GET['find'] === "Communication") {
									$barcode = "0058" . str_pad($numericBarcode + 1, 4, "0", STR_PAD_LEFT);
								} else {
									$barcode = '';
								}

								?>
								<input class="form-control" type="number" placeholder="Barcode No." id="barcode_no" value="<?php echo $barcode; ?>" <?php echo ($_GET['find'] === "Desktop PC") ? '' : 'readonly'; ?>>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">Description: <span style="color: red;">*</span></label>
							<div class="col-sm-12 col-md-10">
								<textarea class="form-control restrict" placeholder="Description..." id="item_description"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">Accountable: <span style="color: red;">*</span></label>
							<div class="col-sm-12 col-md-10">
								<input class="form-control restrict" type="text" placeholder="Accountable..." id="accountable_name">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">User: <span style="color: red;">*</span></label>
							<div class="col-sm-12 col-md-10">
								<input class="form-control restrict" type="text" placeholder="User..." id="user">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">Department: <span style="color: red;">*</span></label>
							<div class="col-sm-12 col-md-10">
								<select class="custom-select col-12" id="department">
									<option value="0" selected disabled>Choose...</option>
									<?php
									require_once 'config/dbconn_main.php';
									require_once 'objects/department.obj.php';

									$databaseMain = new ConnectionMain();
									$dbMain = $databaseMain->connect();

									$select_department = new Department($dbMain);
									$select = $select_department->select_departments();
									while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
										echo '<option value="' . $row['id'] . '">' . $row['dept_name'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">Location: <span style="color: red;">*</span></label>
							<div class="col-sm-12 col-md-10">
								<select class="custom-select col-12" id="location">
									<option value="0" selected disabled>Choose...</option>
									<?php
									require_once 'config/dbconn_main.php';
									require_once 'objects/location.obj.php';

									$databaseMain2 = new ConnectionMain();
									$dbMain2 = $databaseMain2->connect();

									$select_location = new Location($dbMain2);
									$select_loc = $select_location->select_locations();
									while ($row = $select_loc->fetch(PDO::FETCH_ASSOC)) {
										echo '<option value="' . $row['id'] . '">' . $row['location'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">Building Lvl: <span style="color: red;">*</span></label>
							<div class="col-sm-12 col-md-10">
								<input class="form-control restrict" type="text" placeholder="Building Level..." id="bldg_level">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">Status: <span style="color: red;">*</span></label>
							<div class="col-sm-12 col-md-10">
								<select class="custom-select col-12" id="status">
									<option value="0" selected disabled>Choose...</option>
									<?php
									require_once 'config/dbcon.php';
									require_once 'objects/status.obj.php';

									$database = new Connection();
									$db = $database->connect();

									$select_stat = new Status($db);

									$select_stat->user_id = $_SESSION['user_id'];

									$select_stat = $select_stat->select_status();
									while ($row = $select_stat->fetch(PDO::FETCH_ASSOC)) {
										echo '<option value="' . $row['id'] . '">' . $row['stat_name'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">Remarks: <span style="color: red;">*</span></label>
							<div class="col-sm-12 col-md-10">
								<textarea class="form-control restrict" placeholder="Remarks..." id="remarks"></textarea>
							</div>
						</div>
					</form>
					<!-- Default Basic Forms End -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit">Submit</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Edit Modal -->
	<div class="modal fade bs-example-modal-lg open-sans-custom" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel"><i class="icon-copy dw dw-edit-1"></i> Edit</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body" id="edit_modalBody">
					<!-- Content goes here... -->
				</div>
			</div>
		</div>
	</div>

	<!-- View Modal -->
	<div class="modal fade bs-example-modal-lg open-sans-custom" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel"><i class="icon-copy dw dw-eye"></i> View</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body" id="view_modalBody">
					<!-- Content goes here... -->
				</div>
			</div>
		</div>
	</div>

	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>
	<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
	<script src="https://cdn.datatables.net/2.2.2/js/dataTables.semanticui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.min.js"></script>
	<!-- Custom JS -->
	<script src="assets/js/assets.script.js"></script>
</body>

</html>