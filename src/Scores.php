<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$dayNum = null;
if(isset($_GET['dayNum']) || isset($_POST['dayNum'])) {
    $dayNum = ( isset($_GET['dayNum']) ) ? $_GET['dayNum'] : $_POST['dayNum'];
}

require_once 'config.php';
include 'lang.php';
include_once 'classes/ScheduleHolder.php';
include_once 'classes/ScheduleObj.php';
include_once 'classes/TeamAbbrHolder.php';

$CurrentHTML = 'Scores';
$CurrentTitle = 'Scores';
$CurrentPage = 'Scores';
include 'head.php';



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
$round = 4;
$playoffLink = '';

if(isPlayoffs($folder, $playoffMode)){
    $round = 0;
    if(file_exists($folder.'cehlPLF-Round4-Schedule.html')) {
        //$fileName = $folder.'cehlPLF-Round4-Schedule.html';
        $round = 4;
    }else if(file_exists($folder.'cehlPLF-Round3-Schedule.html')) {
        //$fileName = $folder.'cehlPLF-Round3-Schedule.html';
        $round = 3;
    }else if(file_exists($folder.'cehlPLF-Round2-Schedule.html')) {
        //$fileName = $folder.'cehlPLF-Round2-Schedule.html';
        $round = 2;
    }else if(file_exists($folder.'cehlPLF-Round1-Schedule.html')) {
        //$fileName = $folder.'cehlPLF-Round1-Schedule.html';
        $round = 1;
    }
    
    $fileName = getLeagueFile($folder, 'PLF', '-Round'.$round.'-Schedule.html', '-Round'.$round.'-Schedule');
    $playoffLink = '&rnd='.$round;
    
}else{
    $fileName = getLeagueFile($folder, $playoff, 'Schedule.html', 'Schedule');
}



$scheduleHolder = new ScheduleHolder($fileName, '');


// Find Teams Abbr
// $matches = glob($folder.'*TeamScoring.html');
// $folderLeagueURL3 = '';
// $matchesDate = array_map('filemtime', $matches);
// arsort($matchesDate);
// foreach ($matchesDate as $j => $val) {
//     if(!substr_count($matches[$j], 'PLF')) {
//         $folderLeagueURL3 = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'TeamScoring')-strrpos($matches[$j], '/')-1);
//         break 1;
//     }
// }

// $teanScoringFile = $folder.$folderLeagueURL3.'TeamScoring.html';

$gmFile = getLeagueFile($folder, $playoff, 'GMs.html', 'GMs');
$teamScoringFile = getLeagueFile($folder, $playoff, 'TeamScoring.html', 'TeamScoring');
$teamAbbrHolder = new TeamAbbrHolder($gmFile,$teamScoringFile);


//set days
if(isset($dayNum)){
    $selectedDay = intval($dayNum);
}else{
    $selectedDay = $scheduleHolder->getLastDayPlayed();
}


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
		
		    if(!$game->getIsRequired()){
		        $i++;
		        continue;
		    }
		    
		    $lastEquipe1 = $game->getTeam1(); 
		    $lastEquipe2  = $game->getTeam2(); 
		    $lastScore1 = $game->getTeam1Score();
		    $lastScore2 = $game->getTeam2Score();
		    
		    $team1abbr = $teamAbbrHolder->getAbbr($lastEquipe1);
		    $team2abbr = $teamAbbrHolder->getAbbr($lastEquipe2);
		   

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
						$tmpTeam = trim(substr($val, strpos($val, '(')+1, 3));
						//echo $tmpTeam;
						$reste = trim(substr($val, strpos($val, ',')+1));
						$tmpGoalSaves = trim(substr($reste, 0, strpos($reste, 'saves')-1));
						$reste = trim(substr($reste, strpos($reste, 'of')+2));
						$tmpGoalShots = trim(substr($reste, 0, strpos($reste, 'shots')-1));
						$reste = trim(substr($reste, strpos($reste, ',')+1));
						$tmpGoalStatus = trim(substr($reste, 0, strpos($reste, ',')));
						$reste = trim(substr($reste, strpos($reste, ',')+1));
						$tmpGoalRecord = trim(substr($reste, 0, strpos($reste, '<')));

						$tmpGoalieResult = 'N/A';
						
						if($tmpGoalStatus == 'W' || $tmpGoalStatus == 'L' || $tmpGoalStatus == 'T') {
						    $tmpGoalieResult = $tmpGoalName.' ('.$tmpGoalSaves.'SV, '.$tmpGoalRecord.')';//'.$tmpGoalShots.'
						    
						}else{
						    $tmpGoalieResult = $tmpGoalName.' ('.$tmpGoalSaves.'SV)';//'.$tmpGoalShots.'
						}
						
						if(strcmp($team1abbr, $tmpTeam) == 0){
						    $gameGoal1[$i] = $tmpGoalieResult;
						}else if(strcmp($team2abbr, $tmpTeam) == 0){
						    $gameGoal2[$i]  = $tmpGoalieResult;
						}
						
