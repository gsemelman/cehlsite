<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

include 'config.php';
include 'lang.php';

$baseFolder = '';
$seasonId = '';
if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(trim($seasonId) == false){
    $baseFolder = $folder;
}else{
    $baseFolder = str_replace("#",$seasonId,$folderCarrerStats);
}

$matchNumber = '';
$linkHTML = '';
if(isset($_GET['num']) || isset($_POST['num'])) {
	$matchNumber = ( isset($_GET['num']) ) ? $_GET['num'] : $_POST['num'];
	$matchNumber = htmlspecialchars($matchNumber);
	$linkHTML = $matchNumber;
	$round = '';
	if(isset($_GET['rnd']) || isset($_POST['rnd'])) {
		$round = ( isset($_GET['rnd']) ) ? $_GET['rnd'] : $_POST['rnd'];
		$round = htmlspecialchars($round);
	}
	if($matchNumber != '') {
		if($round != '') {
			$playoff = 'PLF';
			$matches = glob($baseFolder.'*'.$playoff.'GMs.html');
			$folderLeagueURL = '';
			$matchesDate = array_map('filemtime', $matches);
			arsort($matchesDate);
			foreach ($matchesDate as $j => $val) {
				if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
					$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
					break 1;
				}
			}
			$Fnm = $baseFolder.$folderGames.$folderLeagueURL.'-R'.$round.'-'.$matchNumber.'.html';
			$linkHTML = '-R'.$round.'-'.$matchNumber;
		}
		else {
			$playoff = '';
			$matches = glob($baseFolder.'*'.$playoff.'GMs.html');
			$folderLeagueURL = '';
			$matchesDate = array_map('filemtime', $matches);
			arsort($matchesDate);
			foreach ($matchesDate as $j => $val) {
				if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
					$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
					break 1;
				}
			}
			$Fnm = $baseFolder.$folderGames.$folderLeagueURL.$matchNumber.'.html';
		}
	}
}

$rondes = '';
if($round != '') $rondes = ' - '.$scheldRound.' '.$round;

$CurrentHTML = $linkHTML;
$CurrentTitle = $gamesTitle.' #'.$matchNumber.$rondes;
$CurrentPage = 'games';
include 'head.php';
?>

<div class="col-sm-12 col-md-8 col-lg-4 offset-md-2 offset-lg-4">
<div class = "container">

<div class="card">
	<div class="card-header wow fadeIn">
		<h3><?php echo $gamesTitle.' #'.$matchNumber.$rondes; ?></h3>
	</div>
	<div class="card-body">
	

<!--<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border:solid 1px <?php echo $couleur_contour; ?>">
<h3><?php echo $gamesTitle.' #'.$matchNumber.$rondes; ?></h3>
<div style="padding:0px 0px 0px 0px;">-->

