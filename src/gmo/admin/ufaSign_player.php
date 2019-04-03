<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

function moneyFormat($money,$lang) {
	if($lang == "fr") $money2 = number_format($money, 0, ',', ' ')." $";
	if($lang == "en") $money2 = "$".number_format($money, 0, '.', ',');
	return $money2;
}

$signID = $_POST['signID'];
$playerID = $_POST['playerID'];
$contract = $_POST['contract'];
$salary = $_POST['salary'];

require_once __DIR__ .'/../../config.php';
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

// Trouver tous les équipes qui veullent signer le joueur
$sql = "SELECT `ID`, `TEAM`, `CONTRACT`, `SALARY` FROM `".$db_table."_ufalistsend` WHERE `LEAGUE` = (SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` desc LIMIT 1) AND `PLAYERID` = '$playerID'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	$i = 0;
	while($data = mysqli_fetch_array($query)) {
		$dbID[$i] = $data['ID'];
		$dbTM[$i] = $data['TEAM'];
		//$dbCT[$i] = $data['CONTRACT'];
		//$dbSA[$i] = $data['SALARY'];
		$i++;
	}
}

// Update UFA Signing List
for($i=0;$i<count($dbID);$i++) {
	
	// Get User Infos
	$sql = "SELECT `EQUIPESIM`, `EMAIL`, `LANGUE`, `NOTIFICATION` FROM `".$db_table."` WHERE `EQUIPESIM`='$dbTM[$i]' LIMIT 1";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	while($data = mysqli_fetch_array($query)) {
		$bd_equipesim = $data['EQUIPESIM'];
		$bdEmail = $data['EMAIL'];
		$bdLangue = $data['LANGUE'];
		$bdNotification = $data['NOTIFICATION'];
	}
	if($bdLangue == "") $bdLangue = $league_langue;
	
	if($dbID[$i] == $signID) {
		$sql = "UPDATE `".$db_table."_ufalistsend` SET `APPR`='2', `DATE_APPR` = '$Datetime' WHERE `ID`='$signID';"; // Accepted
		$query = mysqli_query($con, $sql);
		// Update UFA List
		$sql = "UPDATE `".$db_table."_ufalist` SET `TEAM`='$dbTM[$i]', `DATE` = '$Datetime', `YEAR`='$contract', `SALARY`='$salary' WHERE `INT` = '$playerID' ;";
		$query = mysqli_query($con, $sql);
		
		// Si le courriel existe, envoie la notification
		if($bdEmail != "" && $bdNotification == 1) {
			// Inclure le texte selon la langue
			include 'langEmail.php';
			
			// Recherche du nom de la ligue
			$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_name' LIMIT 1";
			$query = mysqli_query($con, $sql) or die(mysqli_error($con));
			if($query){
				while($data = mysqli_fetch_array($query)) {
					$league_name = $data['VALUE'];
				}
			}
			
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
			
			// Envoie du courriel
			$to = $bdEmail;
			$subject = "$league_name - $db_email_fa1 - $bd_playerName";
			
			$txt = $league_name."\r\n"; // Ligue
			$txt .= $db_email_fa2.": ".$dbTM[$i]."\r\n"; // Your Team: DALLAS
			if($contract > 1) $txtYear = $db_email_fa4;
			else $txtYear = $db_email_fa5;
			$txt .= "\r\n".$db_email_fa3."\r\n"; // Your offer is Accepted
			$txt .= $bd_playerName."\r\n"; // Joe Sakic
			$salary2 = moneyFormat($salary, $bdLangue);
			$txt .= $salary2." / ".$contract." ".$txtYear."\r\n"; // $1,000,000.00 / 1 Year
			$txt .= $db_email_fa6.": ".$dbAGES."\r\n"; // Age
			$txt .= $db_email_fa7.": ".$dbPOSI."\r\n"; // Position
			$txt .= $db_email_fa8.": ".$dbOVER."\r\n"; // OV
			$headers = "From: ufa@fhlsim.com" . "\r\n";
			$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
			mail($to,$subject,$txt,$headers);
		}
		
		// Send Winning Team name
		echo $dbTM[$i];
	}
	else {
		$sql = "UPDATE `".$db_table."_ufalistsend` SET `APPR`='1', `DATE_APPR` = '$Datetime' WHERE `ID`='$dbID[$i]';"; // Refused
		$query = mysqli_query($con, $sql);
		
		// Si le courriel existe, envoie la notification
		if($bdEmail != "" && $bdNotification == 1) {
			// Inclure le texte selon la langue
			include 'langEmail.php';
			
			// Recherche du nom de la ligue
			$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_name' LIMIT 1";
			$query = mysqli_query($con, $sql) or die(mysqli_error($con));
			if($query){
				while($data = mysqli_fetch_array($query)) {
					$league_name = $data['VALUE'];
				}
			}
			
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
			
			// Envoie du courriel
			$to = $bdEmail;
			$subject = "$league_name - $db_email_fa1 - $bd_playerName";
			
			$txt = $league_name."\r\n"; // Ligue
			$txt .= $db_email_fa2.": ".$dbTM[$i]."\r\n"; // Your Team: DALLAS
			if($contract > 1) $txtYear = $db_email_fa4;
			else $txtYear = $db_email_fa5;
			$txt .= "\r\n".$db_email_fa9."\r\n"; // Your offer is Accepted
			$txt .= $bd_playerName."\r\n"; // Joe Sakic
			$salary2 = moneyFormat($salary, $bdLangue);
			$txt .= $salary2." / ".$contract." ".$txtYear."\r\n"; // $1,000,000.00 / 1 Year
			$txt .= $db_email_fa6.": ".$dbAGES."\r\n"; // Age
			$txt .= $db_email_fa7.": ".$dbPOSI."\r\n"; // Position
			$txt .= $db_email_fa8.": ".$dbOVER."\r\n"; // OV
			$headers = "From: ufa@fhlsim.com" . "\r\n";
			$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
			mail($to,$subject,$txt,$headers);
		}
	}
	
}

mysqli_close($con);
?>