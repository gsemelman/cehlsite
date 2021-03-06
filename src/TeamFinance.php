<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'TeamFinance';
$CurrentTitle = $financeTitle;
$CurrentPage = 'TeamFinance';
include 'head.php';
include 'TeamHeader.php';

?>

<div class="container">

<?php
$matches = glob($folder.'*'.$playoff.'Finance.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
$lastUpdated = '';

arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Finance')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'Finance.html';

$a = 0;
$b = 0;
$c = 1;
$d = 1;
$e = 0;
$i = 0;
$j = 0;
$k = 0;
$lastUpdated = '';
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'A NAME=') && $b) {
			$d = 0;
		}
		if(!$e) {
			if(substr_count($val, '<P>(As of')){
				$pos = strpos($val, ')');
				$pos = $pos - 10;
				$val = substr($val, 10, $pos);
				$lastUpdated = $val;
				
				echo '<div class="card">';
				echo '<div class="card-header p-1">';

				   include 'TeamCardHeader.php';
				
				echo' </div>';
				echo '<div class="card-body">';

			}
			if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
				$pos = strpos($val, '</A>');
				$pos = $pos - 23;
				$equipe = substr($val, 23, $pos);
				$b = 1;
			}
			if(substr_count($val, 'Arena') && $b && $d) {
				$valArena = trim(substr($val, 52, 30));
			}
			if(substr_count($val, 'Capacity') && $b && $d) {
				$pos = strpos($val, '</TD>', strpos($val, '</TD>')+5);
				$valCapacity = substr($val, 25, $pos-25);
			}
			if(substr_count($val, 'Ticket Price') && $b && $d) {
				$valTicket = substr($val, 30, 5);
			}
			if(substr_count($val, 'Current Funds') && $b && $d) {
				$pos = strpos($val, '$');
				$reste = substr($val, $pos+1);
				$tmpNeg = '';
				if(substr_count($val, '-')) $tmpNeg = '-';
				$currentfunds = $tmpNeg.substr($reste, 0, strpos($reste, '</B>'));
			}
			if(substr_count($val, 'Home Games Remaining') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$homeGamesRemaining = substr($val, 37, $pos-37);
			}
			if(substr_count($val, 'Avg. Attendance') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$avgAttendance = substr($val, 32, $pos-32);
			}
			if(substr_count($val, 'Avg. Revenue/Game') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$avgRevenueGame = substr($val, 35, $pos-35);
			}
			if(substr_count($val, 'Projected Revenue') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$projectedRevenue = substr($val, 35, $pos-35);
			}
			if(substr_count($val, '<TD>Pro Payroll</TD>') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$pos = $pos - 69;
				$propayroll = substr($val, 69, $pos);
			}
			if(substr_count($val, '<TD>Farm Payroll</TD>') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$pos = $pos - 30;
				$farmpayroll = substr($val, 30, $pos);
			}
			if(substr_count($val, 'Prospect Fees') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$pos = $pos - 31;
				$prospectfees = substr($val, 31, $pos);
			}
			if(substr_count($val, 'Coach') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$pos = $pos - 23;
				$coach = substr($val, 23, $pos);
			}
			if(substr_count($val, 'Games Remaining') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$pos = $pos - 32;
				$gamesremaining = substr($val, 32, $pos);
			}
			if(substr_count($val, 'Total Game Expenses') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$pos = $pos - 37;
				$totalgameexpenses = substr($val, 37, $pos);
			}
			if(substr_count($val, 'Projected Expenses') && $b && $d) {
				$pos = strpos($val, '</TD></TR>');
				$pos = $pos - 36;
				$projectedexpenses = substr($val, 36, $pos);
			}
			if(substr_count($val, 'Projected Balance') && $b && $d) {
				$pos = strpos($val, '$');
				$reste = substr($val, $pos+1);
				$tmpNeg = '';
				if(substr_count($val, '-')) $tmpNeg = '-';
				$projectedbalance = $tmpNeg.substr($reste, 0, strpos($reste, '</B>'));
			}
			if(substr_count($val, 'Year:') && $b && $d) {
				$year[$i] = substr($val, strpos($val, ' ')+1, strpos($val, '</TD>')-strpos($val, ' ')-1);
				$reste = substr($val, strpos($val, '$')+1);
				$i++;
				$year[$i] = substr($reste, 0, strpos($reste, '</TD>'));
				$i++;
			}
			if(substr_count($val, '<B>Pro Payroll</B>') && $b && $d) {
				$e++;
			}
		}
		if($e == 1) {
			if(substr_count($val, '<TR><TD>') && $b && $d) {
				$pos = strpos($val, '(');
				$pos2 = $pos + 1;
				$pos3 = strpos($val, '</TD><TD>') + 9;
				$pos = $pos - $pos3;
				$salaires[$j] = trim(substr($val, $pos3, $pos));
				$salaires[$j] = str_replace(",", " ", $salaires[$j]);
				$salaires2[$j] = preg_replace("/\\s+/iu","",$salaires[$j]);
				$salaires[$j] = preg_replace("/\\s+/iu",",",$salaires[$j]);
				$joueurs[$j] = substr($val, 8, 22);
				$annee[$j] = substr($val, $pos2, 1);
				$j++;
			}
			if(substr_count($val, 'Farm Payroll') && $b && $d) {
				$e++;
			}
		}
		if($e == 2) {
			if(substr_count($val, '<TR><TD>') && $b && $d) {
				$pos = strpos($val, '(');
				$pos2 = $pos + 1;
				$pos3 = strpos($val, '</TD><TD>') + 9;
				$pos = $pos - $pos3;
				$salairesf[$k] = trim(substr($val, $pos3, $pos));
				$salairesf[$k] = str_replace(",", " ", $salairesf[$k]);
				$salaires3[$k] = preg_replace("/\\s+/iu","",$salairesf[$k]);
				$salairesf[$k] = preg_replace("/\\s+/iu",",",$salairesf[$k]);
				$joueursf[$k] = substr($val, 8, 22);
				$anneef[$k] = substr($val, $pos2, 1);
				$k++;
			}
		}
	}
	
	echo '<div class = "row">';
		echo '<div class="col-sm-12 col-md-6 col-lg-4 offset-lg-2">';
			echo '<table class="table table-sm table-striped table-rounded">';
			echo '<thead>';
			echo '<tr><th colspan="2" ><h5 class="m-0">'.$financeOrganization.'</h5></th></tr>';
			echo '</thead>';
			echo '<tbody>';
			echo '<tr><td class="text-left">'.$financeArena.'</td><td class="text-right">'.$valArena.'</td></tr>';
			echo '<tr><td class="text-left">'.$financeCapacity.'</td><td class="text-right">'.$valCapacity.'</td></tr>';
			echo '<tr><td class="text-left">'.$financeTicket.'</td><td class="text-right">'.$valTicket.'$</td></tr>';
			echo '</tbody>';
			echo '</table>';
		echo '</div>';

		echo '<div class="col-sm-12 col-md-6 col-lg-4">';
			echo '<table class="table table-sm table-striped table-rounded">
                <thead>
				<tr><th colspan="2"><h5 class="m-0">'.$financeSalaryCommitment.'</h5></th></tr>
                </thead>
                <tbody>
				<tr><td class="text-left">'.$financeYear.' '.$year[0].'</td><td class="text-right">'.$year[1].'$</td></tr>
				<tr><td class="text-left">'.$financeYear.' '.$year[2].'</td><td class="text-right">'.$year[3].'$</td></tr>
				<tr><td class="text-left">'.$financeYear.' '.$year[4].'</td><td class="text-right">'.$year[5].'$</td></tr>
				<tr><td class="text-left">'.$financeYear.' '.$year[6].'</td><td class="text-right">'.$year[7].'$</td></tr>
                </tbody>    				
                </table>';
		echo '</div>';
	echo '</div>';

	echo '<div class = "row">';	
		echo '<div class="col-sm-12 col-md-6 col-lg-4 offset-lg-2">
			<table class="table table-sm table-striped table-rounded">
            <thead>
			<tr><th colspan="2"><h5 class="m-0">'.$financeExpenses.'</h5></th></tr>
            </thead>
            <tbody>
			<tr><td class="text-left">'.$financeProPayroll.'</td><td class="text-right"">'.$propayroll.'$</td></tr>
			<tr><td class="text-left">'.$financeFarmPayroll.'</td><td class="text-right"">'.$farmpayroll.'$</td></tr>
			<tr><td class="text-left">'.$financeProspectFees.'</td><td class="text-right"">'.$prospectfees.'$</td></tr>
			<tr><td class="text-left">'.$financeCoach.'</td><td class="text-right"">'.$coach.'$</td></tr>';
    		if($currentPLF == 0){
    		    echo '<tr><td class="text-left">'.$financeGamesRemaining.'</td><td class="text-right"">'.$gamesremaining.'</td></tr>';
    		}
			echo '<tr><td class="text-left">'.$financeTotalGameExpenses.'</td><td class="text-right"">'.$totalgameexpenses.'$</td></tr>
			<tr><td class="text-left">'.$financeProjectExpenses.'</td><td class="text-right"">'.$projectedexpenses.'$</td></tr>
            </tbody> 
            <tfoot>
			<tr><td class="text-left">'.$financeProjectedBalance.'</td><td class="text-right"">'.$projectedbalance.'$</td></tr>
			</tfoot>
            </table>';
		echo '</div>';
		echo '<div class="col-sm-12 col-md-6 col-lg-4">
			<table class="table table-sm table-striped table-rounded">
            <thead>
			<tr><th colspan="2"><h5 class="m-0">'.$financeIncome.'</h5></th></tr>
        	</thead>
            <tbody>
			<tr><td class="text-left">'.$financeCurrentFunds.'</td><td class="text-right"">'.$currentfunds.'$</td></tr>';
