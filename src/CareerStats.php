<?php
require_once 'config.php';
include 'lang.php';


$csName = '';
if(isset($_GET['csName']) || isset($_POST['csName'])) {
	$csName = ( isset($_GET['csName']) ) ? $_GET['csName'] : $_POST['csName'];
	$csName = trim(htmlspecialchars($csName));
}

$csLetter = '';
if(isset($_GET['csLetter']) || isset($_POST['csLetter'])) {
	$csLetter = ( isset($_GET['csLetter']) ) ? $_GET['csLetter'] : $_POST['csLetter'];
	$csLetter = htmlspecialchars($csLetter);
}

$csPos = '';
if(isset($_GET['csPos']) || isset($_POST['csPos'])) {
	$csPos = ( isset($_GET['csPos']) ) ? $_GET['csPos'] : $_POST['csPos'];
	$csPos = htmlspecialchars($csPos);
}

$csTeam = '';
if(isset($_GET['csTeam']) || isset($_POST['csTeam'])) {
	$csTeam = ( isset($_GET['csTeam']) ) ? $_GET['csTeam'] : $_POST['csTeam'];
	$csTeam = htmlspecialchars($csTeam);
}

$csSeason = '';
if(isset($_GET['csSeason']) || isset($_POST['csSeason'])) {
	$csSeason = ( isset($_GET['csSeason']) ) ? $_GET['csSeason'] : $_POST['csSeason'];
	$csSeason = htmlspecialchars($csSeason);
}

$csAddLinkPos = '';
$csAddLinkTeam = '';
$csAddLinkLetter = '';
$csAddLinkName = '';
$csAddLinkSeason = '';
if($csLetter != '') {
	$csAddLinkPos .= '&csLetter='.$csLetter;
	$csAddLinkTeam .= '&csLetter='.$csLetter;
	$csAddLinkName .= '&csLetter='.$csLetter;
	$csAddLinkSeason .= '&csLetter='.$csLetter;
}
if($csPos != '') {
	$csAddLinkLetter .= '&csPos='.$csPos;
	$csAddLinkTeam .= '&csPos='.$csPos;
	$csAddLinkName .= '&csPos='.$csPos;
	$csAddLinkSeason .= '&csPos='.$csPos;
}
if($csTeam != '') {
	$csAddLinkLetter .= '&csTeam='.$csTeam;
	$csAddLinkPos .= '&csTeam='.$csTeam;
	$csAddLinkName .= '&csTeam='.$csTeam;
	$csAddLinkSeason .= '&csTeam='.$csTeam;
}
if($csName != '') {
	$csAddLinkLetter .= '&csName='.$csName;
	$csAddLinkPos .= '&csName='.$csName;
	$csAddLinkTeam .= '&csName='.$csName;
	$csAddLinkSeason .= '&csName='.$csName;
}
if($csSeason != '') {
	$csAddLinkLetter .= '&csSeason='.$csSeason;
	$csAddLinkPos .= '&csSeason='.$csSeason;
	$csAddLinkTeam .= '&csSeason='.$csSeason;
}

$CurrentHTML = '';
$CurrentTitle = $careerStatsTitle;
$CurrentPage = 'CareerStats';
include 'head.php';

// Recherche des saisons antérieurs
if($folderCarrerStats != '0') {
	$hashFolder = '';
	$tmpLong = 0;
	for($i=0;$i<substr_count($folderCarrerStats, '/');$i++) {
		if($hashFolder != '') $tmpLong = strlen($hashFolder)+1;
		$hashFolder = substr($folderCarrerStats, 0+$tmpLong, strpos($folderCarrerStats, '/'));
		if(substr_count($hashFolder, '#') > 0) break 1;
	}
	$Fnm = str_replace("#/","*",$folderCarrerStats);
	$NumberSeason = 0;
	$dirs = glob($Fnm, GLOB_ONLYDIR);
	for($j=0;$j<count($dirs);$j++) {
		if(substr_count($dirs[$j], $hashFolder)) {
			$tmpYear = substr($dirs[$j], strlen($folderCarrerStats)-2);
			if($NumberSeason < $tmpYear) $NumberSeason = $tmpYear;
		}
	}
}