// 						if($tmpGoalStatus == 'W' || $tmpGoalStatus == 'L' || $tmpGoalStatus == 'T') {
// 							if(!isset($gameGoal1[$i])){
// 							    $gameGoal1[$i] = $tmpGoalName.' ('.$tmpGoalSaves.'SV, '.$tmpGoalRecord.')';//'.$tmpGoalShots.'
// 							}else{
// 							    $gameGoal2[$i] = $tmpGoalName.' ('.$tmpGoalSaves.'SV, '.$tmpGoalRecord.')';//'.$tmpGoalShots.'
// 							}
							
// 							$gProcessed++;
// 						}else{
// 						    //rendering issue.. For some reason record and W/L/T not listed.
						    
// 						    if(!isset($gameGoal1[$i])){
// 						        $gameGoal1[$i] = $tmpGoalName.' ('.$tmpGoalSaves.'SV, N/A)';//'.$tmpGoalShots.'
// 						    }else{
// 						        $gameGoal2[$i] = $tmpGoalName.' ('.$tmpGoalSaves.'SV, N/A)';//'.$tmpGoalShots.'
// 						    }

// 						}
						
	                    //stop and continue to next step if both goalies set.
						if(isset($gameGoal1[$i]) && isset($gameGoal2[$i])){
						    $a = 4;
						}
						
						
						//will happen if no home team goalie or no goalies play
						//skip to next step which will set to NA
						if(!isset($gameGoal1[$i]) && isset($gameGoal2[$i])){
						    $a = 4;
						}
	
                        
					}
					if(substr_count($val, 'Game Stars') && $a == 4) {
					    
					    //default in case not set.
					    if(!isset($gameGoal1[$i])){
					        $gameGoal1[$i] = 'N/A';
					    }
					    
					    if(!isset($gameGoal2[$i])){
					        $gameGoal2[$i] = 'N/A';
					    }
					    
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

	?>
	
	
	<style>

    .footer-header{
    
        color: #85878c;
        font-weight: bold;
        display: block;
        
    }
    
    #scores .pagination {
      margin-top: 10px;
      margin-bottom: 0;
    }
    
    #scores .logo {
        float: left;
        vertical-align: middle;
    /*     width: 40px; */
    /*     height: 40px; */
        max-width: 45px;
        overflow:hidden;
    /*     margin: 0 auto; */
    /*     margin-left:3px; */
        display: block;
    }
    
    #scores .table th{
        vertical-align: middle;
        background-color: #dcdee0;
        border: 0;
        height: 20px;
        line-height: 10px;
    }
    
    #scores .table td{
       border: 1px solid #dcdee0;
       font-size: 25px;
    /*    font-family: Arial,Helvetica,sans-serif; */
       vertical-align: middle;
       padding: .1rem;
       line-height: 45px;
      
    }
    
    .dark-text{
       color: #323232;
    }
    
    .team-acronym {
        color: #323232;
        font-size: 25px;
        font-weight: bold;
        padding-left: 25px;
        vertical-align: middle;
    }
    
    
    .box-score{
/*         background-color: #7a7a7a; */
        background-color: var(--color-primary-1);
        color: white;
    }
    
    .game-score-footer {
        border: 1px solid #dcdee0;
        border-top: none;
        color: #323232;
        background-color: #f0f1f2; 
        padding: 5px 10px;
        font-size: 13px;
        text-transform: uppercase;
    }

    </style>
	
	
	<div id="scores" class = "container">
	<div class="card">

	<?php 
	if($scheduleHolder->isSeasonStarted()){
	    
	    $CurrentTitle = $CurrentTitle . ' (Day - '.$selectedDay.')';
	}
	
	include 'SectionHeader.php';
	    
	    //echo '<h3>Scores Day - '.$selectedDay.'</h3>';
