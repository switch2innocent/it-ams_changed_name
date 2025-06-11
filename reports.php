<?php
session_start();

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
	<title>Reports Page</title>

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
	<!-- switchery css -->
	<link rel="stylesheet" type="text/css" href="src/plugins/switchery/switchery.min.css">
	<!-- bootstrap-tagsinput css -->
	<link rel="stylesheet" type="text/css" href="src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">
	<!-- bootstrap-touchspin css -->
	<link rel="stylesheet" type="text/css" href="src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.min.css" rel="stylesheet">

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
						<a class="dropdown-item" href="controls/logout_users.ctrl.php"><i class="dw dw-logout"></i> Log Out</a>
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
							<span class="micon dw dw-home"></span><span class="mtext">Dashboard</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-library"></span><span class="mtext">Assets</span>
						</a>
						<ul class="submenu">

							<?php
							require_once 'config/dbcon.php';
							require_once 'objects/forms.obj.php';
							require_once 'objects/assets.obj.php';

							$database = new Connection();
							$db = $database->connect();

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
								<h4>Reports</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Reports</li>
								</ol>
							</nav>
						</div>

					</div>
				</div>

				<!-- Select-2 Start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Generate Reports</h4>
							<p class="mb-30">Please choose a category to generate reports. To enable selections <a class="text-primary" href="#" id="reset">Click here</a>.</p>
						</div>
					</div>
					<form>
						<div class=" row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Barcode</label>
									<select class="form-control" id="barcode">
										<option value="0" selected disabled>Choose...</option>
										<?php
										require_once 'config/dbcon.php';
										require_once 'objects/assets.obj.php';

										$database = new Connection();
										$db = $database->connect();

										$select_barcode = new Assets($db);

										$select = $select_barcode->select_barcodes();
										while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
											echo '<option value="' . $row['bar_no'] . '">' . $row['bar_no'] . '</option>';
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Description</label>
									<select class="form-control" id="description">
										<option value="0" selected disabled>Choose...</option>
										<?php
										$select_description = new Assets($db);

										$select = $select_description->select_descriptions();
										while ($row2 = $select->fetch(PDO::FETCH_ASSOC)) {
											echo '<option value="' . $row2['item_desc'] . '">' . $row2['item_desc'] . '</option>';
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Accountable</label>
									<select class="form-control" id="acct">
										<option value="0" selected disabled>Choose...</option>
										<?php
										$select_accountable = new Assets($db);

										$select = $select_accountable->select_accountables();
										while ($row3 = $select->fetch(PDO::FETCH_ASSOC)) {
											echo '<option value="' . $row3['acct_name'] . '">' . $row3['acct_name'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Department</label>
									<select class="form-control" id="department">
										<option value="0" selected disabled>Choose...</option>
										<?php
										require_once 'config/dbconn_main.php';
										require_once 'objects/department.obj.php';

										$databaseMain = new ConnectionMain();
										$dbMain = $databaseMain->connect();

										$select_department = new Department($dbMain);

										$select = $select_department->select_departments();
										while ($row4 = $select->fetch(PDO::FETCH_ASSOC)) {
											echo '<option value="' . $row4['id'] . '">' . $row4['dept_name'] . '</option>';
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Location</label>
									<select class="form-control" id="location">
										<option value="0" selected disabled>Choose...</option>
										<?php
										require_once 'objects/location.obj.php';

										$select_location = new Location($dbMain);

										$select = $select_location->select_locations();
										while ($row5 = $select->fetch(PDO::FETCH_ASSOC)) {
											echo '<option value="' . $row5['id'] . '">' . $row5['location'] . '</option>';
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Status</label>
									<select class="form-control" id="status">
										<option value="0" selected disabled>Choose...</option>
										<?php
										require_once 'objects/status.obj.php';

										$select_stat = new Status($db);

										$select = $select_stat->view_status();
										while ($row6 = $select->fetch(PDO::FETCH_ASSOC)) {
											echo '<option value="' . $row6['id'] . '">' . $row6['stat_name'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="text-right">
							<button class="btn btn-success" id="generateExcel">Generate as Excel</button>
							<button class="btn btn-primary" id="generatePDF">Generate as PDF</button>
						</div>
					</form>
				</div>
				<!-- Select-2 end -->
			</div>
			<div class="footer-wrap pd-20 mb-20 card-box">
				Copyright 2025 © <a href="#">innogroup.com.ph</a>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<!-- switchery js -->
	<script src="src/plugins/switchery/switchery.min.js"></script>
	<!-- bootstrap-tagsinput js -->
	<script src="src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
	<!-- bootstrap-touchspin js -->
	<script src="src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
	<script src="vendors/scripts/advanced-components.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.min.js"></script>
	<script src="assets/js/reports.script.js"></script>
</body>

</html>