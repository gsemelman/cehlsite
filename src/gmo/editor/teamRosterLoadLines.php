<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once __DIR__ .'/../../config.php';
//include '../config4.php';
include GMO_ROOT.'login/mysqli.php';

$linesGame = 1;
if(isset($_POST['game'])) {
    $linesGame = htmlspecialchars($_POST['game']);
    
}else{
    error_log("unable to load lines without lines game");
    http_response_code(400);
    exit();
}

$linesDay = 0;
if(isset($_POST['day'])) {
    $linesDay = htmlspecialchars($_POST['day']);
    
}else{
    error_log("unable to load lines without game day");
    http_response_code(400);
    exit();
}

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder_lines' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
	    $file_folder_lines = GMO_ROOT.$data['VALUE'];
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

// Read the .lns file and open it
//$filename = "../".$file_folder_lines.$teamFHLSimName.".lns";
//$filename = $file_folder_lines.$teamFHLSimName.".lns";
$filename = $file_folder_lines.$linesDay.'/'.$teamFHLSimName.".lns";
error_log('loading lines: '.$filename);

if(!is_readable($filename)){
    error_log("file no longer exists or cannot be read. cannot load lines");
    http_response_code(500);
    exit();
}

if($linesGame == 1){
    $LNS_FILE_COL = 'LNS_FILE';
    $LNS_DATE_COL = 'LNS_DATE';
}
else if($linesGame == 2){
    $LNS_FILE_COL = 'LNS_FILE2';
    $LNS_DATE_COL = 'LNS_DATE2';
}else{
    error_log("Error loading lines. Invalid game number");
    http_response_code(400);
}


$handle = fopen($filename, "r");
$contents = "";
while (!feof($handle)) {
  $contents .= fread($handle, 8192);
}
fclose ($handle);
$LNS_File = bin2hex($contents);

// Split the LNS File
$LNS_Lineup = substr($LNS_File, 22, 130); // Not Used
$LNS_Status = str_split(substr($LNS_File, 152, 100), 2);
$LNS_Protec = str_split(substr($LNS_File, 252, 200), 4);

// Database : Set LNS_FILE & LNS_DATE
$sql = "UPDATE `$db_table` SET `LNS_FILE`='$LNS_File', `LNS_DATE`='$date_time'  WHERE `INT`='$teamID' LIMIT 1";
//$sql = "UPDATE `$db_table` SET `.$LNS_FILE_COL.`='$LNS_File', `.$LNS_DATE_COL.`='$date_time'  WHERE `INT`='$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
error_log($sql);


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
	//error_log($sql);
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
}

mysqli_close($con);
?>