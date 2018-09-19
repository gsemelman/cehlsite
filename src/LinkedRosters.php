<?php
include 'config.php';
include 'lang.php';

$CurrentHTML = '';
$CurrentTitle = $linkedTitle;
$CurrentPage = 'LinkedRosters';
include 'head.php';
?>

<!--<h3 class = "text-center wow fadeIn"><?php echo $linkedTitle.' - '.$currentTeam; ?></h3>-->

<div class="container">

<?php
$matches = glob($folder.'*'.$playoff.'Rosters.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Rosters')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}

$Fnm = $folder.$folderLeagueURL.'TeamScoring.html';
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
		if(substr_count($val, '</PRE><BR>') && $b) {
			$d = 0;
		}
		if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
			$b = 1;
		}
		if($b && $d && substr_count($val, '------------')) {
			$e = 0;
			$c = 1;
		}
		if($b && $d && $e) {
			$reste = trim($val);
			if(substr_count($val, '                         ')) {
				if($c == 1) $c = 2;
				else $c = 1;
				$tmpFwdPosition = '';
				$tmpFwdNumber = '';
				$tmpFwdRookie = '';
				$tmpFwdName = '';
				$bold = '';
			}
			else {
				if(isset($MemNumber) && isset($MemteamScoringposition) && $MemteamScoringposition != 'G') echo '<div style="display:none; width:555px;" id="num'.$MemNumber.'">'.$enteteF.$statsForward.'</table></div>';
				$statsForward = '';
				$c = 2;
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
				$MemteamScoringposition = $tmpFwdPosition;
				$MemNumber = $tmpFwdNumber;
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
			
			$statsForward .= '<tr class="hover'.$c.'">
			<td style="text-align:center;">'.$tmpFwdPosition.'</td>
			<td>'.$tmpFwdNumber.'</td>
			<td>'.$tmpFwdRookie.'</td>
			<td>'.$tmpFwdName.'</td>
			<td>'.$tmpFwdTeam.'</td>
			<td style="text-align:right;">'.$tmpFwdGP.'</td>
			<td style="text-align:right;">'.$tmpFwdG.'</td>
			<td style="text-align:right;">'.$tmpFwdA.'</td>
			<td style="text-align:right; font-weight:bold;">'.$tmpFwdP.'</td>
			<td style="text-align:right;">'.$tmpFwdDiff.'</td>
			<td style="text-align:right;">'.$tmpFwdPIM.'</td>
			<td style="text-align:right;">'.$tmpFwdPPG.'</td>
			<td style="text-align:right;">'.$tmpFwdSHG.'</td>
			<td style="text-align:right;">'.$tmpFwdGW.'</td>
			<td style="text-align:right;">'.$tmpFwdGT.'</td>
			<td style="text-align:right;">'.$tmpFwdHT.'</td>
			<td style="text-align:right;">'.$tmpFwdS.'</td>
			<td style="text-align:right;">'.$tmpFwdPCTG.'</td>
			<td style="text-align:right;">'.$tmpFwdGS.'</td>
			<td style="text-align:right;">'.$tmpFwdPS.'</td>
			</tr>';
		}
		if($b && $d && substr_count($val, '------------')) {
			$f = 0;
		}
		if($b && $d && $f) {
			$reste = trim($val);
			if(substr_count($val, '                         ')) {
				if($c == 1) $c = 2;
				else $c = 1;
				$tmpGoalPosition = '';
				$tmpGoalNumber = '';
				$tmpGoalRookie = '';
				$tmpGoalName = '';
			}
			else {
				if(isset($MemNumber2)) echo '<div style="display:none; width:555px;" id="num'.$MemNumber2.'">'.$enteteG.$statsGoalie.'</table></div>';
				$statsGoalie = '';
				$c = 2;
				$tmpGoalPosition = 'G';
				$tmpGoalNumber = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				if(substr($reste, 0, 1) == '*') {
					$tmpGoalRookie = substr($reste, 0, 1);
					$reste = trim(substr($reste, 1));
				}
				else $tmpGoalRookie = '';
				
				$MemNumber2 = $tmpGoalNumber;
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
			
			$statsGoalie .= '<tr class="hover'.$c.'">
			<td style="text-align:center;">G</td>
			<td>'.$tmpGoalNumber.'</td>
			<td>'.$tmpGoalRookie.'</td>
			<td>'.$tmpGoalName.'</td>
			<td>'.$tmpGoalTeam.'</td>
			<td style="text-align:right;">'.$tmpGoalGP.'</td>
			<td style="text-align:right;">'.$tmpGoalMin.'</td>
			<td style="text-align:right;">'.$tmpGoalAVG.'</td>
			<td style="text-align:right;">'.$tmpGoalW.'</td>
			<td style="text-align:right;">'.$tmpGoalL.'</td>
			<td style="text-align:right;">'.$tmpGoalT.'</td>
			<td style="text-align:right;">'.$tmpGoalSO.'</td>
			<td style="text-align:right;">'.$tmpGoalGA.'</td>
			<td style="text-align:right;">'.$tmpGoalSA.'</td>
			<td style="text-align:right;">'.$tmpGoalPCT.'</td>
			<td style="text-align:right;">'.$tmpGoalPIM.'</td>
			<td style="text-align:right;">'.$tmpGoalAS.'</td>
			</tr>';
		}
		if($b && $d && substr_count($val, 'PCTG') ) {
			$e = 1;
			$enteteF = '<table class="table table-sm"><tr class="tableau-top">
			<td style="text-align:center;"><a class="info" href="javascript:return;">P<span>Position</span></a></td>
			<td><a class="info" href="javascript:return;">#<span>'.$scoringNumber.'</span></a></td>
			<td><a class="info" href="javascript:return;">R<span>'.$scoringRookie.'</span></a></td>
			<td>'.$scoringName.'</td>
			<td><a class="info" href="javascript:return;">'.$scoringTMm.'<span>'.$scoringTM.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGPm.'<span>'.$scoringGP.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGm.'<span>'.$scoringG.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">A<span>'.$scoringAssits.'</span></a></td>
			<td style="text-align:right; font-weight:bold;"><a class="info" href="javascript:return;">P<span>Points</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">+/-<span>'.$scoringDiff.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringPIMm.'<span>'.$scoringPIM.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringPPm.'<span>'.$scoringPP.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringSHm.'<span>'.$scoringSH.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGWm.'<span>'.$scoringGW.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGTm.'<span>'.$scoringGT.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringHTm.'<span>'.$scoringHT.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringSm.'<span>'.$scoringS.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringPCTGm.'<span>'.$scoringPCTG.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGSm.'<span>'.$scoringGS.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringPSm.'<span>'.$scoringPS.'</span></a></td>
			</tr>';
		}
		if($b && $d && substr_count($val, 'AVG') ) {
			if(isset($MemNumber) && isset($MemteamScoringposition) && $MemteamScoringposition != 'G') echo '<div style="display:none; width:555px;" id="num'.$MemNumber.'">'.$enteteF.$statsForward.'</table></div>';
			$f = 1;
			$enteteG = '<table class="table table-sm"><tr class="tableau-top">
			<td style="text-align:center;"><a class="info" href="javascript:return;">P<span>Position</span></a></td>
			<td><a class="info" href="javascript:return;">#<span>'.$scoringNumber.'</span></a></td>
			<td><a class="info" href="javascript:return;">R<span>'.$scoringRookie.'</span></a></td>
			<td>'.$scoringName.'</td>
			<td><a class="info" href="javascript:return;">'.$scoringTMm.'<span>'.$scoringTM.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGPm.'<span>'.$scoringGP.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">MIN<span>'.$scoringMIN.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringAVGm.'<span>'.$scoringAVG.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringWm.'<span>'.$scoringW.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringLm.'<span>'.$scoringL.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringTm.'<span>'.$scoringT.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringSOm.'<span>'.$scoringSO.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGAm.'<span>'.$scoringGA.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringSAm.'<span>'.$scoringSA.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">PCT<span>'.$scoringPCT.'</span></a></td>
			<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringPIMm.'<span>'.$scoringPIM.'</span></a></td>
			<td style="text-align:right;">AS</td>
			</tr>';
		}
	}
	if(isset($MemNumber2)) echo '<div style="display:none; width:555px;" id="num'.$MemNumber2.'">'.$enteteG.$statsGoalie.'</table></div>';
}
else echo $allFileNotFound.' - '.$Fnm;

