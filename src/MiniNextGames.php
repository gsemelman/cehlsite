<?php
$currentTeam = '';
//session_start();
if(isset($_SESSION["team"])) $currentTeam = $_SESSION["team"];
ob_start();
if(isset($_COOKIE['team'])) $currentTeam = $_COOKIE['team'];
ob_end_flush();

include 'config.php';
include 'lang.php';
?>

<div class = "row">

<?php
if(!isset($playoff)) $playoff = '';
if($playoff == 1) $playoff = 'PLF';
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
$Fnm = $folder.$folderLeagueURL.'TodayGames.html';
$i = 0;
$j = 0;
$round = 0;
$playoffLink = '';
$stop = 0;
if(isset($lastGames)) unset($lastGames);
if(isset($nextGames)) unset($nextGames);
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = each($tableau)) {
		$val = utf8_encode($val);
		
		if(substr_count($val, 'mailto:alexdumont@lchv.biz')) {
			$stop = 1;
		}
				
		// Next Games
		if(substr_count($val, ' at ')) {
			$reste = trim(substr($val, 0, strpos($val, '<BR>')));
			$nextGames[$j] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$nextEquipe1[$j] = trim(substr($reste, 0, strpos($reste, ' at ')));
			$reste = trim(substr($reste, strpos($reste, ' at ')+4));
			$nextEquipe2[$j] = $reste;
			$j++;
		}
	}
	
	if($stop == 0) {
		$c = 1;
		echo '<div class="row justify-content-center">'; 
		
		if(!isset($nextGames)) echo '<div class="col"><h3>'.$todayNoUpcomingGame.'<h3></div>';
		else {
			for($i=0;$i<count($nextGames);$i++){
				$matches = glob($folderTeamLogos.strtolower($nextEquipe1[$i]).'.*');
				$todayImage1 = '';
				for($j=0;$j<count($matches);$j++) {
					$todayImage1 = $matches[$j];
					break 1;
				}
				$matches = glob($folderTeamLogos.strtolower($nextEquipe2[$i]).'.*');
				$todayImage2 = '';
				for($j=0;$j<count($matches);$j++) {
					$todayImage2 = $matches[$j];
					break 1;
				}
				
	/* 			echo '<div style="margin-top:12px; position:relative; display:block; width:45px; height:65px; text-align:center; float:left; padding:2px; border-radius:5px; margin-right:5px; border:solid 1px'.$couleur_contour.'">';
				echo '<div style="position:absolute; top:-15px; left:2px; font-size:10px;">'.$nextGames[$i].'</div>';
				echo '<img style="max-height:30px; max-width:60px; display:block; font-size:10px;" src="'.$todayImage1.'" alt="'.$nextEquipe1[$i].'">';
				echo '<img style="max-height:30px; max-width:60px; display:block; font-size:10px;" src="'.$todayImage2.'" alt="'.$nextEquipe2[$i].'">';
				echo '</div>'; */
				
/* 				echo '<div style="margin-top:12px; position:relative; display:block; width:45px; height:65px; text-align:center; float:left; padding:2px; border-radius:5px; margin-right:5px; border:solid 1px'.$couleur_contour.'">';
					echo '<img style="max-height:30px; max-width:60px; display:block; font-size:10px;" src="'.$todayImage1.'" alt="'.$nextEquipe1[$i].'">';
					echo '<img style="max-height:30px; max-width:60px; display:block; font-size:10px;" src="'.$todayImage2.'" alt="'.$nextEquipe2[$i].'">';
				echo '</div>'; */
				
				echo '<div class="next-game">';
					echo '<div class="next-image"><img src="'.$todayImage1.'" alt="'.$nextEquipe1[$i].'"></div>';
					echo '<div class="next-image"><img src="'.$todayImage2.'" alt="'.$nextEquipe2[$i].'"></div>';
				echo '</div>';
				
				

			}
		}
		echo '</div>'; 
	}
	else echo 'BoxScore by Dominik Lavoie detected, use Original FHLsim files...';
}
else echo $allFileNotFound.' - '.$Fnm;
echo '</div>';
?>
<style>
.next-game { border-radius:10px; border-style: solid; margin:5px; padding:5px; }
.next-image {  max-width:30px;}
</style>