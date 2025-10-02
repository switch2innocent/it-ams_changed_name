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
    <title>Communication</title>
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
</head>

<body>

    <div class="header">
        <div class="header-left">
            <div class="menu-icon dw dw-menu"></div>
            <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
            <div class="header-search">
                <form>
                    <div class="form-group mb-0">
                        <i class="dw dw-search2 search-icon"></i>
                        <input type="text" class="form-control search-input" id="search_val" placeholder="Search Barcode / Accountable Person Here ...">
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
            <!-- <div class="dashboard-setting user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                        <i class="dw dw-settings2"></i>
                    </a>
                </div>
            </div> -->
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

    <div class="left-side-bar" style="height: 100%;">
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
                            <li><a href="desktop_pc.php">Desktop PC</a></li>
                            <li><a href="avr_ups.php">AVR UPS</a></li>
                            <li><a href="laptop.php">Laptop</a></li>
                            <li><a href="printer.php">Printer</a></li>
                            <li><a href="server.php">Server</a></li>
                            <li><a href="computer_peripheral.php">Computer Peripheral</a></li>
                            <li><a href="network_device.php">Network Device</a></li>
                            <li><a href="scanner.php">Scanner</a></li>
                            <li><a href="communication.php">Communication</a></li>
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
                                    <li class="breadcrumb-item active" aria-current="page"> Communication</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Simple Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <p class="mb-0">To add new asset <a class="text-primary" href="#" data-toggle="modal" data-target="#addnew_modal">Click Here</a></p>
                        <table id="communication" class="ui celled table pb-20 table-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th class="w-100">Description</th>
                                    <th>Accountable</th>
                                    <th>User</th>
                                    <th>Department</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Content goes here... -->
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
    <div class="modal fade bs-example-modal-lg open-sans-custom" id="addnew_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel"><i class="icon-copy dw dw-personal-computer"></i> Add New</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <!-- Default Basic Forms Start -->
                    <form id="assetForm" enctype="multipart/form-data">
                        <div class="row">

                            <!-- Column 1 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="barcode_no"><i class="icon-copy dw dw-barcode"></i> Barcode <span class="text-danger">*</span></label>
                                    <input type="hidden" name="form_type" id="form_type" value="Communication">

                                    <?php
                                    $increment_barcode = new Assets($db);

                                    $form_type = "Communication";
                                    $increment_barcode->form_type = $form_type;

                                    $increment = $increment_barcode->increment_barcodes();
                                    $row3 = $increment->fetch(PDO::FETCH_ASSOC);
                                    $numericBarcode = (int)substr($row3['max_barcode'], 4);

                                    if ($form_type === "Communication") {
                                        $barcode = "0058" . str_pad($numericBarcode + 1, 4, "0", STR_PAD_LEFT);
                                    } else {
                                        $barcode = '';
                                    }
                                    ?>

                                    <input class="form-control ui input" type="number" name="barcode_no" id="barcode_no" value="<?php echo $barcode; ?>" placeholder="Barcode No." readonly>
                                </div>
                                <div class="form-group">
                                    <label for="item_description"><i class="icon-copy dw dw-file"></i> Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control ui input restrict" name="item_description" id="item_description" rows="3" placeholder="Description..." required></textarea>
                                </div>
                                <div class="form-group position-relative">
                                    <label for="accountable_name"><i class="icon-copy dw dw-user"></i> Accountable <span class="text-danger">*</span></label>
                                    <br>
                                    <select class="form-control ui input restrict" style="width: 240px;" id="accountable_name">
                                        <option value="0" selected disabled>Choose...</option>
                                        <?php
                                        require_once 'config/dbconn_main.php';
                                        require_once 'objects/users.obj.php';

                                        $databaseMain = new ConnectionMain();
                                        $dbMain = $databaseMain->connect();

                                        $select_user = new Users($dbMain);

                                        $select = $select_user->select_users();
                                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row['fullname'] . '">' . $row['fullname'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group position-relative">
                                    <label for="user"><i class="icon-copy dw dw-user-2"></i> User <span class="text-danger">*</span></label>
                                    <!-- <input class="form-control ui input restrict" type="text" name="user" id="user" placeholder="User..." required> -->
                                    <br>
                                    <select class="form-control ui input restrict" style="width: 240px;" id="user">
                                        <option value="0" selected disabled>Choose...</option>
                                        <?php
                                        require_once 'config/dbconn_main.php';
                                        require_once 'objects/users.obj.php';

                                        $databaseMain = new ConnectionMain();
                                        $dbMain = $databaseMain->connect();

                                        $select_user = new Users($dbMain);

                                        $select = $select_user->select_users();
                                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row['fullname'] . '">' . $row['fullname'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Column 2 -->
                            <div class="col-md-4">
                                <div class="form-group position-relative">
                                    <label for="department"><i class="icon-copy dw dw-building"></i> Department <span class="text-danger">*</span></label>
                                    <br>
                                    <select class="custom-select ui dropdown" name="department" style="width: 240px;" id="department" required>
                                        <option value="" selected disabled>Choose...</option>
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
                                <div class="form-group position-relative">
                                    <label for="location"><i class="icon-copy dw dw-map"></i> Location <span class="text-danger">*</span></label>
                                    <br>
                                    <select class="custom-select ui dropdown" name="location" id="location" style="width: 240px;" required>
                                        <option value="" selected disabled>Choose...</option>
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
                                <div class="form-group">
                                    <label for="bldg_level"><i class="icon-copy dw dw-layers"></i> Building Level <span class="text-danger">*</span></label>
                                    <input class="form-control ui input restrict" type="text" name="bldg_level" id="bldg_level" placeholder="Building Level..." required>
                                </div>
                                <div class="form-group">
                                    <label for="remarks"><i class="icon-copy dw dw-comment"></i> Remarks <span class="text-danger">*</span></label>
                                    <textarea class="form-control ui input restrict" name="remarks" id="remarks" rows="3" placeholder="Remarks..." required></textarea>
                                </div>
                            </div>

                            <!-- Column 3 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status"><i class="icon-copy dw dw-check"></i> Status <span class="text-danger">*</span></label>
                                    <select class="custom-select ui dropdown" name="status" id="status" required>
                                        <option value="1" selected>In Good Condition</option>
                                        <?php
                                        require_once 'config/dbcon.php';
                                        require_once 'objects/status.obj.php';

                                        $database = new Connection();
                                        $db = $database->connect();

                                        $select_stat = new Status($db);
                                        $select_stat->user_id = $_SESSION['access_user_id'];
                                        $select_stat->role_id = $_SESSION['access_role_id'];
                                        $select_stat->role = $_SESSION['role'];
                                        $select_stat = $select_stat->select_status();
                                        while ($row = $select_stat->fetch(PDO::FETCH_ASSOC)) {
                                            if ($row['stat_name'] !== 'In Good Condition') {
                                                echo '<option value="' . $row['id'] . '">' . $row['stat_name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">

                                    <label for="upload_img"><i class="icon-copy dw dw-upload"></i> Upload Image <span class="text-danger">*</span></label>
                                    <div class="ui input">
                                        <input type="file" class="form-control-file border" id="upload_img" name="upload_img" accept="image/*" onchange="previewImage(event)" required>
                                    </div>

                                    <br><br>

                                    <label for="imagePreview"><i class="icon-copy dw dw-eye"></i> Preview <span class="text-success">*</span></label>
                                    <div id="imagePreview" class="mt-2 text-center">
                                        <img id="preview" src="#" alt="Image Preview" style="max-width:100%; height:auto; border-radius:10px; border:1px solid #ddd; padding:5px; box-shadow:0 2px 8px rgba(0,0,0,0.1);" />
                                    </div>

                                </div>
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