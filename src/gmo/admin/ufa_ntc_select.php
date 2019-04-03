<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$id = $_POST['id'];
$ntc = '';
$ntcTeam = '';

require_once __DIR__ .'/../../config.php';
include '../login/mysqli.php';
$sql = "SELECT `NTC`, `PROTECTED`, `DISABLED` FROM `".$db_table."_ufalist` WHERE `INT` = '$id' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$ntc = $data['NTC'];
		$ntcTeam = $data['PROTECTED'];
		$ntcDisabled = $data['DISABLED'];
	}
	$db = array();
	$db['ntc'] = $ntc;
	$db['ntcTeam'] = $ntcTeam;
	$db['ntcDisabled'] = $ntcDisabled;
	echo json_encode($db);
}

mysqli_close($con);
?>