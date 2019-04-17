<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once 'config.php';
include 'lang.php';
include_once 'common.php';
include_once 'classes/GameHolder.php';

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

if(file_exists($Fnm)) {
    
    $gameHolder = new GameHolder($Fnm);

}
else {
    echo $allFileNotFound.' - '.$Fnm;
    exit($allFileNotFound.' - '.$Fnm);
}
?>

<style>

.table{
width:100%;
white-space: normal;
}

.header-content { margin-top: 65px; margin-bottom: 10px; }

.highlight-team {
	-webkit-filter: sepia(1);
	filter: sepia(1);
border-bottom:1px solid blue;
}

#header-nav .active {
    font-weight: 1000;
	font-size: large;
}

.team-header-content { 
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#cedce7+9,596a72+100 */
    background: rgb(206,220,231); /* Old browsers */
    background: -moz-linear-gradient(top, rgba(206,220,231,1) 9%, rgba(89,106,114,1) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, rgba(206,220,231,1) 9%,rgba(89,106,114,1) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, rgba(206,220,231,1) 9%,rgba(89,106,114,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cedce7', endColorstr='#596a72',GradientType=0 ); /* IE6-9 */

    border-radius: 5px;   
    margin-bottom:10px;
}

.team-nav {
   a { color: rgba(225, 239, 255, 1.0); ; border-bottom: 1px ; text-decoration: none; transition: all .3; }
   a:hover, a:focus { 
    color: #856dc0; border: 0; text-decoration: none;   -webkit-filter: grayscale(100%);
    -moz-filter: grayscale(100%);
    filter: grayscale(100%);
   }
}

.team-nav a { color: rgba(225, 239, 255, 1.0); border-bottom: 1px ; text-decoration: none; transition: all .3; }

.panel-profile-img { 
	max-width: 75px; 
	margin-top: -10px; 
	margin-bottom: -10px; 
	margin-left: -20px; 
/*  	border: 1px solid #fff;   */
/* 	background-color: #708090;  */
/* 	border-radius: 100%;   */
}

.nav-item{
    text-transform: uppercase;
}



.teamheader {
	background: linear-gradient(rgb(0, 39, 79) 0%, rgb(0, 39, 79) 60%,
		rgb(27, 98, 162) 100%);
/* 	height: 68px; */

    overflow: hidden;
    width: 100%;
    float: left;

	moz-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	-border-bottom-right-radius: 5px;
	-moz-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
	border-bottom-left-radius: 5px;
}

.team .header-container{ 
     background: linear-gradient(rgb(0, 39, 79) 0%, rgb(0, 39, 79) 60%, rgb(27, 98, 162) 100%); */
     height: 68px;  
} 

.teamheader .logo-gradient {
	background: linear-gradient(rgb(0, 39, 79) 0%, rgb(0, 39, 79) 60%,
		rgb(27, 98, 162) 100%);
}

.teamheader .gloss {
	height: 34px;
	background: linear-gradient(to bottom, rgba(255, 255, 255, 0.6) 0%,
		rgba(255, 255, 255, 0.5) 35%, rgba(255, 255, 255, 0.1) 100%);
		
}

.teamheader .team-logo {
	float: left;
	vertical-align: middle;
	text-align: center;
	width: 68px;
	height: 68px;
	-moz-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
	border-bottom-left-radius: 5px;
}

.teamheader .team-right {
	float: right;
	-moz-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	border-bottom-right-radius: 5px;
}

.teamheader .header {
    vertical-align: middle;
    line-height: 20px;
    padding: 5px 10px;

    color: #fff;
    text-transform: uppercase;
    margin-top: -32px;
    text-align: center;
   
}

.teamheader .score {
    vertical-align: middle;
    color:black;
    font-weight:800;
/*     line-height: 20px; */
    padding: 10px 10px;
    font-size: 2rem;
}

.teamheader .gradient-score {
/* 	background: linear-gradient(rgb(0, 39, 79) 0%, rgb(0, 39, 79) 60%, */
/* 		rgb(27, 98, 162) 100%); */

    background-image: linear-gradient(rgb(255, 255, 255) 0%, rgb(255, 255, 255) 50%, rgb(242, 242, 243) 51%, rgb(242, 242, 243) 100%);
}

</style>

	
<?php 
    include_once 'classes/TeamInfo.php';
    $awayTeam = $gameHolder->getAwayTeam();
    $homeTeam = $gameHolder->getHomeTeam();
    $teamInfoAway = new TeamInfo($folder, $playoff, $awayTeam);
    $teamInfoHome = new TeamInfo($folder, $playoff, $homeTeam);
    $awayTeamAbbr='';
    $homeTeamAbbr='';
    $isOvertime= $gameHolder->isOvertime();
    
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
        $awayTeamAbbr = search($FnmAbbr,$awayTeam);
        $homeTeamAbbr = search($FnmAbbr,$homeTeam);
    }
    else exit($allFileNotFound.' - '.$FnmAbbr);
?>

<div class = "container">
	<div class="row">
		<div class="col">
       		<div class="card">
            	<div class="card-header text-center">
            
                    <h4 class="m-0 p-0"><?php echo $awayTeam.' AT '. $homeTeam. ' FINAL' ?></h4>
                   
            	</div>
            	<div class="card-body p-3">
                	<div class="row no-gutters">
                		 <div class= "col-sm-12 col-lg-6 teamheader logo-gradient">
                        	<?php 
                        	$teamCardLogoSrc = glob($folderTeamLogos.strtolower($awayTeam).'.*');
                        	?>
                         	<div class="team-logo gloss logo-gradient">
                                <?php 
                                    if(isset($teamCardLogoSrc[0])) {
                                        echo'<img src="'.$teamCardLogoSrc[0].'" alt="'.$awayTeam.'">';
                                    }
                                ?>
                             </div>
                             <div class="team-logo gloss gradient-score team-right score">
                                <div><?php echo $gameHolder->getAwayScore()?></div>
                             </div>
                        
                             <div class="header-container">
                        
                        		<div class="gloss"></div>
                        		<div class="header">
                        			<h3 class="mb-0" ><?php echo $awayTeam ?></h3>
                        			<?php echo $teamInfoAway->getWins().'-'.$teamInfoAway->getLosses().'-'.$teamInfoAway->getTies() ?>
                        			<?php echo '('.$teamInfoAway->getPlaceString().' '.$teamInfoAway->getConferenceSafeString().')' ?>
                        			
                        		</div>
                        	</div>
                        </div>
                        
                        <div class= "col-sm-12 col-lg-6 teamheader logo-gradient">
                        	<?php 
                        	$teamCardLogoSrc = glob($folderTeamLogos.strtolower($homeTeam).'.*');
                        	?>
                         	<div class="team-logo gloss logo-gradient">
                                <?php 
                                    if(isset($teamCardLogoSrc[0])) {
                                        echo'<img src="'.$teamCardLogoSrc[0].'" alt="'.$homeTeam.'">';
                                    }
                                ?>
                             </div>
                             <div class="team-logo gloss gradient-score team-right score">
                                <div><?php echo $gameHolder->getHomeScore()?></div>
                             </div>
                        
                             <div class="header-container">
                        
                        		<div class="gloss"></div>
                        		<div class="header">
                        			<h3 class="mb-0" ><?php echo $homeTeam ?></h3>
                        			<?php echo $teamInfoHome->getWins().'-'.$teamInfoHome->getLosses().'-'.$teamInfoHome->getTies() ?>
                        			<?php echo '('.$teamInfoHome->getPlaceString().' '.$teamInfoHome->getConferenceSafeString().')' ?>
                        			
                        		</div>
                        	</div>
                        </div>
                	</div> <!-- end main score row -->
                	
                	
                	<div class="row mt-2">
                        <div class="col-sm-12 col-lg-4">
                        	 <table class = "table table-sm table-striped table-bordered text-center" >
                        	    <thead>
                            	 	<tr style = "text-transform: uppercase;"> 
                    				    <th></th>
                    				    <th>1st</th>
                    				    <th>2nd</th>
                    				    <th>3rd</th>
                    				    <?php if ($isOvertime) {?>
                    				        <th class = "text-center">OT</th>
                    				    <?php }?>
                    				    <th class = "text-center">T</th>
                                    </tr>
                                </thead>
            				    <tbody>
                                <tr> 
                                    <td class = "dark-text">
                                             <?php echo $awayTeamAbbr;?>
                                          </td>

                                    <td><?php echo $gameHolder->getAwayGoals()[0]?></td>
                                    <td><?php echo $gameHolder->getAwayGoals()[1]?></td>
                                    <td><?php echo $gameHolder->getAwayGoals()[2]?></td>
                                    <?php if ($isOvertime) {?>
                                        <td class = "text-center"><?php echo $gameHolder->getAwayGoals()[3]?></td>
                                    <?php } ?>
                                    <td class = "text-center dark-text"><strong><?php echo $gameHolder->getAwayScore()?></strong></td>
                                </tr>
                                
                                <tr> 
                                      <td class = "dark-text">
                                             <?php echo $homeTeamAbbr;?>
                                          </td>

                                    <td><?php echo $gameHolder->getHomeGoals()[0]?></td>
                                    <td><?php echo $gameHolder->getHomeGoals()[1]?></td>
                                    <td><?php echo $gameHolder->getHomeGoals()[2]?></td>
                                    <?php if ($isOvertime) { ?>
                                        <td><?php echo $gameHolder->getHomeGoals()[3]?></td>
                                    <?php } ?>
                                    <td class = "dark-text"><strong><?php echo $gameHolder->getHomeScore()?></strong></td>
                                </tr>
            
                                </tbody>
                             </table> 
                        
                        </div> <!-- end score by period -->
                        
                        <?php  
       
                        $awayScorers = array();
                        $homeScorers = array();
                        
                        $allScorers = array_merge($gameHolder->getScoringFirstPeriod(), $gameHolder->getScoringSecondPeriod(), 
                            $gameHolder->getScoringThirdPeriod(), $gameHolder->getScoringOtPeriod());
           
                        foreach($allScorers as $scoring){
                            $name = substr($scoring['SCORE'], 0, strpos($scoring['SCORE'], ' '));
                            
                            if($scoring['TEAM'] == strtoupper($homeTeam)){
                                array_push($homeScorers, $name);
                            }else{
                                array_push($awayScorers, $name);
                            }
                           
                        }
     
                        $scorersHomeCount = array_count_values($homeScorers);
                        $scorersAwayCount = array_count_values($awayScorers);
                        
                        $awayScorersFormatted= '';
                        $homeScorersFormatted= '';
                        
                        while (list ($key, $val) = myEach($scorersAwayCount)) {
                            //echo "$key -> $val <br>";
                            $awayScorersFormatted .= $key.' ('.$val.'), ';
                        }
                        
                        while (list ($key, $val) = myEach($scorersHomeCount)) {
                            //echo "$key -> $val <br>";
                            $homeScorersFormatted .= $key.' ('.$val.'), ';
                        }

                        
                        ?>
                        
                        <div class="col-sm-12 col-lg-4">
                        
                        	<table class="table table-sm table-striped">
                        		<thead>
                            		<tr>
                            			<th>GOALS</th>
                            		</tr>
                        		</thead>
                        		<tbody>
                            		<tr>
                            			<td><?php echo $awayTeam?> - <span style="font-weight: bold;"><?php echo $awayScorersFormatted ?></span></td>
                            		</tr>
                            		<tr>
                            			<td><?php echo $homeTeam?> - <span style="font-weight: bold;"><?php echo $homeScorersFormatted ?></span></td>
                            		</tr>
                        		</tbody>
                        	</table>
                        
                        </div><!-- end goals smmary -->
                        
                        
                        <?php               
                            $awayGoalieFormatted='';
                            $homeGoalieFormatted='';
                            foreach($gameHolder->getGoalieStats() as $goalieState){
                                if($goalieState['TEAM'] == $awayTeamAbbr && !empty($goalieState["STATUS"])){
                                    $awayGoalieFormatted = $goalieState['PLAYER'].' ('.$goalieState["SAVES"].' SV)';
                                }elseif($goalieState['TEAM'] == $homeTeamAbbr && !empty($goalieState["STATUS"])){
                                    $homeGoalieFormatted = $goalieState['PLAYER'].' ('.$goalieState["SAVES"].' SV)';
                                }
                            }
                        
                        ?>
                        
                        <div class="col-sm-12 col-lg-4">
                         	<table class="table table-sm table-striped ">
                        		<thead>
                            		<tr>
                            			<th>GOALTENDERS:</th>
                            		</tr>
                        		</thead>
                        		<tbody>
                            		<tr>
                            			<td><?php echo $awayTeam?> - <span style="font-weight: bold;"><?php echo $awayGoalieFormatted ?></span></td>
                            		</tr>
                            		<tr>
                            			<td><?php echo $homeTeam?> - <span style="font-weight: bold;"><?php echo $homeGoalieFormatted ?></span></td>
                            		</tr>
                        		</tbody>
                        	</table>
                        </div><!-- end goalie smmary -->
                    
                	</div><!-- end mini scores row -->

                	
                	<div class="row no-gutters">
             	                	
                    	<?php             	
                    	$awayScoreCounter = 0;
                    	$homeScoreCounter = 0;      	
                    	?>
                	
                		<div class="col-sm-12 col-lg-8 offset-lg-2">
                		<div><h5>SCORING SUMMARY</h5></div>
                		<div>
                			<div class="tableau-top">1ST PERIOD</div>
    
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:10%">Time</th>
                                        <th style="width:20%">Team</th>
                                        <th style="width:60%">Details</th>
                                        <th style="width:10%">Score</th>
                               		</tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	foreach($gameHolder->getScoringFirstPeriod() as $scoringTemp){
                                	    if($scoringTemp['TEAM'] == strtoupper($homeTeam)){
                                	        $homeScoreCounter++;
                                	    }else{
                                	        $awayScoreCounter++;
                                	    }
                                	    
                                	    echo '<tr >
                                            <td>'.$scoringTemp['TIME'].'</td>
                                            <td>'.$scoringTemp['TEAM'].'</td>
                                            <td>'.$scoringTemp['SCORE'].'</td>
                                            <td>'.$awayScoreCounter.'-'.$homeScoreCounter.'</td>
                                        </tr>';
                                	}  
                                	
                                	if(empty($gameHolder->getScoringFirstPeriod())){
                                	    echo '<tr><td class="text-center" colspan="4">NO SCORING</td></tr>';
                                	}
                                	?>
                                </tbody>
                            </table>
                            
                            <div class="tableau-top">2ND PERIOD</div>
    
                            <table class="table table-sm table-striped">
          					    <thead>
                                    <tr>
                                        <th style="width:10%">Time</th>
                                        <th style="width:20%">Team</th>
                                        <th style="width:60%">Details</th>
                                        <th style="width:10%">Score</th>
                               		</tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	foreach($gameHolder->getScoringSecondPeriod() as $scoringTemp){
                                	    
                                	    if($scoringTemp['TEAM'] == strtoupper($homeTeam)){
                                	        $homeScoreCounter++;
                                	    }else{
                                	        $awayScoreCounter++;
                                	    }
                                	    
                                	    echo '<tr >
                                            <td>'.$scoringTemp['TIME'].'</td>
                                            <td>'.$scoringTemp['TEAM'].'</td>
                                            <td>'.$scoringTemp['SCORE'].'</td>
                                            <td>'.$awayScoreCounter.'-'.$homeScoreCounter.'</td>
                                        </tr>';
                                	    
                                	}  
                                	if(empty($gameHolder->getScoringSecondPeriod())){
                                	    echo '<tr><td class="text-center" colspan="4">NO SCORING</td></tr>';
                                	}
                                	?>
                                </tbody>
                            </table>
                            
                            <div class="tableau-top">3RD PERIOD</div>
    
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:10%">Time</th>
                                        <th style="width:20%">Team</th>
                                        <th style="width:60%">Details</th>
                                        <th style="width:10%">Score</th>
                               		</tr>
                                </thead>
                                <tbody>
                                	<?php 

                                	foreach($gameHolder->getScoringThirdPeriod() as $scoringTemp){
                                	    
                                	    if($scoringTemp['TEAM'] == strtoupper($homeTeam)){
                                	        $homeScoreCounter++;
                                	    }else{
                                	        $awayScoreCounter++;
                                	    }
                                	    
                                	    echo '<tr >
                                            <td>'.$scoringTemp['TIME'].'</td>
                                            <td>'.$scoringTemp['TEAM'].'</td>
                                            <td>'.$scoringTemp['SCORE'].'</td>
                                            <td>'.$awayScoreCounter.'-'.$homeScoreCounter.'</td>
                                        </tr>';
                                	    
                                	   
                                	}  
                                	if(empty($gameHolder->getScoringThirdPeriod())){
                                	    echo '<tr><td class="text-center" colspan="4">NO SCORING</td></tr>';
                                	}
                                	?>
                                </tbody>
                            </table>
                            
                            <?php if($isOvertime){ ?>
                            
                                          <div class="tableau-top">OVERTIME PERIOD</div>
    
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:10%">Time</th>
                                        <th style="width:20%">Team</th>
                                        <th style="width:60%">Details</th>
                                        <th style="width:10%">Score</th>
                               		</tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	foreach($gameHolder->getScoringOtPeriod() as $scoringTemp){
                                	    if($scoringTemp['TEAM'] == strtoupper($homeTeam)){
                                	        $homeScoreCounter++;
                                	    }else{
                                	        $awayScoreCounter++;
                                	    }
                                	    
                                	    echo '<tr >
                                            <td>'.$scoringTemp['TIME'].'</td>
                                            <td>'.$scoringTemp['TEAM'].'</td>
                                            <td>'.$scoringTemp['SCORE'].'</td>
                                            <td>'.$awayScoreCounter.'-'.$homeScoreCounter.'</td>
                                        </tr>';
                                	}  
                                	
                                	if(empty($gameHolder->getScoringOtPeriod())){
                                	    echo '<tr><td class="text-center" colspan="4">NO SCORING</td></tr>';
                                	}
                                	?>
                                </tbody>
                            </table>
                            
                            <?php }?>
                		</div>
                		</div>
                	</div> <!-- end scoring summary -->
                	
                	<div class="row">
                		<div class="col-sm-12 col-lg-8 offset-lg-2">
                    		<div class="card text-center">
                                <div id="rosterTabs" class="card-header px-2 px-lg-4 pb-1 pt-2">
                                	<h4>STATISTICS</h4>
                                    <ul class="nav nav-tabs nav-fill">
                            			<li class="nav-item">
                                            <a class="nav-link active" href="#AwayTeamStats" data-toggle="tab"><?php echo $awayTeam?></a>
                            			</li>
                            			<li class="nav-item">
                                            <a class="nav-link" href="#HomeTeamStats" data-toggle="tab"><?php echo $homeTeam?></a>
                            			</li>
                                    </ul>
                                </div>
                                <div class="card-body tab-content p-0 m-0">
                                	<div class="tab-pane active" id="AwayTeamStats">
                                		<table class="table table-sm table-striped text-center">
                                            <thead>
                                                <tr>
                                                	<th class="text-left">NAME</th>
                                                    <th>G</th>
                                                    <th>A</th>
                                                    <th>PTS</th>
                                                    <th>+/-</th>
                                                    <th>PIM</th>
                                                    <th>HT</th>
                                                    <th>IT</th>
                                                    
                                           		</tr>
                                            </thead>
                                            <tbody>
                                            	<?php 
                                            	foreach($gameHolder->getAwayStats() as $scoringTemp){
                                        
                                            	    echo '<tr >
                                                        <td class="text-left">'.$scoringTemp['NAME'].'</td>
                                                        <td>'.$scoringTemp['G'].'</td>
                                                        <td>'.$scoringTemp['A'].'</td>
                                                        <td>'.$scoringTemp['P'].'</td>
                                                        <td>'.$scoringTemp['PLUSMINUS'].'</td>
                                                        <td>'.$scoringTemp['PIM'].'</td>
                                                        <td>'.$scoringTemp['HT'].'</td>
                                                        <td>'.$scoringTemp['IT'].'</td>
                                                    </tr>';
                                            	}  
                                            	?>
                                            </tbody>
                                        </table>
                                	</div>
                                	<div class="tab-pane" id="HomeTeamStats">
                                		<table class="table table-sm table-striped text-center">
                                            <thead>
                                                <tr>
                                                	<th class="text-left">NAME</th>
                                                    <th>G</th>
                                                    <th>A</th>
                                                    <th>PTS</th>
                                                    <th>+/-</th>
                                                    <th>PIM</th>
                                                    <th>HT</th>
                                                    <th>IT</th>
                                                    
                                           		</tr>
                                            </thead>
                                            <tbody>
                                            	<?php 
                                            	foreach($gameHolder->getHomeStats() as $scoringTemp){
                                        
                                            	    echo '<tr >
                                                        <td class="text-left">'.$scoringTemp['NAME'].'</td>
                                                        <td>'.$scoringTemp['G'].'</td>
                                                        <td>'.$scoringTemp['A'].'</td>
                                                        <td>'.$scoringTemp['P'].'</td>
                                                        <td>'.$scoringTemp['PLUSMINUS'].'</td>
                                                        <td>'.$scoringTemp['PIM'].'</td>
                                                        <td>'.$scoringTemp['HT'].'</td>
                                                        <td>'.$scoringTemp['IT'].'</td>
                                                    </tr>';
                                            	}  
                                            	?>
                                            </tbody>
                                        </table>
                                	</div>
                                </div>
                            </div>
                		</div>
                	</div>
                	
            	</div> <!-- end card body -->
            </div>
        </div>
    </div>
    
	
</div>


<?php

echo '<pre>';
//echo json_encode($gameHolder, JSON_PRETTY_PRINT);
echo jsonPrettify(json_encode($gameHolder));
echo '/<pre>';

?>

<?php include 'footer.php'; ?>
