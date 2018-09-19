<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = 'PlayerVitals';
$CurrentTitle = $joueursTitle;
$CurrentPage = 'PlayerVitals';
include 'head.php';
?>

<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border:solid 1px<?php echo $couleur_contour; ?>">
<div class="titre"><span class="bold-blanc"><?php echo $joueursTitle.' - '.$currentTeam; ?></span></div>
<div style="padding:0px 0px 0px 0px;">
<table class="tableau">

<?php
$matches = glob($folder.'*'.$playoff.'PlayerVitals.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PlayerVitals')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'PlayerVitals.html';

$a = 0;
$b = 0;
$c = 1;
$d = 1;
$i = 0;
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = each($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			echo '<tr><td colspan="9" style="padding-bottom:20px;">'.$allLastUpdate.' '.$val.'</td></tr>';
		}
		if(substr_count($val, 'A NAME=') && $b) {
			$d = 0;
		}
		if(substr_count($val, 'A NAME='.$currentTeam)) {
			$pos = strpos($val, '</A>');
			$pos = $pos - 23;
			$equipe = substr($val, 23, $pos);
			//echo '<tr class="titre"><td colspan="9" class="text-blanc bold-blanc">'.$equipe.'</td></tr>';
			$b++;
		}
		if($a == 3 && $b && $d) {
			$reste = trim(substr($val, strpos($val, '  '), strpos($val, '</PRE>')-strpos($val, '  ')));
			$mage = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$mgrandeur = substr($reste, 0, strpos($reste, '  '));
			$mgrandeur = str_replace('ft', '\'', $mgrandeur);
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$mpoids = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$msalaire = substr($reste, 0);
			$a++;
		}
		if(substr_count($val, '------------------') && $b && $d) {
			$a++;
		}
		if($a == 2 && $b && $d) {
			$numero[$i] = substr($val, 0,  strpos($val, ' '));
			$reste = trim(substr($val, strpos($val, ' ')));
			if(substr_count($reste, '*', 0, 1)) {
				$recrue[$i] = substr($reste, 0, 1);
				$reste = trim(substr($reste, 1));
			}
			else $recrue[$i] = '';
			
			$name[$i] = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$position[$i] = substr($reste, 0, strpos($reste, '  '));
			$aremplacer = array('LW', 'RW');
			$remplace = array($joueursLW, $joueursRW);
			$position[$i] = str_replace($aremplacer, $remplace, $position[$i]);
			if(substr_count($position[$i], 'G')) $position2[$i] = 5;
			if(substr_count($position[$i], 'D')) $position2[$i] = 4;
			if(substr_count($position[$i], 'AG')) $position2[$i] = 2;
			if(substr_count($position[$i], 'AD')) $position2[$i] = 3;
			if(substr_count($position[$i], 'C')) $position2[$i] = 1;
			$reste = trim(substr($reste, strpos($reste, '  ')));
			
			$age[$i] = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$grandeur[$i] = substr($reste, 0, strpos($reste, '  '));
			$grandeur[$i] = str_replace('ft', '\'', $grandeur[$i]);
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$poids[$i] = substr($reste, 0, strpos($reste, 'lbs') + 3);
			$reste = trim(substr($reste, strpos($reste, 'lbs') + 3));
			$salaire[$i] = substr($reste, 0, strpos($reste, '  '));
			$salaire2[$i] = preg_replace('/\D/', '', $salaire[$i]);
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$contrat[$i] = substr($reste, 0);
			$aremplacer = array('0 years', '1 year', 'years');
			$remplace = array($joueurs0Year, $joueurs1Year, $joueursYears);
			$contrat2[$i] = $contrat[$i];
			$contrat[$i] = str_replace($aremplacer, $remplace, $contrat[$i]);
			$i++;
		}
		if($a == 1 && $b && $d) {
			$a++;
		}
		if(substr_count($val, '<PRE>') && $b && $d) {
			$a = 1;
		}
	}

