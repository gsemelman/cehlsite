<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$question = $_POST['question'];
$z = $_POST['z'];
$id = $_POST['id'];
$date_end = $_POST['datetime'];
$options = json_decode($_POST['value']);
$optionsSeperated = implode("|$|", $options);
$optionsCountSeperator = count($options)-1;
$optionSeperator = str_repeat("|$|", $optionsCountSeperator);

require_once __DIR__ .'/../../config.php';
//include '../config4.php';
include '../login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$TimeZone = $data['VALUE'];
	}
}

date_default_timezone_set($TimeZone);
$Date = date("Y-m-d H:i:s");

$date_end = mysqli_real_escape_string($con, $date_end);
$question = mysqli_real_escape_string($con, $question);
$optionsSeperated = mysqli_real_escape_string($con, $optionsSeperated);

if($z == 0) {
$sql = "INSERT INTO `".$db_table."_poll` (
`ID`, 
`QUESTION`, 
`DATE`, 
`OPTIONS`, 
`VOTES`, 
`VOTERS`,
`DATE_END`
) 
VALUES (
NULL, 
'$question', 
'$Date', 
'$optionsSeperated', 
'$optionSeperator', 
'',
'$date_end'
)
;";
	$query = mysqli_query($con, $sql);
	echo mysqli_insert_id($con);
}
if($z == 1) {
	$sql = "UPDATE `".$db_table."_poll` SET 
	`QUESTION`='$question', 
	`DATE`='$Date', 
	`OPTIONS`='$optionsSeperated', 
	`VOTES`='$optionSeperator', 
	`VOTERS`='', 
	`DATE_END`='$date_end' 
	WHERE `ID`='$id';";
	$query = mysqli_query($con, $sql);
	echo $id;
}

mysqli_close($con);
?>