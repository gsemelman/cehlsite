<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'Finance';
$CurrentTitle = $salaryCopTitle;
$CurrentPage = 'SalaryCop';
include 'head.php';

include_once 'classes/TeamHolder.php';
include_once 'classes/RostersHolder.php';
include_once 'classes/RosterObj.php';
//include_once 'classes/RosterAvgObj.php';

$v = 'background-color:green;'; // Good Salary Cap
$o = 'background-color:orange;'; // Close Salary Cap
$r = 'background-color:red;'; // Over Salary Cap
$dr = 'background-color:#8B0000;'; // Under Floor Salary Cap
?>

<!--<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border:solid 1px<?php echo $couleur_contour; ?>">-->
<div class = "container">
<!--<div class="titre"><span class="bold-blanc"><?php echo $salaryCopTitle; ?></span></div>
<h3 class = "text-center wow fadeIn"><?php echo $salaryCopTitle; ?></h3>-->
<div class = "col-sm-12 col-md-8 offset-md-2">

<div class="card">
	<?php include 'SectionHeader.php'?>
	<div class="card-body">

<table class="table table-sm table-striped">

<?php

$gmFile = getLeagueFile($folder, $playoff, 'GMs.html', 'GMs');


if (file_exists($gmFile)) {
    
    $teams = new TeamHolder($gmFile);
    $rostersFile = getLeagueFile($folder, $playoff, 'Rosters.html', 'Rosters');
    
    $length = count($teams->get_teams());
    for ($i = 0; $i < $length; $i++) {
        $rosters = new RostersHolder($rostersFile, $teams->get_teams()[$i], false);

        $activePro[$i+1] = $rosters->getActivePro();
        $rosterValid[$i+1] = $rosters->isValidRoster() ? 'YES' : 'NO';
    }
    
    //get rosters from file
    
}else{
    die("Unable to find GM files");
}




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
$colspan = 8;
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
			echo '<thead>';
			echo '<tr><th colspan="'.$colspan.'">'.$allLastUpdate.' '.$val.'<br>';
			echo $salaryCopSalaryCap.' '.$leagueSalaryCap_ca.'$<br>';
			echo $salaryCopFloor.' '.$leagueSalaryCap_ca2.'$<br>';
			echo $salaryCopNear.' '.$leagueSalaryClose_ca.'$ '.$salaryCopNearTo.' '.$leagueSalaryCap_ca.'$<br>';
			echo 'Minimum Active Players: '.MIN_ACTIVE_PLAYERS.'';
            echo '</th></tr>';
			echo '<tr>
            <th style="text-align:left;">'.$salaryCopTeam.'</th>
			<th style="text-align:right;">'.$salaryCopProPayroll.'</th>';
			if($leagueSalaryIncFarm == 1) echo '<td style="text-align:right;">'.$salaryCopFarmPayroll.'</th>';
			echo '<th style="text-align:right;">'.$salaryCopRemaining.'</th>
			<th style="text-align:center;">'.$salaryCopStatus.'</th>
			<th style="text-align:center;">'.$salaryCopInjured.'</th>
			<th style="text-align:center;">'.$salaryCopSuspended.'</th>
			<th style="text-align:center;">Active</th>
			<th style="text-align:center;">Sim Valid</th></tr>';
			echo '</thead>';
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
			//if(substr_count($equipe, $currentTeam)) $z = ' font-weight:bold;';
			
			$activeStyle = (MIN_ACTIVE_PLAYERS > 0 && $activePro[$i] < MIN_ACTIVE_PLAYERS ) ? $r : '';
			$rosterValidStyle = $rosterValid[$i] == 'NO' ? $r : '';
			
			if($c == 1) $c = 2;
			else $c = 1;
			echo '
			<tr class="hover'.$c.'"><td style="text-align:left;">'.$equipe.'</td>
			<td style="text-align:right;">'.$propayroll.'$</td>';
			if($leagueSalaryIncFarm == 1) echo '<td style="text-align:right;">'.$farmpayroll.'$</td>';
			echo '<td style="text-align:right;">'.$restant.'$</td>
			<td><div style="'.$b.'"><br></div></td>
			<td style="text-align:center;">'.$blessure[$i].'</td>
			<td style="text-align:center;">'.$suspension[$i].'</td>
		    <td style="text-align:center; '.$activeStyle.'">'.$activePro[$i].'</td>
		    <td style="text-align:center; '.$rosterValidStyle.'">'.$rosterValid[$i].'</td></tr>';
		}
	}
	$vert = number_format($vert, 0, '', ',');
	$jaune = number_format($jaune, 0, '', ',');
	$rouge = number_format($rouge, 0, '', ',');
	$rougeFloor = number_format($rougeFloor, 0, '', ',');
	echo '</table><br>
	<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>'.$salaryCopStatus.'</th>
            <th style="text-align:left;">'.$salaryCopDesc.'</th>
            <th>'.$salaryCopNumber.'</th>
            <th style="text-align:right;">'.$salaryCopRemaining.'</th>
        </tr>
    </thead>
	<tr><td><div style="'.$v.'"><br></div></td><td style="text-align:left;">'.$salaryCopGoodSalaryCap.'</td><td>'.$nv.'</td><td style="text-align:right;">'.$vert.'$</td></tr>
	<tr><td><div style="'.$o.'"><br></div></td><td style="text-align:left;">'.$salaryCapNearSalaryCap.'</td><td>'.$no.'</td><td style="text-align:right;">'.$jaune.'$</td></tr>
	<tr><td><div style="'.$r.'"><br></div></td><td style="text-align:left;">'.$salaryCapOverSalaryCap.'</td><td>'.$nr.'</td><td style="text-align:right;">'.$rouge.'$</td></tr>';
	if($leagueSalaryCapFloor != 0) echo '<tr class="hover1"><td><div style="'.$dr.'"><br></div></td><td style="text-align:left;">'.$salaryCopFloorUnder.'</td><td>'.$nrFloor.'</td><td style="text-align:right;">'.$rougeFloor.'$</td></tr>';
	echo '</table>';
}
else echo '</table>'.$allFileNotFound.' - '.$Fnm;
?>
</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>