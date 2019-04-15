<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Individual';
$CurrentTitle = $individualTitle;
$CurrentPage = 'Individual';
include 'head.php';
?>


<div class="container">

<div class="card">

	<?php include 'SectionHeader.php';?>
	
	<div class="card-body">

<?php
function firstNumber($string) {
	$count = strlen($string);
	$start = 0;
	for($j=0;$j<$count;$j++) {
		if( ctype_digit($string[$j]) ) {
			$start = $j;
			$j = 1000;
		}
	}
	return substr($string, $start);
}

include 'phpGetAbbr.php'; // Output $TSabbr

$matches = glob($folder.'*'.$playoff.'Individual.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Individual')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'Individual.html';
$a = 0;
$c = 1;
$i = 0;
$lastUpdated = '';
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$lastUpdated = $val;

		}
		if(substr_count($val, '<BR>') && !substr_count($val, '(') && !substr_count($val, '<BR><BR>')) {
			$a++;
		}
		if($a == 45) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$spj2[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$spe2[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$spm2[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$spg2[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 43) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$gaj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$gae[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$gam[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$gag[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 41) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$gmj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$gme[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$gmm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$gmg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 39) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$rcj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$rce[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$rcm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$rcg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 37) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$mjj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$mje[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$mjm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$mjg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 35) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$blj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$ble[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$blm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$blg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 33) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$spj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos;
			$spe[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$spm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$spg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 31) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$htj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$hte[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$htm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$htg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 29) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$rkj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$rke[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$rkm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$rkg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 27) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$dfj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$dfe[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$dfm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$dfg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 25) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$adj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$ade[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$adm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$adg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 23) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$agj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$age[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$agm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$agg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 21) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$cej[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$cee[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$cem[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$ceg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 19) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$psj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$pse[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$psm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$psg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' '),-4));
			$i++;
		}
		if($a == 17) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$gsj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$gse[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$gsm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$gsg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' '),-4));
			$i++;
		}
		if($a == 15) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$pmj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$pme[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$pmm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$pmt[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 13) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$pimj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$pime[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$pimm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$pimt[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 11) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$shotj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$shote[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$shotm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$shott[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 9) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$shpj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$shpe[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$shpm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$shpp[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 7) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$shgj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$shge[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$shgm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$shgg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 5) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$ppgj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$ppge[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$ppgm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$ppgg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 3) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$assistj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$assiste[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$assistm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$assista[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if($a == 1) {
			$pos = strpos($val, '(');
			$pos2 = strpos($val, ')');
			$goalj[$i] = substr($val, 0, $pos);
			$pos++;
			$pos2 = $pos2 - $pos; 
			$goale[$i] = substr($val, $pos, $pos2);
			$tmpVal = firstNumber($val);
			$goalm[$i] = trim(substr($tmpVal, 0, strpos($tmpVal, ' ')));
			$goalg[$i] = trim(substr($tmpVal, strpos($tmpVal, ' ')));
			$i++;
		}
		if(substr_count($val, '<PRE>') && !substr_count($val, '<TD>')){
			$a++;
			$i = 0;
		}
	}

$i = 0;
echo '<div class = "row">';
	echo '<div class = "col-sm-12 col-md-4 offset-md-2">
	<div class="tableau-top text-center">'.$individualGoals.'</div>
	<div class = "table-responsive">
	<table class="table table-sm table-striped text-center">
    <thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualG.'</th>
	</tr>
    </thead>
    <tbody>';
	
	if(isset($goalj)) {
	for($i=0;$i<count($goalj);$i++){
		echo '
		<tr>
		<td class="text-left">'.$goalj[$i].'</td>
		<td>'.$goale[$i].'</td>
		<td>'.$goalm[$i].'</td>
		<td>'.$goalg[$i].'</td>
		</tr>';
	}
	}
	echo '</tbody></table></div></div>';

	$c = 1;
	$i = 0;
	echo '<div class = "col-sm-12 col-md-4">
    <div class="tableau-top text-center">'.$individualGSS.'</div>
	<div class = "table-responsive">
	<table class="table table-sm table-striped text-center">
    <thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualStreak.'</th>
	</tr>
    </thead>
    <tbody>';
	if(isset($gsj)) {
	for($i=0;$i<count($gsj);$i++){
		echo '
		<tr>
		<td class="text-left">'.$gsj[$i].'</td>
		<td>'.$gse[$i].'</td>
		<td>'.$gsm[$i].'</td>
		<td>'.$gsg[$i].'</td>
		</tr>';
	}
	}
	echo '</tbody></table></div></div>';
echo '</div>';

$c = 1;
$i = 0;

echo '<div class = "row">';
	echo '<div class = "col-sm-12 col-md-4 offset-md-2">
    <div class="tableau-top text-center">'.$individualAssists.'</div>
	<div class = "table-responsive">
	<table class="table table-sm table-striped text-center">
    <thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualA.'</th>
	</tr>
    </thead>
    <tbody>';
	if(isset($assistj)) {
	for($i=0;$i<count($assistj);$i++){
		echo '
		<tr>
		<td class="text-left">'.$assistj[$i].'</td>
		<td>'.$assiste[$i].'</td>
		<td>'.$assistm[$i].'</td>
		<td>'.$assista[$i].'</td>
		</tr>';
	}
	}
	echo '</tbody></table></div></div>';

	$c = 1;
	$i = 0;
	
	echo '<div class = "col-sm-12 col-md-4">
    <div class="tableau-top text-center">'.$individualPSS.'</div>
	<div class = "table-responsive">';
	echo '<table class="table table-sm table-striped text-center">
	<thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualStreak.'</th>
	</tr>
	</thead>
    <tbody>';
	
	if(isset($psj)) {
	for($i=0;$i<count($psj);$i++){
		echo '
		<tr>
		<td class="text-left">'.$psj[$i].'</td>
		<td>'.$pse[$i].'</td>
		<td>'.$psm[$i].'</td>
		<td>'.$psg[$i].'</td>
		</tr>';
	}
	}
	echo '</table></div></div>';
echo '</div>';

$c = 1;
$i = 0;

echo '<div class = "row">';

	echo '<div class = "col-sm-12 col-md-4 offset-md-2">
    <div class="tableau-top text-center">'.$individualPPG.'</div>
	<div class = "table-responsive">';
	echo '<table class="table table-sm table-striped text-center">
	<thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualG.'</th>
	</tr>
	</thead>
    <tbody>';
	
	if(isset($ppgj)) {
	for($i=0;$i<count($ppgj);$i++){
		echo '
		<tr>
		<td class="text-left">'.$ppgj[$i].'</td>
		<td>'.$ppge[$i].'</td>
		<td>'.$ppgm[$i].'</td>
		<td>'.$ppgg[$i].'</td>
		</tr>';
	}
	}
	echo '</tbody></table></div></div>';

	echo '<div class = "col-sm-12 col-md-4">
    <div class="tableau-top text-center">'.$individualC.'</div>
	<div class = "table-responsive">';
	echo '<table class="table table-sm table-striped text-center">
	<thead>
	<tr>
	<th></td>
	<th>'.$individualTM.'</th>
	<th>'.$individualGP.'</th>
	<th>'.$individualPts.'</th>
	</tr>
	</thead>
    <tbody>';
	
	if(isset($cej)) {
	for($i=0;$i<count($cej);$i++){
		if(isset($TSabbr) && substr_count($cee[$i], $TSabbr)) $bold = 'font-weight:bold;';
		echo '
		<tr>
		<td class="text-left">'.$cej[$i].'</td>
		<td>'.$cee[$i].'</td>
		<td>'.$cem[$i].'</td>
		<td>'.$ceg[$i].'</td>
		</tr>';
	}
	}
	echo '</tbody></table></div></div>';
echo '</div>';


echo '<div class = "row">';

    echo '<div class = "col-sm-12 col-md-4 offset-md-2">
        <div class="tableau-top text-center">'.$individualSHG.'</div>
    	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center">
    	<thead>
    	<tr>
    	<th></td>
    	<th>'.$individualTM.'</th>
    	<th>'.$individualGP.'</th>
    	<th>'.$individualG.'</th>
    	</tr>
    	</thead>
        <tbody>';

    if(isset($shgj)) {
    for($i=0;$i<count($shgj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$shgj[$i].'</td>
    	<td>'.$shge[$i].'</td>
    	<td>'.$shgm[$i].'</td>
    	<td>'.$shgg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';

    $c = 1;
    $i = 0;
    
    echo '<div class = "col-sm-12 col-md-4">
        <div class="tableau-top text-center">'.$individualLW.'</div>
    	<div class = "table-responsive">';
    echo '<table class="table table-sm table-striped text-center">
    	<thead>
    	<tr>
    	<th></td>
    	<th>'.$individualTM.'</th>
    	<th>'.$individualGP.'</th>
    	<th>'.$individualPts.'</th>
    	</tr>
    	</thead>
        <tbody>';
    
    if(isset($agj)) {
    for($i=0;$i<count($agj);$i++){
    	echo '
    	<tr>
    	<td class="text-left">'.$agj[$i].'</td>
    	<td >'.$age[$i].'</td>
    	<td >'.$agm[$i].'</td>
    	<td >'.$agg[$i].'</td>
    	</tr>';
    }
    }
    echo '</tbody></table></div></div>';
echo '</div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualSP.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">%</td>
</tr>';
if(isset($shpj)) {
for($i=0;$i<count($shpj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($shpe[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$shpj[$i].'</td>
	<td >'.$shpe[$i].'</td>
	<td >'.$shpm[$i].'</td>
	<td >'.$shpp[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualRW.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:50px; text-align:right;">'.$individualPts.'</td>
</tr>';
if(isset($adj)) {
for($i=0;$i<count($adj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($ade[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$adj[$i].'</td>
	<td >'.$ade[$i].'</td>
	<td >'.$adm[$i].'</td>
	<td >'.$adg[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualShots.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">'.$individualShots.'</td>
</tr>';
if(isset($shotj)) {
for($i=0;$i<count($shotj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($shote[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$shotj[$i].'</td>
	<td >'.$shote[$i].'</td>
	<td >'.$shotm[$i].'</td>
	<td >'.$shott[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualD.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:50px; text-align:right;">'.$individualPts.'</td>
</tr>';
if(isset($dfj)) {
for($i=0;$i<count($dfj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($dfe[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$dfj[$i].'</td>
	<td >'.$dfe[$i].'</td>
	<td >'.$dfm[$i].'</td>
	<td >'.$dfg[$i].'</td>
	</tr>';
}
}
echo '</table></div>';


$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualPM.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">'.$individualPIM.'</td>
</tr>';
if(isset($pimj)) {
for($i=0;$i<count($pimj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($pime[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$pimj[$i].'</td>
	<td >'.$pime[$i].'</td>
	<td >'.$pimm[$i].'</td>
	<td >'.$pimt[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualRookies.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:50px; text-align:right;">'.$individualPts.'</td>
</tr>';
if(isset($rkj)) {
for($i=0;$i<count($rkj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($rke[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$rkj[$i].'</td>
	<td >'.$rke[$i].'</td>
	<td >'.$rkm[$i].'</td>
	<td >'.$rkg[$i].'</td>
	</tr>';
}
}
echo '</table></div>';


$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">+/-</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">+/-</td>
</tr>';
if(isset($pmj)) {
for($i=0;$i<count($pmj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($pme[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$pmj[$i].'</td>
	<td >'.$pme[$i].'</td>
	<td >'.$pmm[$i].'</td>
	<td >'.$pmt[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualHT.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">'.$individualHTm.'</td>
</tr>';
if(isset($htj)) {
for($i=0;$i<count($htj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($hte[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$htj[$i].'</td>
	<td >'.$hte[$i].'</td>
	<td >'.$htm[$i].'</td>
	<td >'.$htg[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr><td colspan="4" style="font-weight:bold;">'.$individualGoaler.'</td></tr><tr class="titre"><td  colspan="4">'.$individualSPG.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">%</td>
</tr>';
if(isset($spj)) {
for($i=0;$i<count($spj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($spe[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$spj[$i].'</td>
	<td >'.$spe[$i].'</td>
	<td >'.$spm[$i].'</td>
	<td >'.$spg[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualRec.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:50px; text-align:right;">REC</td>
</tr>';
if(isset($rcj)) {
for($i=0;$i<count($rcj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($rce[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$rcj[$i].'</td>
	<td >'.$rce[$i].'</td>
	<td >'.$rcm[$i].'</td>
	<td >'.$rcg[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualSO.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">'.$individualSOm.'</td>
</tr>';
if(isset($blj)) {
for($i=0;$i<count($blj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($ble[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$blj[$i].'</td>
	<td >'.$ble[$i].'</td>
	<td >'.$blm[$i].'</td>
	<td >'.$blg[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualPM.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">'.$individualPIM.'</td>
</tr>';
if(isset($gmj)) {
for($i=0;$i<count($gmj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($gme[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$gmj[$i].'</td>
	<td >'.$gme[$i].'</td>
	<td >'.$gmm[$i].'</td>
	<td >'.$gmg[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualMP.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">MIN</td>
</tr>';
if(isset($mjj)) {
for($i=0;$i<count($mjj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($mje[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$mjj[$i].'</td>
	<td >'.$mje[$i].'</td>
	<td >'.$mjm[$i].'</td>
	<td >'.$mjg[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr class="titre"><td  colspan="4">'.$individualAssists.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">'.$individualA.'</td>
</tr>';
if(isset($gaj)) {
for($i=0;$i<count($gaj);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($gae[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$gaj[$i].'</td>
	<td >'.$gae[$i].'</td>
	<td >'.$gam[$i].'</td>
	<td >'.$gag[$i].'</td>
	</tr>';
}
}
echo '</table></div>';

$c = 1;
$i = 0;
echo '<div>
<br><table class="table table-sm">
<tr><td colspan="4" style="font-weight:bold;">'.$individualStar.'</td></tr><tr class="titre"><td  colspan="4">'.$individualStar.'</td></tr>
<tr class="tableau-top">
<td></td>
<td style="width:40px; text-align:right;">'.$individualTM.'</td>
<td style="width:30px; text-align:right;">'.$individualGP.'</td>
<td style="width:30px; text-align:right;">SP</td>
</tr>';
if(isset($spj2)) {
for($i=0;$i<count($spj2);$i++){
	if($c == 1) $c = 2;
	else $c = 1;
	$bold = '';
	if(isset($TSabbr) && substr_count($spe2[$i], $TSabbr)) $bold = 'font-weight:bold;';
	echo '
	<tr class="hover'.$c.'">
	<td style="'.$bold.'">'.$spj2[$i].'</td>
	<td >'.$spe2[$i].'</td>
	<td >'.$spm2[$i].'</td>
	<td >'.$spg2[$i].'</td>
	</tr>';
}
}
echo '</div>';
echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
echo '</div>';
echo '</div>';

}
else echo $allFileNotFound.' - '.$Fnm;
echo '<div style="clear:both"></div></div></div>';
?>



<?php include 'footer.php'; ?>