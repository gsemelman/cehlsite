<?php

require_once __DIR__ .'/../../config.php';
//include '../config4.php';
include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$TimeZone = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder_lines' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
	    $file_folder_lines = GMO_ROOT.$data['VALUE'];
	}
}

session_name(SESSION_NAME);
session_start();
$teamID = $_SESSION['teamId'];
$teamFHLSimName = $_SESSION['equipesim'];
if($teamFHLSimName == '') {
	echo 'No Filename detected! File not saved!';
	error_log('No Filename detected! File not saved!',0);
	exit();
}


// Team Position
$sql = "SELECT `RANK` FROM `$db_table` WHERE `INT` = '$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$teamRank = $data['RANK'];
	}
	$LNSTMRank = dechex($teamRank);
	if(strlen($LNSTMRank) == 1) $LNSTMRank = "0".$LNSTMRank;
}

$LNSPasswd = $_POST['passwd']; // Password
$LNSLineup = $_POST['lineup']; // Lineup
$linesGame = $_POST['game']; // Lineup

error_log('pass='.$LNSPasswd);

//setting line time

if($linesGame == 1){
    $L_FILE = 'LNS_FILE';
    $L_DATE = 'LNS_DATE';
    $S_STAT = 'SAVE_STAT';
    $S_PROT = 'SAVE_PROT';
}
if($linesGame == 2){
    $L_FILE = 'LNS_FILE2';
    $L_DATE = 'LNS_DATE2';
    $S_STAT = 'SAVE_STAT2';
    $S_PROT = 'SAVE_PROT2';
}

// Player Stats & Player Protection
$LNSStatPl = "";
$LNSProtec = "";
for($i=0;$i<50;$i++) {
	//$sql = "SELECT `SAVE_STAT`, `SAVE_PROT` FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' AND `RANK` = '$i'";
    $sql = "SELECT `$S_STAT` AS SAVE_STAT, `$S_PROT` AS SAVE_PROT FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' AND `RANK` = '$i'";
    error_log($sql);
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	if(mysqli_num_rows($query) != 0) {
		while($data = mysqli_fetch_array($query)) {
			$tmpPlayerStat = dechex($data['SAVE_STAT']);
			if(strlen($tmpPlayerStat) == 1) $LNSStatPl .= "0".$tmpPlayerStat;
			else $LNSStatPl .= $tmpPlayerStat;
			
			if($data['SAVE_PROT'] == 1) $LNSProtec .= "FFFF";
			else $LNSProtec .= "0000";
		}
	}
	else {
		$LNSStatPl .= "00";
		$LNSProtec .= "0000";
	}
}

// Creating LNS File
$LNS_File = $LNSTMRank.$LNSPasswd.$LNSLineup.strtoupper($LNSStatPl).$LNSProtec;

date_default_timezone_set($TimeZone);
$date_time = date("Y-m-d H:i:s");

//$sql = "UPDATE `$db_table` SET `LNS_DATE` = '$date_time', `LNS_FILE` = '$LNS_File' WHERE `INT` = '$teamID' LIMIT 1";
$sql = "UPDATE `$db_table` SET `$L_DATE` = '$date_time', `$L_FILE` = '$LNS_File' WHERE `INT` = '$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));

// Update the LNS count
//$server_file = "../".$file_folder_lines.$teamFHLSimName.".lns";
$server_file = $file_folder_lines.$teamFHLSimName.".lns";
if( !is_readable($server_file) ) {
	$sql = "UPDATE `$db_table` SET `SEND` = `SEND` + 1 WHERE `INT` = '$teamID' LIMIT 1";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
}

error_log($file_folder_lines,0);
// Saving the LNS File to the server
$output = pack('H*', $LNS_File);
//$newfile = "../".$file_folder_lines.$teamFHLSimName.".lns";

if($LNSGame == 1){
    $newfile = $file_folder_lines.$teamFHLSimName.".lns";
}else{
    $newfile = $file_folder_lines.'game2/'.$teamFHLSimName.".lns";
}

//$newfile = $file_folder_lines.$teamFHLSimName.".lns";
$file = fopen ($newfile, "w");
fwrite($file, $output);
fclose ($file);

mysqli_close($con);

echo "done";
?>