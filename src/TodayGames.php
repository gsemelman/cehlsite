<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = 'TodayGames';
$CurrentTitle = $todayTitle;
$CurrentPage = 'TodayGames';
include 'head.php';
?>

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
		
		// Detect BoxScore 1.77 created by Dominik Lavoie and modify by Alexandre Dumont
		if(substr_count($val, 'mailto:alexdumont@lchv.biz')) {
			$stop = 1;
		}
		
		// Dernier Résultats
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
		if(isset($lastGames)) {
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
			for($i=0;$i<count($lastGames);$i++) {
				$matchNumber = $lastGames[$i];
				if($playoff == '') $Fnm = $folder.$folderGames.$folderLeagueURL.$matchNumber.'.html';
				if($playoff == 'PLF')  $Fnm = $folder.$folderGames.$folderLeagueURL.'-R'.$round.'-'.$matchNumber.'.html';
				$a = 0;
				$b = 0;
				$d = 0;
				$e = 0;
				$j = 0;
				$k = 0;
				$gameOvertime[$i] = '';
				if(file_exists($Fnm)) {
					$tableau = file($Fnm);
					while(list($cle,$val) = each($tableau)) {
						$val = utf8_encode($val);
						if(substr_count($val, ' at ') && $a == 0){
							$pos = strpos($val, ' at ');
							$pos_apres = strpos($val, '</H3>');
							$pos_avant = strpos($val, '<H3>') + 4;
							$long1 = $pos - $pos_avant;
							$pos = $pos + 4;
							$long2 = $pos_apres - $pos;
							$gameTeam1[$i] = substr($val, $pos_avant, $long1);
							$gameTeam2[$i] = substr($val, $pos, $long2);
							$a = 1;
						}
						if((substr_count($val, '>Period') || substr_count($val, '>Overtime<')) && ($a == 1 || $a == 3)) {
							$a = 2;
							if(substr_count($val, '>Overtime<')) {
								$gameOvertime[$i] = 'OV';
							}
						}
						if(substr_count($val, '(') && $a == 2 && !substr_count($val, 'PENALTIES') ) {
							$tmpTm = trim(substr($val, strpos($val, '.')+1, strpos($val, ',')-strpos($val, '.')-1));
							$tmpScorerFull = trim(substr($val, strpos($val, ',')+1, strpos($val, '(')-strpos($val, ',')-1));
							$tmpScorer = trim(substr($tmpScorerFull, 0, strrpos($tmpScorerFull, ' ')));
							$tmpScorerNbr = trim(substr($tmpScorerFull, strrpos($tmpScorerFull, ' ')+1));
							// echo '<br>'.$tmpScorer.' - '.$tmpTm;
							if($tmpTm == strtoupper($gameTeam1[$i])) {
								$gameScorer1[$i][$j] = $tmpScorer;
								$gameScorer1Nbr[$i][$j] = $tmpScorerNbr;
								$j++;
							}
							if($tmpTm == strtoupper($gameTeam2[$i])) {
								$gameScorer2[$i][$k] = $tmpScorer;
								$gameScorer2Nbr[$i][$k] = $tmpScorerNbr;
								$k++;
							}
						}
						if(strlen($val) < 10 && $a == 2) {
							$a = 3;
						}
						if(substr_count($val, 'saves out of') && $a == 3) {
							$tmpGoalName = trim(substr($val, 0, strpos($val, '(')));
							$reste = trim(substr($val, strpos($val, ',')+1));
							$tmpGoalSaves = trim(substr($reste, 0, strpos($reste, 'saves')-1));
							$reste = trim(substr($reste, strpos($reste, 'of')+2));
							$tmpGoalShots = trim(substr($reste, 0, strpos($reste, 'shots')-1));
							$reste = trim(substr($reste, strpos($reste, ',')+1));
							$tmpGoalStatus = trim(substr($reste, 0, strpos($reste, ',')));
							$reste = trim(substr($reste, strpos($reste, ',')+1));
							$tmpGoalRecord = trim(substr($reste, 0, strpos($reste, '<')));
							if($tmpGoalStatus == 'W' || $tmpGoalStatus == 'L' || $tmpGoalStatus == 'T') {
								if(isset($gameGoal1[$i]) && !isset($gameGoal2[$i])) {
									$gameGoal2[$i] = $tmpGoalName.', '.$tmpGoalSaves.'/'.$tmpGoalShots.', '.$tmpGoalRecord;
									$a = 4;
								}
								if(!isset($gameGoal1[$i])) $gameGoal1[$i] = $tmpGoalName.', '.$tmpGoalSaves.'/'.$tmpGoalShots.', '.$tmpGoalRecord;
							}
						}
						if(substr_count($val, 'Game Stars') && $a == 4) {
							$a = 5;
						}
						if(substr_count($val, '(') && $a == 5) {
							$tmpGameStar = trim(substr($val, strpos($val, '-')+1, strpos($val, '(')-1-strpos($val, '-')-1));
							if(isset($gameStar1[$i]) && isset($gameStar2[$i]) && !isset($gameStar3[$i])) {
								$gameStar3[$i] = $tmpGameStar;
								$a = 6;
							}
							if(isset($gameStar1[$i]) && !isset($gameStar2[$i])) $gameStar2[$i] = $tmpGameStar;
							if(!isset($gameStar1[$i])) $gameStar1[$i] = $tmpGameStar;
						}
						if(substr_count($val, '</TD><TD><PRE>') && $a == 7) {
							$a = 8;
						}
						if(substr_count($val, '</TD><TD><PRE>') && $a == 9) {
							$a = 10;
						}
						if($a == 7 || $a == 9) {
							$count = strlen($val);
							$z = 0;
							while( $z < $count ) {
								if( ctype_digit($val[$z]) ) {
									$pos = $z;
									break 1;
								}
								$z++;
							}
							if($a == 7) { $gamePlayersList1[$i][$w] = trim(substr($val, 0, $z)); }
							if($a == 9) { $gamePlayersList2[$i][$w] = trim(substr($val, 0, $z)); }
							$w++;
						}
						if(substr_count($val, '-----------------------') && $a == 6) {
							$a = 7;
							$w = 0;
						}
						if(substr_count($val, '-----------------------') && $a == 8) {
							$a = 9;
							$w = 0;
						}
						if(substr_count($val, 'Attendance') && $a == 10) {
							$gameAttendance[$i] = trim(substr($val, strpos($val, ':')+1, strpos($val, '<')-strpos($val, ':')-1));
						}
					}
				}
				else echo $allFileNotFound.' - '.$Fnm;
			}
		}
	
		echo '<div style="clear:both; width:555px; margin-left:auto; margin-right:auto;">';
	
		$nbrBox = 1;
		echo '<div style="float:left;">';
	
		if(!isset($lastGames)) echo '<div style="margin-top:12px; display:block; width:100px; height:60px; float:left; padding:2px; border-radius:5px; margin-right:5px; border:solid 1px'.$couleur_contour.'">'.$todayNoSimGame.'</div>';
		else {
			for($i=0;$i<count($lastGames);$i++){
				if($nbrBox == 1) $nbrBox = 2;
				else $nbrBox = 1;
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
				
				$tmpClear = '';
				if($nbrBox == 2) $tmpClear = 'clear:both;';
				echo '<a class="lien-noir" style="'.$tmpClear.'margin-top:14px; position:relative; display:block; float:left; width:265px; padding:2px; border-radius:5px; margin-right:5px; border:solid 1px'.$couleur_contour.'" href="games.php?num='.$lastGames[$i].$playoffLink.'">';
				echo '<div style="position:absolute; top:-14px; left:2px; font-size:10px;">'.$lastGames[$i].'</div>';
				echo '<div style="position:absolute; top:-14px; right:2px; font-size:10px;">'.$gameOvertime[$i].'</div>';
				echo '<span style="float:right; display:block; width:40px; text-align:center; font-size:24px;'.$bold1.'">'.$lastScore1[$i].'</span>';
				echo '<img style="float:left; display:block; max-height:30px; max-width:60px; font-size:10px;" src="'.$todayImage1.'" alt="'.$lastEquipe1[$i].'">';
				echo '<table class="tableau">';
				$c = 1;
				if(isset($gameScorer1[$i])) {
					for($j=0;$j<count($gameScorer1[$i]);$j++) {
						if($c == 1) $c = 2;
						else $c = 1;
						$tmp = $j+1;
						$tmpScorer1 = '';
						for($w=0;$w<count($gamePlayersList1[$i]);$w++) {
							$tmpPlayerListCAP = mb_strtoupper($gamePlayersList1[$i][$w], 'UTF-8');
							if($gameScorer1[$i][$j] != '' && substr_count($tmpPlayerListCAP, $gameScorer1[$i][$j])) {
								$tmpScorer1 = $gamePlayersList1[$i][$w];
								break 1;
							}
						}
						echo '<tr class="hover'.$c.'"><td style="width:25px;">'.$tmp.'</td><td>'.$tmpScorer1.'</td><td style="width:25px; text-align:right;">'.$gameScorer1Nbr[$i][$j].'</td></tr>';
					}
				}
				echo '</table>';
	
				echo '<span style="clear:both; display:block; float:left; margin-bottom:10px;">'.$gameGoal1[$i].'</span>';
				echo '<span style="clear:both; float:right; display:block; width:40px; text-align:center; font-size:24px;'.$bold2.'">'.$lastScore2[$i].'</span>';
				echo '<img style="float:left; display:block; max-height:30px; max-width:60px; font-size:10px;" src="'.$todayImage2.'" alt="'.$lastEquipe2[$i].'">';
				echo '<table class="tableau">';
				$c = 1;
				if(isset($gameScorer2[$i])) {
					for($j=0;$j<count($gameScorer2[$i]);$j++) {
						if($c == 1) $c = 2;
						else $c = 1;
						$tmp = $j+1;
						$tmpScorer2 = '';
						for($w=0;$w<count($gamePlayersList2[$i]);$w++) {
							$tmpPlayerListCAP = mb_strtoupper($gamePlayersList2[$i][$w], 'UTF-8');
							if($gameScorer2[$i][$j] != '' && substr_count($tmpPlayerListCAP, $gameScorer2[$i][$j])) {
								$tmpScorer2 = $gamePlayersList2[$i][$w];
								break 1;
							}
						}
						echo '<tr class="hover'.$c.'"><td style="width:25px;">'.$tmp.'</td><td>'.$tmpScorer2.'</td><td style="width:25px; text-align:right;">'.$gameScorer2Nbr[$i][$j].'</td></tr>';
					}
				}
				echo '</table>';
				echo '<span style="clear:both; display:block; float:left; margin-bottom:10px;">'.$gameGoal2[$i].'</span>';
				echo '<span style="clear:both; display:block; float:left; font-size:12px;">STARS 1: '.$gameStar1[$i].', 2: '.$gameStar2[$i].', 3: '.$gameStar3[$i].'</span>';
				
				echo '</a>';
			}
			echo '</div>';
		}
		$c = 1;
		echo '<div style="float:left;">';
		
		if(!isset($nextGames)) echo '<div style="margin-top:12px; display:block; width:100px; height:60px; float:left; padding:2px; border-radius:5px; margin-right:5px; border:solid 1px'.$couleur_contour.'">'.$todayNoUpcomingGame.'</div>';
		else {
			for($i=0;$i<count($nextGames);$i++){
				if($c == 1) $c = 2;
				else $c = 1;
				$bold = '';
				if($nextEquipe1[$i] == $currentTeam || $nextEquipe2[$i] == $currentTeam) $bold = 'font-weight:bold;';
				
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
				
				echo '<div style="margin-top:12px; position:relative; display:block; width:60px; height:60px; text-align:center; float:left; padding:2px; border-radius:5px; margin-right:5px; border:solid 1px'.$couleur_contour.'">';
				echo '<div style="position:absolute; top:-12px; left:2px; font-size:10px;">'.$nextGames[$i].'</div>';
				echo '<img style="max-height:30px; max-width:60px; display:block; font-size:10px;" src="'.$todayImage1.'" alt="'.$nextEquipe1[$i].'">';
				echo '<img style="max-height:30px; max-width:60px; display:block; font-size:10px;" src="'.$todayImage2.'" alt="'.$nextEquipe2[$i].'">';
				echo '</div>';
			}
		}
		echo '</div>';
	}
	else echo 'BoxScore by Dominik Lavoie detected, use Original FHLsim files...';
}
else echo $allFileNotFound.' - '.$Fnm;
echo '<div style="clear:both"></div></div>';
?>

</body>
</html>