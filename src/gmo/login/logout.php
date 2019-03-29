<?php
//include '../../config.php';
//include GMO_ROOT.'config4.php';
//include GMO_ROOT.'mysqli.php';
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
unset($_SESSION['isAdmin']);
$_SESSION['isAdmin'] = false;

$_SESSION['authenticated'] = false;

if(isset($_COOKIE['login'])){
    unset($_COOKIE['login']);
    setcookie('login', '', time() - 3600, '/'); // empty value and old timestamp

}

if(isset($_COOKIE['rememberMe'])){
    unset($_COOKIE['rememberMe']);
    setcookie('rememberMe', '', time() - 3600, '/'); // empty value and old timestamp
}

// remove all session variables
//session_unset();

// destroy the session
//session_destroy(); 
//$target = BASE_URL;
//header("Location: $target");
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>