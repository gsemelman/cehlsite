<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'lang.php';
include_once 'config.php';
include_once 'common.php';

if(!HTTPS_REQUIRED){
   //checkHttps();
}

//start session
session_name('GMO');
session_start();


include 'auth.php';
//remember me basic.. need to make this better.
// if(!isAuthenticated()){
//     if(!empty($_COOKIE['login']) && !empty($_COOKIE['rememberMe'])){
       
//         include FS_ROOT.'gmo/config4.php';
//         include FS_ROOT.'gmo/login/mysqli.php';

//         $sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
//         $query = mysqli_query($con, $sql) or die(mysqli_error($con));
//         if($query){
//             while($data = mysqli_fetch_array($query)) {
//                 $SessionName = $data['VALUE'];
//             }
//         }
//         $sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
//         $query = mysqli_query($con, $sql) or die(mysqli_error($con));
//         if($query){
//             while($data = mysqli_fetch_array($query)) {
//                 $TimeZone = $data['VALUE'];
//             }
//         }
        
//         $user = strtoupper($_COOKIE['login']);
//         $user = mysqli_real_escape_string($con, $user);
//         $sql = "SELECT `INT`, `USER` , `PASS` , `EQUIPE` , `EQUIPESIM`, `ADMIN` FROM `$db_table` WHERE `USER` = '$user'";
//         $query = mysqli_query($con, $sql) or die(mysqli_error($con));
//         if($query){
//             while($data = mysqli_fetch_array($query)) {
//                // session_name($SessionName);
//                 //session_start();
//                 $_SESSION['login'] = $user;
//                 $_SESSION['equipe'] = $data['EQUIPE'];
//                 $_SESSION['equipesim'] = $data['EQUIPESIM'];
//                 $_SESSION['int'] = $data['INT'];
//                 if(1==$data['ADMIN']){
//                     // $_SESSION['admin'] = $data['ADMIN'];
//                     $_SESSION['isAdmin'] = true;
//                 }else{
//                     $_SESSION['isAdmin'] = false;
//                 }
//                 $_SESSION['authenticated'] = true;

//             }
            
//             if(isset($_SESSION['login'])){
//                 date_default_timezone_set($TimeZone);
//                 // For more information about timezone available : http://php.net/manual/en/timezones.php, copy paste your timezone in the box bellow!
//                 $date_time = date("Y-m-d H:i:s");
//                 $serv = $_SERVER["REMOTE_ADDR"];
//                 $user = mysqli_real_escape_string($con, $user);
//                 $sql = "UPDATE `$db_table` SET `LAST`='$date_time',`IP`='$serv' WHERE `USER`='$user'";
//                 $query = mysqli_query($con, $sql) or die(mysqli_error($con));
//             }else{
//                 unset($_COOKIE['login']);
//                 setcookie('login', '', time() - 3600, '/'); // empty value and old timestamp
//                 unset($_COOKIE['rememberMe']);
//                 setcookie('rememberMe', '', time() - 3600, '/'); // empty value and old timestamp
//             }
//         }
//         mysqli_close($con);
//     }else{
        
//     }
// }


// if(isset($secured) && $secured){
//     if ( isset( $_SESSION['user_id'] ) ) {
//         // Grab user data from the database using the user_id
//         // Let them access the "logged in only" pages
//     } else {
//         // Redirect them to the login page
//         header("Location: http://www.yourdomain.com/login.php");
//     }
// }


//TRACK TEAM STATE
$currentTeam = '';
if(isset($_GET['team']) || isset($_POST['team'])) {
    $currentTeam = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
    $currentTeam = htmlspecialchars($currentTeam);
    
    $_SESSION["team"] = $currentTeam;
    setcookie('team', $currentTeam, time() + (86400 * 30), "/");
}
else {
    if(isset($_SESSION["team"])) $currentTeam = $_SESSION["team"];
    ob_start();
    if(isset($_COOKIE['team'])) $currentTeam = $_COOKIE['team'];
    ob_end_flush();
}


