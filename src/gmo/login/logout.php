<?php
//include '../../config.php';
//include FS_ROOT.'gmo/config4.php';
//include FS_ROOT.'gmo/mysqli.php';
//include FS_ROOT.'config.php';

include '../config4.php';
include 'mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$SessionName = $data['VALUE'];
	}
}
mysqli_close($con);
session_name($SessionName);
session_start();

unset($_SESSION['login']);
unset($_SESSION['equipe']);
unset($_SESSION['equipesim']);
unset($_SESSION['int']);
unset($_SESSION['admin']);

// remove all session variables
//session_unset();

// destroy the session
//session_destroy(); 
//$target = BASE_URL;
//header("Location: $target");
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>