$ss = 'font-weight: bold;';
$sortmemj = 'ja';
$sortmemn = 'na';
$sortmemr = 'ra';
$sortmemp = 'pa';
$sortmemy = 'ya';
$sortmemg = 'ga';
$sortmempd = 'pda';
$sortmems = 'sa';
$sortmemc = 'ca';
if($sort == 'ja') $sortmemj = 'jd';
if($sort == 'jd') $sortmemj = 'ja';
if($sort == 'na' || !$sort) $sortmemn = 'nd';
if($sort == 'nd') $sortmemn = 'na';
if($sort == 'ra') $sortmemr = 'rd';
if($sort == 'rd') $sortmemr = 'ra';
if($sort == 'pa') $sortmemp = 'pd';
if($sort == 'pd') $sortmemp = 'pa';
if($sort == 'ya') $sortmemy = 'yd';
if($sort == 'yd') $sortmemy = 'ya';
if($sort == 'ga') $sortmemg = 'gd';
if($sort == 'gd') $sortmemg = 'ga';
if($sort == 'pda') $sortmempd = 'pdd';
if($sort == 'pdd') $sortmempd = 'pda';
if($sort == 'sa') $sortmems = 'sd';
if($sort == 'sd') $sortmems = 'sa';
if($sort == 'ca') $sortmemc = 'cd';
if($sort == 'cd') $sortmemc = 'ca';
$lienmem = '?sort=';
echo '
	<tr class="tableau-top">
	<td><a href="'.$lienmem.$sortmemn.'" class="info">#<span>'.$joueursNumber.'</span></a></td>
	<td><a href="'.$lienmem.$sortmemr.'" class="info">R<span>'.$joueursRookie.'</span></a></td>
	<td><a href="'.$lienmem.$sortmemj.'" class="lien-blanc">'.$joueursPlayers.'</a></td>
	<td style="text-align:right;"><a href="'.$lienmem.$sortmemp.'" class="info">Pos<span>Position</span></a></td>
	<td style="text-align:right;"><a href="'.$lienmem.$sortmemy.'" class="lien-blanc">Age</a></td>
	<td><a href="'.$lienmem.$sortmemg.'" class="lien-blanc">'.$joueursHeight.'</a></td>
	<td><a href="'.$lienmem.$sortmempd.'" class="lien-blanc">'.$joueursWeight.'</a></td>
	<td style="text-align:right;"><a href="'.$lienmem.$sortmems.'" class="lien-blanc">'.$joueursSalary.'</a></td>
	<td style="text-align:right;"><a href="'.$lienmem.$sortmemc.'" class="lien-blanc">'.$joueursContrat.'</a></td>
	</tr>';
$i = 0;
$s1 = $s2 = $s3 = $s4 = $s5 = $s6 = $s7 = $s8 = $s9 = '';
if(isset($name)) {
	if($sort == 'ja' || $sort == 'jd') {
		$tableauf = $name;
		$s3 = $ss;
	}
	if($sort == 'na' || $sort == 'nd' || !$sort) {
		$tableauf = $numero;
		$s1 = $ss;
	}
	if($sort == 'ra' || $sort == 'rd') {
		$tableauf = $recrue;
		$s2 = $ss;
	}
	if($sort == 'pa' || $sort == 'pd') {
		$tableauf = $position2;
		$s4 = $ss;
	}
	if($sort == 'ya' || $sort == 'yd') {
		$tableauf = $age;
		$s5 = $ss;
	}
	if($sort == 'ga' || $sort == 'gd') {
		$tableauf = $grandeur;
		$s6 = $ss;
	}
	if($sort == 'pda' || $sort == 'pdd') {
		$tableauf = $poids;
		$s7 = $ss;
	}
	if($sort == 'sa' || $sort == 'sd') {
		$tableauf = $salaire2;
		$s8 = $ss;
	}
	if($sort == 'ca' || $sort == 'cd') {
		$tableauf = $contrat2;
		$s9 = $ss;
	}
	
	if($sort || !$sort) natsort($tableauf);
	if($sort == 'cd' || $sort == 'sa' || $sort == 'pdd' || $sort == 'gd' || $sort == 'jd' || $sort == 'ra' || $sort == 'yd' || $sort == 'nd' || $sort == 'pd') $tableauf = array_reverse ($tableauf, TRUE);
	
	$key = key($tableauf);
	$val = current($tableauf);
	while(list ($key, $val) = each($tableauf)) {
		if($c == 1) $c = 2;
		else $c = 1;
		echo '
			<tr class="hover'.$c.'">
			<td style="'.$s1.'">'.$numero[$key].'</td>
			<td style="'.$s2.'">'.$recrue[$key].'</td>
			<td style="'.$s3.'">'.$name[$key].'</td>
			<td style="text-align:right; '.$s4.'">'.$position[$key].'</td>
			<td style="text-align:right; '.$s5.'">'.$age[$key].'</td>
			<td style="'.$s6.'">'.$grandeur[$key].'"</td>
			<td style="'.$s7.'">'.$poids[$key].'</td>
			<td style="text-align:right;'.$s8.'">'.$salaire[$key].'$</td>
			<td style="text-align:right;'.$s9.'">'.$contrat[$key].'</td>
			</tr>';
			$i++;
	}
}
echo '
	<tr class="tableau-top">
	<td colspan="4">'.$joueursProTeamAverage.'</td>
	<td style="text-align:right; '.$s5.'">'.$mage.'</td>
	<td style="'.$s6.'">'.$mgrandeur.'"</td>
	<td style="'.$s7.'">'.$mpoids.'</td>
	<td style="text-align:right;'.$s8.'">'.$msalaire.'$</td>
	<td></td>
	</tr>';
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
echo '</table></div></div>';
?>

</body>
</html>