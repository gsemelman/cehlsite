<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once __DIR__ .'/../../config.php';
include FS_ROOT.'common.php';

session_name(SESSION_NAME);
session_start();

if(!isAuthenticated() || !isAdmin()){
    http_response_code(401);
    exit;
}

$playerID = $_POST['playerID'];

//include '../config4.php';
//include '../login/mysqli.php';
//include '../../config.php';
//include GMO_ROOT.'config4.php';

include GMO_ROOT.'login/mysqli.php';

$sql = "DELETE FROM `".$db_table."_position` WHERE `ID` = '$playerID';";
$query = mysqli_query($con, $sql);

mysqli_close($con);
?>