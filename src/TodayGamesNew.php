<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once 'config.php';
include 'lang.php';
include_once 'classes/ScheduleHolder.php';
include_once 'classes/ScheduleObj.php';

$CurrentHTML = 'TodayGames';
$CurrentTitle = $todayTitle;
$CurrentPage = 'TodayGamesTSN';
include 'head.php';

$bg_1 = 'background-color:'.$tableauGrey2.';';
$bg_2 = 'background-color:'.$tableauGrey1.';';
$style1 = 'border-color:'.$tableauGrey2.';border-width:1px;text-align:left;font-size:18px; line-height:30px;';
$style2 = 'border-color:'.$tableauGrey2.';border-width:1px;text-align:center;width:35px;';


if(!function_exists('search')) {
    function search($Fnm,$currentTeam) {
        $b = 0;
        $d = 0;
        $tableau = file($Fnm);
        while(list($cle,$val) = myEach($tableau)) {
            $val = utf8_encode($val);
            if(substr_count($val, 'A NAME='.$currentTeam)) {
                $b = 1;
            }
            if($b == 1 && $d == 1) {
                $reste = trim($val);
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                if(substr($reste, 0, 1) == '*') {
                    $reste = trim(substr($reste, 1));
                }
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                return $TSabbr = trim(substr($reste, strrpos($reste, ' ')));
            }
            if($b == 1 && substr_count($val, 'PCTG')) {
                $d = 1;
            }
        }
    }
}

// Today Games
$fileName = getLeagueFile($folder, $playoff, 'Schedule.html', 'Schedule');
$i = 0;
$j = 0;
$round = 0;
$playoffLink = '';

$scheduleHolder = new ScheduleHolder($fileName, '');

$selectedDay = $scheduleHolder->getLastDayPlayed();
$selectedDay = 2;

