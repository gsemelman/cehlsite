<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$gameNum = null;
if(isset($_GET['gameNum']) || isset($_POST['gameNum'])) {
    $gameNum = ( isset($_GET['gameNum']) ) ? $_GET['gameNum'] : $_POST['gameNum'];
}

include 'config.php';
include 'lang.php';
include_once 'classes/ScheduleHolder.php';
include_once 'classes/ScheduleObj.php';

$CurrentHTML = 'TodayGamesNew2';
$CurrentTitle = $todayTitle;
$CurrentPage = 'TodayGames';
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
$round = 0;
$playoffLink = '';

$scheduleHolder = new ScheduleHolder($fileName, '');



if(isset($gameNum)){
    $lastGamePlayed = intval($gameNum);
}else{
    $lastGamePlayed = $scheduleHolder->getLastDayPlayed();
}


$lastGames = $scheduleHolder->getScheduleByDay($lastGamePlayed);


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

	?>
	
	
	<div id="#scores" class = "container">
	
	<h2>Scores Day - <?php echo $lastGamePlayed?></h2>
	
	<div class="row align-items-center justify-content-center"> 
	
    <?php 
    
        $next = $lastGamePlayed + 1;
        $game3 = $lastGamePlayed;
        $game2 = $lastGamePlayed - 1;
        $game1 = $lastGamePlayed - 2;
        $previous =  $lastGamePlayed - 3;
    ?>

	<div class="form-inline">
		<div class="form-group mb-2">
            <div>
                 <label for="daySelect" class="sr-only"><span>Day</span></label>
            </div>
        	<nav aria-label="Page nav" id="daySelect">
                  <ul class="pagination">
                    <li class="page-item">
                      <a class="page-link" href="<?php echo $CurrentHTML.'.php?gameNum='.$previous?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                      </a>
                    </li>
					<?php 
                    echo '<li class="page-item"><a class="page-link" href="'.$CurrentHTML.'.php?gameNum='.$game1.'">'.$game1.'</a></li>';
                    echo '<li class="page-item"><a class="page-link" href="'.$CurrentHTML.'.php?gameNum='.$game2.'">'.$game2.'</a></li>';
                    echo '<li class="page-item active"><a class="page-link" href="'.$CurrentHTML.'.php?gameNum='.$game3.'">'.$game3.'</a></li>';

                    ?>
            
                    <li class="page-item">
                      <a class="page-link" href="<?php echo $CurrentHTML.'.php?gameNum='.$next?>" aria-label="Next">
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
				echo '<div class="col-sm-12 col-md-6 col-lg-4">';
				//echo '<div class="col-sm-12 bordertest league-scores">';
				echo '<div class="card" style="margin-top:15px">';
				echo '<div class="card-header" style="padding-bottom: 1px; padding-top: 5px;">';
				    echo '<h3>'.$lastEquipe1.' @ '.$lastEquipe2.' '.$gameOvertime[$i].'</h3>';
				
				   // echo '<div class="row tableau-top"><span style="color:#ffffff">'.$lastEquipe1.' @ '.$lastEquipe2.' Final'.$gameOvertime[$i].'</span></div>';
				echo '</div>';
				echo '<div class="card-body">';
				
				echo '<div class = "row">';
				    echo '<table class = "table table-sm table-bordered">';
				    echo '<tbody>';
    				echo '<tr class="d-flex">'; //header
    				    echo '<th class = "col-6"></th>';
    				    echo '<th class = "col text-center">1st</th>';
    				    echo '<th class = "col text-center">2nd</th>';
    				    echo '<th class = "col text-center">3rd</th>';
    				    if ($gameOvertime[$i] != '') {
    				        echo '<th class = "col text-center">OT</th>';
    				    }
    				    echo '<th class = "col text-center">T</th>';
                    echo '</tr>';
                    
                    echo '<tr class="d-flex" style= " background-color: transparent;">'; //header
                        echo '<td class = "col-6 text-left"><img style=" height:35px;" src="'.$todayImage1.'" alt="'.$lastEquipe1.'">'.$lastEquipe1Abbr.'</td>';
                        echo '<td class = "col mid-align">'.$gameAway2[$i][0].'</td>';
                        echo '<td class = "col">'.$gameAway2[$i][1].'</td>';
                        echo '<td class = "col">'.$gameAway2[$i][2].'</td>';
                        if ($gameOvertime[$i] != '') {
                            echo '<td class = "col">'.$gameAway2[$i][3].'</td>';
                        }
                        echo '<td class = "col"><strong>'.$lastScore1.'</strong></td>';
                    echo '</tr>';
                    
                    echo '<tr class="d-flex ">'; //header
                    echo '<td class = "col-6 text-left"><img style=" max-height:35px;" src="'.$todayImage2.'" alt="'.$lastEquipe2.'">'.$lastEquipe2Abbr.'</td>';
                    echo '<td class = "col">'.$gameHome2[$i][0].'</td>';
                    echo '<td class = "col">'.$gameHome2[$i][1].'</td>';
                    echo '<td class = "col">'.$gameHome2[$i][2].'</td>';
                    if ($gameOvertime[$i] != '') {
                        echo '<td class = "col">'.$gameHome2[$i][3].'</td>';
                    }
                    echo '<td class = "col"><strong>'.$lastScore2.'</strong></td>';
                    echo '</tr>';

                    echo '</tbody>';
                    echo '</table>'; //end score-main table
                echo '</div>'; //end score-main
                
                echo '<div class = "row game-score-footer">'; //goals scoring details
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
                    
         
                    echo '<div class = "text-left">'.$lastEquipe1.' - <strong>'.$scoringList.'</strong></div>';
                    
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
                    
                    echo '<div class = "text-left">'.$lastEquipe2.' - <strong>'.$scoringList.'</strong></div>';
                
                echo '</div>'; // end scoring details
                
               echo '<div class = "row game-score-footer">'; //goalie details 
                 echo '<div class = "footer-header text-left" style="width: 100%;">Goalies</div>';
                 echo '<div>'.$lastEquipe1.' - '.$gameGoal1[$i].'</div>';
                 echo '<div>'.$lastEquipe2.' - '.$gameGoal2[$i].'</div>';      
               echo '</div>'; // end goalie details
      
               //box score link
//                echo '<div class = "tableau-top row text-center">'; //box score link
                
//                 echo '<div class="col"><a class="lien-blanc" href="games.php?num='.$matchNumber.$playoffLink.'">BOX SCORE</a></div>';
//                echo '</div>'; // end box score 
      
                echo '</div>'; //end card-body
                echo '<div class = "tableau-top card-footer" style="padding-bottom: 1px; padding-top: 2px;">';
                echo '<div class="col"><a class="lien-blanc" href="games.php?num='.$matchNumber.$playoffLink.'">BOX SCORE</a></div>';
                
                echo '</div>'; //end card footer 
                
                echo '</div>'; //end card
                //echo '</div>'; //end col inner
                echo '</div>'; //end col outer
          
      
                $i++;
			}
			
	
			
		}

        echo '</div>'; //end row
        echo '</div>'; //end container 
        
?>

<style>
.bordertest {
	margin-top:10px;
	border: #cdcdcd thin solid;
/* 	border-radius: 10px; */
/* 	-moz-border-radius: 10px; */
/* 	-webkit-border-radius: 10px; */
}

.footer-header{

    color: #85878c;
    font-weight: bold;
    display: block;
    
}

.test{
background-color: #fff;
}


.table th{
    background-color: #dcdee0;
    border: 0;
}

.table td{
   border: 1px solid #dcdee0;
   font-size: 25px;
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

<?php include 'footer.php'; ?>