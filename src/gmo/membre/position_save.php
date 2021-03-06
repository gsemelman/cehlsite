<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once __DIR__ .'/../../config.php';
include FS_ROOT.'common.php';
//include GMO_ROOT.'config4.php';
include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$TimeZone = $data['VALUE'];
	}
}

session_name(SESSION_NAME);
session_start();

//must be logged in with admin privaleges
if(!isAuthenticated()){
    http_response_code(401);
    exit;
}


$teamFHLSimName = $_SESSION['equipesim'];

date_default_timezone_set($TimeZone);
$date_time = date("Y-m-d H:i:s");

$playerName = $_POST['playerName'];
$playerPosBf = $_POST['playerPosBf'];
$playerPosAf = $_POST['playerPosAf'];

if(!$playerName || !$playerName || !$playerPosAf){
    error_log('Caught exception: invalid params', 0);
    header( 'HTTP/1.1 400 internal error' );
    exit;
}

// Add new position change
$playerName = mysqli_real_escape_string($con, $playerName);
$playerPosBf = mysqli_real_escape_string($con, $playerPosBf);
$playerPosAf = mysqli_real_escape_string($con, $playerPosAf);


$query = mysqli_query($con,
    "SELECT 1 FROM `".$db_table."_position` WHERE TEAM='$teamFHLSimName' AND NAME='$playerName' LIMIT 1") 
    or die(mysqli_error($con));;

$isNew = mysqli_num_rows($query) == 0;    

if(!$isNew){
    $sql = "UPDATE `".$db_table."_position` 
    SET DATE = '$date_time',
    POS_BF = '$playerPosBf',
    POS_AF = '$playerPosAf'
    WHERE TEAM='$teamFHLSimName' AND NAME='$playerName'
    ;";

    error_log($sql, 0);
}else{
    $sql = "INSERT INTO `".$db_table."_position` (
    `ID`,
    `DATE`,
    `NAME`,
    `TEAM`,
    `POS_BF`,
    `POS_AF`
    )
    VALUES (
    NULL,
    '$date_time',
    '$playerName',
    '$teamFHLSimName',
    '$playerPosBf',
    '$playerPosAf'
    )
    ;";
}
   


// $sql = "INSERT INTO `".$db_table."_position` (
// `ID`, 
// `DATE`, 
// `NAME`, 
// `TEAM`, 
// `POS_BF`, 
// `POS_AF`
// ) 
// VALUES (
// NULL, 
// '$date_time', 
// '$playerName', 
// '$teamFHLSimName', 
// '$playerPosBf', 
// '$playerPosAf'
// )
// ;";

//$query = mysqli_query($con, $sql) or die(mysqli_error($con));
//$query = mysqli_query($con, $sql);

if (!$query = mysqli_query($con, $sql))
{
    error_log('Caught exception: '.mysqli_error($con), 0);
    
    header( 'HTTP/1.1 500 Server error' );
    
    mysqli_close($con);
    exit();
    
   // die(mysqli_error($con));
}



mysqli_close($con);
?>