// Recherche des équipes - Current Season
$matches = glob($folder.'*GMs.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if(!substr_count($matches[$j], 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$FnmGMs = $folder.$folderLeagueURL.'GMs.html';
$i = 0;
if(file_exists($FnmGMs)) {
	$tableau = file($FnmGMs);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'HREF') && !substr_count($val, '<BR>')) {
			$gmequipe[$i] = trim(substr($val, 0, 10));
			$i++;
		}
	}
	
	// Recherche des équipes - Previous Seasons
	for($n=$NumberSeason;$n!=0;$n--) {
		$Fnmtmp = str_replace("#",$n,$folderCarrerStats);
		$matches = glob($Fnmtmp.'/*GMs.html');
		$folderLeagueURL = '';
		for($j=0;$j<count($matches);$j++) {
			if(!substr_count($matches[$j], 'PLF')) {
				$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
				break 1;
			}
		}
		if($folderLeagueURL != '') {
			$FnmGMs = $Fnmtmp.$folderLeagueURL.'GMs.html';
			$tableau = file($FnmGMs);
			while(list($cle,$val) = myEach($tableau)) {
				$val = utf8_encode($val);
				if(substr_count($val, 'HREF') && !substr_count($val, '<BR>')) {
					$tmpGMTeam = trim(substr($val, 0, 10));
					$tmpfound = 0;
					for($o=0;$o<count($gmequipe);$o++) {
						if($gmequipe[$o] == $tmpGMTeam) {
							$tmpfound = 1;
						}
					}
					if($tmpfound == 0) {
						$gmequipe[$i] = $tmpGMTeam;
						$i++;
					}
				}
			}
		}
	}
}
else echo $allFileNotFound.' - '.$FnmGMs;

// Recherche des joueurs - Current Season
if($csName != '' || $csLetter != '' || $csPos != '' || $csTeam != '' || $csSeason != '') {
	$matches = glob($folder.'*PlayerVitals.html');
	$folderLeagueURL = '';
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		if(!substr_count($matches[$j], 'PLF')) {
			$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PlayerVitals')-strrpos($matches[$j], '/')-1);
			break 1;
		}
	}
	$Fnm = $folder.$folderLeagueURL.'PlayerVitals.html';
