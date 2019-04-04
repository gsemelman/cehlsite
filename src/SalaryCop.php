<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = 'Finance';
$CurrentTitle = $salaryCopTitle;
$CurrentPage = 'SalaryCop';
include 'head.php';


$v = 'background-color:green;'; // Good Salary Cap
$o = 'background-color:orange;'; // Close Salary Cap
$r = 'background-color:red;'; // Over Salary Cap
$dr = 'background-color:#8B0000;'; // Under Floor Salary Cap
?>

<!--<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border:solid 1px<?php echo $couleur_contour; ?>">-->
<div class = "container">
<!--<div class="titre"><span class="bold-blanc"><?php echo $salaryCopTitle; ?></span></div>-->
<h3 class = "text-center wow fadeIn"><?php echo $salaryCopTitle; ?></h3>
<div class = "col-sm-12 col-md-8 offset-md-2">
<table class="table table-sm table-striped">

<?php
$i = 0;
$matches = glob($folder.'*'.$playoff.'Injury.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Injury')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}

$Fnm = $folder.$folderLeagueURL.'Injury.html';
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		if(substr_count($val, 'A NAME')) {
			$i++;
			$blessure[$i] = '';
			$suspension[$i] = '';
		}
		//if(substr_count($val, 'Injured')) {
		if(substr_count($val, 'sidelined')) {
			//$blessure[$i] = $salaryCapYes;
			$blessure[$i] = substr_count($val, 'sidelined');
		}
		if(substr_count($val, 'suspended')) {
			//$suspension[$i] = $salaryCapYes;
			$suspension[$i] = substr_count($val, 'suspended');
		}
	}
}
else echo $allFileNotFound.' - '.$Fnm;
$rougeFloor = 0;
$rouge = 0;
$jaune = 0;
$vert = 0;
$i = 0;
$a = 0;
$c = 1;
$no = 0;
$nv = 0;
$nr = 0;
$nrFloor = 0;
$Fnm = $folder.$folderLeagueURL.'Finance.html';
$colspan = 6;
if($leagueSalaryIncFarm == 1) $colspan = 7;

