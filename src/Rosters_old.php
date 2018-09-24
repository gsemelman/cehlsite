<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = 'Rosters';
$CurrentTitle = $rostersTitle;
$CurrentPage = 'Rosters';
include 'head.php';
?>

<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border:solid 1px<?php echo $couleur_contour; ?>">
<div class="titre"><span class="bold-blanc"><?php echo $rostersTitle.' - '.$currentTeam; ?></span></div>
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
$Fnm = $folder.$folderLeagueURL.'Rosters.html';

$a = 0;
$b = 0;
$c = 1;
$d = 1;
$i = 0;
$z = 0;
$stop = 0;
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = each($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			echo '<tr><td colspan="20" style="padding-bottom:20px;">'.$allLastUpdate.' '.$val.'</td></tr>';
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
			if(substr_count($reste, ' C ')) $tmpPos = ' C ';
			if(substr_count($reste, ' LW ')) $tmpPos = ' LW ';
			if(substr_count($reste, ' RW ')) $tmpPos = ' RW ';
			if(substr_count($reste, ' D ')) $tmpPos = ' D ';
			if(substr_count($reste, ' G ')) $tmpPos = ' G ';
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
			if(substr_count($reste, ' C ')) $tmpPos = ' C ';
			if(substr_count($reste, ' LW ')) $tmpPos = ' LW ';
			if(substr_count($reste, ' RW ')) $tmpPos = ' RW ';
			if(substr_count($reste, ' D ')) $tmpPos = ' D ';
			if(substr_count($reste, ' G ')) $tmpPos = ' G ';
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
	if($stop == 0) {
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
		
		$lienmem = '?sort=';
		
		$s1 = $s2 = $s3 = $s4 = $s5 = $s6 = $s7 = $s8 = $s9 = $s10 = $s11 = $s12 = $s13 = $s14 = $s15 = $s16 = $s17 = $s18 = $s19 = $s20 = 0;
		
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
		
		if($sort || !$sort) {
			if(isset($numero)) natsort($tableauf);
			if(isset($numero2)) natsort($tableaufs);
		}
		if($sort == 'nd' || $sort == 'jd' || $sort == 'pd' || $sort == 'ld' || $sort == 'cd' || $sort == 'ba' || $sort == 'ia' || 
		$sort == 'va' || $sort == 'fa' || $sort == 'ea' || $sort == 'dua' || $sort == 'dia' || $sort == 'pta' || $sort == 'psa' ||
		$sort == 'coa' || $sort == 'da' || $sort == 'oa' || $sort == 'exa' || $sort == 'lda' || $sort == 'ova') {
			if(isset($numero)) $tableauf = array_reverse ($tableauf, TRUE);
			if(isset($numero2))$tableaufs = array_reverse ($tableaufs, TRUE);
		}
		
		
		
		echo '<tr><td colspan="20" style="text-align:center; font-weight:bold;">'.$rostersPro.'</td></tr>';
		$a = 0;
		$b = 0;
		$d = 0;
		$i = 0;
		$z = 0;
		while(!$a) {
			if(!$b) {
				echo '
				<tr class="tableau-top">
				<td style="width:20px;'.$s1.'"><a href="'.$lienmem.$sortmemn.'" class="info">#<span>'.$rostersNumber.'</span></a></td>
				<td style="width:170px;'.$s2.'"><a href="'.$lienmem.$sortmemj.'" class="lien-blanc">'.$rostersName.'</a></td>
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
				</tr>';
				$b++;
			}
			if($z) {
				$key = key($tableaufs);
				$val = current($tableaufs);
				while(list ($key, $val) = each($tableaufs)) {
					if($c == 1) $c = 2;
					else $c = 1;
					echo '
					<tr class="hover'.$c.'">
					<td style="'.$s1.'">'.$numero2[$key].'</td>
					<td style="'.$s2.'">'.$name2[$key].'</td>
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
					</tr>';
				}
				$a++;
			}
			else {
				if(isset($numero)) {
					$key = key($tableauf);
					$val = current($tableauf);
					while(list ($key, $val) = each($tableauf)) {
						if($c == 1) $c = 2;
						else $c = 1;
						echo '
						<tr class="hover'.$c.'">
						<td style="'.$s1.'">'.$numero[$key].'</td>
						<td style="'.$s2.'">'.$name[$key].'</td>
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
						</tr>';
					}
				}
			}
			if(isset($numero2) && !$a) {
				echo '<tr><td colspan="20" style="text-align:center; font-weight:bold; padding-top:20px;">'.$rostersFarm.'</td></tr>';
				$b = 0;
				$z = 1;
				$c = 1;
			}
			else $a++;
		}
	}
	else echo '<tr><td>'.$rostersLinked.'</td></tr>';
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
echo '</table></div></div>';
?>

</body>
</html>