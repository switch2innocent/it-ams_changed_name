<?php

session_start();

require_once '../config/dbconn_main.php';
require_once '../objects/users.obj.php';

$databaseMain = new ConnectionMain();
$dbMain = $databaseMain->connect();

$update_profile = new Users($dbMain);
$get_userPassword = new Users($dbMain);

$update_profile->id = $_POST['user_id'];
$update_profile->firstname = ucwords($_POST['fname']);
$update_profile->lastname = ucwords($_POST['lname']);

//Check if a new password is provided
if (!empty($_POST['pass'])) {
    $update_profile->password = md5($_POST['pass']);
} else {
    //Retain existing password
    $get_userPassword->id = $_POST['user_id'];
    $get = $get_userPassword->get_userPasswords();
    $row = $get->fetch(PDO::FETCH_ASSOC);
    $update_profile->password = $row ? $row['password'] : null;
}

$update = $update_profile->update_profiles();

if ($update) {
    echo 1;
} else {
    echo 0;
}
