<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = 'Coaches';
$CurrentTitle = $CoachesTitle;
$CurrentPage = 'Coaches';
include 'head.php';

?>

<div class="container">

<div class="card">
	<?php include 'SectionHeader.php';?>
	<div class="card-body">

<?php

//READ COACH CSV
$coachArray = array();
$start_row = 2; //define start row
$i = 1; //define row count flag
$csvLocation = $folderLegacy."coachContracts.csv";
$file = fopen($csvLocation, "r");
while (($row = fgetcsv($file)) !== FALSE) {
    if($i >= $start_row) {
        $coachArray[$row[0]] = $row;
    }
    $i++;
}


// close file
fclose($file);

$matches = glob($folder.'*'.$playoff.'Coaches.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Coaches')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'Coaches.html';
$a = 0;
$c = 1;
$lastUpdated = '';
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<P>(As of')){
			$pos = strpos($val, ')');
			$pos = $pos - 10;
			$val = substr($val, 10, $pos);
			$lastUpdated = $val;
			
			echo '<div class="col-sm-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">';
			echo '<div class="table-responsive wow fadeIn">';
			echo '<table class="table table-sm table-striped">';
		}
		if($a == 1 && substr_count($val, '(')) {
			$reste = trim($val);
			$coachName = substr($reste, 0, strpos($reste, '(')-1);
			$reste = trim(substr($reste, strpos($reste, '(')+1));
			$coachTeam = substr($reste, 0, strpos($reste, ')'));
			$reste = trim(substr($reste, strpos($reste, ')')+1));
			$coachOf = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$coachDf = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$coachEx = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$coachLd = substr($reste, 0, 2);
			$reste = trim(substr($reste, 2));
			$coachSalary = $reste;
			
			
			$coachTerm = "N/A";

			if(array_key_exists(trim($coachTeam), $coachArray)){
			    $coachRow = $coachArray[trim($coachTeam)];
			    $coachTerm = $coachRow[3];
			}
		
			if($coachTeam == 'Available') $coachTeam = str_replace('Available', $CoachesAvailable, $coachTeam);
			
			$b = '';
			//if(substr_count($val, $currentTeam)) $b = ' font-weight:bold;'; //remove references to $b
			
			if($c == 1) $c = 2;
			else $c =  1; 
			echo '
			<tr class="hover'.$c.'">
			<td style="'.$b.'">'.$coachName.'</td>
			<td style="'.$b.'">'.$coachTeam.'</td>
			<td style="text-align:center;'.$b.'">'.$coachOf.'</td>
			<td style="text-align:center;'.$b.'">'.$coachDf.'</td>
			<td style="text-align:center;'.$b.'">'.$coachEx.'</td>
			<td style="text-align:center;'.$b.'">'.$coachLd.'</td>
			<td style="text-align:right;'.$b.'">$'.$coachSalary.'</td>
            <td style="text-align:right;'.$b.'">'.$coachTerm.'</td>
			</tr>';
		}
		if(substr_count($val, '                                   ')) {
			echo '
            <thead>
			<tr class="tableau-top">
			<td>'.$CoachesName.'</td>
			<td>'.$CoachesTeam.'</td>
			<td style="text-align:center;"><a href="javascript:return;" class="info">OF<span>'.$CoachesOff.'</span></a></td>
			<td style="text-align:center;"><a href="javascript:return;" class="info">DF<span>'.$CoachesDef.'</span></a></td>
			<td style="text-align:center;"><a href="javascript:return;" class="info">EX<span>'.$CoachesExp.'</span></a></td>
			<td style="text-align:center;"><a href="javascript:return;" class="info">LD<span>'.$CoachesLead.'</span></a></td>
			<td style="text-align:right;">'.$CoachesSalary.'</td>
            <td>Term</td>
			</tr>
            </thead>
			<tbody>';
			$a = 1;
		}
	}
}
else echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';

echo '</tbody></table>

<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h5>
			    
</div></div></div></div>';
?>

</body>
</html>