$e = 0;
$d = 0;
$i = 0;
$lastTeam = '';
$workSeason = $NumberSeason + 1;
$searchName = array();
if($csTeam != '') $d = 1;
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'A NAME='.$csTeam)) {
			$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
			$lastTeam = trim(substr($reste, strpos($reste, '>')+1));
			if($csTeam != '') $d = 0;
		}
		if(substr_count($val, '------------')) {
			$e = 0;
			if($csTeam != '') $d = 1;
		}
		if($d == 0 && $e) {
			$reste = trim($val);
			$reste = trim(substr($reste, strpos($reste, ' ')));
			if(substr($reste, 0, 1) == '*') {
				$reste = trim(substr($reste, 1));
			}
			$tmpName = trim(substr($reste, 0, strpos($reste, '  ')));
			$tmpNameFirstLetter = strtoupper(substr($reste, strpos($reste, ' ')+1, 1));
			$tmpNameLastName = substr($reste, strpos($reste, ' ')+1);
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$tmpPosition = substr($reste, 0, strpos($reste, ' '));
			
			if((($csPos != '' && $csPos == $tmpPosition) || $csPos == '') && (($csLetter != '' && $csLetter == $tmpNameFirstLetter) || $csLetter == '') && (($csName != '' && substr_count(strtoupper($tmpName), strtoupper($csName))) || $csName == '') && (($csSeason != '' && $csSeason == $workSeason) || $csSeason == '')) {
				$searchName[$i] = $tmpName;
				$searchLastName[$i] = $tmpNameLastName;
				$searchPosition[$i] = $tmpPosition;
				$searchSeason[$i] = '|'.$workSeason.'|';
				$searchTm[$i] = $lastTeam;
				$i++;
			}
		}
		if(substr_count($val, 'CONTRACT') ) {
			$e = 1;
		}
	}
	
	// Recherche des joueurs - Previous Seasons
	for($n=0;$n<$NumberSeason;$n++) {
		if($i == 0) $lastTeam = '';
		$workSeason--;
		if(($csSeason != '' && $workSeason == $csSeason) || $csSeason == '') {
			$Fnmtmp = str_replace("#",$workSeason,$folderCarrerStats);
			$matches = glob($Fnmtmp.'*PlayerVitals.html');
			$folderLeagueURL = '';
			for($j=0;$j<count($matches);$j++) {
				if(!substr_count($matches[$j], 'PLF')) {
					$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PlayerVitals')-strrpos($matches[$j], '/')-1);
					break 1;
				}
			}
			if($folderLeagueURL != '') {
				//$Fnmtmp = str_replace("#",$workSeason,$folderCarrerStats);
				$Fnm = $Fnmtmp.$folderLeagueURL.'PlayerVitals.html';
				//echo $Fnm.'<br>';
				$e = 0;
				$d = 0;
				if($csTeam != '') $d = 1;
				$lastTeam = '';
				if(file_exists($Fnm)) {
					$tableau = file($Fnm);
					while(list($cle,$val) = myEach($tableau)) {
						$val = utf8_encode($val);
						if(substr_count($val, 'A NAME='.$csTeam)) {
							$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
							$lastTeam = trim(substr($reste, strpos($reste, '>')+1));
							if($csTeam != '') $d = 0;
							
						}
						if(substr_count($val, '------------')) {
							$e = 0;
							if($csTeam != '') $d = 1;
						}
						if($d == 0 && $e) {
							$reste = trim($val);
							$reste = trim(substr($reste, strpos($reste, ' ')));
							if(substr($reste, 0, 1) == '*') {
								$reste = trim(substr($reste, 1));
							}
							$tmpName = trim(substr($reste, 0, strpos($reste, '  ')));
							$tmpNameFirstLetter = strtoupper(substr($reste, strpos($reste, ' ')+1, 1));
							$tmpNameLastName = substr($reste, strpos($reste, ' ')+1);
							$reste = trim(substr($reste, strpos($reste, '  ')));
							$tmpPosition = substr($reste, 0, strpos($reste, ' '));
							
							if((($csPos != '' && $csPos == $tmpPosition) || $csPos == '') && (($csLetter != '' && $csLetter == $tmpNameFirstLetter) || $csLetter == '') && (($csName != '' && substr_count(strtoupper($tmpName), strtoupper($csName))) || $csName == '') && (($csSeason != '' && $csSeason == $workSeason) || $csSeason == '')) {
								$tmpFound = 0;
								for($k=0;$k<count($searchName);$k++){
									if($searchName[$k] == $tmpName) {
										$tmpFound = 1;
										$searchSeason[$k] = '|'.$workSeason.'|'.$searchSeason[$k];
										break 1;
									}
								}
								if($tmpFound == 0) {
									$searchName[$i] = $tmpName;
									$searchLastName[$i] = $tmpNameLastName;
									$searchPosition[$i] = $tmpPosition;
									$searchSeason[$i] = '|'.$workSeason.'|';
									$searchTm[$i] = $lastTeam;
									$i++;
								}
							}
						}
						if(substr_count($val, 'CONTRACT') ) {
							$e = 1;
						}
					}
				}
				else echo $allFileNotFound.' - '.$Fnm;
			}
		}
	}
}
else echo $allFileNotFound.' - '.$Fnm;
}

?>

