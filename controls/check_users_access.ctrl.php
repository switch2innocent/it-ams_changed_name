<?php
session_start();

require_once '../config/dbconn_main.php';
require_once '../objects/users.obj.php';

$databaseMain = new ConnectionMain();
$dbMain = $databaseMain->connect();

$check_access = new Users($dbMain);

$check_access->user_id = $_SESSION['user_id'];
$check_access->system_id = 16;

$check = $check_access->check_access();

if ($check->fetchColumn() > 0) {

    $get = $check_access->get_access();
    $row = $get->fetch(PDO::FETCH_ASSOC);

    $_SESSION['access_user_id'] = $row['access_user_id'];
    $_SESSION['access_role_id'] = $row['role_id'];
    $_SESSION['role'] = $row['role'];

    echo 1;
} else {
    echo 0;
}
