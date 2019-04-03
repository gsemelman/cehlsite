<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

function moneyFormat($money,$lang) {
	if($lang == "fr") $money2 = number_format($money, 0, ',', ' ')." $";
	if($lang == "en") $money2 = "$".number_format($money, 0, '.', ',');
	return $money2;
}

$id = $_POST['signID'];

require_once __DIR__ .'/../../config.php';
include '../login/mysqli.php';


session_name(SESSION_NAME);
session_start();
$sessionUser = $_SESSION['login'];

$sql = "SELECT `LANGUE` FROM `".$db_table."` WHERE `USER` = '$sessionUser' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_langue = $data['LANGUE'];
	}
}

$sql = "SELECT `TEAM`, `CONTRACT`, `SALARY`, `OTHER`, `COUNTEROFFER`, `COUNTERCONTRACT`, `COUNTERSALARY`, `COUNTEROTHER` FROM `".$db_table."_ufalistsend` WHERE `LEAGUE` = (SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` desc LIMIT 1) AND `ID` = '$id'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$dbTM = $data['TEAM'];
		$dbCT = $data['CONTRACT'];
		$dbSL = $data['SALARY'];
		$dbOT = $data['OTHER'];
		$dbOFOF = $data['COUNTEROFFER'];
		$dbOFCT = $data['COUNTERCONTRACT'];
		$dbOFSL = $data['COUNTERSALARY'];
		$dbOFOT = $data['COUNTEROTHER'];
	}
}
mysqli_close($con);

$data = array();
$data['tm'] = $dbTM;
$data['ct'] = $dbCT;
$data['sl'] = $dbSL;
$data['ot'] = $dbOT;
$data['ofof'] = $dbOFOF;
$data['ofct'] = $dbOFCT;
$data['ofsl'] = $dbOFSL;
$data['ofot'] = $dbOFOT;

echo json_encode($data);
?>