// 	echo '<span style="display: inline-block;"><h3 class="m-0">Scores</h3></span>';
//     echo '<span style="display: inline-block; margin-left:5px; ">(Day - '.$selectedDay.')</span>';
// 	}else{
// 	    echo '<h3>Scores</h3>';
// 	}
	?>

	<div class = "card-body pt-2">
	
	<div class="row align-items-center justify-content-center"> 
	
	<?php 
	if(!$scheduleHolder->isSeasonStarted()){
	    echo '<h3>The season has not started</h3>';
	}
	?>
	
	
	
    <?php 

        if($selectedDay == 1){
            $next = $selectedDay + 1;
            $game3 = 3;
            $game2 = 2;
            $game1 = 1;
            $previous =  0;
        }else if($selectedDay == 2){
            $next = 4;
            $game3 = 3;
            $game2 = 2;
            $game1 = 1;
            $previous = 1;
        } else{
            
            $game3 = $selectedDay;
            $game2 = $selectedDay - 1;
            $game1 = $selectedDay - 2;
            $next = $selectedDay + 1;
            $previous =  $selectedDay - 1;
        }
        
        $nextDisabled = '';
        if($next > $scheduleHolder->getLastDayPlayed()){
            $nextDisabled = 'disabled';
        }
        $prevDisabled = '';
        if($previous < 1){
            $prevDisabled = 'disabled';
        }
    ?>

	<div class="form-inline" <?php echo ($scheduleHolder->isSeasonStarted() ? '' : 'hidden' )?>>
		<div class="form-group">
            <div>
                 <label for="daySelect" class="sr-only"><span>Day</span></label>
            </div>
        	<nav aria-label="Page nav" id="daySelect">
                  <ul class="pagination">
                    <li class="page-item <?php echo $prevDisabled ?>">
                      <a class="page-link" href="<?php echo $CurrentHTML.'.php?dayNum=1'?>" aria-label="Start">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                      </a>
                    </li>
                    <li class="page-item <?php echo $prevDisabled ?>">
                      <a class="page-link" href="<?php echo $CurrentHTML.'.php?dayNum='.$previous?>" aria-label="Previous">
<!--                         <span aria-hidden="true">&lt;</span> -->
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span>
                      </a>
                    </li>
					<?php 

					$gameCounter = $selectedDay >= 3 ? $selectedDay - 2 : $selectedDay;
					$maxGames = 5;
					
					for ($x = 1; $x <= $maxGames; $x++) {
					    
					    if($gameCounter > $scheduleHolder->getLastDayPlayed()) continue;
					    if($gameCounter <= 0) continue;
					    
					    echo '<li class="page-item'.(($gameCounter == $selectedDay)?' active':'').'"><a class="page-link" href="'.$CurrentHTML.'.php?dayNum='.$gameCounter.'">'.$gameCounter.'</a></li>';
					    $gameCounter++;
					}
					
// 					echo '<li class="page-item'.(($game1 == $selectedDay)?' active':'').'"><a class="page-link" href="'.$CurrentHTML.'.php?dayNum='.$game1.'">'.$game1.'</a></li>';
//                     echo '<li class="page-item'.(($game2 == $selectedDay)?' active':'').'"><a class="page-link" href="'.$CurrentHTML.'.php?dayNum='.$game2.'">'.$game2.'</a></li>';
//                     echo '<li class="page-item'.(($game3 == $selectedDay)?' active':'').'"><a class="page-link" href="'.$CurrentHTML.'.php?dayNum='.$game3.'">'.$game3.'</a></li>';

                    ?>
            
                    <li class="page-item  <?php echo $nextDisabled?>">
                      <a class="page-link" href="<?php echo $CurrentHTML.'.php?dayNum='.$next?>" aria-label="Next">
