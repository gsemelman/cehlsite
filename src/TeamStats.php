<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = 'TeamStats';
$CurrentTitle = $teamStatsTitle;
$CurrentPage = 'TeamStats';
include 'head.php';
?>

<div class="container">

<div class="card">
	<div class="card-header wow fadeIn">
		<h3><?php echo $CurrentTitle; ?></h3>
	</div>
	<div class="card-body">

<?php

// PPG PPO PKGA PKO
if($playoff == '') {
	$matches = glob($folder.'*'.$playoff.'Schedule.html');
	$folderLeagueURL = '';
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
			$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Schedule')-strrpos($matches[$j], '/')-1);
			break 1;
		}
	}
	$Fnm = $folder.$folderLeagueURL.'Schedule.html';
}

$round = 1;
if($playoff == 'PLF') {
	$matches = glob($folder.'*PLF-Round1-Schedule.html');
	$folderLeagueURL2 = '';
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		if(substr_count($matches[$j], 'PLF')) {
			$folderLeagueURL2 = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLF-Round1-Schedule.html')-strrpos($matches[$j], '/')-1);
			break 1;
		}
	}
	if (file_exists($folder.$folderLeagueURL2.'PLF-Round1-Schedule.html')) {
		$round = 1;
	}
	if (file_exists($folder.$folderLeagueURL2.'PLF-Round2-Schedule.html')) {
		$round = 2;
	}
	if (file_exists($folder.$folderLeagueURL2.'PLF-Round3-Schedule.html')) {
		$round = 3;
	}
	if (file_exists($folder.$folderLeagueURL2.'PLF-Round4-Schedule.html')) {
		$round = 4;
	}
}

for($j=1;$j<=$round;$j++) {
	if($playoff == 'PLF') {
		$Fnm = $folder.$folderLeagueURL2.'PLF-Round'.$j.'-Schedule.html';
	}
	if(file_exists($Fnm)) {
		// DÉTECTER LES PARTIES JOUÉES
		$i = 0;
		unset($schelduleNumber);
		$tableau = file($Fnm);
		while(list($cle,$val) = myEach($tableau)) {
			if(substr_count($val, ' at ') && !substr_count($val, '<strike>')){
				break 1;
			}
			if(substr_count($val, 'A HREF=')){
				$reste = trim(substr($val, strpos($val, '> ')+1));
				$schelduleNumber[$i] = substr($reste, 0, strpos($reste, ' '));
				$i++;
			}
		}
		// OUVRIR CHAQUE PARTIE POUR VOIR LES RÉSULTATS PP/PK
		if(isset($schelduleNumber)) {
			for($i=0;$i<count($schelduleNumber);$i++) {
				$matchNumber = $schelduleNumber[$i];
				if($playoff == '') $Fnm = $folder.$folderGames.$folderLeagueURL.$matchNumber.'.html';
				if($playoff == 'PLF') $Fnm = $folder.$folderGames.$folderLeagueURL2.'PLF-R'.$j.'-'.$matchNumber.'.html';
				$a = 0;
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
							$tmpGameTeam1 = trim(substr($val, $pos_avant, $long1));
							$tmpGameTeam2 = trim(substr($val, $pos, $long2));
							$a = 1;
						}
						if(substr_count($val, 'Power Play Conversions') && $a == 1) {
							$a = 2;
							$b = 0;
						}
						if(substr_count($val, 'Game Stars') && $a == 2) {
							break 1;
						}
						if(substr_count($val, 'for') && $a == 2) {
							
							if(substr_count($val, $tmpGameTeam1)) {
								$tmpTeam1PPG = trim(substr($val, strlen($tmpGameTeam1)+1, strpos($val, 'for')-1-strlen($tmpGameTeam1)-1));
								$tmpTeam1PPGO = trim(substr($val, strpos($val, 'for')+4, strpos($val, '<')-strpos($val, 'for')-4));
							}
							if(substr_count($val, $tmpGameTeam2)) {
								$tmpTeam2PPG = trim(substr($val, strlen($tmpGameTeam2)+1, strpos($val, 'for')-1-strlen($tmpGameTeam2)-1));
								$tmpTeam2PPGO = trim(substr($val, strpos($val, 'for')+4, strpos($val, '<')-strpos($val, 'for')-4));
							}
							
							$b++;
							
							if($b == 2) {
								$d = 0;
								for($k = 0; $k < count($gmequipe) ; $k++) {
									if($tmpGameTeam1 == $gmequipe[$k]) {
										$d++;
										if(isset($gameStatsFilePPG[$k])) $gameStatsFilePPG[$k] += $tmpTeam1PPG;
										else $gameStatsFilePPG[$k] = $tmpTeam1PPG;
										if(isset($gameStatsFilePPGO[$k])) $gameStatsFilePPGO[$k] += $tmpTeam1PPGO;
										else $gameStatsFilePPGO[$k] = $tmpTeam1PPGO;
										if(isset($gameStatsFilePKGA[$k])) $gameStatsFilePKGA[$k] += $tmpTeam2PPG;
										else $gameStatsFilePKGA[$k] = $tmpTeam2PPG;
										if(isset($gameStatsFilePKOA[$k])) $gameStatsFilePKOA[$k] += $tmpTeam2PPGO;
										else $gameStatsFilePKOA[$k] = $tmpTeam2PPGO;
									}
									if($tmpGameTeam2 == $gmequipe[$k]) {
										$d++;
										if(isset($gameStatsFilePPG[$k])) $gameStatsFilePPG[$k] += $tmpTeam2PPG;
										else $gameStatsFilePPG[$k] = $tmpTeam2PPG;
										if(isset($gameStatsFilePPGO[$k])) $gameStatsFilePPGO[$k] += $tmpTeam2PPGO;
										else $gameStatsFilePPGO[$k] = $tmpTeam2PPGO;
										if(isset($gameStatsFilePKGA[$k])) $gameStatsFilePKGA[$k] += $tmpTeam1PPG;
										else $gameStatsFilePKGA[$k] = $tmpTeam1PPG;
										if(isset($gameStatsFilePKOA[$k])) $gameStatsFilePKOA[$k] += $tmpTeam1PPGO;
										else $gameStatsFilePKOA[$k] = $tmpTeam1PPGO;
									}
									if($d == 2) break 1;
								}
							}
						}
					}
				}
				else echo $allFileNotFound.' - '.$Fnm.'<br>';
			}
		}
	}
	else echo $allFileNotFound.' - '.$Fnm.'<br>';
}

