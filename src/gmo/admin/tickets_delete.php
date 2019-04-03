<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once __DIR__ .'/../../config.php';
require_once FS_ROOT.'common.php';


session_name(SESSION_NAME);
session_start();


$teamId = $_POST['teamId'];

//include '../config4.php';
//include '../login/mysqli.php';
require_once __DIR__ .'/../../config.php';
include FS_ROOT.'common.php';
//include GMO_ROOT.'config4.php';


if(isAuthenticated() && isAdmin()){
    include GMO_ROOT.'login/mysqli.php';
    $sql = "UPDATE `".$db_table."` SET TICKETS_REQ = NULL WHERE `INT` = '$teamId';";
    $query = mysqli_query($con, $sql);
    
    mysqli_close($con);
}else{
    error_log('HTTP/1.1 403 Forbidden', 0);
    header( 'HTTP/1.1 403 Forbidden' );
    die('HTTP/1.1 403 Forbidden');
}


?>