<!--                         <span aria-hidden="true">&gt;</span> -->
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        <span class="sr-only">Next</span>
                      </a>
                    </li>
                    <li class="page-item  <?php echo $nextDisabled?>">
                      <a class="page-link" href="<?php echo $CurrentHTML.'.php?dayNum='.$scheduleHolder->getLastDayPlayed()?>" aria-label="Last">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                      </a>
                    </li>
                  </ul>
            </nav>
		</div>
   	 </div>
     </div>
     
	


	<div class="row"> 
		
	<?php 
	
		
	
		$nbrBox = 1;

		if(!isset($lastGames)) echo '<div class="col"><h3>'.$todayNoSimGame.'<h3></div>';
		else {
			//for($i=0;$i<count($lastGames);$i++){
			$i = 0;
		    foreach ($lastGames as $game) {
		        
		        if(!$game->getIsRequired()){
		            continue;
		        }
			    
			    $lastEquipe1 = $game->getTeam1();
			    $lastEquipe2  = $game->getTeam2();
			    $lastScore1 = $game->getTeam1Score();
			    $lastScore2 = $game->getTeam2Score();
			    $matchNumber = $game->getGameNumber();
	
				if($nbrBox == 1) $nbrBox = 2;
				else $nbrBox = 1;
				
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
	
				$FnmAbbr = $folder.$folderLeagueURL3.'TeamScoring.html';
				if(file_exists($FnmAbbr)) {
					$lastEquipe1Abbr = search($FnmAbbr,$lastEquipe1);
					$lastEquipe2Abbr = search($FnmAbbr,$lastEquipe2);
				}
				else echo $allFileNotFound.' - '.$FnmAbbr;
				

				//header
				echo '<div class="col-sm-12 col-md-6 col-lg-4" style="padding-left: 7px; padding-right: 7px;">';
				
				echo '<div class="card border-dark" style="margin-top:15px;">';
				echo '<div class="card-header box-score" style="padding-bottom: 0px; padding-top: 0px;">';
				    echo '<div class = "text-center" style = "text-transform: uppercase;">
                        '.$lastEquipe1.' @ '.$lastEquipe2.' '.$gameOvertime[$i].
				         '</div>';
				
				   // echo '<div class="row tableau-top"><span style="color:#ffffff">'.$lastEquipe1.' @ '.$lastEquipe2.' Final'.$gameOvertime[$i].'</span></div>';
				echo '</div>';
				echo '<div class="card-body p-3">';
				
				echo '<div class = "row" style=" margin-top: -15px;">';
				    echo '<table class = "table table-sm table-bordered" >';
				    echo '<tbody>';
    				echo '<tr class="d-flex"  style = "text-transform: uppercase;">'; //header
    				    echo '<th class = "col-6"></th>';
    				    echo '<th class = "col text-center">1st</th>';
    				    echo '<th class = "col text-center">2nd</th>';
    				    echo '<th class = "col text-center">3rd</th>';
    				    if ($gameOvertime[$i] != '') {
    				        echo '<th class = "col text-center">OT</th>';
    				    }
    				    echo '<th class = "col text-center">T</th>';
                    echo '</tr>';
                    
                    echo '<tr class="d-flex">'; //header
//                         echo '<td class = "col-6 text-left dark-text">
//                                 <img class="logo" src="'.$todayImage1.'" alt="'.$lastEquipe1.'"</img>'.$lastEquipe1Abbr.'
//                              </td>';
                        echo '<td class = "col-6 dark-text">
                                <div><img class="logo" src="'.$todayImage1.'" alt="'.$lastEquipe1.'"</img></div>
                                <div class = "team-acronym">'.$lastEquipe1Abbr.'</div>
                             </td>';

                        echo '<td class = "col text-center">'.$gameAway2[$i][0].'</td>';
                        echo '<td class = "col text-center">'.$gameAway2[$i][1].'</td>';
                        echo '<td class = "col text-center">'.$gameAway2[$i][2].'</td>';
                        if ($gameOvertime[$i] != '') {
                            echo '<td class = "col text-center">'.$gameAway2[$i][3].'</td>';
                        }
                        echo '<td class = "col text-center dark-text"><strong>'.$lastScore1.'</strong></td>';
                    echo '</tr>';
                    
                    echo '<tr class="d-flex">'; //header
                        //echo '<td class = "col-6 text-left"><img style=" max-height:35px;" src="'.$todayImage2.'" alt="'.$lastEquipe2.'">'.$lastEquipe2Abbr.'</td>';
                        
    //                     echo '<td class = "col-6 text-left dark-text">
    //                                 <img class="logo" src="'.$todayImage2.'" alt="'.$lastEquipe2.'"</img>'.$lastEquipe2Abbr.'
    //                              </td>';
                        echo '<td class = "col-6 dark-text">
                                    <div><img class="logo" src="'.$todayImage2.'" alt="'.$lastEquipe2.'"</img></div>
    				                <div class = "team-acronym">'.$lastEquipe2Abbr.'</div>
                                 </td>';
                        
                        echo '<td class = "col text-center">'.$gameHome2[$i][0].'</td>';
                        echo '<td class = "col text-center">'.$gameHome2[$i][1].'</td>';
                        echo '<td class = "col text-center">'.$gameHome2[$i][2].'</td>';
                        if ($gameOvertime[$i] != '') {
                            echo '<td class = "col text-center">'.$gameHome2[$i][3].'</td>';
                        }
                        echo '<td class = "col text-center dark-text"><strong>'.$lastScore2.'</strong></td>';
                    echo '</tr>';

                    echo '</tbody>';
                    echo '</table>'; //end score-main table
                echo '</div>'; //end score-main
                
                echo '<div class = "row game-score-footer" style="margin-top: -15px;">'; //goals scoring details
                    //echo '<span class = "footer-header">Goals</span>';
                    echo '<div class = "footer-header text-left" style="width: 100%;">Goals</div>';

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
                    
         
                    echo '<div class = "text-left" style="width: 100%;">'.$lastEquipe1.' - <strong>'.$scoringList.'</strong></div>';
                    
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
                    
                    echo '<div class = "text-left" style="width: 100%;" >'.$lastEquipe2.' - <strong>'.$scoringList.'</strong></div>';
                
                echo '</div>'; // end scoring details
                
               echo '<div class = "row game-score-footer" style="margin-bottom: -15px;">'; //goalie details 
                 echo '<div class = "footer-header text-left" style="width: 100%;">Goalies</div>';
                 echo '<div>'.$lastEquipe1.' - '.$gameGoal1[$i].'</div>';
                 echo '<div>'.$lastEquipe2.' - '.$gameGoal2[$i].'</div>';      
               echo '</div>'; // end goalie details
               
//                echo '<div class = "row box-score">'; //box score 
//                 echo '<div class="col"><a class="lien-blanc" href="games.php?num='.$matchNumber.$playoffLink.'">BOX SCORE</a></div>';  
//                echo '</div>'; // end box score
              
 
      
                echo '</div>'; //end card-body
                
                echo '<div class = "card-footer box-score py-1" >';
                    echo '<div class="col text-center"><a class="lien-blanc" href="games.php?num='.$matchNumber.$playoffLink.'">BOX SCORE</a></div>';      
                echo '</div>'; //end card footer 
                
                echo '</div>'; //end card
               
                echo '</div>'; //end col outer
          
      
                $i++;
			}
			
	
			
		}

        echo '</div>'; //end row
        echo '</div>'; //end card-body
        echo '</div>'; //end card
        echo '</div>'; //end container 
        
?>


<?php include 'footer.php'; ?>