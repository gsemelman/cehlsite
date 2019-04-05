<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once __DIR__ .'/../../config.php';
include FS_ROOT.'common.php';
//include GMO_ROOT.'config4.php';
include GMO_ROOT.'login/mysqli.php';

if(!isset($_POST['playerName']) || !isset($_POST['type'])){
    error_log("Missing params for release save");
    http_response_code(400);
    exit;
}

if(!$_POST['playerName'] || !$_POST['type']){
    error_log('invalid params for release save', 0);
    http_response_code(400);
    exit;
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

//must be logged in with admin privaleges
if(!isAuthenticated()){
    http_response_code(401);
    exit;
}

date_default_timezone_set($TimeZone);
$date_time = date("Y-m-d H:i:s");

$playerName = $_POST['playerName'];
$type = $_POST['type'];

$playerName = mysqli_real_escape_string($con, $playerName);
$type = mysqli_real_escape_string($con, $type);

$teamId = $_SESSION['teamId'];

error_log("SAVING",0);

$query = mysqli_query($con,
    "SELECT 1 FROM `".$db_table."_player_release` WHERE teamId='$teamId' AND playerName='$playerName' LIMIT 1")
    or die(mysqli_error($con));;

//$type
$exists = mysqli_num_rows($query) > 0;

if($type == 'ADD'){
    if(!$exists){
        $sql = "INSERT INTO `".$db_table."_player_release` (
        `teamId`,
        `playerName`,
        `date`
        )
        VALUES (
        '$teamId',
        '$playerName',
        '$date_time'
        )
        ;";
    }else{
        //player exists
    }
}else if($type == 'CAN'){
    $sql = "DELETE FROM `".$db_table."_player_release` WHERE teamId='$teamId' AND playerName='$playerName' ";
}else{
    error_log("Invalid save type");
    http_response_code(400);
    exit;
}



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