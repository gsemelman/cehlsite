<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

function moneyFormat($money,$lang) {
	if($lang == "fr") $money2 = number_format($money, 0, ',', ' ')." $";
	if($lang == "en") $money2 = "$".number_format($money, 0, '.', ',');
	return $money2;
}

if(isset($_POST['id'])) $id = $_POST['id'];
else exit();

include '../config4.php';
include '../login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$SessionName = $data['VALUE'];
	}
}

session_name($SessionName);
session_start();
$sessionUser = $_SESSION['login'];

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_langue' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_langue = $data['VALUE'];
	}
}
$sql = "SELECT `LANGUE` FROM `".$db_table."` WHERE `USER` = '$sessionUser' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$db_lang = $data['LANGUE'];
	}
}
if(isset($db_lang) && $db_lang != '') $league_langue = $db_lang;

$sql = "SELECT `ID`, `TEAM`, `CONTRACT`, `SALARY`, `OTHER`, `DATE`, `VIEWED`, `COUNTEROFFER`, `COUNTERCONTRACT`, `COUNTERSALARY`, `COUNTEROTHER` FROM `".$db_table."_ufalistsend` WHERE `LEAGUE` = (SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` desc LIMIT 1) AND `PLAYERID` = '$id' AND `APPR`!='1'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	$i = 0;
	while($data = mysqli_fetch_array($query)) {
		$dbID[$i] = $data['ID'];
		$dbTM[$i] = $data['TEAM'];
		$dbCT[$i] = $data['CONTRACT'];
		$dbSL[$i] = $data['SALARY'];
		$dbOT[$i] = $data['OTHER'];
		$dbDT[$i] = $data['DATE'];
		if($data['VIEWED'] == '0') {
			$sql2 = "UPDATE `".$db_table."_ufalistsend` SET `VIEWED`='1' WHERE `ID`='$dbID[$i]';"; // Viewed
			$query2 = mysqli_query($con, $sql2);
		}
		$dbOFOF[$i] = $data['COUNTEROFFER'];
		$dbOFCT[$i] = $data['COUNTERCONTRACT'];
		$dbOFSA[$i] = $data['COUNTERSALARY'];
		$dbOFOT[$i] = $data['COUNTEROTHER'];
		$i++;
	}
}

$sql = "SELECT * FROM `".$db_table."_ufalist` WHERE `INT` = '$id' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		if($data['POSI'] == "00") $dbPOSI = "C";
		if($data['POSI'] == "01") $dbPOSI = "LW";
		if($data['POSI'] == "02") $dbPOSI = "RW";
		if($data['POSI'] == "03") $dbPOSI = "D";
		if($data['POSI'] == "04") $dbPOSI = "G";
		$dbNUMB = $data['NUMB'];
		if($data['HAND'] == "00") $dbHAND = "L";
		if($data['HAND'] == "01") $dbHAND = "R";
		$dbHEIG = $data['HEIG'];
		$height1 = floor($dbHEIG / 12);
		$height2 = $dbHEIG - ($height1 * 12);
		$dbHEIG = $height1.'\''.$height2.'"';
		$dbWEIG = $data['WEIG'];
		$dbAGES = $data['AGES'];
		if($data['COND'] == "00") $dbCOND = "FARM";
		if($data['COND'] == "64") $dbCOND = "PRO"; // Scratch
		if($data['COND'] == "c8") $dbCOND = "PRO";
		$dbINTE = $data['INTE'];
		$dbSPEE = $data['SPEE'];
		$dbSTRE = $data['STRE'];
		$dbENDU = $data['ENDU'];
		$dbDURA = $data['DURA'];
		$dbDISC = $data['DISC'];
		$dbSKAT = $data['SKAT'];
		$dbPASS = $data['PASS'];
		$dbPKCT = $data['PKCT'];
		$dbDEFS = $data['DEFS'];
		$dbOFFS = $data['OFFS'];
		$dbEXPE = $data['EXPE'];
		$dbLEAD = $data['LEAD'];
		$dbSALA = moneyFormat($data['SALA'], $league_langue);
		$dbBIRT = $data['BIRT'];
		$dbOVER = $data['OVER'];
		$dbLAST = $data['LAST_TEAM'];
	}
}
mysqli_close($con);

$data = array();
$data['id'] = $dbID;
$data['tm'] = $dbTM;
$data['ct'] = $dbCT;
$data['sl'] = $dbSL;
$data['ot'] = $dbOT;
$data['dt'] = $dbDT;
$data['ofof'] = $dbOFOF;
$data['ofct'] = $dbOFCT;
$data['ofsa'] = $dbOFSA;
$data['ofot'] = $dbOFOT;

$data['posi'] = $dbPOSI;
$data['numb'] = $dbNUMB;
$data['hand'] = $dbHAND;
$data['heig'] = $dbHEIG;
$data['weig'] = $dbWEIG;
$data['ages'] = $dbAGES;
$data['cond'] = $dbCOND;
$data['inte'] = $dbINTE;
$data['spee'] = $dbSPEE;
$data['stre'] = $dbSTRE;
$data['endu'] = $dbENDU;
$data['dura'] = $dbDURA;
$data['disc'] = $dbDISC;
$data['skat'] = $dbSKAT;
$data['pass'] = $dbPASS;
$data['pkct'] = $dbPKCT;
$data['defs'] = $dbDEFS;
$data['offs'] = $dbOFFS;
$data['expe'] = $dbEXPE;
$data['lead'] = $dbLEAD;
$data['sala'] = $dbSALA;
$data['birt'] = $dbBIRT;
$data['over'] = $dbOVER;
$data['last'] = $dbLAST;
echo json_encode($data);
?>