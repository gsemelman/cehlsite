<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

session_name('GMO');
session_start();


$teamId = $_POST['teamId'];

//include '../config4.php';
//include '../login/mysqli.php';
include '../../config.php';
include FS_ROOT.'common.php';
include FS_ROOT.'gmo/config4.php';


if(isAuthenticated() && isAdmin()){
    include FS_ROOT.'gmo/login/mysqli.php';
    $sql = "UPDATE `".$db_table."` SET TICKETS_REQ = NULL WHERE `INT` = '$teamId';";
    $query = mysqli_query($con, $sql);
    
    mysqli_close($con);
}else{
    error_log('HTTP/1.1 403 Forbidden', 0);
    header( 'HTTP/1.1 403 Forbidden' );
    die('HTTP/1.1 403 Forbidden');
}


?>