<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');

$version = '4.01';
ini_set('arg_separator.output', '&amp;'); // MODE DANS LE URL

include_once 'config.php';

if(file_exists(FS_ROOT.'gmo/config4.php')) {
    require FS_ROOT.'gmo/config4.php';
}
else {
	echo '<a href="install/">Please install the Online GM Editor! - Installer le GM Editor en ligne S.V.P.</a>';
	exit();
}

include FS_ROOT.'gmo/login/mysqli.php';


// Get Infos from database
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$SessionName = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_langue' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_langue = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_name' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_name = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$TimeZone = $data['VALUE'];
	}
}

// Get Colors from database
$sql = "SELECT `NAME`, HEX(`COLOR`) AS COLOR FROM `".$db_table."_colors`";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$tmpName = $data['NAME'];
		$tmpColor = $data['COLOR'];
		$tmpArray = array($tmpName=>$tmpColor);
		if(isset($databaseColors)) $databaseColors = array_merge((array)$databaseColors, (array)$tmpArray);
		else $databaseColors = $databaseColors = $tmpArray;
	}
}

mysqli_close($con);

//session_name($SessionName);
//session_start();

// unset($_SESSION['admin']);

// $_SESSION['login'] = 'WASHINGTON';
// $_SESSION['equipe'] = 'Washington';
// $_SESSION['equipesim'] = 'Washington';
// $_SESSION['int'] = 28;
// $_SESSION['login'] = 'ADMIN';
// $_SESSION['equipe'] = 'ADMIN';
// $_SESSION['equipesim'] = 'ADMIN';
// $_SESSION['int'] = 33;


date_default_timezone_set($TimeZone);
$date_time = date("Y-m-d H:i:s"); // Global variable!

$a = '';

if(isset($_SESSION['int'])) {
	$teamID = $_SESSION['int'];
	$teamFullName = $_SESSION['equipe'];
	$teamFHLSimName = $_SESSION['equipesim'];
	if(isset($_SESSION['int']) && isset($_SESSION['equipe'])) {
		if (isset($_SESSION['int']) AND $_SESSION['equipe'] =="ADMIN"){ 
			$_SESSION['admin'] = 1;
		}
		include 'login/mysqli.php';
		$sql = "UPDATE `".$db_table."` SET `LAST`='".$date_time."' WHERE `INT`='".$teamID."'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		mysqli_close($con);
	}
	else {
		// remove all session variables
		session_unset();
		
		// destroy the session
		session_destroy(); 
	}
}

// LIGUE NAME
if ( !isset($_SESSION['int']) ) {
    include FS_ROOT.'gmo/login/header.php';
    include FS_ROOT.'gmo/login/index.php';
	$a = 1;
}

// ADMIN ZONE
if (isset($_SESSION['admin'])) {
	$db_lang = '';
	include FS_ROOT.'gmo/login/mysqli.php';
	$sql = "SELECT `LANGUE` FROM `".$db_table."` WHERE `INT`='".$teamID."'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	while($data = mysqli_fetch_array($query)) {
		$db_lang = $data['LANGUE'];
	}
	if($db_lang) $league_langue = $db_lang;
	include FS_ROOT.'gmo/admin/index.php';
	$a = 1;
}
// MEMBRE ZONE
if (isset($_SESSION['equipe']) && !isset($_SESSION['admin'])) {
	$db_lang = '';
	include FS_ROOT.'gmo/login/mysqli.php';
	$sql = "SELECT `LANGUE` FROM `".$db_table."` WHERE `INT`='".$teamID."'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	while($data = mysqli_fetch_array($query)) {
		$db_lang = $data['LANGUE'];
	}
	if(isset($_GET['lang']) || isset($_POST['lang'])) {
		$mode = ( isset($_GET['lang']) ) ? $_GET['lang'] : $_POST['lang'];
		$mode = htmlspecialchars($mode);
		
		if($mode == 'fr' || $mode == 'en') {
			if($db_lang == '') {
				if($league_langue == "en") $db_lang = "fr";
				if($league_langue == "fr") $db_lang = "en";
			}
			else {
				$db_lang = $mode;
			}
			$sql = "UPDATE `".$db_table."` SET `LANGUE`='$db_lang' WHERE `INT`='".$teamID."'";
			$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		}
		mysqli_close($con);
	}
	if($db_lang) $league_langue = $db_lang;
	include FS_ROOT.'gmo/membre/lang.php';
	include FS_ROOT.'gmo/membre/index.php';
	$a = 1;
}

//include FS_ROOT.'gmo/footer.php';

echo '</div>';
?>