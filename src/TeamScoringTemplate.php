<?php
include_once 'config.php';
include_once 'lang.php';
include_once 'common.php';

$seasonId = '';
//$playoff = '';

if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    //$sort = ( isset($_GET['sort']) ) ? $_GET['sort'] : $_POST['sort'];
    //$sort = htmlspecialchars($sort);
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(isset($_GET['seasonType']) || isset($_POST['seasonType'])) {
    $seasonType = ( isset($_GET['seasonType']) ) ? $_GET['seasonType'] : $_POST['seasonType'];

    $playoff = $seasonType;
}

if(isset($_GET['team']) || isset($_POST['team'])) {
    $currentTeam = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
    $currentTeam = htmlspecialchars($currentTeam);

}

?>

<?php

if(trim($seasonId) == false){
    $Fnm = getLeagueFile($folder, $playoff, 'TeamScoring.html', 'TeamScoring');
}else{
    $seasonFolder = str_replace("#",$seasonId,$folderCarrerStats);
    $Fnm = getLeagueFile($seasonFolder, $playoff, 'TeamScoring.html', 'TeamScoring');
}

$a = 0;
$b = 0;
$c = 1;
$d = 1;
$e = 0;
$f = 0;
$fileExists = false;
$lastUpdated = '';
if(file_exists($Fnm)) {
    $fileExists = true;
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);

            $lastUpdated = $val;
            echo '<div class = "row wow fadeIn">';
			echo '<div class="col-sm-12 col-md-10 offset-md-1">';

		}
		if(substr_count($val, '</PRE><BR>') && $b) {
			$d = 0;
		}
		if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
			$pos = strpos($val, '</A>');
			$pos = $pos - 23;
			$equipe = substr($val, 23, $pos);
			$b = 1;
		}
		if($b && $d && substr_count($val, '------------')) {
			$e = 0;
			$c = 1;
		}
		if($b && $d && $e) {
			if($c == 1) $c = 2;
			else $c = 1;
			$reste = trim($val);
			if(substr_count($val, '                         ')) {
				$tmpFwdPosition = '';
				$tmpFwdNumber = '';
				$tmpFwdRookie = '';
				$tmpFwdName = '';
				$bold = '';
			}
			else {
				$tmpFwdPosition = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$tmpFwdNumber = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				if(substr($reste, 0, 1) == '*') {
					$tmpFwdRookie = substr($reste, 0, 1);
					$reste = trim(substr($reste, 1));
				}
				else $tmpFwdRookie = '';
				$tmpFwdHT2 = 0;
			}
			$tmpFwdPS = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdGS = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdPCTG = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdS = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdHT = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdGT = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdGW = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdSHG = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdPPG = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdPIM = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdDiff = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdP = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdA = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdG = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdGP = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpFwdTeam = substr($reste, strrpos($reste, ' '));
			if(!substr_count($val, '                         ')) {
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$tmpFwdName = $reste;
				if(substr_count($tmpFwdName, 'xtrastats.html')) {
					$tmpFwdName = trim(substr($tmpFwdName, strpos($tmpFwdName, '"')+1, strpos($tmpFwdName, '>')-1-strpos($tmpFwdName, '"')-1));
				}
			}
			$tmpVal = $tableau[$cle+1];
			if(substr_count($tmpVal, '                         ') || (!substr_count($val, '                         ') && !substr_count($tmpVal, '                         '))) {
				$tmpFwdHT2 += $tmpFwdHT;
			}
			else $tmpFwdHT = $tmpFwdHT2;
			
			//$scoringNameSearch = htmlspecialchars($tmpFwdName);
			//$scoringNameLink = 'http://www.google.com/search?q='.$scoringNameSearch.'%nhl.com&btnI';
			//$scoringNameLink = urlencode($tmpFwdName);
			//<td><a href="'.$scoringNameLink.'">'.$tmpFwdName.'</a></td>
			
			echo '<tr class="hover'.$c.'">
			<td>'.$tmpFwdPosition.'</td>
			<td>'.$tmpFwdRookie.'</td>
			<td class="text-left"><a href="CareerStatsPlayer.php?csName='.urlencode($tmpFwdName).'">'.$tmpFwdName.'</a></td>
			<td>'.$tmpFwdGP.'</td>
			<td>'.$tmpFwdG.'</td>
			<td>'.$tmpFwdA.'</td>
			<td>'.$tmpFwdP.'</td>
			<td>'.$tmpFwdDiff.'</td>
			<td>'.$tmpFwdPIM.'</td>
			<td>'.$tmpFwdPPG.'</td>
			<td>'.$tmpFwdSHG.'</td>
			<td>'.$tmpFwdGW.'</td>
			<td>'.$tmpFwdGT.'</td>
			<td>'.$tmpFwdHT.'</td>
			<td>'.$tmpFwdS.'</td>
			<td>'.$tmpFwdPCTG.'</td>
			<td>'.$tmpFwdGS.'</td>
			<td>'.$tmpFwdPS.'</td>
			</tr>';
		}
		if($b && $d && substr_count($val, '------------')) {
			$f = 0;
		}
		if($b && $d && $f) {
			if($c == 1) $c = 2;
			else $c = 1;
			$reste = trim($val);
			if(substr_count($val, '                         ')) {
				$tmpGoalPosition = '';
				$tmpGoalNumber = '';
				$tmpGoalRookie = '';
				$tmpGoalName = '';
			}
			else {
				$tmpGoalPosition = 'G';
				$tmpGoalNumber = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				if(substr($reste, 0, 1) == '*') {
					$tmpGoalRookie = substr($reste, 0, 1);
					$reste = trim(substr($reste, 1));
				}
				else $tmpGoalRookie = '';
			}
			$tmpGoalAS = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalPIM = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalPCT = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalSA = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalGA = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalSO = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalT = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalL = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalW = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalAVG = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalMin = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalGP = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$tmpGoalTeam = substr($reste, strrpos($reste, ' '));
			if(!substr_count($val, '                         ')) {
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$tmpGoalName = $reste;
				if(substr_count($tmpGoalName, 'xtrastats.html')) {
					$tmpGoalName = trim(substr($tmpGoalName, strpos($tmpGoalName, '"')+1, strpos($tmpGoalName, '>')-1-strpos($tmpGoalName, '"')-1));
				}
			}
			
			//$goalieNameSearch = htmlspecialchars($tmpGoalName);
			//$goalieNameLink = 'http://www.google.com/search?q='.$goalieNameSearch.'%nhl.com&btnI';
			//<td><a href="'.$goalieNameLink.'">'.$tmpGoalName.'</a></td>

			echo '<tr>
			<td>G</td>
			<td>'.$tmpGoalRookie.'</td>
            <td class="text-left"><a href="CareerStatsPlayer.php?csName='.urlencode($tmpGoalName).'">'.$tmpGoalName.'</a></td>
			<td>'.$tmpGoalGP.'</td>
			<td>'.$tmpGoalMin.'</td>
			<td>'.$tmpGoalAVG.'</td>
			<td>'.$tmpGoalW.'</td>
			<td>'.$tmpGoalL.'</td>
			<td>'.$tmpGoalT.'</td>
			<td>'.$tmpGoalSO.'</td>
			<td>'.$tmpGoalGA.'</td>
			<td>'.$tmpGoalSA.'</td>
			<td>'.$tmpGoalPCT.'</td>
			<td>'.$tmpGoalPIM.'</td>
			<td>'.$tmpGoalAS.'</td>
			</tr>';
		}
		

		if($b && $d && substr_count($val, 'PCTG') ) {
			$e = 1;
			echo '<h5 class="tableau-top titre" style = "padding-top:5px; padding-bottom:5px">'.$scoringScoring.'</h5>';
			echo '<div class = "table-responsive">
			<table id="ForwardScoring" class="table table-sm table-striped table-hover text-center">
                <thead>
                    <tr>
            			<th data-toggle="tooltip" data-placement="top" title="'.$rostersPosition.'">PO</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringRookie.'">R</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringName.'" class="text-left">'.$scoringName.'</th>
			            <th data-toggle="tooltip" data-placement="top" title="'.$scoringGP.'">'.$scoringGPm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringG.'">'.$scoringGm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringAssits.'">A</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$rostersPosition.'">P</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringDiff.'">+/-</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringPIM.'">'.$scoringPIMm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringPP.'">'.$scoringPPm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringSH.'">'.$scoringSHm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringGW.'">'.$scoringGWm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringGT.'">'.$scoringGTm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringHT.'">'.$scoringHTm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringS.'">'.$scoringSm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringPCTG.'">'.$scoringPCTGm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringGS.'">'.$scoringGSm.'</th>
            			<th data-toggle="tooltip" data-placement="top" title="'.$scoringPS.'">'.$scoringPSm.'</th>
        			</tr>
                </thead>
                <tbody style="font-weight:normal">';
		}
		if($b && $d && substr_count($val, 'AVG') ) {
			$f = 1;
			echo '</tbody></table></div>
            <h5 class="tableau-top">'.$scoringGoalie.'</h5>
			<div class = "table-responsive">
			<table id="GoalieStats" class="table table-sm table-striped">
                <thead>
                    <tr>
            			<th>PO</th>
            			<th>R</th>
            			<th class="text-left">'.$scoringName.'</th>
            			<th>'.$scoringGPm.'</th>
            			<th>MIN</th>
            			<th>'.$scoringAVGm.'</th>
            			<th>'.$scoringWm.'</th>
            			<th>'.$scoringLm.'</th>
            			<th>'.$scoringTm.'</th>
            			<th>'.$scoringSOm.'</th>
            			<th>'.$scoringGAm.'</th>
            			<th>'.$scoringSAm.'</th>
            			<th>PCT</th>
            			<th>'.$scoringPIMm.'</th>
            			<th>AS</th>
        			</tr>
    			<thead>
                <tbody style="font-weight:normal">';
		}
	}
	echo '</tbody></table></div></div>';
}
else {
    //echo '<h5 class = "text-center">'.$allFileNotFound.' - '.$Fnm.'</h5>';
    
    if(!$seasonId && isset($playoff) && $playoff=='PLF'){
        echo '<h5 class = "text-center">The playoffs have not started</h5>';
    }else{
        if(isset($playoff) && $playoff = 'PLF'){
            echo '<h5>No playoff data found</h5>';
            
        }else{
            echo '<h5>No season data found</h5>';
            
        }
    }

   
}

if($fileExists && $d){
    if(isset($playoff) && $playoff=='PLF'){
        echo '<h5 class = "text-center">This team did not make the playoffs</h5>';
    }else{
        echo '<h5 class = "text-center">The season has not started</h5>';
    }
   
    echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
}

// if($d) {
// 	echo '<h5 class = "text-center">'.$scoringError.'</h5>';
// }


echo '</div>';
?>

<script>

    $("#ForwardScoring").tablesorter({ 
        sortInitialOrder: 'desc'
    }); 
    $("#GoalieStats").tablesorter({ 
        sortInitialOrder: 'desc'
    }); 



</script>

