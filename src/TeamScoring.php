<?php
include 'config.php';
include 'lang.php';

$CurrentHTML = 'TeamScoring';
$CurrentTitle = $scoringTitle;
$CurrentPage = 'TeamScoring';
include 'head.php';
include 'TeamHeader.php';
?>



<div class="container">

<?php

$Fnm = getLeagueFile($folder, $playoff, 'TeamScoring.html', 'TeamScoring');

$a = 0;
$b = 0;
$c = 1;
$d = 1;
$e = 0;
$f = 0;
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);


			echo '<div class="card">';
			echo '<div class="card-header wow fadeIn" style="padding-bottom: 0px; padding-top: 2px;">';
				echo'<div class = "row d-flex align-items-center justify-content-center">';

					$teamCardLogoSrc = glob($folderTeamLogos.strtolower($currentTeam).'.*');
					if(isset($teamCardLogoSrc[0])) {
						echo'<img class="float-left card-img-top" src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
					}
					echo'<h3>'.$CurrentTitle.'</h3>';
				echo'</div>';
			echo' </div>';
			echo '<div class="card-body">';

			echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$val.'</h5>';
			
			echo '<div class = "row wow fadeIn">';
			echo '<div class="col-sm-12 col-md-8 offset-md-2">';
		}
		if(substr_count($val, '</PRE><BR>') && $b) {
			$d = 0;
		}
		if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
			$pos = strpos($val, '</A>');
			$pos = $pos - 23;
			$equipe = substr($val, 23, $pos);
			//echo '<tr class="titre"><td colspan="20" class="text-blanc bold-blanc">'.$equipe.'</td></tr></table>';
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
			<td><a href="CareerStatsPlayer.php?csName='.urlencode($tmpFwdName).'">'.$tmpFwdName.'</a></td>
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

			echo '<tr class="hover'.$c.'">
			<td>G</td>
			<td>'.$tmpGoalRookie.'</td>
            <td><a href="CareerStatsPlayer.php?csName='.urlencode($tmpGoalName).'">'.$tmpGoalName.'</a></td>
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
			<table id="ForwardScoring" class="table table-sm">
                <thead>
                    <tr class="tableau-top">
            			<td style="text-align:center;"><a class="info" href="javascript:return;">P<span>Position</span></a></td>
            			<td><a class="info" href="javascript:return;">R<span>'.$scoringRookie.'</span></a></td>
            			<td >'.$scoringName.'</td>
            			<td><a class="info" href="javascript:return;">'.$scoringGPm.'<span>'.$scoringGP.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringGm.'<span>'.$scoringG.'</span></a></td>
            			<td><a class="info" href="javascript:return;">A<span>'.$scoringAssits.'</span></a></td>
            			<td style="text-align:right; font-weight:bold;"><a class="info" href="javascript:return;">P<span>Points</span></a></td>
            			<td><a class="info" href="javascript:return;">+/-<span>'.$scoringDiff.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringPIMm.'<span>'.$scoringPIM.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringPPm.'<span>'.$scoringPP.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringSHm.'<span>'.$scoringSH.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringGWm.'<span>'.$scoringGW.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringGTm.'<span>'.$scoringGT.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringHTm.'<span>'.$scoringHT.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringSm.'<span>'.$scoringS.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringPCTGm.'<span>'.$scoringPCTG.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringGSm.'<span>'.$scoringGS.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringPSm.'<span>'.$scoringPS.'</span></a></td>
        			</tr>
                </thead>
                <tbody style="font-weight:normal">';
		}
		if($b && $d && substr_count($val, 'AVG') ) {
			$f = 1;
			echo '</tbody></table></div>
            <h5 class="tableau-top titre" style = "padding-top:5px; padding-bottom:5px">'.$scoringGoalie.'</h5>
			<div class = "table-responsive">
			<table id="GoalieStats" class="table table-sm">
                <thead>
                    <tr class="tableau-top">
            			<td style="text-align:center;"><a class="info" href="javascript:return;">P<span>Position</span></a></td>
            			<td><a class="info" href="javascript:return;">R<span>'.$scoringRookie.'</span></a></td>
            			<td>'.$scoringName.'</td>
            			<td><a class="info" href="javascript:return;">'.$scoringGPm.'<span>'.$scoringGP.'</span></a></td>
            			<td><a class="info" href="javascript:return;">MIN<span>'.$scoringMIN.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringAVGm.'<span>'.$scoringAVG.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringWm.'<span>'.$scoringW.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringLm.'<span>'.$scoringL.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringTm.'<span>'.$scoringT.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringSOm.'<span>'.$scoringSO.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringGAm.'<span>'.$scoringGA.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringSAm.'<span>'.$scoringSA.'</span></a></td>
            			<td><a class="info" href="javascript:return;">PCT<span>'.$scoringPCT.'</span></a></td>
            			<td><a class="info" href="javascript:return;">'.$scoringPIMm.'<span>'.$scoringPIM.'</span></a></td>
            			<td>AS</td>
        			</tr>
    			<thead>
                <tbody style="font-weight:normal">';
		}
	}
	echo '</tbody></table></div></div></div></div></div></div></div>';
}
else echo '<h5 class = "text-center">'.$allFileNotFound.' - '.$Fnm.'</h5>';

if($d) {
	echo '<h5 class = "text-center">'.$scoringError.'</h5>';
}
?>

<script>

window.onload = function () {
	makeTableSortable('ForwardScoring');
	makeTableSortable('GoalieStats');
	};

</script>

<?php include 'footer.php'; ?>