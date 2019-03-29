<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$colorsID = json_decode($_POST['ID']);
$colorsValue = json_decode($_POST['VALUE']);

include '../../config.php';
include GMO_ROOT.'config4.php';
include GMO_ROOT.'login/mysqli.php';

for($i=0;$i<count($colorsID);$i++) {
	$id = mysqli_real_escape_string($con, $colorsID[$i]);
	$value = mysqli_real_escape_string($con, $colorsValue[$i]);
	$sql = "UPDATE `".$db_table."_colors` SET `COLOR`=UNHEX('$value') WHERE `NAME`='$id'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
}
mysqli_close($con);
?>