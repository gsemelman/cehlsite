<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$id = $_POST['id'];
$ntc = $_POST['ntc']; // 0: Delete - 1: Add
$team = $_POST['team'];
$teamList = '';

require_once __DIR__ .'/../../config.php';
include '../login/mysqli.php';

$sql = "SELECT `PROTECTED` FROM `".$db_table."_ufalist` WHERE `INT` = '$id' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$ntcTeam = $data['PROTECTED'];
	}
	
	// Delete
	if($ntc == 0) {
		if(strpos($ntcTeam, $team) !== false) {
			if(strpos($ntcTeam, ',')) {
				$explodedTeam = explode(",", $ntcTeam);
				for($i=0;$i<count($explodedTeam);$i++) {
					if($explodedTeam[$i] == $team) {
						unset($explodedTeam[$i]);
						break 1;
					}
				}
				$teamList = implode(",", $explodedTeam);
			}
		}
	}
	if($ntc == 1) {
		if($ntcTeam == '') {
			$teamList = $team;
		}
		else $teamList = $ntcTeam.','.$team;
	}
	
	$sql = "UPDATE `".$db_table."_ufalist` SET `PROTECTED`='$teamList' WHERE `INT`='$id';";
	$query = mysqli_query($con, $sql);
}

mysqli_close($con);

echo 'done';
?>