<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once 'config.php';
include 'lang.php';
include_once 'common.php';
include_once 'classes/GameHolder.php';



$baseFolder = '';
$seasonId = '';
if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(trim($seasonId) == false){
    $baseFolder = $folder;
}else{
    $baseFolder = str_replace("#",$seasonId,$folderCarrerStats);
}

$matchNumber = '';
$linkHTML = '';
if(isset($_GET['num']) || isset($_POST['num'])) {
	$matchNumber = ( isset($_GET['num']) ) ? $_GET['num'] : $_POST['num'];
	$matchNumber = htmlspecialchars($matchNumber);
	$linkHTML = $matchNumber;
	$round = '';
	if(isset($_GET['rnd']) || isset($_POST['rnd'])) {
		$round = ( isset($_GET['rnd']) ) ? $_GET['rnd'] : $_POST['rnd'];
		$round = htmlspecialchars($round);
	}
	if($matchNumber != '') {
		if($round != '') {
			$playoff = 'PLF';
			$matches = glob($baseFolder.'*'.$playoff.'GMs.html');
			$folderLeagueURL = '';
			$matchesDate = array_map('filemtime', $matches);
			arsort($matchesDate);
			foreach ($matchesDate as $j => $val) {
				if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
					$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
					break 1;
				}
			}
			$Fnm = $baseFolder.$folderGames.$folderLeagueURL.'-R'.$round.'-'.$matchNumber.'.html';
			$linkHTML = '-R'.$round.'-'.$matchNumber;
		}
		else {
			$playoff = '';
			$matches = glob($baseFolder.'*'.$playoff.'GMs.html');
			$folderLeagueURL = '';
			$matchesDate = array_map('filemtime', $matches);
			arsort($matchesDate);
			foreach ($matchesDate as $j => $val) {
				if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
					$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
					break 1;
				}
			}
			$Fnm = $baseFolder.$folderGames.$folderLeagueURL.$matchNumber.'.html';
		}
	}
}

$rondes = '';
if($round != '') $rondes = ' - '.$scheldRound.' '.$round;

$CurrentHTML = $linkHTML;
$CurrentTitle = $gamesTitle.' #'.$matchNumber.$rondes;
$CurrentPage = 'games';
include 'head.php';
?>

<div class="col-sm-12 col-md-8 col-lg-4 offset-md-2 offset-lg-4">
<div class = "container">

<div class="card">
	<div class="card-header wow fadeIn">
		<h3><?php echo $gamesTitle.' #'.$matchNumber.$rondes; ?></h3>
	</div>
	<div class="card-body">
	

<!--<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border:solid 1px <?php echo $couleur_contour; ?>">
<h3><?php echo $gamesTitle.' #'.$matchNumber.$rondes; ?></h3>
<div style="padding:0px 0px 0px 0px;">-->

<?php

function prettify($json)
{
    $array = json_decode($json, true);
    $json = json_encode($array, JSON_PRETTY_PRINT);
    return $json;
}

if(file_exists($Fnm)) {
   
    $gameHolder = new GameHolder($Fnm);
    
    echo '<div class="card">';
    echo '<pre>';
    //echo json_encode($gameHolder, JSON_PRETTY_PRINT);
    echo prettify(json_encode($gameHolder));
    echo '/<pre>';
    echo '</div>';
  

}
else echo $allFileNotFound.' - '.$Fnm;

echo '<div style="clear:both;"></div></div></div></div>';
?>


<?php include 'footer.php'; ?>