?>

<div id="playerStatsFrame" style="display:none; z-index:10; margin-left:auto; margin-right:auto; background-color:#ffffff; width:555px; border:solid 1px<?php echo $couleur_contour; ?>; position:fixed; left:0; right:0; top:300px;">
<!--<div class="titre"><span class="bold-blanc" id="playerStatsName">Player Stats!</span></div>-->
<div><span id="playerStatsName">Player Stats!</div>
<div id="playerStats">Player Stats!</div>
</div>

<!--<div style="clear:both; width:820px; margin-left:auto; margin-right:auto; border:solid 1px<?php echo $couleur_contour; ?>">
<div class="titre"><span class="bold-blanc"><?php echo $linkedTitle.' - '.$currentTeam; ?></span></div>-->
<!--<div class = "container">
	<div class = "row wow fadeIn">
	<div class="col-sm-12 col-md-12 col-lg-10 offset-lg-1">
			<div class = "table-responsive">
				<table class="table table-sm">-->
			

<?php
// NOUVEAU CODE LINKED ROSTERS
$Fnm = $folder.$folderLeagueURL.'Rosters.html';
$Fnm2 =  $folder.$folderLeagueURL.'PlayerVitals.html';
$a = 0;
$b = 0;
$c = 1;
$d = 1;
$i = 0;
$z = 0;
$stop = 0;
if(file_exists($Fnm) && file_exists($Fnm2)) {
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$last_update = $val;
			
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
			
			//echo '<div class = "container">
			echo '<div class = "row wow fadeIn">
					<div class="col-sm-12 col-md-12 col-lg-10 offset-lg-1">
							<div class = "table-responsive">
								<table class="table table-sm">';
		}
		if(substr_count($val, 'AGE CT SALARY')){
			$stop = 1;
			break 1;
		}
		if(substr_count($val, 'A NAME=') && $b) {
			$d = 0;
		}
		if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
			$pos = strpos($val, '</A>');
			$pos = $pos - 23;
			$equipe = substr($val, 23, $pos);
			$b = 1;
		}
		if(substr_count($val, '</PRE>') && $b && $d) {
			$a = 0;
		}
		if($a == 1 && $b && $d && $z == 1) {
			$reste = trim($val);
			$numero[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$tmpPos = '';
			if(substr_count($reste, '  C ')) $tmpPos = '  C ';
			if(substr_count($reste, ' LW ')) $tmpPos = ' LW ';
			if(substr_count($reste, ' RW ')) $tmpPos = ' RW ';
			if(substr_count($reste, '  D ')) $tmpPos = '  D ';
			if(substr_count($reste, '  G ')) $tmpPos = '  G ';
			$name[$i] = trim(substr($reste, 0,  strpos($reste, $tmpPos)));
			$reste = trim(substr($reste, strpos($reste, $tmpPos)));
			$aremplacer = array('L ', 'R ', 'LW ', 'RW ');
			$remplace = array($rostersLeft.' ', $rostersRight.' ', $rostersLW.' ', $rostersRW.' ');
			$reste = str_replace($aremplacer, $remplace, $reste);
			$position[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			if(substr_count($position[$i], 'G')) $positions[$i] = 5;
			if(substr_count($position[$i], 'D')) $positions[$i] = 4;
			if(substr_count($position[$i], 'AG') || substr_count($position[$i], 'LW')) $positions[$i] = 2;
			if(substr_count($position[$i], 'AD') || substr_count($position[$i], 'RW')) $positions[$i] = 3;
			if(substr_count($position[$i], 'C')) $positions[$i] = 1;
			$lance[$i] = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$condition[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = substr($reste, strpos($reste, ' '));
			$count = strlen($reste);
			$j = 3;
			while( $j < $count ) {
				if( ctype_digit($reste[$j]) ) {
					$pos = $j;
					$j = 1000;
				}
				$j++;
			}
			$blessure[$i] = trim(substr($reste, 0, $pos));
			$reste = trim(substr($reste, $pos));
			$intensite[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$vitesse[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$force[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$endurance[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$durabilite[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$discipline[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$patinage[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$passe[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$controle[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$defense[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$offense[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$experience[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$leadership[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$total[$i] = substr($reste, strpos($reste, ' '));
			$i++;
		}
		if($a == 1 && $b && $d && $z == 2) {
			$reste = trim($val);
			$numero2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$tmpPos = '';
			if(substr_count($reste, '  C ')) $tmpPos = '  C ';
			if(substr_count($reste, ' LW ')) $tmpPos = ' LW ';
			if(substr_count($reste, ' RW ')) $tmpPos = ' RW ';
			if(substr_count($reste, '  D ')) $tmpPos = '  D ';
			if(substr_count($reste, '  G ')) $tmpPos = '  G ';
			$name2[$i] = trim(substr($reste, 0, strpos($reste, $tmpPos)));
			$reste = trim(substr($reste, strpos($reste, $tmpPos)));
			$aremplacer = array('L ', 'R ', 'LW ', 'RW ');
			$remplace = array($rostersLeft.' ', $rostersRight.' ', $rostersLW.' ', $rostersRW.' ');
			$reste = str_replace($aremplacer, $remplace, $reste);
			$position2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			if(substr_count($position2[$i], 'G')) $positions2[$i] = 5;
			if(substr_count($position2[$i], 'D')) $positions2[$i] = 4;
			if(substr_count($position2[$i], 'AG') || substr_count($position2[$i], 'LW')) $positions2[$i] = 2;
			if(substr_count($position2[$i], 'AD') || substr_count($position2[$i], 'RW')) $positions2[$i] = 3;
			if(substr_count($position2[$i], 'C')) $positions2[$i] = 1;
			$lance2[$i] = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$condition2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = substr($reste, strpos($reste, ' '));
			$count = strlen($reste);
			$j = 3;
			while( $j < $count ) {
				if( ctype_digit($reste[$j]) ) {
					$pos = $j;
					$j = 1000;
				}
				$j++;
			}
			$blessure2[$i] = trim(substr($reste, 0, $pos));
			$reste = trim(substr($reste, $pos));
			$intensite2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$vitesse2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$force2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$endurance2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$durabilite2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$discipline2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$patinage2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$passe2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$controle2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$defense2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$offense2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$experience2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$leadership2[$i] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$total2[$i] = substr($reste, strpos($reste, ' '));
			$i++;
		}
		if(substr_count($val, '<PRE>') && $b && $d) {
			$a = 1;
			$z++;
			$i = 0;
		}
	}
}

$a = 0;
$b = 0;
$d = 1;
$i = 0;
if(file_exists($Fnm2) && $stop == 0) {
	$tableau = file($Fnm2);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'A NAME=') && $b) {
			$d = 0;
		}
		if(substr_count($val, 'A NAME='.$currentTeam)) {
			$b++;
		}
		if($a == 3 && $b && $d) {
			$a++;
		}
		if(substr_count($val, '------------------') && $b && $d) {
			$a++;
		}
		if($a == 2 && $b && $d) {
			$vital_numero[$i] = substr($val, 0,  strpos($val, ' '));
			$reste = trim(substr($val, strpos($val, ' ')));
			if(substr_count($reste, '*', 0, 1)) {
				$recrue[$i] = substr($reste, 0, 1);
				$reste = trim(substr($reste, 1));
			}
			else $recrue[$i] = '';
			
			$tmpPos = '';
			if(substr_count($reste, '  C ')) $tmpPos = '  C ';
			if(substr_count($reste, ' LW ')) $tmpPos = ' LW ';
			if(substr_count($reste, ' RW ')) $tmpPos = ' RW ';
			if(substr_count($reste, '  D ')) $tmpPos = '  D ';
			if(substr_count($reste, '  G ')) $tmpPos = '  G ';
			
			$vital_name[$i] = trim(substr($reste, 0, strpos($reste, $tmpPos)));
			$reste = trim(substr($reste, strpos($reste, $tmpPos)));
			$vital_position[$i] = substr($reste, 0, strpos($reste, '  '));
			$aremplacer = array('LW', 'RW');
			$remplace = array($joueursLW, $joueursRW);
			if(substr_count($vital_position[$i], 'G')) $vital_position2[$i] = 5;
			if(substr_count($vital_position[$i], 'D')) $vital_position2[$i] = 4;
			if(substr_count($vital_position[$i], 'LW')) $vital_position2[$i] = 2;
			if(substr_count($vital_position[$i], 'RW')) $vital_position2[$i] = 3;
			if(substr_count($vital_position[$i], 'C')) $vital_position2[$i] = 1;
			$vital_position[$i] = str_replace($aremplacer, $remplace, $vital_position[$i]);
			$reste = trim(substr($reste, strpos($reste, '  ')));
			
			$vital_age[$i] = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$vital_grandeur[$i] = substr($reste, 0, strpos($reste, '  '));
			$vital_grandeur[$i] = str_replace('ft', '\'', $vital_grandeur[$i]);
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$vital_poids[$i] = substr($reste, 0, strpos($reste, 'lbs')-1);
			$reste = trim(substr($reste, strpos($reste, 'lbs') + 3));
			$vital_salaire[$i] = substr($reste, 0, strpos($reste, '  '));
			$vital_salaire2[$i] = preg_replace('/\D/', '', $vital_salaire[$i]);
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$vital_contrat[$i] = substr($reste, 0);
			$aremplacer = array('years', 'year');
			$remplace = array('', '');
			$vital_contrat[$i] = str_replace($aremplacer, $remplace, $vital_contrat[$i]);
			
			$vital_grandeur2[$i] = floatval(substr($vital_grandeur[$i], 0, strpos($vital_grandeur[$i], '\''))) * 12 + trim(substr($vital_grandeur[$i], strpos($vital_grandeur[$i], '\'')+1));
			$i++;
		}
		if($a == 1 && $b && $d) {
			$a++;
		}
		if(substr_count($val, '<PRE>') && $b && $d) {
			$a = 1;
		}
	}
}

if($stop == 0) {
	// Regrouper les PRO ensemblent et les Farm Ensemblent avec les deux pages Rosters / PlayerVitals
	if(isset($name)) {
		for($i=0;$i<count($name);$i++) {
			for($j=0;$j<count($vital_name);$j++) {
				$vi_nom = trim($vital_name[$j]);
				$ro_nom = trim($name[$i]);
				$vi_num = trim($vital_numero[$j]);
				$ro_num = trim($numero[$i]);
				if($vi_nom == $ro_nom && $vi_num == $ro_num) {
					$contrat[$i] = $vital_contrat[$j];
					$age[$i] = $vital_age[$j];
					$salaire[$i] = $vital_salaire[$j];
					$salaires[$i] = $vital_salaire2[$j];
					$grandeur[$i] = $vital_grandeur[$j];
					$grandeurs[$i] = $vital_grandeur2[$j];
					$poids[$i] = $vital_poids[$j];
					break 1;
				}
			}
		}
	}
	if(isset($name2)) {
		for($i=0;$i<count($name2);$i++) {
			for($j=0;$j<count($vital_name);$j++) {
				$vi_nom = trim($vital_name[$j]);
				$ro_nom = trim($name2[$i]);
				$vi_num = trim($vital_numero[$j]);
				$ro_num = trim($numero2[$i]);
				if($vi_nom == $ro_nom && $vi_num == $ro_num) {
					$contrat2[$i] = $vital_contrat[$j];
					$age2[$i] = $vital_age[$j];
					$salaire2[$i] = $vital_salaire[$j];
					$salaires2[$i] = $vital_salaire2[$j];
					$grandeur2[$i] = $vital_grandeur[$j];
					$grandeurs2[$i] = $vital_grandeur2[$j];
					$poids2[$i] = $vital_poids[$j];
					break 1;
				}
			}
		}
	}

	// Calcul de la Moyenne Pro / Farm
	$avgAge = 0;
	$avgSalary = 0;
	$avgContract = 0;
	$avgHeight = 0;
	$avgWeight = 0;
	$avgIn = 0;
	$avgSp = 0;
	$avgSt = 0;
	$avgEn = 0;
	$avgDu = 0;
	$avgDi = 0;
	$avgSk = 0;
	$avgPa = 0;
	$avgPC = 0;
	$avgDf = 0;
	$avgOf = 0;
	$avgXp = 0;
	$avgLd = 0;
	$avgOv = 0;
	$goalie = 0;
	
	if(isset($name)) {
		for($i=0;$i<count($name);$i++) {
			$avgIn += $intensite[$i];
			$avgSp += $vitesse[$i];
			$avgSt += $force[$i];
			$avgEn += $endurance[$i];
			$avgDu += $durabilite[$i];
			$avgDi += $discipline[$i];
			$avgSk += $patinage[$i];
			$avgPa += $passe[$i];
			$avgPC += $controle[$i];
			if($defense[$i] != 'NA') {
				$avgDf += $defense[$i];
				$avgOf += $offense[$i];
			}
			else $goalie++;
			$avgXp += $experience[$i];
			$avgLd += $leadership[$i];
			$avgOv += $total[$i];
			$avgAge += $age[$i];
			$avgSalary += $salaires[$i];
			$avgContract += floatval($contrat[$i]);
			$avgHeight += $grandeurs[$i];
			$avgWeight += $poids[$i];
		}
	
		$avgAge = round($avgAge / count($name));
		$avgSalary = number_format(round($avgSalary / count($name)), 0, "", " ");
		$avgContract = round($avgContract / count($name));
		$avgHeight = round($avgHeight / count($name));
		$feet = floor($avgHeight/12);
		$inches = ($avgHeight%12);
		$avgHeight = $feet.'\' '.$inches;
		$avgWeight = round($avgWeight / count($name));
		$avgIn = round($avgIn / count($name));
		$avgSp = round($avgSp / count($name));
		$avgSt = round($avgSt / count($name));
		$avgEn = round($avgEn / count($name));
		$avgDu = round($avgDu / count($name));
		$avgDi = round($avgDi / count($name));
		$avgSk = round($avgSk / count($name));
		$avgPa = round($avgPa / count($name));
		$avgPC = round($avgPC / count($name));
		$avgDf = round($avgDf / (count($name)-$goalie));
		$avgOf = round($avgOf / (count($name)-$goalie));
		$avgXp = round($avgXp / count($name));
		$avgLd = round($avgLd / count($name));
		$avgOv = round($avgOv / count($name));
	}
	
	if(isset($name2)) {
		$avgAge2 = 0;
		$avgSalary2 = 0;
		$avgContract2 = 0;
		$avgHeight2 = 0;
		$avgWeight2 = 0;
		$avgIn2 = 0;
		$avgSp2 = 0;
		$avgSt2 = 0;
		$avgEn2 = 0;
		$avgDu2 = 0;
		$avgDi2 = 0;
		$avgSk2 = 0;
		$avgPa2 = 0;
		$avgPC2 = 0;
		$avgDf2 = 0;
		$avgOf2 = 0;
		$avgXp2 = 0;
		$avgLd2 = 0;
		$avgOv2 = 0;
		$goalie2 = 0;
		for($i=0;$i<count($name2);$i++) {
			$avgIn2 += $intensite2[$i];
			$avgSp2 += $vitesse2[$i];
			$avgSt2 += $force2[$i];
			$avgEn2 += $endurance2[$i];
			$avgDu2 += $durabilite2[$i];
			$avgDi2 += $discipline2[$i];
			$avgSk2 += $patinage2[$i];
			$avgPa2 += $passe2[$i];
			$avgPC2 += $controle2[$i];
			if($defense2[$i] != 'NA') {
				$avgDf2 += $defense2[$i];
				$avgOf2 += $offense2[$i];
			}
			else $goalie2++;
			$avgXp2 += $experience2[$i];
			$avgLd2 += $leadership2[$i];
			$avgOv2 += $total2[$i];
			$avgAge2 += $age2[$i];
			$avgSalary2 += $salaires2[$i];
			$avgContract2 += floatval($contrat2[$i]);
			$avgHeight2 += $grandeurs2[$i];
			$avgWeight2 += $poids2[$i];
		}
		$avgAge2 = round($avgAge2 / count($name2));
		$avgSalary2 = number_format(round($avgSalary2 / count($name2)), 0, "", " ");
		$avgContract2 = round($avgContract2 / count($name2));
		$avgHeight2 = round($avgHeight2 / count($name2));
		$feet = floor($avgHeight2/12);
		$inches = ($avgHeight2%12);
		$avgHeight2 = $feet.'\' '.$inches;
		$avgWeight2 = round($avgWeight2 / count($name2));
		$avgIn2 = round($avgIn2 / count($name2));
		$avgSp2 = round($avgSp2 / count($name2));
		$avgSt2 = round($avgSt2 / count($name2));
		$avgEn2 = round($avgEn2 / count($name2));
		$avgDu2 = round($avgDu2 / count($name2));
		$avgDi2 = round($avgDi2 / count($name2));
		$avgSk2 = round($avgSk2 / count($name2));
		$avgPa2 = round($avgPa2 / count($name2));
		$avgPC2 = round($avgPC2 / count($name2));
		$avgDf2 = round($avgDf2 / (count($name2)-$goalie2));
		$avgOf2 = round($avgOf2 / (count($name2)-$goalie2));
		$avgXp2 = round($avgXp2 / count($name2));
		$avgLd2 = round($avgLd2 / count($name2));
		$avgOv2 = round($avgOv2 / count($name2));
	}
	
	$ss = 'font-weight: bold;';
	$sortmemn = 'na';
	$sortmemj = 'ja';
	$sortmemp = 'pa';
	$sortmeml = 'la';
	$sortmemc = 'ca';
	$sortmemb = 'ba';
	$sortmemi = 'ia';
	$sortmemv = 'va';
	$sortmemf = 'fa';
	$sortmeme = 'ea';
	$sortmemdu = 'dua';
	$sortmemdi = 'dia';
	$sortmempt = 'pta';
	$sortmemps = 'psa';
	$sortmemco = 'coa';
	$sortmemd = 'da';
	$sortmemo = 'oa';
	$sortmemex = 'exa';
	$sortmemld = 'lda';
	$sortmemov = 'ova';
	$sortmema = 'aa';
	$sortmemct = 'cta';
	$sortmems = 'sa';
	$sortmempd = 'pda';
	$sortmemg = 'ga';
	
	if($sort == 'na') $sortmemn = 'nd';
	if($sort == 'nd') $sortmemn = 'na';
	if($sort == 'ja') $sortmemj = 'jd';
	if($sort == 'jd') $sortmemj = 'ja';
	if($sort == 'pa' || !$sort) $sortmemp = 'pd';
	if($sort == 'pd') $sortmemp = 'pa';
	if($sort == 'la') $sortmeml = 'ld';
	if($sort == 'ld') $sortmeml = 'la';
	if($sort == 'ca') $sortmemc = 'cd';
	if($sort == 'cd') $sortmemc = 'ca';
	if($sort == 'ba') $sortmemb = 'bd';
	if($sort == 'bd') $sortmemb = 'ba';
	if($sort == 'ia') $sortmemi = 'id';
	if($sort == 'id') $sortmemi = 'ia';
	if($sort == 'va') $sortmemv = 'vd';
	if($sort == 'vd') $sortmemv = 'va';
	if($sort == 'fa') $sortmemf = 'fd';
	if($sort == 'fd') $sortmemf = 'fa';
	if($sort == 'ea') $sortmeme = 'ed';
	if($sort == 'ed') $sortmeme = 'ea';
	if($sort == 'dua') $sortmemdu = 'dud';
	if($sort == 'dud') $sortmemdu = 'dua';
	if($sort == 'dia') $sortmemdi = 'did';
	if($sort == 'did') $sortmemdi = 'dia';
	if($sort == 'pta') $sortmempt = 'ptd';
	if($sort == 'ptd') $sortmempt = 'pta';
	if($sort == 'psa') $sortmemps = 'psd';
	if($sort == 'psd') $sortmemps = 'psa';
	if($sort == 'coa') $sortmemco = 'cod';
	if($sort == 'cod') $sortmemco = 'coa';
	if($sort == 'da') $sortmemd = 'dd';
	if($sort == 'dd') $sortmemd = 'da';
	if($sort == 'oa') $sortmemo = 'od';
	if($sort == 'od') $sortmemo = 'oa';
	if($sort == 'exa') $sortmemex = 'exd';
	if($sort == 'exd') $sortmemex = 'exa';
	if($sort == 'lda') $sortmemld = 'ldd';
	if($sort == 'ldd') $sortmemld = 'lda';
	if($sort == 'ova') $sortmemov = 'ovd';
	if($sort == 'ovd') $sortmemov = 'ova';
	if($sort == 'aa') $sortmema = 'ad';
	if($sort == 'ad') $sortmema = 'aa';
	if($sort == 'cta') $sortmemct = 'ctd';
	if($sort == 'ctd') $sortmemct = 'cta';
	if($sort == 'sa') $sortmems = 'sd';
	if($sort == 'sd') $sortmems = 'sa';
	if($sort == 'pda') $sortmempd = 'pdd';
	if($sort == 'pdd') $sortmempd = 'pda';
	if($sort == 'ga') $sortmemg = 'gd';
	if($sort == 'gd') $sortmemg = 'ga';
	
	$lienmem = '?sort=';
	
	$s1 = $s2 = $s3 = $s4 = $s5 = $s6 = $s7 = $s8 = $s9 = $s10 = $s11 = $s12 = $s13 = $s14 = $s15 = $s16 = $s17 = $s18 = $s19 = $s20 = $s21 = $s22 = $s23 = $s24 = $s25 = '';
	if($sort == 'na' || $sort == 'nd') { 
		if(isset($numero)) $tableauf = $numero;
		if(isset($numero2)) $tableaufs = $numero2;
		$s1 = $ss;
	}
	if($sort == 'ja' || $sort == 'jd') { 
		if(isset($numero)) $tableauf = $name;
		if(isset($numero2)) $tableaufs = $name2;
		$s2 = $ss;
	}
	if($sort == 'pa' || $sort == 'pd' || !$sort) { 
		if(isset($numero)) $tableauf = $positions;
		if(isset($numero2)) $tableaufs = $positions2;
		$s3 = $ss;
	}
	if($sort == 'la' || $sort == 'ld') { 
		if(isset($numero)) $tableauf = $lance;
		if(isset($numero2)) $tableaufs = $lance2;
		$s4 = $ss;
	}
	if($sort == 'ca' || $sort == 'cd') { 
		if(isset($numero)) $tableauf = $condition;
		if(isset($numero2)) $tableaufs = $condition2;
		$s5 = $ss;
	}
	if($sort == 'ba' || $sort == 'bd') { 
		if(isset($numero)) $tableauf = $blessure;
		if(isset($numero2)) $tableaufs = $blessure2;
		$s6 = $ss;
	}
	if($sort == 'ia' || $sort == 'id') { 
		if(isset($numero)) $tableauf = $intensite;
		if(isset($numero2)) $tableaufs = $intensite2;
		$s7 = $ss;
	}
	if($sort == 'va' || $sort == 'vd') { 
		if(isset($numero)) $tableauf = $vitesse;
		if(isset($numero2)) $tableaufs = $vitesse2;
		$s8 = $ss;
	}
	if($sort == 'fa' || $sort == 'fd') { 
		if(isset($numero)) $tableauf = $force;
		if(isset($numero2)) $tableaufs = $force2;
		$s9 = $ss;
	}
	if($sort == 'ea' || $sort == 'ed') { 
		if(isset($numero)) $tableauf = $endurance;
		if(isset($numero2)) $tableaufs = $endurance2;
		$s10 = $ss;
	}
	if($sort == 'dua' || $sort == 'dud') { 
		if(isset($numero)) $tableauf = $durabilite;
		if(isset($numero2)) $tableaufs = $durabilite2;
		$s11 = $ss;
	}
	if($sort == 'dia' || $sort == 'did') { 
		if(isset($numero)) $tableauf = $discipline;
		if(isset($numero2)) $tableaufs = $discipline2;
		$s12 = $ss;
	}
	if($sort == 'pta' || $sort == 'ptd') { 
		if(isset($numero)) $tableauf = $patinage;
		if(isset($numero2)) $tableaufs = $patinage2;
		$s13 = $ss;
	}
	if($sort == 'psa' || $sort == 'psd') { 
		if(isset($numero)) $tableauf = $passe;
		if(isset($numero2)) $tableaufs = $passe2;
		$s14 = $ss;
	}
	if($sort == 'coa' || $sort == 'cod') { 
		if(isset($numero)) $tableauf = $controle;
		if(isset($numero2)) $tableaufs = $controle2;
		$s15 = $ss;
	}
	if($sort == 'da' || $sort == 'dd') { 
		if(isset($numero)) $tableauf = $defense;
		if(isset($numero2)) $tableaufs = $defense2;
		$s16 = $ss;
	}
	if($sort == 'oa' || $sort == 'od') { 
		if(isset($numero)) $tableauf = $offense;
		if(isset($numero2)) $tableaufs = $offense2;
		$s17 = $ss;
	}
	if($sort == 'exa' || $sort == 'exd') { 
		if(isset($numero)) $tableauf = $experience;
		if(isset($numero2)) $tableaufs = $experience2;
		$s18 = $ss;
	}
	if($sort == 'lda' || $sort == 'ldd') { 
		if(isset($numero)) $tableauf = $leadership;
		if(isset($numero2)) $tableaufs = $leadership2;
		$s19 = $ss;
	}
	if($sort == 'ova' || $sort == 'ovd') { 
		if(isset($numero)) $tableauf = $total;
		if(isset($numero2)) $tableaufs = $total2;
		$s20 = $ss;
	}
	if($sort == 'aa' || $sort == 'ad') { 
		if(isset($numero)) $tableauf = $age;
		if(isset($numero2)) $tableaufs = $age2;
		$s21 = $ss;
	}
	if($sort == 'cta' || $sort == 'ctd') { 
		if(isset($numero)) $tableauf = $contrat;
		if(isset($numero2)) $tableaufs = $contrat2;
		$s22 = $ss;
	}
	if($sort == 'sa' || $sort == 'sd') { 
		if(isset($numero)) $tableauf = $salaires;
		if(isset($numero2)) $tableaufs = $salaires2;
		$s23 = $ss;
	}
	if($sort == 'pda' || $sort == 'pdd') { 
		if(isset($numero)) $tableauf = $poids;
		if(isset($numero2)) $tableaufs = $poids2;
		$s24 = $ss;
	}
	if($sort == 'ga' || $sort == 'gd') { 
		if(isset($numero)) $tableauf = $grandeurs;
		if(isset($numero2)) $tableaufs = $grandeurs2;
		$s25 = $ss;
	}
	
	if($sort || !$sort) {
		if(isset($numero)) natsort($tableauf);
		if(isset($numero2)) natsort($tableaufs);
	}
	if($sort == 'nd' || $sort == 'jd' || $sort == 'pd' || $sort == 'ld' || $sort == 'cd' || $sort == 'ba' || $sort == 'ia' || 
	$sort == 'va' || $sort == 'fa' || $sort == 'ea' || $sort == 'dua' || $sort == 'dia' || $sort == 'pta' || $sort == 'psa' ||
	$sort == 'coa' || $sort == 'da' || $sort == 'oa' || $sort == 'exa' || $sort == 'lda' || $sort == 'ova' || $sort == 'aa' || 
	$sort == 'cta' || $sort == 'sa' || $sort == 'pdd' || $sort == 'gd') {
		if(isset($numero)) $tableauf = array_reverse ($tableauf, TRUE);
		if(isset($numero2)) $tableaufs = array_reverse ($tableaufs, TRUE);
	}

	echo '<tr><td colspan="25" style="text-align:left; font-weight:bold;"><h3>'.$rostersPro.'</h3></td></tr>';
	
	if(isset($tableauf)) {
		echo '
		<tr class="tableau-top">
			<td style="width:20px;'.$s1.'"><a href="'.$lienmem.$sortmemn.'" class="info">#<span>'.$rostersNumber.'</span></a></td>
			<td style="'.$s2.'"><a href="'.$lienmem.$sortmemj.'" class="lien-blanc">'.$rostersName.'</a></td>
			<td style="width:22px;'.$s3.'"><a href="'.$lienmem.$sortmemp.'" class="info">PO<span>'.$rostersPosition.'</span></a></td>
			<td style="width:15px;'.$s4.'"><a href="'.$lienmem.$sortmeml.'" class="info">'.$rostersHD.'<span>'.$rostersHDF.'</span></a></td>
			<td style="width:22px;'.$s5.'"><a href="'.$lienmem.$sortmemc.'" class="info">CD<span>Condition</span></a></td>
			<td style="width:20px; text-align:center;'.$s6.'"><a href="'.$lienmem.$sortmemb.'" class="info">'.$rostersIJ.'<span>'.$rostersIJF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s7.'"><a href="'.$lienmem.$sortmemi.'" class="info">'.$rostersIT.'<span>'.$rostersITF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s8.'"><a href="'.$lienmem.$sortmemv.'" class="info">'.$rostersSP.'<span>'.$rostersSPF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s9.'"><a href="'.$lienmem.$sortmemf.'" class="info">'.$rostersST.'<span>'.$rostersSTF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s10.'"><a href="'.$lienmem.$sortmeme.'" class="info">'.$rostersEN.'<span>'.$rostersENF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s11.'"><a href="'.$lienmem.$sortmemdu.'" class="info">'.$rostersDU.'<span>'.$rostersDUF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s12.'"><a href="'.$lienmem.$sortmemdi.'" class="info">'.$rostersDI.'<span>'.$rostersDIF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s13.'"><a href="'.$lienmem.$sortmempt.'" class="info">'.$rostersSK.'<span>'.$rostersSKF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s14.'"><a href="'.$lienmem.$sortmemps.'" class="info">'.$rostersPA.'<span>'.$rostersPAF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s15.'"><a href="'.$lienmem.$sortmemco.'" class="info">'.$rostersPC.'<span>'.$rostersPCF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s16.'"><a href="'.$lienmem.$sortmemd.'" class="info">'.$rostersDF.'<span>'.$rostersDFF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s17.'"><a href="'.$lienmem.$sortmemo.'" class="info">'.$rostersOF.'<span>'.$rostersOFF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s18.'"><a href="'.$lienmem.$sortmemex.'" class="info">'.$rostersEX.'<span>'.$rostersEXF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s19.'"><a href="'.$lienmem.$sortmemld.'" class="info">'.$rostersLD.'<span>'.$rostersLDF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s20.'"><a href="'.$lienmem.$sortmemov.'" class="info">'.$rostersOV.'<span>'.$rostersOVF.'</span></a></td>
			<td style="width:20px; text-align:center;'.$s21.'"><a href="'.$lienmem.$sortmema.'" class="lien-blanc">AGE</a></td>
			<td style="width:70px; text-align:right;'.$s23.'"><a href="'.$lienmem.$sortmems.'" class="lien-blanc">'.$joueursSalary.'</a></td>
			<td style="width:20px; text-align:center;'.$s22.'"><a href="'.$lienmem.$sortmemct.'" class="info">'.$linkedYear.'<span>'.$linkedYearF.'</span></a></td>
			<td style="width:40px; text-align:center;'.$s25.'"><a href="'.$lienmem.$sortmemg.'" class="info">'.$linkedHeightm.'<span>'.$joueursHeightF.'</span></a></td>
			<td style="width:50px; text-align:center;'.$s24.'"><a href="'.$lienmem.$sortmempd.'" class="info">'.$linkedWeightm.'<span>'.$joueursWeight.'</span></a></td>
			</tr>';
		
			$key = key($tableauf);
			$val = current($tableauf);
			while(list ($key, $val) = myEach($tableauf)) {
				if($c == 1) $c = 2;
				else $c = 1;
				echo '
				<tr class="hover'.$c.'">
				<td style="'.$s1.'">'.$numero[$key].'</td>
				<td style="'.$s2.'">';
				echo '<a style="display:block; width:100%;"
				onmouseover="javascript:if(document.getElementById(\'num'.$numero[$key].'\')) { document.getElementById(\'playerStats\').innerHTML = document.getElementById(\'num'.$numero[$key].'\').innerHTML; document.getElementById(\'playerStatsName\').innerHTML = \''.$name[$key].'\'; document.getElementById(\'playerStatsFrame\').style.display = \'block\'; }" 
				onmouseout="javascript:document.getElementById(\'playerStatsFrame\').style.display = \'none\';" 
				href="CareerStatsPlayer.php?csName='.urlencode($name[$key]).'">';
				echo $name[$key];
				echo '</a>';
				echo '</td>
				<td style="'.$s3.'">'.$position[$key].'</td>
				<td style="'.$s4.'">'.$lance[$key].'</td>
				<td style="'.$s5.'">'.$condition[$key].'</td>
				<td style="text-align:center;'.$s6.'">'.$blessure[$key].'</td>
				<td style="text-align:center;'.$s7.'">'.$intensite[$key].'</td>
				<td style="text-align:center;'.$s8.'">'.$vitesse[$key].'</td>
				<td style="text-align:center;'.$s9.'">'.$force[$key].'</td>
				<td style="text-align:center;'.$s10.'">'.$endurance[$key].'</td>
				<td style="text-align:center;'.$s11.'">'.$durabilite[$key].'</td>
				<td style="text-align:center;'.$s12.'">'.$discipline[$key].'</td>
				<td style="text-align:center;'.$s13.'">'.$patinage[$key].'</td>
				<td style="text-align:center;'.$s14.'">'.$passe[$key].'</td>
				<td style="text-align:center;'.$s15.'">'.$controle[$key].'</td>
				<td style="text-align:center;'.$s16.'">'.$defense[$key].'</td>
				<td style="text-align:center;'.$s17.'">'.$offense[$key].'</td>
				<td style="text-align:center;'.$s18.'">'.$experience[$key].'</td>
				<td style="text-align:center;'.$s19.'">'.$leadership[$key].'</td>
				<td style="text-align:center;'.$s20.'">'.$total[$key].'</td>
				<td style="text-align:center;'.$s21.'">'.$age[$key].'</td>
				<td style="text-align:right;'.$s23.'">'.$salaire[$key].'$</td>
				<td style="text-align:center;'.$s22.'">'.$contrat[$key].'</td>
				<td style="text-align:right;'.$s25.'">'.$grandeur[$key].'</td>
				<td style="text-align:right;'.$s24.'">'.$poids[$key].' lbs</td>
				</tr>';
			}
		
			echo '
			<tr class="tableau-top">
			<td colspan="6">'.$joueursProTeamAverage.'</td>
			<td style="text-align:center;'.$s7.'">'.$avgIn.'</td>
			<td style="text-align:center;'.$s8.'">'.$avgSp.'</td>
			<td style="text-align:center;'.$s9.'">'.$avgSt.'</td>
			<td style="text-align:center;'.$s10.'">'.$avgEn.'</td>
			<td style="text-align:center;'.$s11.'">'.$avgDu.'</td>
			<td style="text-align:center;'.$s12.'">'.$avgDi.'</td>
			<td style="text-align:center;'.$s13.'">'.$avgSk.'</td>
			<td style="text-align:center;'.$s14.'">'.$avgPa.'</td>
			<td style="text-align:center;'.$s15.'">'.$avgPC.'</td>
			<td style="text-align:center;'.$s16.'">'.$avgDf.'</td>
			<td style="text-align:center;'.$s17.'">'.$avgOf.'</td>
			<td style="text-align:center;'.$s18.'">'.$avgXp.'</td>
			<td style="text-align:center;'.$s19.'">'.$avgLd.'</td>
			<td style="text-align:center;'.$s20.'">'.$avgOv.'</td>
			<td style="text-align:center;'.$s21.'">'.$avgAge.'</td>
			<td style="text-align:right;'.$s23.'">'.$avgSalary.'$</td>
			<td style="text-align:center;'.$s22.'">'.$avgContract.'</td>
			<td style="text-align:right;'.$s25.'">'.$avgHeight.'</td>
			<td style="text-align:right;'.$s24.'">'.$avgWeight.' lbs</td>
			</tr>';
		}
	
		if(isset($tableaufs)) {
			echo '<tr><td colspan="25" style="text-align:left; font-weight:bold; padding-top:20px;"><h3>'.$rostersFarm.'</h3></td></tr>';
			
			echo '
			<tr class="tableau-top">
				<td style="width:20px;'.$s1.'"><a href="'.$lienmem.$sortmemn.'" class="info">#<span>'.$rostersNumber.'</span></a></td>
				<td style="'.$s2.'"><a href="'.$lienmem.$sortmemj.'" class="lien-blanc">'.$rostersName.'</a></td>
				<td style="width:22px;'.$s3.'"><a href="'.$lienmem.$sortmemp.'" class="info">PO<span>'.$rostersPosition.'</span></a></td>
				<td style="width:15px;'.$s4.'"><a href="'.$lienmem.$sortmeml.'" class="info">'.$rostersHD.'<span>'.$rostersHDF.'</span></a></td>
				<td style="width:22px;'.$s5.'"><a href="'.$lienmem.$sortmemc.'" class="info">CD<span>Condition</span></a></td>
				<td style="width:20px; text-align:center;'.$s6.'"><a href="'.$lienmem.$sortmemb.'" class="info">'.$rostersIJ.'<span>'.$rostersIJF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s7.'"><a href="'.$lienmem.$sortmemi.'" class="info">'.$rostersIT.'<span>'.$rostersITF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s8.'"><a href="'.$lienmem.$sortmemv.'" class="info">'.$rostersSP.'<span>'.$rostersSPF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s9.'"><a href="'.$lienmem.$sortmemf.'" class="info">'.$rostersST.'<span>'.$rostersSTF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s10.'"><a href="'.$lienmem.$sortmeme.'" class="info">'.$rostersEN.'<span>'.$rostersENF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s11.'"><a href="'.$lienmem.$sortmemdu.'" class="info">'.$rostersDU.'<span>'.$rostersDUF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s12.'"><a href="'.$lienmem.$sortmemdi.'" class="info">'.$rostersDI.'<span>'.$rostersDIF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s13.'"><a href="'.$lienmem.$sortmempt.'" class="info">'.$rostersSK.'<span>'.$rostersSKF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s14.'"><a href="'.$lienmem.$sortmemps.'" class="info">'.$rostersPA.'<span>'.$rostersPAF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s15.'"><a href="'.$lienmem.$sortmemco.'" class="info">'.$rostersPC.'<span>'.$rostersPCF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s16.'"><a href="'.$lienmem.$sortmemd.'" class="info">'.$rostersDF.'<span>'.$rostersDFF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s17.'"><a href="'.$lienmem.$sortmemo.'" class="info">'.$rostersOF.'<span>'.$rostersOFF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s18.'"><a href="'.$lienmem.$sortmemex.'" class="info">'.$rostersEX.'<span>'.$rostersEXF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s19.'"><a href="'.$lienmem.$sortmemld.'" class="info">'.$rostersLD.'<span>'.$rostersLDF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s20.'"><a href="'.$lienmem.$sortmemov.'" class="info">'.$rostersOV.'<span>'.$rostersOVF.'</span></a></td>
				<td style="width:20px; text-align:center;'.$s21.'"><a href="'.$lienmem.$sortmema.'" class="lien-blanc">AGE</a></td>
				<td style="width:70px; text-align:right;'.$s23.'"><a href="'.$lienmem.$sortmems.'" class="lien-blanc">'.$joueursSalary.'</a></td>
				<td style="width:20px; text-align:center;'.$s22.'"><a href="'.$lienmem.$sortmemct.'" class="info">'.$linkedYear.'<span>'.$linkedYearF.'</span></a></td>
				<td style="width:40px; text-align:center;'.$s25.'"><a href="'.$lienmem.$sortmemg.'" class="info">'.$linkedHeightm.'<span>'.$joueursHeightF.'</span></a></td>
				<td style="width:50px; text-align:center;'.$s24.'"><a href="'.$lienmem.$sortmempd.'" class="info">'.$linkedWeightm.'<span>'.$joueursWeight.'</span></a></td>
				</tr>';
				
			$key = key($tableaufs);
			$val = current($tableaufs);
			while(list ($key, $val) = myEach($tableaufs)) {
				if($c == 1) $c = 2;
				else $c = 1;
				echo '
				<tr class="hover'.$c.'">
				<td style="'.$s1.'">'.$numero2[$key].'</td>
				<td style="'.$s2.'">';
				echo '<a style="display:block; width:100%;"
				onmouseover="javascript:if(document.getElementById(\'num'.$numero2[$key].'\')) { document.getElementById(\'playerStats\').innerHTML = document.getElementById(\'num'.$numero2[$key].'\').innerHTML; document.getElementById(\'playerStatsName\').innerHTML = \''.$name2[$key].'\'; document.getElementById(\'playerStatsFrame\').style.display = \'block\';}" 
				onmouseout="javascript:document.getElementById(\'playerStatsFrame\').style.display = \'none\';" 
				href="CareerStatsPlayer.php?csName='.urlencode($name2[$key]).'">';
				echo $name2[$key];
				echo '</a>';
				echo '</td>
				<td style="'.$s3.'">'.$position2[$key].'</td>
				<td style="'.$s4.'">'.$lance2[$key].'</td>
				<td style="'.$s5.'">'.$condition2[$key].'</td>
				<td style="text-align:center;'.$s6.'">'.$blessure2[$key].'</td>
				<td style="text-align:center;'.$s7.'">'.$intensite2[$key].'</td>
				<td style="text-align:center;'.$s8.'">'.$vitesse2[$key].'</td>
				<td style="text-align:center;'.$s9.'">'.$force2[$key].'</td>
				<td style="text-align:center;'.$s10.'">'.$endurance2[$key].'</td>
				<td style="text-align:center;'.$s11.'">'.$durabilite2[$key].'</td>
				<td style="text-align:center;'.$s12.'">'.$discipline2[$key].'</td>
				<td style="text-align:center;'.$s13.'">'.$patinage2[$key].'</td>
				<td style="text-align:center;'.$s14.'">'.$passe2[$key].'</td>
				<td style="text-align:center;'.$s15.'">'.$controle2[$key].'</td>
				<td style="text-align:center;'.$s16.'">'.$defense2[$key].'</td>
				<td style="text-align:center;'.$s17.'">'.$offense2[$key].'</td>
				<td style="text-align:center;'.$s18.'">'.$experience2[$key].'</td>
				<td style="text-align:center;'.$s19.'">'.$leadership2[$key].'</td>
				<td style="text-align:center;'.$s20.'">'.$total2[$key].'</td>
				<td style="text-align:center;'.$s21.'">'.$age2[$key].'</td>
				<td style="text-align:right;'.$s23.'">'.$salaire2[$key].'$</td>
				<td style="text-align:center;'.$s22.'">'.$contrat2[$key].'</td>
				<td style="text-align:right;'.$s25.'">'.$grandeur2[$key].'</td>
				<td style="text-align:right;'.$s24.'">'.$poids2[$key].' lbs</td>
				</tr>';
			}
			echo '
				<tr class="tableau-top">
				<td colspan="6">'.$linkedFarmTeamAverage.'</td>
				<td style="text-align:center;'.$s7.'">'.$avgIn2.'</td>
				<td style="text-align:center;'.$s8.'">'.$avgSp2.'</td>
				<td style="text-align:center;'.$s9.'">'.$avgSt2.'</td>
				<td style="text-align:center;'.$s10.'">'.$avgEn2.'</td>
				<td style="text-align:center;'.$s11.'">'.$avgDu2.'</td>
				<td style="text-align:center;'.$s12.'">'.$avgDi2.'</td>
				<td style="text-align:center;'.$s13.'">'.$avgSk2.'</td>
				<td style="text-align:center;'.$s14.'">'.$avgPa2.'</td>
				<td style="text-align:center;'.$s15.'">'.$avgPC2.'</td>
				<td style="text-align:center;'.$s16.'">'.$avgDf2.'</td>
				<td style="text-align:center;'.$s17.'">'.$avgOf2.'</td>
				<td style="text-align:center;'.$s18.'">'.$avgXp2.'</td>
				<td style="text-align:center;'.$s19.'">'.$avgLd2.'</td>
				<td style="text-align:center;'.$s20.'">'.$avgOv2.'</td>
				<td style="text-align:center;'.$s21.'">'.$avgAge2.'</td>
				<td style="text-align:right;'.$s23.'">'.$avgSalary2.'$</td>
				<td style="text-align:center;'.$s22.'">'.$avgContract2.'</td>
				<td style="text-align:right;'.$s25.'">'.$avgHeight2.'</td>
				<td style="text-align:right;'.$s24.'">'.$avgWeight2.' lbs</td>
				</tr>';
		}
	}
	else echo '<tr><td>'.$rostersLinked.'</td></tr>';
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.' - '.$Fnm2.'</td></tr>';

/* echo '</table></div></div>'; */
?>
</table>
</div>	
</div>
</div>
</div>
</div>