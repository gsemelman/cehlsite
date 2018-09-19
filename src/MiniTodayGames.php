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
		
		// Last Results
		if(substr_count($val, 'HREF')) {
			if($playoff == 'PLF' && substr_count($val, 'PLF-R')) {
				$round = trim(substr($val, strpos($val, 'PLF-R')+5, 1));
				$playoffLink = '&rnd='.$round;
			}
			if(substr_count($val, '</')) $reste = trim(substr($val, strpos($val, '>')+1, strpos($val, '</A>')-strpos($val, '>')-1));
			else $reste = trim(substr($val, strpos($val, '> ')+1));
			
			$lastGames[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			
			$count = strlen($reste);
			$z = 0;
			while( $z < $count ) {
				if( ctype_digit($reste[$z]) ) {
					$lastPos = $z;
					break 1;
				}
				$z++;
			}
			$lastEquipe1[$i] = trim(substr($reste, 0, $lastPos)); 
			$reste = trim(substr($reste, $lastPos));
			$lastScore1[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$count = strlen($reste);
			$z = 0;
			while( $z < $count ) {
				if( ctype_digit($reste[$z]) ) {
					$lastPos = $z;
					break 1;
				}
				$z++;
			}
			$lastEquipe2[$i] = trim(substr($reste, 0, $lastPos));
			$reste = trim(substr($reste, $lastPos));
			$lastScore2[$i] = $reste;
			$i++;
		}
	}
	
	if($stop == 0) {
		$c = 1;
		echo '<div class="row justify-content-center">'; 
		

		if(!isset($lastGames)) echo '<div class="col"><h3>'.$todayNoSimGame.'<h3></div>';
		else {
			for($i=0;$i<count($lastGames);$i++){
				$bold1 = '';
				if($lastEquipe1[$i] == $currentTeam) $bold1 = 'font-weight:bold;';
				$bold2 = '';
				if($lastEquipe2[$i] == $currentTeam) $bold2 = 'font-weight:bold;';
				
				$matches = glob($folderTeamLogos.strtolower($lastEquipe1[$i]).'.*');
				$todayImage1 = '';
				for($j=0;$j<count($matches);$j++) {
					$todayImage1 = $matches[$j];
					break 1;
				}
				$matches = glob($folderTeamLogos.strtolower($lastEquipe2[$i]).'.*');
				$todayImage2 = '';
				for($j=0;$j<count($matches);$j++) {
					$todayImage2 = $matches[$j];
					break 1;
				}
				
/* 				echo '<a class="lien-noir" style="margin-top:12px; position:relative; display:block; width:100px; height:70px; float:left; padding:2px; border-radius:5px; margin-right:5px; border:solid 1px'.$couleur_contour.'" href="games.php?num='.$lastGames[$i].$playoffLink.'">';
				echo '<img style="float:left; display:block; max-height:30px; max-width:60px; font-size:10px;" src="'.$todayImage1.'" alt="'.$lastEquipe1[$i].'">';
				echo '<span style="float:right; display:block; width:40px; text-align:center; font-size:18px;'.$bold1.'">'.$lastScore1[$i].'</span>';
				echo '<img style="clear:left; float:left; display:block; max-height:30px; max-width:60px; font-size:10px;" src="'.$todayImage2.'" alt="'.$lastEquipe2[$i].'">';
				echo '<span style="float:right; display:block; width:40px; text-align:center; font-size:18px;'.$bold2.'">'.$lastScore2[$i].'</span>';
				echo '</a>'; */
/* 				echo '<a class="lien-noir" style="margin-top:12px; position:relative; display:block; width:100px; height:100px; float:left; padding:2px; border-radius:5px; margin-right:5px; border:solid 1px'.$couleur_contour.'" href="games.php?num='.$lastGames[$i].$playoffLink.'">';
				echo '<img style="float:left; display:block; max-height:30px; max-width:30px;" src="'.$todayImage1.'" alt="'.$lastEquipe1[$i].'">';
				echo '<span style="float:right; display:block; width:40px; text-align:center; font-size:18px;'.$bold1.'">'.$lastScore1[$i].'</span>';
				echo '<img style="clear:left; float:left; display:block; max-height:30px; max-width:30px;" src="'.$todayImage2.'" alt="'.$lastEquipe2[$i].'">';
				echo '<span style="float:right; display:block; width:40px; text-align:center; font-size:18px;'.$bold2.'">'.$lastScore2[$i].'</span>';
				echo '</a>'; */
				
 				echo '<div class="latest-game">';
					echo '<a href="games.php?num='.$lastGames[$i].$playoffLink.'">';
						echo '<div class="row">';
							echo '<div class="col">';
								echo '<div class="latest-image"><img src="'.$todayImage1.'" alt="'.$nextEquipe1[$i].'"></div>';
								echo '<div class="latest-score text">'.$lastScore1[$i].'</div>';
							echo '</div>';
							echo '<div class="col">';
								echo '<div class="latest-image"><img src="'.$todayImage2.'" alt="'.$nextEquipe2[$i].'"></div>';
								echo '<div class="latest-score text">'.$lastScore2[$i].'</div>';
							echo '</div>';
						echo '</div>';
					echo '</a>';
				echo '</div>'; 

/* 				echo '<div class="latest-game">';
					echo '<a href="games.php?num='.$lastGames[$i].$playoffLink.'">';
					echo '<div class="latest-image"><img src="'.$todayImage1.'" alt="'.$nextEquipe1[$i].'"> '.$lastScore1[$i].'</div>';
					echo '<div class="latest-image"><img src="'.$todayImage2.'" alt="'.$nextEquipe2[$i].'"> '.$lastScore2[$i].'</div>';
					echo '</a>';
				echo '</div>'; */

			}
			echo '</div>';
		}
	
	}
	else echo 'BoxScore by Dominik Lavoie detected, use Original FHLsim files...';
}
else echo $allFileNotFound.' - '.$Fnm;
echo '</div>';
?>

<style>
.latest-game { border-radius:10px; border-style: solid; margin:5px; padding:5px; font-size: 17px;}
.latest-image { max-width:30px; }
.latest-score { font-size: 20px; line-height: 32px; }

</style>