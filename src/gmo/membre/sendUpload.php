<?php
// ADD SOMETHING TO CHECK IF THE PLAYERS ARE WELL ASSIGNED. Suspended & Injured in Scratches.

error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once __DIR__ .'/../../config.php';
//include '../config4.php';
include '../login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder_lines' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$file_folder_lines = $data['VALUE'];
	}
}

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$TimeZone = $data['VALUE'];
	}
}

session_name(SESSION_NAME);
session_start();

if(isset($_SESSION['equipesim']) && $_SESSION['equipesim'] == "") {
	echo 'You need to be logged to access this page!';
	mysqli_close($con);
	exit();
}
$teamID = $_SESSION['teamId'];
$teamFHLSimName = $_SESSION['equipesim'];

date_default_timezone_set($TimeZone);
$date_time = date("Y-m-d H:i:s");

// Get the LNS File
$LNS_File = $_POST['LNS_File'];

// Split the LNS File
$LNS_Lineup = substr($LNS_File, 22, 130);
$LNS_Status = str_split(substr($LNS_File, 152, 100), 2);
$LNS_Protec = str_split(substr($LNS_File, 252, 200), 4);

// Database : Set LNS_FILE & LNS_DATE
$sql = "UPDATE `$db_table` SET `LNS_FILE`='$LNS_File', `LNS_DATE`='$date_time'  WHERE `INT`='$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));

// Database : Set SAVE_STAT & SAVE_PROT
$sql = "SELECT `RANK` FROM `$db_table` WHERE `INT`='$teamID'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$teamRank = $data['RANK'];
}
for($i=0;$i<count($LNS_Status);$i++) {
	$tmpStat = hexdec($LNS_Status[$i]);
	$tmpProt = 0;
	if($LNS_Protec[$i] == "ffff") $tmpProt = 1;
	$sql = "UPDATE `".$db_table."_players` SET `SAVE_STAT`='$tmpStat', `SAVE_PROT`='$tmpProt'  WHERE `TEAM` = '$teamRank' AND `RANK` = '$i'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
}

// Database : Update the line counter
$server_file = "../".$file_folder_lines.$teamFHLSimName.".lns";
if( !is_readable($server_file) ) {
	$sql = "UPDATE `$db_table` SET `SEND` = `SEND` + 1 WHERE `INT` = '$teamID' LIMIT 1";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
}

mysqli_close($con);

// Saving the LNS File to the server
$output = pack('H*', $LNS_File);
$newfile = "../".$file_folder_lines.$teamFHLSimName.".lns";
$file = fopen ($newfile, "w");
fwrite($file, $output);
fclose ($file);

?>