//TRACK PLAYOFF STATE
$playoff = '';
$currentPLF = 0;

if(isPlayoffs(TRANSFER_DIR, LEAGUE_MODE)){
    $playoff = 'PLF';
    $currentPLF = 1;
}

//$dropLinkPlf = '';
$plfLink = '';
$tmpFolderPlayoff = '';
// TEAM CARD - SEE IF PLAYOFFS GMS FILE EXISTS
$matches = glob(TRANSFER_DIR.'*GMs.html');
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	$tmpFolderPlayoff = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
	break 1;
}
//if($CurrentPage == 'fiche') {
if($CurrentPage == 'Overview') {
	if(substr_count($tmpFolderPlayoff, 'PLF')) {
		$playoff = 'PLF';
		$currentPLF = 1;
		$plfLink = '?plf=1';
	}
}

if(isset($_GET['plf']) || isset($_POST['plf'])) {
	$currentPLF = ( isset($_GET['plf']) ) ? $_GET['plf'] : $_POST['plf'];
	$currentPLF = htmlspecialchars($currentPLF);
	if($currentPLF == 1) {
		$playoff = 'PLF';
		//$dropLinkPlf = 'plf=1&';
		$plfLink = '?plf=1';
	}
	if($currentPLF == 0) $playoff = '';
}
if(isset($_GET['rnd']) || isset($_POST['rnd'])) {
	$playoff = 'PLF';
	$currentPLF = 1;
	//$dropLinkPlf = 'plf=1&';
	$plfLink = '?plf=1';
}

//SORTING (FACTOR THIS OUT)
$sort = '';
if(isset($_GET['sort']) || isset($_POST['sort'])) {
	$sort = ( isset($_GET['sort']) ) ? $_GET['sort'] : $_POST['sort'];
	$sort = htmlspecialchars($sort);
}

$dropLinkOne = '';
if($CurrentPage == 'CareerLeaders' && (isset($_GET['one']) || isset($_POST['one']))) {
	$ctlOneTeams = ( isset($_GET['one']) ) ? $_GET['one'] : $_POST['one'];
	$ctlOneTeams = trim(htmlspecialchars($ctlOneTeams));
	if($ctlOneTeams == 1) $dropLinkOne = 'one=1&';
}

// CREATE TEAM LIST
$matches = glob(TRANSFER_DIR.'*'.$playoff.'GMs.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$FnmGMs = TRANSFER_DIR.$folderLeagueURL.'GMs.html';
$i = 0;
if(file_exists($FnmGMs)) {
	$tableau = file($FnmGMs);
	/* while(list($cle,$val) = each($tableau)) { */
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'HREF') && !substr_count($val, '<BR>')) {
			$gmequipe[$i] = trim(substr($val, 0, 10));
			if($currentTeam == '' && $i == 0) $currentTeam = $gmequipe[$i];
			$i++;
		}
	}
}
else echo $allFileNotFound.' - '.$FnmGMs;


$farm = '';
$dropLinkFarm = '';
$currentFarm = 0;
if(isset($_GET['s']) || isset($_POST['s'])) {
	$currentFarm = ( isset($_GET['s']) ) ? $_GET['s'] : $_POST['s'];
	$currentFarm = htmlspecialchars($currentFarm);
	if($currentFarm == 1) {
		$farm = 'Farm';
		//if($CurrentPage == 'Standings') $CurrentTitle = $standingTitleFarm;
		//if($CurrentPage == 'OverallStandings') $CurrentTitle = $standingTitleFarm;
		if($CurrentPage == 'Leaders') $CurrentTitle = $leaderTitleFarm;
		$dropLinkFarm = 's=1&';
	}
}

if(isset($skipNav) && !$skipNav){
 
}else{
    include 'nav.php';
//     echo '<div class="header-content top-container"></div>';
}

?>

<!-- workaround for margins. Fix this properly -->
<!-- <div class="header-content top-container"></div> -->




