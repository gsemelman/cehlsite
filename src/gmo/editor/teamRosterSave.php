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
for($i=0;$i<count($playerRank);$i++) {
	$tmpStat = $playerStat[$i];
	$tmpProt = $playerProt[$i];
	$tmpRank = $playerRank[$i];
	$sql = "UPDATE `".$db_table."_players` SET `SAVE_STAT` = '$tmpStat', `SAVE_PROT` = '$tmpProt' WHERE `TEAM` = '$teamRank' AND `RANK` = '$tmpRank'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
}

mysqli_close($con);

echo "done";
?>