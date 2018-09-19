<?php
//$currentTeam = '';
include 'class_lib.php';
include 'config.php';
include 'lang.php';
$CurrentHTML = 'MiniWaivers';
$CurrentTitle = 'Waivers';
$CurrentPage = 'MiniWaivers';

?>

<div class = "container">
<div class = "row">
<div class = "col">
<div class = "table-responsive">
<table class="table table-sm">

<?php
if(!isset($playoff)) $playoff = '';
if($playoff == 1) $playoff = 'PLF';
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
$c = 1;
$d = 0;
$e = 0;
$f = 0;
$g = 0;

if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = each($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'NO PLAYERS ON WAIVERS')){
			$d = 3;
			if($e == 0) echo '<tr class="hover2"><td colspan="4" style="font-weight:bold;">'.$waiversNothing.'</td></tr>';
		}
		
		if($d == 2 && $g < 5 && !substr_count($val, '<')) {
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
			//if($waivBy == $currentTeam) $bold = 'font-weight:bold;';
			
			echo '<tr class="hover'.$c.'">
			<td style="'.$bold.'">'.$waivName.'</td>
			<td style="'.$bold.'">'.$waivDate.'</td>
			<td style="'.$bold.'">'.$waivBy.'</td>
			<td style="'.$bold.'">'.$waivClaim.'</td>
			</tr>';
			$e = 1;
			$g++;
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
		
		

	}
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
echo '</table></div></div></div></div>';
?>