<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

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

if(isset($_SESSION['equipesim']) && $_SESSION['equipesim'] == "") {
	echo 'You need to be logged to access this page!';
	mysqli_close($con);
	exit();
}
$teamFHLSimName = $_SESSION['equipesim'];

$pollChoice = $_POST['pollChoice'];
$inputPollID = $_POST['inputPollID'];

$sql = "SELECT * FROM `".$db_table."_poll` WHERE `ID` = '$inputPollID'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query) {
	while($data = mysqli_fetch_array($query)) {
		$DB_MOD_VOTES = explode("|$|",$data['VOTES']);
		$DB_MOD_VOTERS = explode("|$|",$data['VOTERS']);
	}
}
for($i=0;$i<count($DB_MOD_VOTES);$i++) {
	if($pollChoice == $i) $DB_MOD_VOTES[$i]++;
}
$NEW_MOD_VOTES = implode('|$|',$DB_MOD_VOTES);
if($DB_MOD_VOTERS[0] != "") {
	$DB_MOD_VOTERS[] = $teamFHLSimName;
	$NEW_MOD_VOTERS = implode('|$|', $DB_MOD_VOTERS);
}
else {
	$NEW_MOD_VOTERS = $teamFHLSimName;
}

$NEW_MOD_VOTERS = mysqli_real_escape_string($con, $NEW_MOD_VOTERS);
$NEW_MOD_VOTES = mysqli_real_escape_string($con, $NEW_MOD_VOTES);
$inputPollID = mysqli_real_escape_string($con, $inputPollID);

$sql = "UPDATE `".$db_table."_poll` SET `VOTES`='$NEW_MOD_VOTES', `VOTERS`='$NEW_MOD_VOTERS'  WHERE `ID` = '$inputPollID'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));

mysqli_close($con);
?>