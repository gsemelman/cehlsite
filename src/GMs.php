<?php
require_once 'config.php';
include 'lang.php';

$CurrentHTML = 'GMs';
$CurrentTitle = $GMsTitle;
$CurrentPage = 'GMs';
$SecurePage=true;

include 'head.php';
?>

<div class="container">

<div class="card">
	<?php include 'SectionHeader.php';?>
	<div class="card-body">

<?php
$matches = glob($folder.'*'.$playoff.'GMs.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'GMs.html';

$c = 1;
$i = 0;
$lastUpdated = '';
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$lastUpdated=$val;

			//echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$val.'</h5>';
			
			echo '<div class="col-sm-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">';
			echo '<div class="table-responsive wow fadeIn">';
			echo '<table class="table table-sm table-striped table-rounded">';
		}
		if(substr_count($val, 'HREF') && !substr_count($val, '<BR>')) {
			$gmequipe[$i] = trim(substr($val, 0, 10));
			$gm[$i] = substr($val, 16, 26);
			$gmEmail[$i] = substr($val, strpos($val, '>')+1, strpos($val, '</A>')-strpos($val, '>')-1);
			if($gmEmail[$i] == '') $libre[$i] = 1;
			else $libre[$i] = 0;
			$i++;
		}
	}
	$i = 0;
	$z = 0;
	$sendAll = '';
	$sendAllFirst = 0;
	echo '<thead>';
	echo '<tr>
		<th>'.$GMsTeam.'</th>
		<th>'.$GMsName.'</th>
		</tr>';
	echo '</thead>';
	echo '<tbody>';
	for($i=0;$i<count($gmequipe);$i++) {
		if($libre[$i]) {
			$free[$z] = $gmequipe[$i];
			$z++;
		}
		else {

			echo '<tr>
			<td>'.$gmequipe[$i].'</td>
			<td><a style="display:block; width:100%;" href="mailto:'.$gmEmail[$i].'">'.$gm[$i].'</a></td>
			</tr>';
			if($sendAllFirst == 0) {
				$sendAll .= $gmEmail[$i];
				$sendAllFirst = 1;
			}
			else $sendAll .= ','.$gmEmail[$i];
		}
	}
	if($sendAll != '') {
			echo '<tr class="tableau-top">
			<td colspan="2"><a style ="color:white" href="mailto:'.$sendAll.'">'.$GMsEmailAll.'</a></td>
			</tr>';
		}
	$z = 0;

	if(isset($free[$z])) {
		echo '<tr><td colspan="2"><br></td></tr><tr class="tableau-top"><td colspan="2" >'.$GMsFreeTeam.'</td></tr>';
		for($z=0;$z<count($free);$z++) {
			$equipe = $free[$z];
			echo '<tr><td colspan="2">'.$equipe.'</td></tr>';
		}
	}
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
echo '</tbody></table></div>';
 echo '<h6 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h6>';
echo '</div></div></div></div>';
?>

<?php include 'footer.php'; ?>