<div style="margin-left:auto; margin-right:auto; margin-top:5px; margin-bottom:5px; clear:both; width:555px; text-align:center;">
<a style="<?php if($csLetter == 'A') echo 'font-weight:bold;'; ?>>" class="lien-noir" href="?csLetter=A<?php echo $csAddLinkLetter; ?>">A</a> - 
<a style="<?php if($csLetter == 'B') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=B<?php echo $csAddLinkLetter; ?>">B</a> - 
<a style="<?php if($csLetter == 'C') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=C<?php echo $csAddLinkLetter; ?>">C</a> - 
<a style="<?php if($csLetter == 'D') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=D<?php echo $csAddLinkLetter; ?>">D</a> - 
<a style="<?php if($csLetter == 'E') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=E<?php echo $csAddLinkLetter; ?>">E</a> - 
<a style="<?php if($csLetter == 'F') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=F<?php echo $csAddLinkLetter; ?>">F</a> - 
<a style="<?php if($csLetter == 'G') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=G<?php echo $csAddLinkLetter; ?>">G</a> - 
<a style="<?php if($csLetter == 'H') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=H<?php echo $csAddLinkLetter; ?>">H</a> - 
<a style="<?php if($csLetter == 'I') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=I<?php echo $csAddLinkLetter; ?>">I</a> - 
<a style="<?php if($csLetter == 'J') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=J<?php echo $csAddLinkLetter; ?>">J</a> - 
<a style="<?php if($csLetter == 'K') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=K<?php echo $csAddLinkLetter; ?>">K</a> - 
<a style="<?php if($csLetter == 'L') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=L<?php echo $csAddLinkLetter; ?>">L</a> - 
<a style="<?php if($csLetter == 'M') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=M<?php echo $csAddLinkLetter; ?>">M</a> - 
<a style="<?php if($csLetter == 'N') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=N<?php echo $csAddLinkLetter; ?>">N</a> - 
<a style="<?php if($csLetter == 'O') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=O<?php echo $csAddLinkLetter; ?>">O</a> - 
<a style="<?php if($csLetter == 'P') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=P<?php echo $csAddLinkLetter; ?>">P</a> - 
<a style="<?php if($csLetter == 'Q') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=Q<?php echo $csAddLinkLetter; ?>">Q</a> - 
<a style="<?php if($csLetter == 'R') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=R<?php echo $csAddLinkLetter; ?>">R</a> - 
<a style="<?php if($csLetter == 'S') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=S<?php echo $csAddLinkLetter; ?>">S</a> - 
<a style="<?php if($csLetter == 'T') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=T<?php echo $csAddLinkLetter; ?>">T</a> - 
<a style="<?php if($csLetter == 'U') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=U<?php echo $csAddLinkLetter; ?>">U</a> - 
<a style="<?php if($csLetter == 'V') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=V<?php echo $csAddLinkLetter; ?>">V</a> - 
<a style="<?php if($csLetter == 'W') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=W<?php echo $csAddLinkLetter; ?>">W</a> - 
<a style="<?php if($csLetter == 'X') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=X<?php echo $csAddLinkLetter; ?>">X</a> - 
<a style="<?php if($csLetter == 'Y') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=Y<?php echo $csAddLinkLetter; ?>">Y</a> - 
<a style="<?php if($csLetter == 'Z') echo 'font-weight:bold;'; ?>" class="lien-noir" href="?csLetter=Z<?php echo $csAddLinkLetter; ?>">Z</a>
<br>
 
