<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$playerID = $_POST['playerID'];

//include '../config4.php';
//include '../login/mysqli.php';
require_once __DIR__ .'/../../config.php';
include FS_ROOT.'common.php';
//include GMO_ROOT.'config4.php';


session_name(SESSION_NAME);
session_start();


//must be logged in with admin privaleges
if(!isAuthenticated()){
    http_response_code(401);
    exit;
}

include GMO_ROOT.'login/mysqli.php';

$sql = "DELETE FROM `".$db_table."_position` WHERE `ID` = '$playerID';";
$query = mysqli_query($con, $sql);

mysqli_close($con);
?>