<?php
$bg_1 = 'background-color:'.$tableauGrey1.';';
$bg_2 = 'background-color:'.$tableauGrey2.';';
$style1 = 'border-width:1px 1px 1px 1px;';
$style2 = ' style="width:20px; border-width:1px 1px 1px 1px;"';
$a = 0;
$b = 0;
$c = 1;
$d = 0;
$e = 0;
if(file_exists($Fnm)) {
$tableau = file($Fnm);
while(list($cle,$val) = myEach($tableau)) {
	$val = utf8_encode($val);
	
	if(substr_count($val, ' at ') && $a == 0){
		$pos = strpos($val, ' at ');
		$pos_apres = strpos($val, '</H3>');
		$pos_avant = strpos($val, '<H3>') + 4;
		$long1 = $pos - $pos_avant;
		$pos = $pos + 4;
		$long2 = $pos_apres - $pos;
		$equipe1 = substr($val, $pos_avant, $long1);
		$equipe2 = substr($val, $pos, $long2);
		echo '<div style="text-align:center; font-weight:bold;">'.$equipe1.' at '.$equipe2.'</div>';
		$equipe1c = strtoupper($equipe1);
		$equipe2c = strtoupper($equipe2);
		$a++;
	}
	if( (isset($equipe1) && (substr_count($val, '<TR><TD>'.$equipe1)) || (isset($equipe1) && substr_count($val, '<TR><TD>'.$equipe2))) && $a >= 1 && $a < 5) {
		$mod = prev($tableau);
		for($i=0;$i<4;$i++) {
			$mod = next($tableau);
			$pos_avant = strpos($mod, '>') + 1;
			$pos_apres = strpos($mod, '</TD>');
			$long = $pos_apres - $pos_avant;
			if($a == 1)$visiteur1[$i] = substr($mod, $pos_avant, $long);
			if($a == 2)$domicile1[$i] = substr($mod, $pos_avant, $long);
			if($a == 3)$visiteur2[$i] = substr($mod, $pos_avant, $long);
			if($a == 4)$domicile2[$i] = substr($mod, $pos_avant, $long);
		}
		$mod = next($tableau);
		$pos_avant = strpos($mod, '<B>') + 3;
		$pos_apres = strpos($mod, '</B>');
		$long = $pos_apres - $pos_avant;
		if($a == 1)$visiteur1[4] = substr($mod, $pos_avant, $long);
		if($a == 2)$domicile1[4] = substr($mod, $pos_avant, $long);
		if($a == 3)$visiteur2[4] = substr($mod, $pos_avant, $long);
		if($a == 4)$domicile2[4] = substr($mod, $pos_avant, $long);
		$a++;
	}
	if($a == 5) {
		echo '<br><table class="tableau">
		<tr class="tableau-top"><td colspan="2">'.$gamesFinalResult.'</td></tr>
		<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$equipe1.'</td><td style="text-align:center;'.$style1.'">'.$visiteur2[4].'</td></tr>
		<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$equipe2.'</td><td style="text-align:center;'.$style1.'">'.$domicile2[4].'</td></tr></table>
		<br><div style="position: relative; text-align:left; float:left;">
		<table class="tableau" style="width:185px;">
		<tr class="tableau-top"><td colspan="6">'.$gamesShotOnGoal.'</td></tr>
		<tr style="'.$bg_1.' text-align:right;">
		<td style="'.$style1.'"></td>
		<td'.$style2.'>1</td>
		<td'.$style2.'>2</td>
		<td'.$style2.'>3</td>
		<td'.$style2.'>OT</td>
		<td'.$style2.'><b>T</b></td></tr>
		<tr style="'.$bg_2.' text-align:right;">
		<td style="'.$bg_2.' text-align:left;'.$style1.'">'.$equipe1.'</td>
		<td'.$style2.'>'.$visiteur1[0].'</td>
		<td'.$style2.'>'.$visiteur1[1].'</td>
		<td'.$style2.'>'.$visiteur1[2].'</td>
		<td'.$style2.'>'.$visiteur1[3].'</td>
		<td'.$style2.'><b>'.$visiteur1[4].'</b></td></tr>
		<tr style="'.$bg_2.' text-align:right;">
		<td style="'.$bg_2.' text-align:left;'.$style1.'">'.$equipe2.'</td>
		<td'.$style2.'>'.$domicile1[0].'</td>
		<td'.$style2.'>'.$domicile1[1].'</td>
		<td'.$style2.'>'.$domicile1[2].'</td>
		<td'.$style2.'>'.$domicile1[3].'</td>
		<td'.$style2.'><b>'.$domicile1[4].'</b></td></tr>
		</table></div>';
		echo'<div style="position: relative; text-align:right; float:right;">
		<table class="tableau" style="width:185px;"><tr class="tableau-top">
		<td colspan="6" style="text-align:left;">'.$gamesGoalScore.'</td></tr>
		<tr style="'.$bg_1.' text-align:right;"><td style="'.$style1.'"></td>
		<td'.$style2.'>1</td>
		<td'.$style2.'>2</td>
		<td'.$style2.'>3</td>
		<td'.$style2.'>OT</td>
		<td'.$style2.'><b>T</b></td></tr>
		<tr style="'.$bg_2.' text-align:right;">
		<td style="'.$bg_2.' text-align:left;'.$style1.'">'.$equipe1.'</td>
		<td'.$style2.'>'.$visiteur2[0].'</td>
		<td'.$style2.'>'.$visiteur2[1].'</td>
		<td'.$style2.'>'.$visiteur2[2].'</td>
		<td'.$style2.'>'.$visiteur2[3].'</td>
		<td'.$style2.'><b>'.$visiteur2[4].'</b></td></tr>
		<tr style="'.$bg_2.' text-align:right;'.$style1.'">
		<td style="'.$bg_2.' text-align:left;'.$style1.'">'.$equipe2.'</td>
		<td'.$style2.'>'.$domicile2[0].'</td>
		<td'.$style2.'>'.$domicile2[1].'</td>
		<td'.$style2.'>'.$domicile2[2].'</td>
		<td'.$style2.'>'.$domicile2[3].'</td>
		<td'.$style2.'><b>'.$domicile2[4].'</b></td></tr>
		</table></div>';
		$a++;
	}
	if($a == 23 && substr_count($val, '------')) {
		$a = 24;
		echo '</table>';
	}
	if($a == 22 || $a == 23) {
		$a = 23;
		echo '<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$val.'</td></tr>';
	}
	if($a == 21) {
		$a = 22;
		echo '<table class="tableau"><tr style="'.$bg_1.'"><td style="'.$style1.'"><b>'.$gamesSchoolGoalers.'</b></td></tr>';
	}
	if($a == 20 && substr_count($val, '------')) {
		$a = 21;
		echo '</table>';
	}
	if($a == 19 || $a == 20) {
		$a = 20;
		if(!substr_count($val, '(')) echo '<tr><td><br></td></tr>';
		else echo '<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$val.'</td></tr>';
	}
	if($a == 18) {
		$a = 19;
		echo '<table class="tableau"><tr><td><br></td></tr><tr style="'.$bg_1.'"><td style="'.$style1.'"><b>'.$gamesGoalScorers.'</b></td></tr>';
	}
	if($a == 17) {
		$team_r2 = substr($val, 0, 12);
		$team_r2p = substr($val, 14, 3);
		echo '
		<table class="tableau">
		<tr style="'.$bg_1.'"><td colspan="2" style="'.$style1.'"><b>'.$gamesFinalResult.'</b></td></tr>
		<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$team_r1.'</td><td style="text-align:center;'.$style1.'">'.$team_r1p.'</td></tr>
		<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$team_r2.'</td><td style="text-align:center;'.$style1.'">'.$team_r2p.'</td></tr></table>';
		$a = 18;
	}
	if($a == 16) {
		$team_r1 = substr($val, 0, 12);
		$team_r1p = substr($val, 14, 3);
		$a = 17;
	}
	if($a == 15) {
		$a = 16;
	}
	if($a == 14) {
		echo '<div style="clear:both;"><br></div><table class="tableau"><tr class="tableau-top"><td>'.$gamesMinorLeagueBoxScore.'</td></tr></table>';
		$a = 15;
	}
	if($a == 13) {
		str_replace('<BR>', '', $val);
		$long = strlen($val);
		if($long > 5) echo '<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$val.'</td></tr>';
		else {
			echo '</table>';
			$a = 14;
		}
	}
	if(substr_count($val, 'Game Notes')) {
		echo '</table><div style="clear:both;"><br></div><table class="tableau"><tr class="tableau-top"><td style="'.$style1.'">'.$gamesGameNotes.'</td></tr>';
		$a = 13;
	}
	if($a == 12) {
		$pos = strpos($val, '<');
		$long = $pos - 12;
		$texte = substr($val, 12, $long);
		if(substr_count($val, 'Attendance')) $texte2 = $gamesAttendance;
		if(substr_count($val, 'Net Profit')) $texte2 = $gamesNetProfit;
		echo '<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$texte2.'</td><td style="'.$style1.'">'.$texte.'</td></tr>';
	}
	if(substr_count($val, 'Financial')) {
		echo '<div style="clear:both;"><br></div><table class="tableau" style="width:260px;"><tr class="tableau-top"><td colspan="2" style="'.$style1.'">'.$gamesFinancial.'</td></tr>';
		$a = 12;
	}
	if($a == 11 && substr_count($val, '</TD><TD><PRE>   </PRE></TD><TD>')) {
		echo '</table></div>';
		$a = 10;
		$b++;
	}
	if($a == 11) {
		if(!substr_count($val, '                      ') && !substr_count($val, '-------')) {
			if($c == 1) $c = 2;
			else $c = 1;
			
			$count = strlen($val);
			$i = 0;
			while( $i < $count ) {
				if( ctype_digit($val[$i]) ) {
					$pos = $i;
					break 1;
				}
				$i++;
			}
			$plusmoins = substr($val, $pos+9, 4);
			$plusmoins = str_replace('Even', '0', $plusmoins);
			
			echo '<tr class="hover'.$c.'">
			<td style="font-size:8pt;'.$style1.'">'.substr($val, 0, $pos).'</td>
			<td style="font-size:8pt;'.$style1.' text-align:right;">'.substr($val, $pos, 2).'</td>
			<td style="font-size:8pt;'.$style1.' text-align:right;">'.substr($val, $pos+3, 2).'</td>
			<td style="font-size:8pt;'.$style1.' text-align:right;">'.substr($val, $pos+6, 2).'</td>
			<td style="font-size:8pt;'.$style1.' text-align:right;">'.$plusmoins.'</td>
			<td style="font-size:8pt;'.$style1.' text-align:right;">'.substr($val, $pos+14, 3).'</td>
			<td style="font-size:8pt;'.$style1.' text-align:right;">'.substr($val, $pos+18, 2).'</td>
			<td style="font-size:8pt;'.$style1.' text-align:right;">'.substr($val, $pos+21, 3).'</td>
			<td style="font-size:8pt;'.$style1.' text-align:right;">'.substr($val, $pos+24, 3).'</td></tr>';
		}
	}
	if($a == 10 && substr_count($val, '<BR><BR><PRE>')) {
		$pos = strpos($val, '<');
		$team = substr($val, 0, $pos);
		if($b == 1)$float = 'right';
		else $float = 'left';
		echo '<div style="position: relative; text-align:left; float:'.$float.';"><table class="tableau" style="width:260px;"><tr style="'.$bg_2.'"><td colspan="9" style="text-align:center;'.$style1.'">'.$team.'</td></tr>
		<tr class="tableau-top">
		<td style="'.$style1.'"></td>
		<td style="font-size:8pt; font-weight: bold ;'.$style1.' text-align:right;"><a href="javascript:return;" class="info">'.$gamesGoal.'<span>'.$gamesGoalF.'</span></a></td>
		<td style="font-size:8pt; font-weight: bold ;'.$style1.' text-align:right;"><a href="javascript:return;" class="info">'.$gamesAss.'<span>'.$gamesAssF.'</span></a></td>
		<td style="font-size:8pt; font-weight: bold ;'.$style1.' text-align:right;"><a href="javascript:return;" class="info">'.$gamesPoints.'<span>'.$gamesPointsF.'</span></a></td>
		<td style="font-size:8pt; font-weight: bold ;'.$style1.' text-align:right;"><a href="javascript:return;" class="info">+/-<span>'.$gamesDiff.'</span></a></td>
		<td style="font-size:8pt; font-weight: bold ;'.$style1.' text-align:right;"><a href="javascript:return;" class="info">'.$gamesPIM.'<span>'.$gamesPIMF.'</span></a></td>
		<td style="font-size:8pt; font-weight: bold ;'.$style1.' text-align:right;"><a href="javascript:return;" class="info">'.$gamesShots.'<span>'.$gamesShotsF.'</span></a></td>
		<td style="font-size:8pt; font-weight: bold ;'.$style1.' text-align:right;"><a href="javascript:return;" class="info">'.$gamesHT.'<span>'.$gamesHTF.'</span></a></td>
		<td style="font-size:8pt; font-weight: bold ;'.$style1.' text-align:right;"><a href="javascript:return;" class="info">'.$gamesIceTime.'<span>'.$gamesIceTimeF.'</span></a></td></tr>';
		$a = 11;
	}
	if(substr_count($val, 'Player Statistics')) {
		echo '</table></div><div style="clear:both;"><br></div><table class="tableau">
		<tr class="tableau-top"><td colspan="9" style="'.$style1.'">'.$gamesPlayerStats.'</td></tr></table>';
		$a = 10;
	}
	if($a == 9) {
		$numero = substr($val, 1, 1);
		$pos = strpos($val, '(');
		$long = $pos - 6;
		$joueur = substr($val, 5, $long);
		$equipe = substr($val, $pos + 1, 3);
		echo '<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$numero.'</td><td style="'.$style1.'">'.$joueur.'</td><td style="'.$style1.'">'.$equipe.'</td></tr>';
	}
	if(substr_count($val, 'Game Stars')) {
		echo '</table></div><div style="position: relative; text-align:left; float:right;"><table class="tableau" style="width:180px;">
		<tr><td colspan="3"><br></td></tr>
		<tr class="tableau-top"><td colspan="3" style="'.$style1.'">'.$gamesThreeStars.'</td></tr>';
		$a = 9;
	}
	if($a == 8) {
		$val = str_replace('<BR>', '', $val);
		$pos = strpos($val, '  ');
		$team = substr($val, 0, $pos);
		$pos = $pos + 2;
		$long = strlen($val);
		$long = $long - $pos;
		$result = substr($val, $pos, $long);
		$result = str_replace('for', $gamesin, $result);
		echo '<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$team.'</td><td style="'.$style1.'">'.$result.'</td></tr>';
	}
	if(substr_count($val, 'Power Play Conversions')) {
		echo '</table><div style="position: relative; text-align:left; float:left;"><table class="tableau" style="width:180px;">
		<tr><td colspan="2"><br></td></tr>
		<tr class="tableau-top"><td colspan="2" style="'.$style1.'">'.$gamesPPC.'</td></tr>';
		$a = 8;
	}
	if($a == 7) {
		$pos = strpos($val, '(') - 1;
		$joueur = substr($val, 0, $pos);
		
		$pos = $pos + 2;
		$pos2 = strpos($val, ')');
		$long = $pos2 - $pos;
		$team = substr($val, $pos, $long);
		
		$pos2 = $pos2 + 3;
		$pos = strpos($val, ' shots') + 6;
		$long = $pos - $pos2;
		$save = substr($val, $pos2, $long);
		$save  = str_replace('saves out of', $gamesSavesOutOf, $save );
		$save  = str_replace('shots', $gamesGoalShots, $save );
		
		if(!substr_count($val, 'shots<BR>')) {
			$pos = $pos + 3;
			$status = substr($val, $pos, 1);
			$status = str_replace('W', $gamesW, $status);
			$status = str_replace('L', $gamesL, $status);
			$status = str_replace('T', $gamesT, $status);
			$pos = $pos + 3;
			$pos2 = strpos($val, '<BR>');
			$long = $pos2 - $pos;
			$total = substr($val, $pos, $long);
		}
		else {
			$status = '';
			$total = '';
		}
		echo '<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$joueur.'</td><td style="'.$style1.'">'.$team.'</td><td style="'.$style1.'">'.$save.'</td><td style="'.$style1.'">'.$status.'</td><td style="'.$style1.'">'.$total.'</td></tr>';
	}
	if(substr_count($val, 'Goalie Statistics')) {
		if(isset($punition)) {
			echo '</table><table class="tableau"><tr><td colspan="3" style="'.$style1.'"><br></td></tr><tr class="tableau-top"><td colspan="3" style="text-align:left;'.$style1.'">'.$gamesSumPen.'</td></tr>';
			$f = $d;
			for($d=0;$d<=$f;$d++) {
				$aremplacer = array('<I>', '</I>', '<BR>', 'PENALTIES:');
				$remplace = array('', '', '', '');
				$tmpCpt = '';
				if(isset($punition[$d])) {
					$punition[$d] = str_replace($aremplacer, $remplace, $punition[$d]);
					$tmpCpt = substr_count($punition[$d],"(") - substr_count($punition[$d],"(Served");
				}
				$tmpPunList = '';
				for($i=0;$i<$tmpCpt;$i++) {
					$pos = strpos($punition[$d], ',', strpos($punition[$d], ')'));
					if(!$pos) $tmpPunList[$i] = $punition[$d];
					else {
						$tmpPunList[$i] = substr($punition[$d], 0, $pos);
						$punition[$d] = substr($punition[$d], $pos+1);
					}
				}
				
				if(isset($punition2[$d]) && $punition2[$d] == 1) {
					echo '<tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$games1stPer.'</b></td></tr>';
				}
				if(isset($punition2[$d]) && $punition2[$d] == 2) {
					echo '<tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$games2ndPer.'</b></td></tr>';
				}
				if(isset($punition2[$d]) && $punition2[$d] == 3) {
					echo '<tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$games3rdPer.'</b></td></tr>';
				}
				if(isset($punition2[$d]) && $punition2[$d] == 4) {
					echo '<tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$gamesOTPer.'</b></td></tr>';
				}
				for($i=0;$i<$tmpCpt;$i++) {
					echo '<tr style="'.$bg_2.'"><td colspan="3" style="'.$style1.'">'.$tmpPunList[$i].'</td></tr>';
				}
			}
			echo'</table>';
		}
		else echo '</table>';
		echo '<div style="clear:both;"><br></div><table class="tableau">
		<tr class="tableau-top"><td style="'.$style1.'">'.$gamesGoalieStats.'</td>
		<td style="'.$style1.'"><a href="#" class="info">'.$gamesTeam.'<span>'.$gamesTeamF.'</span></a></td>
		<td style="'.$style1.'">'.$gamesSavesShots.'</td>
		<td style="'.$style1.'"><a href="#" class="info">S<span>'.$gamesStatus.'</span></a></td>
		<td style="'.$style1.'"><a href="#" class="info">TOTAL<span>'.$gamesTotal.'</span></a></td></tr>';
		$a = 7;
	}
	if($a == 6 && $e && (substr_count($val, $equipe1c) || substr_count($val, $equipe2c)) ) {
		$long = strlen($val);
		$pos = $long - 10;
		$temps = substr($val, $pos-1, 6);
		if(substr_count($temps, '<')) $temps = substr($temps, 0, 5);
		$pos_avant = strpos($val, '.') + 1;
		$pos_apres = strpos($val, ',');
		$pos_apres2 = $pos_apres - $pos_avant;
		$team = substr($val, $pos_avant, $pos_apres2);
		$pos_apres = $pos_apres + 2;
		$pos = $pos - 2;
		$pos = $pos - $pos_apres;
		$score = substr($val, $pos_apres, $pos);
		
		echo '<tr style="'.$bg_2.'"><td style="'.$style1.'">'.$team.'</td><td style="'.$style1.'">'.$temps.'</td><td style="'.$style1.'">'.$score.'</td></tr>';
	}
	if($a == 6 && (substr_count($val, 'NO SCORING'))) {
		echo '<tr style="'.$bg_2.'"><td colspan="3" style="'.$style1.'">'.$gamesNoScoring.'</td></tr>';
	}
	if($a == 6 && (substr_count($val, 'PENALTIES'))) {
		$punition[$d] = $val;
		$punition2[$d] = $e;
		$d++;
	}
	if($a == 6 && (substr_count($val, '<B>Period') || substr_count($val, '<B>Overtime'))) {
		if(substr_count($val, 'Period 1')) {
			$e++;
			echo '<div style="clear:both;"><br></div><table class="tableau"><tr class="tableau-top"><td colspan="3" style="text-align:left;'.$style1.'">'.$gamesGoalScorers.'</td></tr><tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$games1stPer.'</b></td></tr>';
		}
		if(substr_count($val, 'Period 2')) {
			$e++;
			echo '<tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$games2ndPer.'</b></td></tr>';
		}
		if(substr_count($val, 'Period 3')) {
			$e++;
			echo '<tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$games3rdPer.'</b></td></tr>';
		}
		if(substr_count($val, 'Overtime')) {
			$e++;
			echo '<tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$gamesOTPer.'</b></td></tr>';
		}
	}
}
}
else echo $allFileNotFound.' - '.$Fnm;

echo '<div style="clear:both;"></div></div></div></div>';
?>


<?php include 'footer.php'; ?>
