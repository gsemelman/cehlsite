<?php
extract($_POST,EXTR_OVERWRITE); // NAME = PHP VARIABLE

require_once __DIR__ .'/../../config.php';
//include GMO_ROOT.'config4.php';
include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$TimeZone = $data['VALUE'];
	}
}
mysqli_close($con);
session_name(SESSION_NAME);
session_start();
// remove all session variables
session_unset();
		
// destroy the session
session_destroy(); 

//include '../config4.php';

// Connexion local
//if($login) {
	$user = strtoupper($user);
	include 'mysqli.php';
	$user = mysqli_real_escape_string($con, $user);
	$sql = "SELECT `INT`, `USER` , `PASS` , `EQUIPE` , `EQUIPESIM`, `ADMIN` FROM `$db_table` WHERE `USER` = '$user'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	if($query){
		while($data = mysqli_fetch_array($query)) {
    		$user = $data['USER'];
			if(md5($pass) == $data['PASS']) {
			    session_name(SESSION_NAME);
				session_start();
				
				$teamID = $data['INT'];
				$_SESSION['authenticated'] = true;
  				$_SESSION['login'] = $user;
				$_SESSION['equipe'] = $data['EQUIPE'];
				$_SESSION['equipesim'] = $data['EQUIPESIM'];
				//$_SESSION['int'] = $data['INT'];
				if(1==$data['ADMIN']){
				   // $_SESSION['admin'] = $data['ADMIN'];
				    $_SESSION['isAdmin'] = true;
				}else{  
				    $_SESSION['isAdmin'] = false;
				}

				setcookie('login', $user, time() + (86400 * 30), "/");
				
				if(isset($rememberMe) && $rememberMe){
				    setcookie('rememberMe', true, time() + (86400 * 30), "/");
				}
				

			}
		}
	}
	mysqli_close($con);
//}

if(isset($_SESSION['login'])){
	date_default_timezone_set($TimeZone);
	// For more information about timezone available : http://php.net/manual/en/timezones.php, copy paste your timezone in the box bellow!
	$date_time = date("Y-m-d H:i:s");
	$serv = $_SERVER["REMOTE_ADDR"];
	include 'mysqli.php';
	$user = mysqli_real_escape_string($con, $user);
	$sql = "UPDATE `$db_table` SET `LAST`='$date_time',`IP`='$serv' WHERE `USER`='$user'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
}

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
//header('Location: ../');
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>