<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Waivers';
$CurrentTitle = $waiversTitle;
$CurrentPage = 'Waivers';
include 'head.php';
?>

<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border:solid 1px<?php echo $couleur_contour; ?>">
<div class="titre"><span class="bold-blanc"><?php echo $waiversTitle; ?></span></div>
<div style="padding:0px 0px 0px 0px;">
<table class="tableau">

<?php
$matches = glob($folder.'*'.$playoff.'Waivers.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
   if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Waivers')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'Waivers.html';
$b = 0;
$c = 1;
$d = 0;
$e = 0;
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = each($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '(As of')){
			$date = substr($val, strpos($val, '(')+7, strpos($val, ')')-strpos($val, '(')-7);
			echo '<tr><td colspan="4" style="padding-bottom:20px;">'.$allLastUpdate.' '.$date.'</td></tr>';
		}
		
		if(substr_count($val, 'NO PLAYERS ON WAIVERS')){
			$d = 3;
			if($e == 0) echo '<tr class="hover2"><td colspan="4" style="font-weight:bold;">'.$waiversNothing.'</td></tr>';
		}
		
		if($d == 2 && !substr_count($val, '<')) {
			if($c == 1) $c = 2;
			else $c = 1;
			$reste = trim($val);
			$waivName = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$waivDate = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$waivBy = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$waivClaim = $reste;
			
			$bold = '';
			if($waivBy == $currentTeam) $bold = 'font-weight:bold;';
			
			echo '<tr class="hover'.$c.'">
			<td style="'.$bold.'">'.$waivName.'</td>
			<td style="'.$bold.'">'.$waivDate.'</td>
			<td style="'.$bold.'">'.$waivBy.'</td>
			<td style="'.$bold.'">'.$waivClaim.'</td>
			</tr>';
			$e = 1;
		}
		
		if($d == 1 && (substr_count($val, '<br>') || substr_count($val, '<BR>'))){
			$d = 2;
			$c = 1;
		}
		
		if(substr_count($val, '<pre>') || substr_count($val, '<PRE>')){
			echo '<tr class="tableau-top">';
			echo '<td>'.$waiversPlayer.'</td>';
			echo '<td>'.$waiversDate.'</td>';
			echo '<td>'.$waiversBy.'</td>';
			echo '<td>'.$waiversClaimed.'</td>';
			echo '</tr>';
			$d = 1;
		}
		
		if($d == 4 && (substr_count($val, '<br>') || substr_count($val, '<BR>'))) {
			if(substr_count($val, '<br>')) $reste = substr($val, 0, strpos($val, '<br>'));
			if(substr_count($val, '<BR>')) $reste = substr($val, 0, strpos($val, '<BR>'));
			$waivNum = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$waivTeam = $reste;
			if($c == 1) $c = 2;
			else $c = 1;
			
			$bold = '';
			if($waivTeam == $currentTeam) $bold = 'font-weight:bold;';
			
			echo '<tr class="hover'.$c.'">
			<td style="'.$bold.'">'.$waivNum.'</td>
			<td style="'.$bold.'">'.$waivTeam.'</td>
			</tr>';
		}
		
		if(substr_count($val, 'PRIORITY LIST')){
			$d = 4;
			$c = 1;
			echo '</table><table class="tableau" style="margin-top:20px;"><tr class="tableau-top">';
			echo '<td>#</td>';
			echo '<td>'.$waiversPriority.'</td>';
			echo '</tr>';
		}
	}
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
echo '</table></div></div>';
?>

<?php include 'footer.php'; ?>