$lastGames = $scheduleHolder->getScheduleByDay($selectedDay);


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

		foreach ($lastGames as $game) {
		//for($i=0;$i<count($lastGames);$i++) {
		    
		    $lastEquipe1 = $game->getTeam1(); 
		    $lastEquipe2  = $game->getTeam2(); 
		    $lastScore1 = $game->getTeam1Score();
		    $lastScore2 = $game->getTeam2Score();
		    
			//$matchNumber = $lastGames[$i];
		    $matchNumber = $game->getGameNumber();
			if($playoff == '') $Fnm = $folder.$folderGames.$folderLeagueURL.$matchNumber.'.html';
			if($playoff == 'PLF')  $Fnm = $folder.$folderGames.$folderLeagueURL.'-R'.$round.'-'.$matchNumber.'.html';
			$a = 0;
			$b = 0;
			$d = 0;
			$e = 0;
			$j = 0;
			$k = 0;
			$l = 1;
			$m = 0;
			$gameOvertime[$i] = '';
			$test='';
			if(file_exists($Fnm)) {
				$tableau = file($Fnm);
				while(list($cle,$val) = myEach($tableau)) {
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
						$b = 1;
					}
					
					if((isset($gameTeam1[$i]) && (substr_count($val, '<TR><TD>'.$gameTeam1[$i])) || (isset($gameTeam2[$i]) && substr_count($val, '<TR><TD>'.$gameTeam2[$i]))) && $b >= 1 && $b < 5) {
						$gameMod = prev($tableau);
						for($m=0;$m<4;$m++) {
							$gameMod = next($tableau);
							$pos_avant = strpos($gameMod, '>') + 1;
							$pos_apres = strpos($gameMod, '</TD>');
							$long1 = $pos_apres - $pos_avant;
							if($b == 1) $gameAway1[$i][$m] = substr($gameMod, $pos_avant, $long1);
							if($b == 2) $gameHome1[$i][$m] = substr($gameMod, $pos_avant, $long1);
							if($b == 3) $gameAway2[$i][$m] = substr($gameMod, $pos_avant, $long1);
							if($b == 4) $gameHome2[$i][$m] = substr($gameMod, $pos_avant, $long1);
						}
						$gameMod = next($tableau);
						$pos_avant = strpos($gameMod, '<B>') + 3;
						$pos_apres = strpos($gameMod, '</B>');
						$long1 = $pos_apres - $pos_avant;
						if($b == 1) $gameAway1[$i][4] = substr($gameMod, $pos_avant, $long1);
						if($b == 2) $gameHome1[$i][4] = substr($gameMod, $pos_avant, $long1);
						if($b == 3) $gameAway2[$i][4] = substr($gameMod, $pos_avant, $long1);
						if($b == 4) $gameHome2[$i][4] = substr($gameMod, $pos_avant, $long1);
						$b++;
					}
					
					if((substr_count($val, '>Period') || substr_count($val, '>Overtime<')) && ($a == 1 || $a == 3)) {
						$b = 6;
						$a = 2;
						if(substr_count($val, '>Overtime<')) {
							$gameOvertime[$i] = ' (OT)';
						}
					}
						
					if(substr_count($val, '(') && $a == 2 && !substr_count($val, 'PENALTIES') ) {
						
						$tmpTm = trim(substr($val, strpos($val, '.')+1, strpos($val, ',')-strpos($val, '.')-1));
						$tmpScorerFull = trim(substr($val, strpos($val, ',')+1, strpos($val, '(')-strpos($val, ',')-1));
						$tmpScorer = trim(substr($tmpScorerFull, 0, strrpos($tmpScorerFull, ' ')));
						$tmpScorerNbr = trim(substr($tmpScorerFull, strrpos($tmpScorerFull, ' ')+1));
						//echo $tmpScorer.' - '.$tmpTm.' - '.$gameTeam1[$i].' - '.$gameTeam2[$i].'<br>';
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
						$tmpGoalName = '<b>'.trim(substr($val, 0, strpos($val, '('))).'</b>';
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
								$gameGoal2[$i] = $tmpGoalName.' ('.$tmpGoalSaves.' SV, '.$tmpGoalRecord.')';//'.$tmpGoalShots.'
								$a = 4;
							}
							if(!isset($gameGoal1[$i])) $gameGoal1[$i] = $tmpGoalName.' ('.$tmpGoalSaves.'SV, '.$tmpGoalRecord.')';//'.$tmpGoalShots.'
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
						if($a == 7) $gamePlayersList1[$i][$w] = trim(substr($val, 0, $z));
						if($a == 9) $gamePlayersList2[$i][$w] = trim(substr($val, 0, $z));
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
			
			$i++;
		}
	}
		
		echo '<div><h3>Latest Scores</h3></div>';

		echo '<div class="row justify-content-center">'; 
	
		$nbrBox = 1;

		if(!isset($lastGames)) echo '<div class="col"><h3>'.$todayNoSimGame.'<h3></div>';
		else {
			//for($i=0;$i<count($lastGames);$i++){
			$i = 0;
		    foreach ($lastGames as $game) {
			    
			    $lastEquipe1 = $game->getTeam1();
			    $lastEquipe2  = $game->getTeam2();
			    $lastScore1 = $game->getTeam1Score();
			    $lastScore2 = $game->getTeam2Score();
			    $matchNumber = $game->getGameNumber();
			    
				if($nbrBox == 1) $nbrBox = 2;
				else $nbrBox = 1;
				$bold1 = '';
				if($lastEquipe1 == $currentTeam) $bold1 = 'font-weight:bold;';
				$bold2 = '';
				if($lastEquipe2 == $currentTeam) $bold2 = 'font-weight:bold;';
				
				$matches = glob($folderTeamLogos.strtolower($lastEquipe1).'.*');
				$todayImage1 = '';
				for($j=0;$j<count($matches);$j++) {
					$todayImage1 = $matches[$j];
					break 1;
				}
				$matches = glob($folderTeamLogos.strtolower($lastEquipe2).'.*');
				$todayImage2 = '';
				for($j=0;$j<count($matches);$j++) {
					$todayImage2 = $matches[$j];
					break 1;
				}
				
				// Find Teams Abbr
				$matches = glob($folder.'*TeamScoring.html');
				$folderLeagueURL3 = '';
				$matchesDate = array_map('filemtime', $matches);
				arsort($matchesDate);
				foreach ($matchesDate as $j => $val) {
					if(!substr_count($matches[$j], 'PLF')) {
						$folderLeagueURL3 = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'TeamScoring')-strrpos($matches[$j], '/')-1);
						break 1;
					}
				}
				$TSabbr = '';
				$FnmAbbr = $folder.$folderLeagueURL3.'TeamScoring.html';
				if(file_exists($FnmAbbr)) {
					$lastEquipe1Abbr[$i] = search($FnmAbbr,$lastEquipe1);
					$lastEquipe2Abbr[$i] = search($FnmAbbr,$lastEquipe2);
				}
				else echo $allFileNotFound.' - '.$FnmAbbr;
				
				// 
				//$team1 = strtolower(str_replace('.','',$lastEquipe1));//
				//$team2 = strtolower(str_replace('.','',$lastEquipe2));
				
				$tmpClear = '';
				$tmpOT = '';
				$tmpOT2 = '';
				$tmpOT3 = '';
				if($nbrBox == 2) $tmpClear = 'clear:both;';
				if ($gameOvertime[$i] != '') {
					$tmpOT = '<td style="'.$style2.'">OT</td>';
					$tmpOT2 = '<td style="'.$style2.'">'.$gameAway2[$i][3].'</td>';
					$tmpOT3 = '<td style="'.$style2.'">'.$gameHome2[$i][3].'</td>';
				}
				echo '<div class="col-sm-4 col-md-4 col-lg-2" style="'.$tmpClear.'margin-top:14px; position:relative; display:block; float:left; width:300px; padding:2px; border-radius:0px; margin-right:5px; border:solid 1px'.$couleur_contour.'">';
				echo '<table class="tableau"><tbody><tr class="tableau-top"><td colspan="6" style="border-width:1px 1px 1px 1px;">FINAL'.$gameOvertime[$i].'</td><tr style="'.$bg_2.'"><td style="text-align:center;"></td><td style="text-align:center;width:35px;">1</td><td style="text-align:center;width:35px;">2</td><td style="text-align:center;width:35px;">3</td>'.$tmpOT.'<td style="text-align:center;width:40px;">T</td></tr>';
				echo '<tr><td style="'.$style1.'">'.$lastEquipe1Abbr[$i].'<img style="float:left; display:block; max-height:30px; max-width:60px; font-size:10px;" src="'.$todayImage1.'" alt="'.$lastEquipe1.'"></td><td style="'.$style2.'">'.$gameAway2[$i][0].'</td><td style="'.$style2.'">'.$gameAway2[$i][1].'</td><td style="'.$style2.'">'.$gameAway2[$i][2].'</td>'.$tmpOT2.'<td style="'.$style2.'width:40px;font-size:24px;'.$bold1.'">'.$lastScore1.'</td></tr>';
				echo '<tr><td style="'.$style1.'">'.$lastEquipe2Abbr[$i].'<img style="float:left; display:block; max-height:30px; max-width:60px; font-size:10px;" src="'.$todayImage2.'" alt="'.$lastEquipe2.'"></td><td style="'.$style2.'">'.$gameHome2[$i][0].'</td><td style="'.$style2.'">'.$gameHome2[$i][1].'</td><td style="'.$style2.'">'.$gameHome2[$i][2].'</td>'.$tmpOT3.'<td style="'.$style2.'width:40px;font-size:24px;'.$bold2.'">'.$lastScore2.'</td></tr>';
				echo '</tbody></table>';
				
				echo '<table class="tableau">';
				echo '<tr style="'.$bg_2.'"><td colspan="2" style="font-weight:bold;font-size:12px;">GOALS</td></tr>';
				echo '<tr class="hover2"><td style="width:70px;">'.$lastEquipe1.'</td><td style="font-weight:bold;">';
				$scoringList = '';
				if(isset($gameScorer1[$i])) {
					for($j=0;$j<count($gameScorer1[$i]);$j++) {
						$tmpScorer1 = '';
						for($w=0;$w<count($gamePlayersList1[$i]);$w++) {
							$tmpPlayerListCAP = mb_strtoupper($gamePlayersList1[$i][$w], 'UTF-8');
							if(isset($gameScorer1[$i][$j]) && $gameScorer1[$i][$j] != '' && substr_count($tmpPlayerListCAP, $gameScorer1[$i][$j])) {
								$tmpScorer1 = $gamePlayersList1[$i][$w];
								break 1;
							}
						}
						$scoringList = $scoringList.$tmpScorer1.' ('.$gameScorer1Nbr[$i][$j].'), ';
					}
				}
				$scoringList = substr($scoringList,0,-2);
				if($scoringList == '') $scoringList='None';
				echo $scoringList.'</td></tr>';
				echo '<tr class="hover2"><td style="width:70px;">'.$lastEquipe2.'</td><td style="font-weight:bold;">';
				
				$scoringList = '';
				if(isset($gameScorer2[$i])) {
					for($j=0;$j<count($gameScorer2[$i]);$j++) {
						$tmpScorer2 = '';
						for($w=0;$w<count($gamePlayersList2[$i]);$w++) {
							$tmpPlayerListCAP = mb_strtoupper($gamePlayersList2[$i][$w], 'UTF-8');
							if(isset($gameScorer2[$i][$j]) && $gameScorer2[$i][$j] != '' && substr_count($tmpPlayerListCAP, $gameScorer2[$i][$j])) {
								$tmpScorer2 = $gamePlayersList2[$i][$w];
								break 1;
							}
						}
						$scoringList = $scoringList.$tmpScorer2.' ('.$gameScorer2Nbr[$i][$j].'), ';
					}
				}
				$scoringList = substr($scoringList,0,-2);
				if ($scoringList == '') $scoringList = 'None';
				echo $scoringList.'</td></tr>';
				echo '</table>';
				echo '<table class="tableau">';
				echo '<tr style="'.$bg_2.'"><td colspan="2" style="font-weight:bold;font-size:12px;">GOALIES</td></tr>';
				echo '<tr class="hover2"><td style="width:70px;">'.$lastEquipe1.'</td><td>'.$gameGoal1[$i].'</td></tr>';
				echo '<tr class="hover2"><td style="width:70px;">'.$lastEquipe2.'</td><td>'.$gameGoal2[$i].'</td></tr>';
				echo '</table>';

				echo '<table class="tableau"><tbody><tr class="tableau-top"><td style="height:50px; border-width:1px 1px 1px 1px;"><a class="lien-blanc" href="games.php?num='.$matchNumber.$playoffLink.'">BOX SCORE</a></td></tr></tbody></table>';
				
				echo '</div>';
				
			}
			$i++;
			echo '</div>';
			
		}
		$c = 1;

?>

<?php include 'footer.php'; ?>