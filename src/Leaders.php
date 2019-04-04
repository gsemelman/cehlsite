<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = 'Leaders';
$CurrentTitle = $leaderTitle;
$CurrentPage = 'Leaders';
include 'head.php';
?>

<div class="container">

<div class="card">
	<?php include 'SectionHeader.php';?>
	<div class="card-body">


<?php
$tableColScoring = 12;
$tableColGoaltending = 14;
if($currentFarm == 1) {
	$tableColScoring = 7;
	$tableColGoaltending = 4;
	$playoff = '';
}
include 'phpGetAbbr.php'; // Output $TSabbr

$a = 0;
$b = 0;
$c = 1;
$i = 0;
$lastUpdated = '';
$matches = glob($folder.'*'.$playoff.$farm.'Leaders.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'Farm') && $farm == '') || (substr_count($matches[$j], 'Farm') && $farm == 'Farm')) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], $farm.'Leaders')-strrpos($matches[$j], '/')-1);
		break 1;
	}
	}
}
$Fnm = $folder.$folderLeagueURL.$farm.'Leaders.html';
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$lastUpdated = $val;
			
			//echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$val.'</h5>';
			
			echo '<div class="col-sm-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">';
			echo '<div class="table-responsive wow fadeIn">';
			echo '<table class="table table-sm table-striped">';
		
		}
		if(substr_count($val, '</PRE>')) {
			$a = 0;
		}
		if(substr_count($val, '</PRE>')) {
			$b = 0;
		}
		if($a) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')') - $pos;
			$joueur[$i] = trim(substr($val, 0, $pos));
			$equipes[$i] = substr($val, $pos+1, $pos2-1);
			
			$reste = trim(substr($val, strpos($val, ')')+1));
			$gp[$i] = substr($reste, 0, strpos($reste, ' '));
			
			$reste = trim(substr($reste, strpos($reste, ' ')+1));
			$goal[$i] = substr($reste, 0, strpos($reste, ' '));
			
			$reste = trim(substr($reste, strpos($reste, ' ')+1));
			$ass[$i] = substr($reste, 0, strpos($reste, ' '));
			
			$reste = trim(substr($reste, strpos($reste, ' ')+1));
			$points[$i] = substr($reste, 0, strpos($reste, ' '));
			
			$reste = trim(substr($reste, strpos($reste, ' ')+1));
			if($currentFarm == 1) $pun[$i] = $reste;
			if($currentFarm == 0) {
				$diff[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$pun[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$pp[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$sh[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$shots[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$shp[$i] = $reste;
			}
			$i++;
		}
		if($b == 2) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')') - $pos;
			$joueur2[$i] = trim(substr($val, 0, $pos));
			$equipes2[$i] = substr($val, $pos+1, $pos2-1);
			
			$reste = trim(substr($val, strpos($val, ')')+1));
			$gp2[$i] = substr($reste, 0, strpos($reste, ' '));
			
			$reste = trim(substr($reste, strpos($reste, ' ')+1));
			if($currentFarm == 1) $avg[$i] = $reste;
			if($currentFarm == 0) {
				$win[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$loose[$i] = substr($reste, 0,strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$tie[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$min[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$ga[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$so[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$avg[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$pun2[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$sh2[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$pct[$i] = substr($reste, 0, strpos($reste, ' '));
				
				$reste = trim(substr($reste, strpos($reste, ' ')+1));
				$ass2[$i] = $reste;
			}
			$i++;
		}
		if(substr_count($val, '<PRE> Player')) {
			$a++;
		}
		if(substr_count($val, '<PRE>Minimum')) {
			$b++;
			$i = 0;
			$pos = strpos($val, ' Games');
			$pos = $pos - 13;
			$games = substr($val, 13, $pos);
		}
		if(substr_count($val, 'AVG PIM Shots') || substr_count($val, 'GP  AVG')) {
			$b++;
		}
	}
	$i = 0;
	echo '<thead>';
	echo '<tr class="tableau-top"><td style="text-align:center; font-weight:bold;" colspan="'.$tableColScoring.'">'.$leaderScoring.'</td></tr><tr class="tableau-top">';
	echo '<td></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderTeam.'<span>'.$leaderTeamF.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderGP.'<span>'.$leaderGPF.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderGoal.'<span>'.$leaderGoalF.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderAssist.'<span>'.$leaderAssistF.'</span></a></td>';
	echo '<td style="text-align:right; font-weight:bold;"><a href="javascript:return;" class="info">'.$leaderPoints.'<span>'.$leaderPointsF.'</span></a></td>';
	if($currentFarm == 0) echo '<td style="text-align:right;"><a href="javascript:return;" class="info">+/-<span>'.$leaderDiff.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderPIM.'<span>'.$leaderPIMF.'</span></a></td>';
	if($currentFarm == 0) {
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderPP.'<span>'.$leaderPPF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderSH.'<span>'.$leaderSHF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderShots.'<span>'.$leaderShotsF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderShotsAcc.'<span>'.$leaderShotsAccF.'</span></a></td>';
	}
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	if(isset($joueur)) {
		for($i=0;$i<count($joueur);$i++) {
			if($c == 1) $c = 2;
			else $c =  1;
			if(isset($TSabbr) && substr_count($equipes[$i], $TSabbr)) $bold = 'font-weight:bold;';
			else $bold = '';
			echo '<tr class="hover'.$c.'">';
			echo '<td style="'.$bold.'">'.$joueur[$i].'</td>';
			echo '<td style="text-align:right;'.$bold.'">'.$equipes[$i].'</td>';
			echo '<td style="text-align:right;'.$bold.'">'.$gp[$i].'</td>';
			echo '<td style="text-align:right;'.$bold.'">'.$goal[$i].'</td>';
			echo '<td style="text-align:right;'.$bold.'">'.$ass[$i].'</td>';
			echo '<td style="text-align:right; font-weight:bold;">'.$points[$i].'</td>';
			if($currentFarm == 0) echo '<td style="text-align:right;'.$bold.'">'.$diff[$i].'</td>';
			echo '<td style="text-align:right;'.$bold.'">'.$pun[$i].'</td>';
			if($currentFarm == 0) {
				echo '<td style="text-align:right;'.$bold.'">'.$pp[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$sh[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$shots[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$shp[$i].'</td>';
			}
			echo '</tr>';
		}
	}
	echo '</tbody></table></div><br>';
	/* echo '<table class="tableau"><tr><td style="text-align:center; font-weight:bold;" colspan="'.$tableColGoaltending.'">'.$leaderGoalies.'</td></tr>'; */
	echo '<div class="table-responsive wow fadeIn">';
	echo '<table class="table table-sm table-striped"><tr><td style="text-align:center; font-weight:bold;" colspan="'.$tableColGoaltending.'">'.$leaderGoalies.'</td></tr>';
	echo '<tr><td style="text-align:center;" colspan="'.$tableColGoaltending.'">'.$leaderminGames.' '.$games.' '.$leaderminGames2.'.</td></tr><tr class="tableau-top">';
	echo '<td></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderTeam.'<span>'.$leaderTeamF.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderGP.'<span>'.$leaderGP.'</span></a></td>';
	if($currentFarm == 0) {
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderWin.'<span>'.$leaderWinF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderLost.'<span>'.$leaderLostF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderTie.'<span>'.$leaderTieF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderMin.'<span>'.$leaderMinF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderGA.'<span>'.$leaderGAF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderSO.'<span>'.$leaderSOF.'</span></a></td>';
	}
	echo '<td style="text-align:right; font-weight:bold;"><a href="javascript:return;" class="info">'.$leaderAVG.'<span>'.$leaderAVGF.'</span></a></td>';
	if($currentFarm == 0) {
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderPIM.'<span>'.$leaderPIMF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderShots.'<span>'.$leaderShotsF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderPct.'<span>'.$leaderPctF.'</span></a></td>';
		echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$leaderAssist.'<span>'.$leaderAssistF.'</span></a></td>';
	}
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	$i = 0;
	$c =  1;
	if(isset($joueur2)) {
		for($i=0;$i<count($joueur2);$i++) {
			if($c == 1) $c = 2;
			else $c = 1;
			if(isset($TSabbr) && substr_count($equipes2[$i], $TSabbr)) $bold = 'font-weight:bold;';
			else $bold = '';
			echo '<tr class="hover'.$c.'">';
			echo '<td style="'.$bold.'">'.$joueur2[$i].'</td>';
			echo '<td style="text-align:right;'.$bold.'">'.$equipes2[$i].'</td>';
			echo '<td style="text-align:right;'.$bold.'">'.$gp2[$i].'</td>';
			if($currentFarm == 0) {
				echo '<td style="text-align:right;'.$bold.'">'.$win[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$loose[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$tie[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$min[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$ga[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$so[$i].'</td>';
			}
			echo '<td style="text-align:right; font-weight:bold;">'.$avg[$i].'</td>';
			if($currentFarm == 0) {
				echo '<td style="text-align:right;'.$bold.'">'.$pun2[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$sh2[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$pct[$i].'</td>';
				echo '<td style="text-align:right;'.$bold.'">'.$ass2[$i].'</td>';
			}
			echo '</tr>';
		}
	}
	
	
}
else{
    echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
}
echo '</tbody></table></div>';

    if(isset($lastUpdated)){
        echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
    }

echo'</div></div></div></div>';
?>

<?php include 'footer.php'; ?>