<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$playerID = $_POST['playerID'];

//include '../config4.php';
//include '../login/mysqli.php';
include '../../config.php';
include FS_ROOT.'common.php';
include GMO_ROOT.'config4.php';

include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $SessionName = $data['VALUE'];
    }
}

session_name($SessionName);
session_start();


//must be logged in with admin privaleges
if(!isAuthenticated()){
    error_log('HTTP/1.1 403 Forbidden', 0);
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}


$sql = "DELETE FROM `".$db_table."_position` WHERE `ID` = '$playerID';";
$query = mysqli_query($con, $sql);

mysqli_close($con);
?>