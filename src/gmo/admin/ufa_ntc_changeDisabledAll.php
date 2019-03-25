<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$ntc = $_POST['ntc']; // 0: Enable - 1: Disable

include '../config4.php';
include '../login/mysqli.php';

$sql = "SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` desc LIMIT 1";
$query = mysqli_query($con, $sql);
while($data = mysqli_fetch_array($query)) {
	$league = $data['LEAGUE'];
}

if($ntc == 0) $sql = "UPDATE `".$db_table."_ufalist` SET `DISABLED`='$ntc' WHERE `LEAGUE` = '$league';";
if($ntc == 1) $sql = "UPDATE `".$db_table."_ufalist` SET `DISABLED`='$ntc' WHERE `LEAGUE` = '$league';";
$query = mysqli_query($con, $sql);
if(!$query) echo mysqli_error($con);

mysqli_close($con);

echo 'done';
?>