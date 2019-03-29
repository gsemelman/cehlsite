<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$playerID = $_POST['playerID'];

//include '../config4.php';
//include '../login/mysqli.php';
include '../../config.php';
include GMO_ROOT.'config4.php';
include GMO_ROOT.'login/mysqli.php';

$sql = "DELETE FROM `".$db_table."_position` WHERE `ID` = '$playerID';";
$query = mysqli_query($con, $sql);

mysqli_close($con);
?>