if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$leagueSalaryClose2 = $leagueSalaryCap - $leagueSalaryClose;
			$leagueSalaryCap_ca = number_format($leagueSalaryCap, 0, ' ', ',');
			$leagueSalaryCap_ca2 = number_format($leagueSalaryCapFloor, 0, ' ', ',');
			$leagueSalaryClose_ca = number_format($leagueSalaryClose, 0, ' ', ',');
			echo '<tr><td colspan="'.$colspan.'">'.$allLastUpdate.' '.$val.'<br>';
			echo $salaryCopSalaryCap.' '.$leagueSalaryCap_ca.'$<br>';
			echo $salaryCopFloor.' '.$leagueSalaryCap_ca2.'$<br>';
			echo $salaryCopNear.' '.$leagueSalaryClose_ca.'$ '.$salaryCopNearTo.' '.$leagueSalaryCap_ca.'$</td></tr>';
			echo '<tr class="tableau-top"><td style="text-align:left;">'.$salaryCopTeam.'</td>
			<td style="text-align:right;">'.$salaryCopProPayroll.'</td>';
			if($leagueSalaryIncFarm == 1) echo '<td style="text-align:right;">'.$salaryCopFarmPayroll.'</td>';
			echo '<td style="text-align:right;">'.$salaryCopRemaining.'</td>
			<td style="text-align:center;">'.$salaryCopStatus.'</td>
			<td style="text-align:center;">'.$salaryCopInjured.'</td>
			<td style="text-align:center;">'.$salaryCopSuspended.'</td></tr>';
		}
		if(substr_count($val, 'A NAME')) {
			$pos = strpos($val, '</A>');
			$pos = $pos - 23;
			$equipe = substr($val, 23, $pos);
			$i++;
		}
		if(substr_count($val, '<TD>Pro Payroll</TD>')) {
			$pos = strpos($val, '</TD></TR>');
			$pos = $pos - 69;
			$propayroll = substr($val, 69, $pos);
			$propayroll2 = preg_replace('/\D/', '', $propayroll);
		}
		if(substr_count($val, '<TD>Farm Payroll</TD>')) {
			$pos = strpos($val, '</TD></TR>');
			$pos = $pos - 30;
			$farmpayroll = substr($val, 30, $pos);
			$farmpayroll2 = preg_replace('/\D/', '', $farmpayroll);
			
			if($leagueSalaryIncFarm == 0) {
				$restant = $leagueSalaryCap - $propayroll2;
				$salaryCap = $propayroll2;
			}
			if($leagueSalaryIncFarm == 1) {
				$restant = $leagueSalaryCap - $propayroll2 - $farmpayroll2;
				$salaryCap = $farmpayroll2 + $propayroll2;
			}
			
			if($salaryCap < $leagueSalaryCapFloor && $leagueSalaryCapFloor != 0) {
				$nrFloor++;
				$b = $dr;
				$rougeFloor = $rougeFloor + $restant;
			}
			if($salaryCap <= $leagueSalaryClose && ($salaryCap >= $leagueSalaryCapFloor || $leagueSalaryCapFloor == 0)) {
				$nv++;
				$b = $v;
				$vert = $vert + $restant;
			}
			if($salaryCap >= $leagueSalaryClose && $salaryCap <= $leagueSalaryCap) {
				$no++;
				$b = $o;
				$jaune = $jaune + $restant;
			}
			if($salaryCap > $leagueSalaryCap) {
				$nr++;
				$b = $r;
				$rouge = $rouge + $restant;
			}
			$restant = number_format($restant, 0, ' ', ',');
			
			$z = '';
			if(substr_count($equipe, $currentTeam)) $z = ' font-weight:bold;';
			
			if($c == 1) $c = 2;
			else $c = 1;
			echo '
			<tr class="hover'.$c.'"><td style="text-align:left;'.$z.'">'.$equipe.'</td>
			<td style="text-align:right;'.$z.'">'.$propayroll.'$</td>';
			if($leagueSalaryIncFarm == 1) echo '<td style="text-align:right;'.$z.'">'.$farmpayroll.'$</td>';
			echo '<td style="text-align:right;'.$z.'">'.$restant.'$</td>
			<td><div style="'.$b.'"><br></div></td>
			<td style="text-align:center;'.$z.'">'.$blessure[$i].'</td>
			<td style="text-align:center;'.$z.'">'.$suspension[$i].'</td></tr>';
		}
	}
	$vert = number_format($vert, 0, '', ',');
	$jaune = number_format($jaune, 0, '', ',');
	$rouge = number_format($rouge, 0, '', ',');
	$rougeFloor = number_format($rougeFloor, 0, '', ',');
	echo '</table><br>
	<table class="table table-sm table-striped">
	<tr class="tableau-top"><td>'.$salaryCopStatus.'</td><td style="text-align:left;">'.$salaryCopDesc.'</td><td>'.$salaryCopNumber.'</td><td style="text-align:right;">'.$salaryCopRemaining.'</td></tr>
	<tr class="hover2"><td><div style="'.$v.'"><br></div></td><td style="text-align:left;">'.$salaryCopGoodSalaryCap.'</td><td>'.$nv.'</td><td style="text-align:right;">'.$vert.'$</td></tr>
	<tr class="hover1"><td><div style="'.$o.'"><br></div></td><td style="text-align:left;">'.$salaryCapNearSalaryCap.'</td><td>'.$no.'</td><td style="text-align:right;">'.$jaune.'$</td></tr>
	<tr class="hover2"><td><div style="'.$r.'"><br></div></td><td style="text-align:left;">'.$salaryCapOverSalaryCap.'</td><td>'.$nr.'</td><td style="text-align:right;">'.$rouge.'$</td></tr>';
	if($leagueSalaryCapFloor != 0) echo '<tr class="hover1"><td><div style="'.$dr.'"><br></div></td><td style="text-align:left;">'.$salaryCopFloorUnder.'</td><td>'.$nrFloor.'</td><td style="text-align:right;">'.$rougeFloor.'$</td></tr>';
	echo '</table>';
}
else echo '</table>'.$allFileNotFound.' - '.$Fnm;
?>
</div></div>

<?php include 'footer.php'; ?>