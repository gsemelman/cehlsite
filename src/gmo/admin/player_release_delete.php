<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once __DIR__ .'/../../config.php';
require_once FS_ROOT.'common.php';


session_name(SESSION_NAME);
session_start();


$playerReleaseId = $_POST['id'];


if(isAuthenticated() && isAdmin()){
    include GMO_ROOT.'login/mysqli.php';
    $sql = "DELETE FROM `".$db_table."_player_release` WHERE `id` = '$playerReleaseId';";
    $query = mysqli_query($con, $sql);
    
    mysqli_close($con);
}else{
    error_log('HTTP/1.1 403 Forbidden', 0);
    header( 'HTTP/1.1 403 Forbidden' );
    die('HTTP/1.1 403 Forbidden');
}


?>