// 			if($currentPLF == 0) echo '<tr><td class="text-left">'.$financeHomeGameRemaining.'</td><td class="text-right"">'.$homeGamesRemaining.'</td></tr>
// 			<tr><td class="text-left">'.$financeAVGAttendance.'</td><td class="text-right"">'.$avgAttendance.'</td></tr>
// 			<tr><td class="text-left">'.$financeAVGRevenueParGame.'</td><td class="text-right"">'.$avgRevenueGame.'$</td></tr>
// 			<tr><td class="text-left">'.$financeProjectedRevenue.'</td><td class="text-right"">'.$projectedRevenue.'$</td></tr>
// 			</tbody>
// 			</table>';
		    if($currentPLF == 0) echo '<tr><td class="text-left">'.$financeHomeGameRemaining.'</td><td class="text-right"">'.$homeGamesRemaining.'</td></tr>
			<tr><td class="text-left">'.$financeAVGAttendance.'</td><td class="text-right"">'.$avgAttendance.'</td></tr>
			<tr><td class="text-left">'.$financeAVGRevenueParGame.'</td><td class="text-right"">'.$avgRevenueGame.'$</td></tr>
			<tr><td class="text-left">'.$financeProjectedRevenue.'</td><td class="text-right"">'.$projectedRevenue.'$</td></tr>';
			echo '</tbody>
			</table>';
	echo '</div>';
	echo '</div>';

	$tableaut = $joueurs;

	echo '<div class = "row">';	
		echo '<div class="col-sm-12 col-md-6 col-lg-4 offset-lg-2">
        <div class="tableau-top">'.$financeProPayroll2.'</div>
		<table id="proPayroll" class="table table-sm table-striped table-rounded-bottom text-center">
        <thead>
		
		<tr>
		<th class="text-left">'.$financePlayers.'</th>
		<th>'.$financeYear2.'</th>
		<th class="text-right">'.$financeContract.'</tr>';
		echo '</thead><tbody>';

		$key = key($tableaut);
		$val = current($tableaut);
		while(list ($key, $val) = myEach($tableaut)) {
			echo '<tr>
            <td class="text-left">'.$joueurs[$key].'</td>
            <td>'.$annee[$key].'</td>
            <td class="text-right">'.$salaires[$key].'$</td>
            </tr>';
		}
		echo '</tbody></table></div>';

		echo '<div class="col-sm-12 col-md-6 col-lg-4">
        <div class="tableau-top">'.$financeFarmPayroll2.'</div>
		<table id="farmPayroll" class="table table-sm table-striped table-rounded-bottom text-center">
        <thead>
		<tr>
		<th class="text-left">'.$financePlayers.'</th>
		<th>'.$financeYear2.'</th>
		<th class="text-right">'.$financeContract.'</tr>';
		echo '<thead><tbody>';
		if($joueursf) {

		    $tableauf = $joueursf;
		    
			$key = key($tableauf);
			$val = current($tableauf);
			while(list ($key, $val) = myEach($joueursf)) {

				echo '<tr>
                <td class="text-left">'.$joueursf[$key].'</td>
                <td>'.$anneef[$key].'</td>
                <td class="text-right">'.$salairesf[$key].'$</td>
                </tr>';
			}
		}
		}
		else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
		echo '</tbody></table></div>';
		
		echo '</div>';
	echo '</div>';

	echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
	
	echo '</div>'; //end card body
	echo '</div>'; //end card 
	echo '</div>';//end container

?>

<script>

$(document).ready(function() 
    { 
        $("#proPayroll").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 
        $("#farmPayroll").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 
    } 
); 



</script>

<?php include 'footer.php'; ?>