<input id="csName" type="text" value="<?php echo $csName; ?>">
<select onchange="window.location = '?csTeam='+ this.value + '<?php echo $csAddLinkTeam; ?>';">
<option value=""><?php echo $careerStatsTeams; ?></option>
<?php
for($i=0;$i<count($gmequipe);$i++) {
	$selected = '';
	if($csTeam != '' && $gmequipe[$i] == $csTeam) $selected = ' selected="selected"';
	echo '<option value="'.$gmequipe[$i].'"'.$selected.'>'.$gmequipe[$i].'</option>';
}
?>
</select>
<select onchange="window.location = '?csPos='+ this.value + '<?php echo $csAddLinkPos; ?>';">
<option value="">Position</option>
<option value="C"<?php if($csPos == 'C') echo ' selected="selected"'; ?>><?php echo $careerStatsCenters; ?></option>
<option value="RW"<?php if($csPos == 'RW') echo ' selected="selected"'; ?>><?php echo $careerStatsRightWings; ?></option>
<option value="LW"<?php if($csPos == 'LW') echo ' selected="selected"'; ?>><?php echo $careerStatsLeftWings; ?></option>
<option value="D"<?php if($csPos == 'D') echo ' selected="selected"'; ?>><?php echo $careerStatsDefenseman; ?></option>
<option value="G"<?php if($csPos == 'G') echo ' selected="selected"'; ?>><?php echo $careerStatsGoalies; ?></option>
</select>
<select onchange="window.location = '?csSeason='+ this.value + '<?php echo $csAddLinkSeason; ?>';">
<option value=""><?php echo $careerStatsSeasons; ?></option>
<?php
for($o=$NumberSeason+1;$o!=0;$o--) {
	$selected = '';
	if($csSeason != '' && $o == $csSeason) $selected = ' selected="selected"';
	echo '<option value="'.$o.'"'.$selected.'>'.$o.'</option>';
}
?>
</select>
<a class="lien-noir" href="CareerStats.php"><?php echo $careerStatsReset; ?></a>
</div>

<?php
if($csName != '' || $csLetter != '' || $csPos != '' || $csTeam != '' || $csSeason != '') {
echo '
<div style="margin-left:auto; margin-right:auto; clear:both; width:555px; border:solid 1px'.$couleur_contour.'">
<div class="titre"><span class="bold-blanc">'.$careerStatsTitle.' - '.$careerStatsPlayerList.'</span></div>
<table class="table table-sm table-striped">';

if(count($searchName)) {
	$txtLastTeam = $careerStatsLASTTEAM;
	if($csTeam != '') $txtLastTeam = $careerStatsSeasonsPlayedWith;
	echo '
	<tr class="tableau-top">
	<td>'.$joueursPlayers.'</td>
	<td style="text-align:right;"><a href="javascript:return;" class="info">POS<span>Position</span></a></td>
	<td style="text-align:right;">'.$txtLastTeam.'</td>';
	for($o=1;$o<=$NumberSeason+1;$o++) {
		echo '<td style="text-align:center;">'.$o.'</td>';
	}
	echo '</tr>';
	
	$tableauf = $searchLastName;
	if($csLetter != '') asort($tableauf);
	$key = key($tableauf);
	$val = current($tableauf);
	$c = 1;
	while(list ($key, $val) = myEach($tableauf)) {
		if($c == 1) $c = 2;
		else $c = 1;
		echo '
			<tr class="hover'.$c.'">
			<td><a class="lien-noir" href="CareerStatsPlayer.php?csName='.urlencode($searchName[$key]).'" style="display:block; width:100%;">'.$searchName[$key].'</a></td>
			<td style="text-align:right;">'.$searchPosition[$key].'</td>
			<td style="text-align:right;">'.$searchTm[$key].'</td>';
		for($o=1;$o<=$NumberSeason+1;$o++) {
			if(substr_count($searchSeason[$key], '|'.$o.'|')) echo '<td style="text-align:center; background-color:green;"></td>';
			else echo '<td></td>';
		}
		echo '</tr>';
	}
}
else {
	echo '<tr class="hover2"><td style="text-align:center;">'.$careerStatsNoPlayerFound.'</td></tr>';
}

echo '</table></div>';
}
/*
echo '<pre>';
print_r($searchSeason);
echo '<pre>';
*/
?>

<script type="text/javascript">
<!--
document.getElementById('csName').onkeypress = function(e){
	if (!e) e = window.event;
	var keyCode = e.keyCode || e.which;
	if (keyCode == '13' && this.value != ''){
		window.location = '?csName='+ this.value + '<?php echo $csAddLinkName; ?>';
	}
}
//-->
</script>

<?php include 'footer.php'; ?>