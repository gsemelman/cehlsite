<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

function moneyFormat($money,$lang) {
	if($lang == "fr") $money2 = number_format($money, 0, ',', ' ')." $";
	if($lang == "en") $money2 = "$".number_format($money, 0, '.', ',');
	return $money2;
}

$counterID = $_POST['counterID'];
$contract = $_POST['contract'];
$salary = $_POST['salary'];
$other = $_POST['other'];

include '../config4.php';
include '../login/mysqli.php';

// Datetime
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$TimeZone = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_langue' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_langue = $data['VALUE'];
	}
}
date_default_timezone_set($TimeZone);
$Datetime = date("Y-m-d H:i:s");

// Get EQUIPESIM
$sql = "SELECT `TEAM`, `PLAYERID` FROM `".$db_table."_ufalistsend` WHERE `ID` = '$counterID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$dbTM = $data['TEAM'];
		$playerID = $data['PLAYERID'];
	}
}

// Get User Infos
$sql = "SELECT `EQUIPESIM`, `EMAIL`, `LANGUE`, `NOTIFICATION` FROM `".$db_table."` WHERE `EQUIPESIM`='$dbTM' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$bd_equipesim = $data['EQUIPESIM'];
	$bdEmail = $data['EMAIL'];
	$bdLangue = $data['LANGUE'];
	$bdNotification = $data['NOTIFICATION'];
}
if($bdLangue == "") $bdLangue = $league_langue;

// Update Counter Offer
$contract = mysqli_real_escape_string($con, $contract);
$salary = mysqli_real_escape_string($con, $salary);
$other = mysqli_real_escape_string($con, $other);
$sql = "UPDATE `".$db_table."_ufalistsend` SET `COUNTEROFFER`='1', `COUNTERCONTRACT` = '$contract', `COUNTERSALARY` = '$salary', `COUNTEROTHER` = '$other' WHERE `ID`='$counterID';";
$query = mysqli_query($con, $sql);
// 0: No CounterOffer | 1: CounterOffer done but not view by GM | 2: CounterOffer done and GM view it | 3: GM responded to the CounterOffer

// Email Notification
if($bdEmail != "" && $bdNotification == 1) {
	// Lang File for Email
	include 'langEmail.php';
	
	// Get league name
	$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_name' LIMIT 1";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	if($query){
		while($data = mysqli_fetch_array($query)) {
			$league_name = $data['VALUE'];
		}
	}
	
	// Get Player Stats
	$sql = "SELECT `NAME`, `OVER`, `POSI`, `AGES` FROM `".$db_table."_ufalist` WHERE `INT`='$playerID' LIMIT 1";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	while($data = mysqli_fetch_array($query)) {
		$bd_playerName = $data['NAME'];
		$dbOVER = $data['OVER'];
		if($data['POSI'] == "00") $dbPOSI = "C";
		if($data['POSI'] == "01") $dbPOSI = "LW";
		if($data['POSI'] == "02") $dbPOSI = "RW";
		if($data['POSI'] == "03") $dbPOSI = "D";
		if($data['POSI'] == "04") $dbPOSI = "G";
		$dbAGES = $data['AGES'];
	}
	
	// Send Email
	$to = $bdEmail;
	$subject = "$league_name - $db_email_fa11 - $bd_playerName";
	
	$txt = $league_name."\r\n"; // Ligue
	$txt .= $db_email_fa2.": ".$dbTM."\r\n"; // Your Team: DALLAS
	if($contract > 1) $txtYear = $db_email_fa4;
	else $txtYear = $db_email_fa5;
	$txt .= "\r\n".$db_email_fa12."\r\n"; // Your offer is Accepted
	$txt .= $bd_playerName."\r\n"; // Joe Sakic
	$salary2 = moneyFormat($salary, $bdLangue);
	$txt .= $salary2." / ".$contract." ".$txtYear."\r\n"; // $1,000,000.00 / 1 Year
	$txt .= $other."\r\n";
	$txt .= $db_email_fa6.": ".$dbAGES."\r\n"; // Age
	$txt .= $db_email_fa7.": ".$dbPOSI."\r\n"; // Position
	$txt .= $db_email_fa8.": ".$dbOVER."\r\n"; // OV
	$headers = "From: ufa@fhlsim.com" . "\r\n";
	$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
	mail($to,$subject,$txt,$headers);
}

mysqli_close($con);
?>