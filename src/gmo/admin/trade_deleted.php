<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

function moneyFormat($money,$lang) {
	if($lang == "fr") $money2 = number_format($money, 0, ',', ' ')." $";
	if($lang == "en") $money2 = "$".number_format($money, 0, '.', ',');
	return $money2;
}

$id = $_POST['id'];

require_once __DIR__ .'/../../config.php';
include '../login/mysqli.php';

$id = mysqli_real_escape_string($con, $id);

//////////////////
// NOTIFICATION //
//////////////////
$sql = "SELECT * FROM `".$db_table."_trade` WHERE `INT`='$id' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$bd_Team1 = $data['TEAM1'];
	$bd_Team2 = $data['TEAM2'];
	$bd_Player1 = explode("|", $data['PLAYER1']);
	$bd_Player2 = explode("|", $data['PLAYER2']);
	$bd_Prospect1 = explode("|", $data['PROSPECT1']);
	$bd_Prospect2 = explode("|", $data['PROSPECT2']);
	$bd_Draft1 = explode("|", $data['DRAFT1']);
	$bd_Draft2 = explode("|", $data['DRAFT2']);
	$bd_Cash1 = $data['CASH1'];
	$bd_Cash2 = $data['CASH2'];
}

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_langue' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_langue = $data['VALUE'];
	}
}

$sql = "SELECT `EQUIPESIM`, `EMAIL`, `LANGUE`, `NOTIFICATION` FROM `".$db_table."` WHERE `EQUIPESIM`='$bd_Team1' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$bd_Team_Equipesim[0] = $data['EQUIPESIM'];
	$bd_Team_Email[0] = $data['EMAIL'];
	$bd_Team_Langue[0] = $data['LANGUE'];
	$bd_Team_Notification[0] = $data['NOTIFICATION'];
}
if($bd_Team_Email[0] == "") $bd_Team_Email[0] = $league_langue;

$sql = "SELECT `EQUIPESIM`, `EMAIL`, `LANGUE`, `NOTIFICATION` FROM `".$db_table."` WHERE `EQUIPESIM`='$bd_Team2' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$bd_Team_Equipesim[1] = $data['EQUIPESIM'];
	$bd_Team_Email[1] = $data['EMAIL'];
	$bd_Team_Langue[1] = $data['LANGUE'];
	$bd_Team_Notification[1] = $data['NOTIFICATION'];
}
if($bd_Team_Email[1] == "") $bd_Team_Email[1] = $league_langue;

for($x=0;$x<2;$x++) {
	// Si le courriel existe et les notifications sont authorisées, envoie la notification
	if($bd_Team_Email[$x] != "" && $bd_Team_Notification[$x] == 1) {
		// Inclure le texte selon la langue
		$bdLangue = $bd_Team_Langue[$x];
		include 'langEmail.php';
		
		// Recherche du nom de la ligue
		$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_name' LIMIT 1";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		if($query){
			while($data = mysqli_fetch_array($query)) {
				$league_name = $data['VALUE'];
			}
		}
		
		// Envoie du courriel
		$to = $bd_Team_Email[$x];
		$subject = "$league_name - $db_email_trade1 : $bd_Team1 $db_email_trade2 $bd_Team2";
		$txt = $db_email_trade5."\r\n"; // Sorry, Your trade is refused!
		
		$txt .= "\r\n".$db_email_trade3." ".$bd_Team2."\r\n"; // To DALLAS
		// Joueurs Team 1
		if($bd_Player1[0] != "") {
			for($i=0;$i<count($bd_Player1);$i++) {
				$txt .= $bd_Player1[$i]."\r\n";
			}
		}
		// Prospect Team 1
		if($bd_Prospect1[0] != "") {
			for($i=0;$i<count($bd_Prospect1);$i++) {
				$txt .= $bd_Prospect1[$i]."\r\n";
			}
		}
		// Draft Team 1
		if($bd_Draft1[0] != "") {
			for($i=0;$i<count($bd_Draft1);$i++) {
				$txt .= $bd_Draft1[$i]."\r\n";
			}
		}
		// Cash Team 1
		if($bd_Cash1 != "" && $bd_Cash1 != "0") {
			$bd_Cash1b = moneyFormat($bd_Cash1, $bdLangue);
			$txt .= $bd_Cash1b."\r\n";
		}
		
		$txt .= "\r\n".$db_email_trade3." ".$bd_Team1."\r\n"; // To DALLAS
		// Joueurs Team 2
		if($bd_Player2[0] != "") {
			for($i=0;$i<count($bd_Player2);$i++) {
				$txt .= $bd_Player2[$i]."\r\n";
			}
		}
		// Prospect Team 2
		if($bd_Prospect2[0] != "") {
			for($i=0;$i<count($bd_Prospect2);$i++) {
				$txt .= $bd_Prospect2[$i]."\r\n";
			}
		}
		// Draft Team 2
		if($bd_Draft2[0] != "") {
			for($i=0;$i<count($bd_Draft2);$i++) {
				$txt .= $bd_Draft2[$i]."\r\n";
			}
		}
		// Cash Team 2
		if($bd_Cash2 != "" && $bd_Cash2 != "0") {
			$bd_Cash2b = moneyFormat($bd_Cash2, $bdLangue);
			$txt .= $bd_Cash2b."\r\n";
		}
		
		$headers = "From: trade@fhlsim.com" . "\r\n";
		$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
		$success = mail($to,$subject,$txt,$headers);
		if (!$success) {
			$errorMessage = error_get_last()['message'];
		}
	}
}

$sql = "DELETE FROM `".$db_table."_trade` WHERE `INT` = '$id';";
$query = mysqli_query($con, $sql);

mysqli_close($con);

echo 'done';
?>