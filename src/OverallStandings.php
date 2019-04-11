<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Standings';
$CurrentTitle = $standingOVTitle;
$CurrentPage = 'OverallStandings';
include 'head.php';
?>

<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border: solid 1px <?php echo $couleur_contour; ?>;">
<div class="titre"><span class="bold-blanc"><?php echo $standingOVTitle; ?></span></div>
<div style="padding:0px 0px 0px 0px;">
<table class="tableau">

<?php
$tableCol = 15;
if($currentFarm == 1) {
	$tableCol = 11;
}
include 'phpGetAbbr.php'; // Output $TSabbr

$matches = glob($folder.'*'.$playoff.$farm.'Standings.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if(!substr_count($matches[$j], 'OverallStandings')) {
		if((!substr_count($matches[$j], 'Farm') && $farm == '') || (substr_count($matches[$j], 'Farm') && $farm == 'Farm')) {
			if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
				$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], $farm.'Standings')-strrpos($matches[$j], '/')-1);
				break 1;
			}
		}
	}
}
$c = 1;
$d = 0;
$e = 0;
$Fnm = $folder.$folderLeagueURL.$farm.'Standings.html';
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val2 = substr($val, 10, $pos);
			echo '<tr><td colspan="'.$tableCol.'" style="padding-bottom:20px;">'.$allLastUpdate.' '.$val2.'</td></tr>';
		}
		if(substr_count($val, 'STK') && (substr_count($val, 'OL') || substr_count($val, 'OTL'))) {
			$e = 1;
		}
		if($d == 0 && substr_count($val, 'Conference</H3>') && !substr_count($val, '<H3>By Conference</H3>')) {
			$d = 0;
			$b = 0;
		}
		if(substr_count($val, 'Conference</H3>') && !substr_count($val, '<H3>By Conference</H3>')) {
			$b = 0;
		}
		if(substr_count($val, '<H3>By Division</H3>')) {
			break 1;
		}
		if(substr_count($val, 'HREF=') || ($currentFarm == 1 && substr_count($val, '<') == false)) {
			$reste = trim($val);
			if(substr_count($reste, 'WIDTH')) {
				$reste = substr($reste, strpos($reste, '<A '));
			}
			$serie[$d] = '';
			if($currentFarm == 0) {
				$serie[$d] = substr($reste, 0, strpos($reste, '<'));
				$reste = trim(substr($reste, strpos($reste, '>')+1));
				$equipe[$d] = substr($reste, 0, strpos($reste, '</A>'));
				$reste = trim(substr($reste, strpos($reste, '</A>')+4));
			}
			if($currentFarm == 1) {
				$count = strlen($reste);
				$z = 0;
				while( $z < $count ) {
					if( ctype_digit($reste[$z]) ) {
						$pos = $z;
						break 1;
					}
					$z++;
				}
				$equipe[$d] = trim(substr($reste, 0, $pos));
				$reste = trim(substr($reste, $pos));
			}
			$pj[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsW[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsL[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsT[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			if($currentFarm == 0 && $e == 1) {
				$standingsOL[$d] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
			}
			$standingsPts[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsGF[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsGA[$d] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingsDiff[$d] = $standingsGF[$d] - $standingsGA[$d];
			$sortingDiff = $standingsDiff[$d];
			if($standingsDiff[$d] > 0) $standingsDiff[$d] = '+'.$standingsDiff[$d];
			if($currentFarm == 1) {
				$standingsPCT[$d] = $reste;
			}
			if($currentFarm == 0) {
				$standingsPCT[$d] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				for($z=0;$z<9;$z++) {
					$reste = trim(substr($reste, strpos($reste, ' ')));
				}
				$standingsL10[$d] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$standingsSTK[$d] = $reste;
			}
			if($serie[$d] != ''){
				if($serie[$d] == 'z') $serie[$d] = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingZ.'<span>'.$standingZFull.'</span></a>';
				if($serie[$d] == 'y') $serie[$d] = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingY.'<span>'.$standingYFull.'</span></a>';
				if($serie[$d] == 'x') $serie[$d] = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingX.'<span>'.$standingXFull.'</span></a>';
				$b++;
			}
			else {
				if($b > 7) $serie[$d] = '<a href="javascript:return;" class="info" style="color:#000000">'.$standingN.'<span>'.$standingNFull.'</span></a>';
			}
			if($equipe[$d] == $currentTeam || ($currentFarm == 1 && substr_count($val, '('.$TSabbr))) $bold = 'font-weight:bold;';
			else $bold = '';
			
			$data[] = array('id' => $d, 'pts' => $standingsPts[$d], 'gp' => $pj[$d], 'win' => $standingsW[$d], 'diff' => $sortingDiff);
			
			$d++;
		}
	}
	echo '<tr class="tableau-top">';
	echo '<td></td>';
	if($currentFarm == 0) echo '<td></td>';
	echo '<td>'.$standingTeam.'</td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingGP.'<span>'.$standingGPFull.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingW.'<span>'.$standingWFull.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingL.'<span>'.$standingLFull.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingE.'<span>'.$standingEFull.'</span></a></td>';
	if($currentFarm == 0 && $e == 1) echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingOT.'<span>'.$standingOTFull.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info"><b>'.$standingPTS.'</b><span>'.$standingPTSFull.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingGF.'<span>'.$standingGFFull.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingGA.'<span>'.$standingGAFull.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingDiff.'<span>'.$standingDiffFull.'</span></a></td>';
	echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingPCT.'<span>'.$standingPCTFull.'</span></a></td>';
	if($currentFarm == 0) echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingL10.'<span>'.$standingL10Full.'</span></a></td>';
	if($currentFarm == 0) echo '<td style="text-align:right;"><a href="javascript:return;" class="info">'.$standingSTRK.'<span>'.$standingSTRKFull.'</span></a></td>';
	echo '</tr>';
	
	function array_orderby() {
		$args = func_get_args();
		$data = array_shift($args);
		foreach ($args as $n => $field) {
			if (is_string($field)) {
				$tmp = array();
				foreach ($data as $key => $row)
					$tmp[$key] = $row[$field];
				$args[$n] = $tmp;
				}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);
		return array_pop($args);
	}
	$sorted = array_orderby($data, 'pts', SORT_DESC, 'gp', SORT_ASC, 'win', SORT_DESC, 'diff', SORT_DESC);
	
	for($d=0;$d<count($sorted);$d++) {
		$key = $sorted[$d]['id'];
		if($equipe[$key] == $currentTeam || ($currentFarm == 1 && substr_count($val, '('.$TSabbr))) $bold = 'font-weight:bold;';
		else $bold = '';
		if($c == 1) $c = 2;
		else $c = 1;
		$pos = $d + 1;
		echo '<tr class="hover'.$c.'">';
		echo '<td style="'.$bold.'">'.$pos.'</td>';
		if($currentFarm == 0) echo '<td style="'.$bold.'">'.$serie[$key].'</td>';
		if($currentFarm == 0) echo '<td style="'.$bold.'"><a class="lien-noir" style="display:block; width:100%;" href="TeamRosters.php?team='.$equipe[$key].'">'.$equipe[$key].'</a></td>';
		if($currentFarm == 1) echo '<td style="'.$bold.'">'.$equipe[$key].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$pj[$key].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingsW[$key].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingsL[$key].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingsT[$key].'</td>';
		if($currentFarm == 0 && $e == 1) echo '<td style="text-align:right;'.$bold.'">'.$standingsOL[$key].'</td>';
		echo '<td style="text-align:right;'.$bold.'"><b>'.$standingsPts[$key].'</b></td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingsGF[$key].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingsGA[$key].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingsDiff[$key].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingsPCT[$key].'</td>';
		if($currentFarm == 0) echo '<td style="text-align:right;'.$bold.'">'.$standingsL10[$key].'</td>';
		if($currentFarm == 0) echo '<td style="text-align:right;'.$bold.'">'.$standingsSTK[$key].'</td>';
		echo '</tr>';
	}
}
else { 
	echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
}

?>
</table></div></div>

</body>
</html>