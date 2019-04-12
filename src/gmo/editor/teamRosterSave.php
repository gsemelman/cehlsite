<?php

require_once __DIR__ .'/../../config.php';
//include '../config4.php';
include GMO_ROOT.'login/mysqli.php';

session_name(SESSION_NAME);
session_start();
$teamID = $_SESSION['teamId'];

$sql = "SELECT `RANK` FROM `$db_table` WHERE `INT` = '$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$teamRank = $data['RANK'];
	}
}

$playerStat = json_decode($_POST['stat']);
$playerRank = json_decode($_POST['rank']);
$playerProt = json_decode($_POST['prot']);
$linesGame = json_decode($_POST['game']);

if(empty($linesGame) || empty($playerRank) || empty($playerProt) || empty($linesGame) ){
    error_log("Error Saving lines. Not all parameters passed in");
    http_response_code(400);
}

if($linesGame == 1){
    $SAVE_STAT = 'SAVE_STAT';
    $SAVE_PROT = 'SAVE_PROT';
}
else if($linesGame == 2){
    $SAVE_STAT = 'SAVE_STAT2';
    $SAVE_PROT = 'SAVE_PROT2';
}else{
    error_log("Error Saving lines. Invalid game number");
    http_response_code(400);
}

for($i=0;$i<count($playerRank);$i++) {
	$tmpStat = $playerStat[$i];
	$tmpProt = $playerProt[$i];
	$tmpRank = $playerRank[$i];
	//$sql = "UPDATE `".$db_table."_players` SET `SAVE_STAT` = '$tmpStat', `SAVE_PROT` = '$tmpProt' WHERE `TEAM` = '$teamRank' AND `RANK` = '$tmpRank'";
	$sql = "UPDATE `".$db_table."_players` SET `$SAVE_STAT` = '$tmpStat', `$SAVE_PROT` = '$tmpProt' WHERE `TEAM` = '$teamRank' AND `RANK` = '$tmpRank'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
}

mysqli_close($con);

echo "done";
?>