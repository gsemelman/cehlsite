<?php
include_once 'common.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$playoff = '';
$currentPLF = 0;

if(isPlayoffs($folder, $playoffMode)){
    $playoff = 'PLF';
    $currentPLF = 1;
}

//$dropLinkPlf = '';
$plfLink = '';
$tmpFolderPlayoff = '';
// TEAM CARD - TROUVÉ SI LES FICHIERS PLAYOFF EXIST
$matches = glob($folder.'*GMs.html');
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

$sort = '';
if(isset($_GET['sort']) || isset($_POST['sort'])) {
	$sort = ( isset($_GET['sort']) ) ? $_GET['sort'] : $_POST['sort'];
	$sort = htmlspecialchars($sort);
}

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

$checkedOnly = 0;
if(isset($_SESSION["only"])) $checkedOnly = $_SESSION["only"];
ob_start();
if(isset($_COOKIE['only'])) $checkedOnly = $_COOKIE['only'];
ob_end_flush();
if($checkedOnly == 1 && $currentPLF == 0) {
	$checked = ' checked="checked"';
	$checkedLink = '?only=0';
}
else {
	$checked = '';
	$checkedLink = '?only=1';
}
if(isset($_GET['only']) || isset($_POST['only'])) {
	$checked = ( isset($_GET['only']) ) ? $_GET['only'] : $_POST['only'];
	$checked = htmlspecialchars($checked);
	if($checked == 1) {
		$checked = ' checked="checked"';
		$checkedLink = '?only=0';
		$_SESSION["only"] = 1;
		setcookie('only', 1, time() + (86400 * 30), "/");
	}
	else {
		$checked = '';
		$checkedLink = '?only=1';
		$_SESSION["only"] = 0;
		setcookie('only', 0, time() + (86400 * 30), "/");
	}
}

$dropLinkOne = '';
if($CurrentPage == 'CareerLeaders' && (isset($_GET['one']) || isset($_POST['one']))) {
	$ctlOneTeams = ( isset($_GET['one']) ) ? $_GET['one'] : $_POST['one'];
	$ctlOneTeams = trim(htmlspecialchars($ctlOneTeams));
	if($ctlOneTeams == 1) $dropLinkOne = 'one=1&';
}

// CRÉATION DE LA LISTE DES ÉQUIPES
$matches = glob($folder.'*'.$playoff.'GMs.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$FnmGMs = $folder.$folderLeagueURL.'GMs.html';
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

include 'nav.php'
?>

<!-- workaround for margins. Fix this properly -->
<div class="container header-content"></div>



