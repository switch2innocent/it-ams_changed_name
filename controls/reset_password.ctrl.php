<?php

require_once '../config/dbconn_main.php';
require_once '../objects/users.obj.php';

$databaseMain = new ConnectionMain();
$dbMain = $databaseMain->connect();

$change_pass = new Users($dbMain);

$change_pass->password = md5($_POST['password']);
$change_pass->id = $_POST['id'];

$change = $change_pass->change_password();

if ($change) {
    echo 1;
} else {
    echo 0;
}