// Team Stats
$matches = glob($folder.'*'.$playoff.'TeamStats.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'TeamStats')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'TeamStats.html';

$a = 0;
$c = 1;
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$val.'</h5>';
			
			echo '<div class="col-sm-12 col-md-10 offset-md-1">';
			echo '<div class="table-responsive wow fadeIn">';
			echo '<table class="table table-sm">';
		}
		if(substr_count($val, '</PRE>')){
			$a++;
		}
		if($a == 1){
			$tmpTeam = trim(substr($val, 0, 10));
			$tmpGP = substr($val, 14, 2);
			$tmpPP = substr($val, 18, 5);
			$tmpPK = substr($val, 24, 5);
			$tmpPIMP = substr($val, 32, 5);
			$tmpGFG = substr($val, 39, 5);
			$tmpGAG = substr($val, 45, 5);
			$tmpSFG = substr($val, 52, 5);
			$tmpSAG = substr($val, 59, 5);
			
			for($k = 0; $k < count($gmequipe) ; $k++) {
				if($tmpTeam == $gmequipe[$k]) {
					$teamStatsFileGP[$k] = $tmpGP;
					$teamStatsFilePP[$k] = $tmpPP;
					$teamStatsFilePK[$k] = $tmpPK;
					$teamStatsFilePIMP[$k] = $tmpPIMP;
					$teamStatsFileGFG[$k] = $tmpGFG;
					$teamStatsFileGAG[$k] = $tmpGAG;
					$teamStatsFileSFG[$k] = $tmpSFG;
					$teamStatsFileSAG[$k] = $tmpSAG;
					break 1;
				}
			}
		}
		if(substr_count($val, '<PRE>')){
			$a++;
		}
	}
	
	if(isset($teamStatsFileGP)) {
		$ss = 'font-weight: bold;';
		$sortmempj = 'pja';
		$sortmeman = 'ana';
		$sortmemdn = 'dna';
		$sortmempp = 'ppa';
		$sortmembp = 'bpa';
		$sortmembc = 'bca';
		$sortmemtp = 'tpa';
		$sortmemtc = 'tca';
		$sortmemppg = 'ppga';
		$sortmemppo = 'ppoa';
		$sortmempkg = 'pkga';
		$sortmempko = 'pkoa';
		
		if(!$sort) $sort = 'ana';
		
		if($sort == 'pja') $sortmempj = 'pjd';
		if($sort == 'pjd') $sortmempj = 'pja';
		if($sort == 'ana') $sortmeman = 'and';
		if($sort == 'and') $sortmeman = 'ana';
		if($sort == 'dna') $sortmemdn = 'dnd';
		if($sort == 'dnd') $sortmemdn = 'dna';
		if($sort == 'ppa') $sortmempp = 'ppd';
		if($sort == 'ppd') $sortmempp = 'ppa';
		if($sort == 'bpa') $sortmembp = 'bpd';
		if($sort == 'bpd') $sortmembp = 'bpa';
		if($sort == 'bca') $sortmembc = 'bcd';
		if($sort == 'bcd') $sortmembc = 'bca';
		if($sort == 'tpa') $sortmemtp = 'tpd';
		if($sort == 'tpd') $sortmemtp = 'tpa';
		if($sort == 'tca') $sortmemtc = 'tcd';
		if($sort == 'tcd') $sortmemtc = 'tca';
		if($sort == 'ppga') $sortmemppg = 'ppgd';
		if($sort == 'ppgd') $sortmemppg = 'ppga';
		if($sort == 'ppoa') $sortmemppo = 'ppod';
		if($sort == 'ppod') $sortmemppo = 'ppoa';
		if($sort == 'pkga') $sortmempkg = 'pkgd';
		if($sort == 'pkgd') $sortmempkg = 'pkga';
		if($sort == 'pkoa') $sortmempko = 'pkod';
		if($sort == 'pkod') $sortmempko = 'pkoa';
		
		$lienmem = '?sort=';
		if($playoff == 'PLF') $lienmem = '?plf=1&sort=';
		
		$s1 = $s2 = $s3 = $s4 = $s5 = $s6 = $s7 = $s8 = $s9 = $s10 = $s11 = $s12 = '';
		if($sort == 'pja' || $sort == 'pjd') {
			$tableaut = $teamStatsFileGP;
			$s1 = $ss;
		}
		if($sort == 'ana' || $sort == 'and' || !$sort) {
			$tableaut = $teamStatsFilePP;
			$s2 = $ss;
		}
		if($sort == 'dna' || $sort == 'dnd') {
			$tableaut = $teamStatsFilePK;
			$s3 = $ss;
		}
		if($sort == 'ppa' || $sort == 'ppd') {
			$tableaut = $teamStatsFilePIMP;
			$s4 = $ss;
		}
		if($sort == 'bpa' || $sort == 'bpd') {
			$tableaut = $teamStatsFileGFG;
			$s5 = $ss;
		}
		if($sort == 'bca' || $sort == 'bcd') {
			$tableaut = $teamStatsFileGAG;
			$s6 = $ss;
		}
		if($sort == 'tpa' || $sort == 'tpd') {
			$tableaut = $teamStatsFileSFG;
			$s7 = $ss;
		}
		if($sort == 'tca' || $sort == 'tcd') {
			$tableaut = $teamStatsFileSAG;
			$s8 = $ss;
		}
		if($sort == 'ppga' || $sort == 'ppgd' || !$sort) {
			$tableaut = $gameStatsFilePPG;
			$s9 = $ss;
		}
		if($sort == 'ppoa' || $sort == 'ppod' || !$sort) {
			$tableaut = $gameStatsFilePPGO;
			$s10 = $ss;
		}
		if($sort == 'pkga' || $sort == 'pkgd' || !$sort) {
			$tableaut = $gameStatsFilePKGA;
			$s11 = $ss;
		}
		if($sort == 'pkoa' || $sort == 'pkod' || !$sort) {
			$tableaut = $gameStatsFilePKOA;
			$s12 = $ss;
		}
		
		echo '<tr class="tableau-top">
			<td></td>
			<td>'.$teamStatsTEAM.'</td>
			<td style="text-align:right;"><a style="'.$s1.'" href="'.$lienmem.$sortmempj.'" class="info">'.$teamStatsGPm.'<span>'.$teamStatsGP.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s9.'" href="'.$lienmem.$sortmemppg.'" class="info">'.$teamStatsPPGm.'<span>'.$teamStatsPPG.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s10.'" href="'.$lienmem.$sortmemppo.'" class="info">'.$teamStatsPPOm.'<span>'.$teamStatsPPO.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s2.'" href="'.$lienmem.$sortmeman.'" class="info">'.$teamStatsPPm.'<span>'.$teamStatsPP.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s11.'" href="'.$lienmem.$sortmempkg.'" class="info">'.$teamStatsPKGAm.'<span>'.$teamStatsPKGA.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s12.'" href="'.$lienmem.$sortmempko.'" class="info">'.$teamStatsPKOm.'<span>'.$teamStatsPKO.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s3.'" href="'.$lienmem.$sortmemdn.'" class="info">'.$teamStatsPKm.'<span>'.$teamStatsPK.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s4.'" href="'.$lienmem.$sortmempp.'" class="info">'.$teamStatsPIMGm.'<span>'.$teamStatsPIMG.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s5.'" href="'.$lienmem.$sortmembp.'" class="info">'.$teamStatsGFGm.'<span>'.$teamStatsGFG.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s6.'" href="'.$lienmem.$sortmembc.'" class="info">'.$teamStatsGAGm.'<span>'.$teamStatsGAG.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s7.'" href="'.$lienmem.$sortmemtp.'" class="info">'.$teamStatsSFGm.'<span>'.$teamStatsSFG.'</span></a></td>
			<td style="text-align:right;"><a style="'.$s8.'" href="'.$lienmem.$sortmemtc.'" class="info">'.$teamStatsSAGm.'<span>'.$teamStatsSAG.'</span></a></td>
			</tr>';
		if($sort) natsort($tableaut);
		if($sort == 'pja' || $sort == 'ana' || $sort == 'dna' || $sort == 'ppa' || $sort == 'bpa' || $sort == 'bca' || $sort == 'tpa' || $sort == 'tca' || $sort == 'ppga' || $sort == 'ppoa' || $sort == 'pkga' || $sort == 'pkoa') $tableaut = array_reverse ($tableaut, TRUE);
		$key = key($tableaut);
		$val = current($tableaut);
		
		$i = 0;
		while(list ($key, $val) = myEach($tableaut)) {
			if($c == 1) $c = 2;
			else $c = 1;
			$equipe = $gmequipe[$key];
			if($equipe == $currentTeam) $bold = 'font-weight:bold;';
			else $bold = '';
			$position = $i + 1;
			echo '<tr class="hover'.$c.'">
			<td>'.$position.'</td>
			<td style="'.$bold.'">'.$equipe.'</td>
			<td style="text-align:right;'.$s1.$bold.'">'.$teamStatsFileGP[$key].'</td>';
			if($teamStatsFilePP[$key] == 'N/A') {
				$gameStatsFilePPG[$key] = 0;
				$gameStatsFilePPGO[$key] = 0;
			}
			echo '<td style="text-align:right;'.$s9.$bold.'">'.$gameStatsFilePPG[$key].'</td>';
			echo '<td style="text-align:right;'.$s10.$bold.'">'.$gameStatsFilePPGO[$key].'</td>';
			echo '<td style="text-align:right;'.$s2.$bold.'">'.$teamStatsFilePP[$key].'</td>';
			if($teamStatsFilePK[$key] == 'N/A') {
				$gameStatsFilePKGA[$key] = 0;
				$gameStatsFilePKOA[$key] = 0;
			}
			echo '<td style="text-align:right;'.$s11.$bold.'">'.$gameStatsFilePKGA[$key].'</td>';
			echo '<td style="text-align:right;'.$s12.$bold.'">'.$gameStatsFilePKOA[$key].'</td>';
			echo '<td style="text-align:right;'.$s3.$bold.'">'.$teamStatsFilePK[$key].'</td>
			<td style="text-align:right;'.$s4.$bold.'">'.$teamStatsFilePIMP[$key].'</td>
			<td style="text-align:right;'.$s5.$bold.'">'.$teamStatsFileGFG[$key].'</td>
			<td style="text-align:right;'.$s6.$bold.'">'.$teamStatsFileGAG[$key].'</td>
			<td style="text-align:right;'.$s7.$bold.'">'.$teamStatsFileSFG[$key].'</td>
			<td style="text-align:right;'.$s8.$bold.'">'.$teamStatsFileSAG[$key].'</td>
			</tr>';
			$i++;
		}
	}
	else echo '<tr><td>'.$teamStatsStarted.'</td></tr>';
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
echo '</table></div></div></div></div>';
?>

</body>
</html>