<?php
include 'common.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$playoff = '';
$currentPLF = 0;
$dropLinkPlf = '';
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
if($CurrentPage == 'fiche') {
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
		$dropLinkPlf = 'plf=1&';
		$plfLink = '?plf=1';
	}
	if($currentPLF == 0) $playoff = '';
}
if(isset($_GET['rnd']) || isset($_POST['rnd'])) {
	$playoff = 'PLF';
	$currentPLF = 1;
	$dropLinkPlf = 'plf=1&';
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

// $link = '';
// if($currentTeam != '') {
// 	$team2 = '';
// 	if(substr_count($currentTeam, ' ')) $team2 = substr($currentTeam, 0, strpos($currentTeam, ' '));
// 	else $team2 = $currentTeam;
// 	$link = '#'.$team2;
// }

$farm = '';
$dropLinkFarm = '';
$currentFarm = 0;
if(isset($_GET['s']) || isset($_POST['s'])) {
	$currentFarm = ( isset($_GET['s']) ) ? $_GET['s'] : $_POST['s'];
	$currentFarm = htmlspecialchars($currentFarm);
	if($currentFarm == 1) {
		$farm = 'Farm';
		if($CurrentPage == 'Standings') $CurrentTitle = $standingTitleFarm;
		if($CurrentPage == 'OverallStandings') $CurrentTitle = $standingTitleFarm;
		if($CurrentPage == 'Leaders') $CurrentTitle = $leaderTitleFarm;
		$dropLinkFarm = 's=1&';
	}
}

//if($currentFarm == 0 && $CurrentPage != 'ChatBox' && $CurrentPage != 'Unassigned' && $CurrentPage != 'games' && $CurrentPage != 'Injury' && $CurrentPage != 'CareerStats' && $CurrentPage != 'CareerStatsPlayer' && $CurrentPage != 'SearchPlayers' && $CurrentPage != 'ComparePlayers') $CurrentTitle .= ' - '.$currentTeam;
if($CurrentPage == 'games') $folder .= $folderGames;

// $width = 555;
// if($CurrentPage == 'Rosters' || $CurrentPage == 'StandingsTree') $width = 800;
// if($CurrentPage == 'Unassigned' || $CurrentPage == 'OverallStandings' || $CurrentPage == 'StandingsTree' || $CurrentPage == 'Standings' || $CurrentPage == 'Waivers' || $CurrentPage == 'Transact' || $CurrentPage == 'Schedule' || $CurrentPage == 'games' || $CurrentPage == 'Leaders' || $CurrentPage == 'GMs' || $CurrentPage == 'Coaches' || $CurrentPage == 'Injury' || $CurrentPage == 'Individual' || $CurrentPage == 'TeamStats' || $CurrentPage == 'TodayGames') $link = '';
?>
<?php include 'nav.php' ?>

<div class="container header-content">

<?php

// Avoir l'adresse de base du site internet (base address)
if(isset($_SERVER['HTTPS'])){
	$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}
else{
	$protocol = 'http';
}
$protocol .= "://" . $_SERVER['HTTP_HOST'];

if($CurrentPage == 'Schedule' && $currentPLF == 1 && isset($existRnd)) {
	if($existRnd >= 4) echo ' - <a href="'.$CurrentPage.'.php?plf=1&rnd=4" class="lien-noir">'.$scheldRound.' 4</a>';
	if($existRnd >= 3) echo ' - <a href="'.$CurrentPage.'.php?plf=1&rnd=3" class="lien-noir">'.$scheldRound.' 3</a>';
	if($existRnd >= 2) echo ' - <a href="'.$CurrentPage.'.php?plf=1&rnd=2" class="lien-noir">'.$scheldRound.' 2</a>';
	if($existRnd >= 1) echo ' - <a href="'.$CurrentPage.'.php?plf=1&rnd=1" class="lien-noir">'.$scheldRound.' 1</a>';
}

if($CurrentPage == 'Rosters' || $CurrentPage == 'LinkedRosters' || $CurrentPage == 'Finance' || $CurrentPage == 'Lines' || $CurrentPage == 'Futures' || $CurrentPage == 'fiche' || $CurrentPage == 'TeamScoring' || ($CurrentPage == 'Schedule' && $checked ==' checked="checked"')) {
	$CurrentTitle .= ' - '.$currentTeam;
	
	//team logo links
	echo '<div class="row">';
		echo '<div id="logo-header" class="col logo-header logo-header-description">';
		for($i=0;$i<count($gmequipe);$i++) {
			$matches = glob($folderTeamLogos.strtolower($gmequipe[$i]).'.*');
			$teamImage = '';
			for($j=0;$j<count($matches);$j++) {
				$teamImage = $matches[$j];
				break 1;
			}
			echo '<a id="'.$gmequipe[$i].'" href="'.$CurrentPage.'.php?'.$dropLinkPlf.$dropLinkFarm.$dropLinkOne.'team='.$gmequipe[$i].'">';

			echo '<img src="'.$teamImage.'" width=55>';
			
			echo '</a>';
		}
		echo '</div>';
	echo '</div>';
	
	//team nav
	echo '<nav id ="header-nav" class="nav nav-justified-center justify-content-center">';
		echo'<a class="nav-item nav-link" href="TeamScoring.php'.$plfLink.'">'.$allScoring.'</a>';
		echo'<a class="nav-item nav-link" href="Finance.php'.$plfLink.'">'.$allFinances.'</a>';
		echo'<a class="nav-item nav-link" href="Rosters.php'.$plfLink.'">'.$allRosters.'</a>';
		echo'<a class="nav-item nav-link" href="Lines.php'.$plfLink.'">'.$allLines.'</a>';
		//echo'<a class="nav-item nav-link" href="Futures.php'.$plfLink.'">'.$allProspects.'</a>';
		echo'<a class="nav-item nav-link" href="Futures2.php">'.$allProspects.'</a>';
		echo'<a class="nav-item nav-link" href="fiche.php'.$plfLink.'">'.$allTeamCard.'</a>';
		echo'<a class="nav-item nav-link" href="Schedule.php?only=1'.$plfLink.'">'.$schedTitle.'</a>';
	echo '</nav>';
	
}


?>

<style>
.numberCircle {
    width: 60px;
    line-height: 60px;
    border-radius: 50%;
    border: 2px solid #666;
	-webkit-filter: sepia(1);
	filter: sepia(1);
}

.highlight-team {
	-webkit-filter: sepia(1);
	filter: sepia(1);
border-bottom:1px solid blue;
}

.active {
    font-weight: 1000;
	font-size: large;
}


</style>

<script>

function getPageName() {

    var index = window.location.href.lastIndexOf("/") + 1,
        filenameWithExtension = window.location.href.substr(index),
        filename = filenameWithExtension.split('?')[0]; 

	return filename;
}

$(document).ready(function() {

	$('a', $('#header-nav')).each(function () {

		var href = $(this).attr('href');
		if(typeof href !== "undefined"){
			if(href.startsWith(getPageName())){
				$(this).addClass('active');
			}
		}

	});

});

</script>

</div>

