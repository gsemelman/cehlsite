<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$protect = $_POST['protect']; // 0: Enable - 1: Disable

include '../config4.php';
include '../login/mysqli.php';

$sql = "SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` desc LIMIT 1";
$query = mysqli_query($con, $sql);
while($data = mysqli_fetch_array($query)) {
	$league = $data['LEAGUE'];
}

if($protect == 0) $sql = "UPDATE `".$db_table."_ufalist` SET `PROTECTED`='', `NTC`='0' WHERE `LEAGUE` = '$league' AND `YEAR` = '';";
if($protect == 1) $sql = "UPDATE `".$db_table."_ufalist` SET `PROTECTED`=`LAST_TEAM`, `NTC`='1' WHERE `LEAGUE` = '$league' AND `YEAR` = '';";
$query = mysqli_query($con, $sql);
if(!$query) echo mysqli_error($con);

mysqli_close($con);

echo 'done';
?>