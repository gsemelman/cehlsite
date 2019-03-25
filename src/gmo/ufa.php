<!DOCTYPE html>
<html>
<head>
<title>Free Agents</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="author" content="Éric Leclerc">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=yes">

<?php
if(file_exists('config4.php')) {
	include 'config4.php';
}
else {
	echo '<a href="install/">Please install the Online GM Editor! - Installer le GM Editor en ligne S.V.P.</a>';
	exit();
}

$teamSelected = "";
if(isset($_GET['team']) || isset($_POST['team'])) {
	$teamSelected = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
	$teamSelected = htmlspecialchars($teamSelected);
}

$yearSelected = "";
if(isset($_GET['year']) || isset($_POST['year'])) {
	$yearSelected = ( isset($_GET['year']) ) ? $_GET['year'] : $_POST['year'];
	$yearSelected = htmlspecialchars($yearSelected);
}
$sortAttSelected = 0;
if(isset($_GET['sortAtt']) || isset($_POST['sortAtt'])) {
	$sortAttSelected = ( isset($_GET['sortAtt']) ) ? $_GET['sortAtt'] : $_POST['sortAtt'];
	$sortAttSelected = htmlspecialchars($sortAttSelected);
}
$sortTypSelected = "0";
if(isset($_GET['sortTyp']) || isset($_POST['sortTyp'])) {
	$sortTypSelected = ( isset($_GET['sortTyp']) ) ? $_GET['sortTyp'] : $_POST['sortTyp'];
	$sortTypSelected = htmlspecialchars($sortTypSelected);
}

include 'login/mysqli.php';
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$file_folder = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_langue' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_langue = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_TradeToolStatus' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_TradeToolStatus = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_UFAToolStatus' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_UFAToolStatus = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_position' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_position = $data['VALUE'];
	}
}
$league_poll_active = 0;
$query = mysqli_query($con, "SELECT `ID` FROM `".$db_table."_poll` LIMIT 0,1");
if(mysqli_num_rows($query) != 0) {
	$league_poll_active = 1;
}

// Get Colors from database
$sql = "SELECT `NAME`, HEX(`COLOR`) AS COLOR FROM `".$db_table."_colors`";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$tmpName = $data['NAME'];
		$tmpColor = $data['COLOR'];
		$tmpArray = array($tmpName=>$tmpColor);
		if(isset($databaseColors)) $databaseColors = array_merge((array)$databaseColors, (array)$tmpArray);
		else $databaseColors = $databaseColors = $tmpArray;
	}
}

mysqli_close($con);

$tableau_ligne2 = "#B0D6FF"; // #B0D6FF
$tableau_ligne1 = "#E1EFFF"; // #E1EFFF
$tableau_soustitre = "#1791CA"; // #1791CA
$tableau_titre1 = "#1B9DD4"; // #1B9DD4
$tableau_titre2 = "#014A92"; // #014A92

include 'css.php';

if($league_langue == "fr") {
	$langUFA[0] = 'Nom de la Saison';
	$langUFA[1] = 'NOM';
	$langUFA[2] = 'PS';
	$langUFA[3] = '#';
	$langUFA[4] = 'HD';
	$langUFA[5] = 'HGT';
	$langUFA[6] = 'WGT';
	$langUFA[7] = 'AGE';
	$langUFA[8] = 'CD';
	$langUFA[9] = 'IT';
	$langUFA[10] = 'SP';
	$langUFA[11] = 'ST';
	$langUFA[12] = 'EN';
	$langUFA[13] = 'DU';
	$langUFA[14] = 'DI';
	$langUFA[15] = 'SK';
	$langUFA[16] = 'PA';
	$langUFA[17] = 'PC';
	$langUFA[18] = 'DF';
	$langUFA[19] = 'OF';
	$langUFA[20] = 'EX';
	$langUFA[21] = 'LD';
	$langUFA[22] = 'SALAIRE';
	$langUFA[23] = 'BP';
	$langUFA[24] = 'OV';
	$langUFA[25] = 'NV. ÉQUIPE';
	$langUFA[26] = 'DATE';
	$langUFA[27] = 'SALAIRE';
	$langUFA[28] = 'CONTRAT';
	$langUFA[29] = 'Menu Principal';
	$langUFA[30] = 'Page des échanges';
	$langUFA[31] = 'Page des signatures';
	$langUFA[32] = 'PROTÉGÉ';
	$langUFA[33] = 'Trié par une équipe';
	$langUFA[34] = 'Historique des signatures';
	$langUFA[35] = 'DERN ÉQU';
	$langUFA[36] = 'Page des changements de position';
	$langUFA[37] = 'Page des votes';
	$langUFA[38] = 'Attribut -> Position -> Nom';
	$langUFA[39] = 'Position -> Attribut -> Nom';
}

if($league_langue == "en") {
	$langUFA[0] = 'Season name';
	$langUFA[1] = 'NAME';
	$langUFA[2] = 'PS';
	$langUFA[3] = '#';
	$langUFA[4] = 'HD';
	$langUFA[5] = 'HGT';
	$langUFA[6] = 'WGT';
	$langUFA[7] = 'AGE';
	$langUFA[8] = 'CD';
	$langUFA[9] = 'IT';
	$langUFA[10] = 'SP';
	$langUFA[11] = 'ST';
	$langUFA[12] = 'EN';
	$langUFA[13] = 'DU';
	$langUFA[14] = 'DI';
	$langUFA[15] = 'SK';
	$langUFA[16] = 'PA';
	$langUFA[17] = 'PC';
	$langUFA[18] = 'DF';
	$langUFA[19] = 'OF';
	$langUFA[20] = 'EX';
	$langUFA[21] = 'LD';
	$langUFA[22] = 'SALARY';
	$langUFA[23] = 'BP';
	$langUFA[24] = 'OV';
	$langUFA[25] = 'NEW TEAM';
	$langUFA[26] = 'DATE';
	$langUFA[27] = 'SALARY';
	$langUFA[28] = 'CONTRACT';
	$langUFA[29] = 'Home';
	$langUFA[30] = 'Trade Page';
	$langUFA[31] = 'Signing Page';
	$langUFA[32] = 'PROTECTED';
	$langUFA[33] = 'Sort By A Team';
	$langUFA[34] = 'Signing History';
	$langUFA[35] = 'LAST TEAM';
	$langUFA[36] = 'Position Change Page';
	$langUFA[37] = 'Poll Page';
	$langUFA[38] = 'Attribute -> Position -> Name';
	$langUFA[39] = 'Position -> Attribute -> Name';
}

// .TMS - Team List
$matches = glob($file_folder.'*.tms');
if(isset($matches) && count($matches)) {
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		break 1;
	}
	$fileTMS = $matches[$j];
}

if(isset($fileTMS)) {
	$filename = $fileTMS;
	$handle = fopen ($filename, "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$hex = '';
	$hex = bin2hex($load_contents);
	
	$teamNumber = 0;
	for($x=0;$x<strlen($hex);$x=$x+508){
		$teamName = substr($hex, $x, 20);
		$teamAbbr = substr($hex, $x+122, 6);
		$erreur = substr($hex, $x+506, 2);
		if((hexdec($erreur)>="32") && (hexdec($erreur)<="126")) $x = $x - 2;
		else {
			$strLength = strlen($teamName);
			$returnVal = '';
			for($k=0; $k<$strLength; $k += 2) {
				$dec_val = hexdec(substr($teamName, $k, 2));
				$returnVal .= chr($dec_val);
			}
			$teamName = utf8_encode(trim($returnVal));
			$fileTMSName[$teamNumber] = $teamName;
			
			$teamNumber++;
		}
	}
}
?>

<script type="text/javascript" language="JavaScript">
<!--

function sortTeam() {
	//
	if(document.getElementById('teamSelect').value == "") document.getElementById('ufaHistory').action = "ufa.php?";
	else document.getElementById('ufaHistory').action = "ufa.php?team="+document.getElementById('teamSelect').value+"&";
	document.getElementById('ufaHistory').action += "year="+document.getElementById('yearselect').value;
	document.getElementById('ufaHistory').action += "&sortTyp="+document.getElementById('sortTypSelect').value;
	document.getElementById('ufaHistory').action += "&sortAtt="+document.getElementById('sortAttSelect').value;
	document.getElementById('ufaHistory').submit();
}

//-->
</script>

</head>
<body>
<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

// Find the last UFA list entered
include 'login/mysqli.php';
$sql = "SELECT * FROM `".$db_table."_ufalist` WHERE `LEAGUE` = (SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` desc LIMIT 1)";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$i = 0;
if($query){
	while($data = mysqli_fetch_array($query)) {
		$dbLEAGUE = $data['LEAGUE'];
	}
}

echo '<a class="tooltip" href="index.php"><img class="menu2" src="images/design/home.png" alt="'.$langUFA[29].'"><span class="tooltiptext">'.$langUFA[29].'</span></a>';
if(isset($league_TradeToolStatus) && $league_TradeToolStatus != 0) echo '<a class="tooltip" href="trade.php"><img class="menu2" src="images/design/trade.png" alt="'.$langUFA[30].'"><span class="tooltiptext">'.$langUFA[30].'</span></a>';
if(isset($league_UFAToolStatus) && $league_UFAToolStatus != 0) echo '<a class="tooltip" href="ufa.php"><img class="menu2" src="images/design/ufa.png" alt="'.$langUFA[31].'"><span class="tooltiptext">'.$langUFA[31].'</span></a>';
if(isset($league_position) && $league_position == 1) echo '<a class="tooltip" href="position.php"><img class="menu2" src="images/design/position.png" alt="'.$langUFA[36].'"><span class="tooltiptext">'.$langUFA[36].'</span></a>';
if($league_poll_active == 1) echo '<a class="tooltip" href="poll.php"><img class="menu2" src="images/design/poll.png" alt="'.$langUFA[37].'"><span class="tooltiptext">'.$langUFA[37].'</span></a>';

echo '<br><br><br><span style="font-weight:bold;">'.$langUFA[34].'</span><br>';
echo '<form id="ufaHistory" method="post" enctype="multipart/form-data" action="ufa.php">';
// Make the year list
$sql = "SELECT `LEAGUE` FROM `".$db_table."_ufalist` GROUP BY `LEAGUE` ORDER BY `LEAGUE` DESC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if(mysqli_num_rows($query) != 0) {
	echo $langUFA[0].': <select name="yearselect" id="yearselect" onchange="sortTeam();">';
	$i = 0;
	while($data = mysqli_fetch_array($query)) {
		$LEAGUE[$i] = $data['LEAGUE'];
		$i++;
	}
	for($i=0;$i<count($LEAGUE);$i++) {
		$tmpYearSelected = "";
		if(isset($yearSelected) && $LEAGUE[$i] == $yearSelected) $tmpYearSelected = " selected";
		if(isset($yearSelected) && $yearSelected == "" && $dbLEAGUE == $LEAGUE[$i]) $tmpYearSelected = " selected";
		echo '<option value="'.$LEAGUE[$i].'"'.$tmpYearSelected.'>'.$LEAGUE[$i].'</option>';
	}
	echo '</select>';
}

// Make the team list
echo '<select name="teamSelect" id="teamSelect" style="margin-bottom:10px;" onchange="sortTeam();">';
if($teamSelected == "") echo '<option value="" selected="selected">'.$langUFA[33].'</option>';
else echo '<option value="">Sort By A Team</option>';
for($x=0;$x<count($fileTMSName);$x++) {
	if($teamSelected == $fileTMSName[$x]) echo '<option value="'.$fileTMSName[$x].'" selected="selected">'.$fileTMSName[$x].'</option>';
	else echo '<option value="'.$fileTMSName[$x].'">'.$fileTMSName[$x].'</option>';
}
echo '</select>';

$sortTypSel0 = ' selected="selected"';
$sortTypSel1 = '';
if($sortTypSelected == "1") {
	$sortTypSel0 = '';
	$sortTypSel1 = ' selected="selected"';
}
echo '<select name="sortTypSelect" id="sortTypSelect" style="margin-bottom:10px;" onchange="sortTeam();">';
echo '<option value="0"'.$sortTypSel0.'>'.$langUFA[38].'</option>';
echo '<option value="1"'.$sortTypSel1.'>'.$langUFA[39].'</option>';
echo '</select>';

$selected = ' selected="selected"';
$sortAttSel0 = $sortAttSel1 = $sortAttSel2 = $sortAttSel3 = $sortAttSel4 = $sortAttSel5 = $sortAttSel6 = $sortAttSel7 = $sortAttSel8 = $sortAttSel9 = $sortAttSel10 = $sortAttSel11 = $sortAttSel12 = $sortAttSel13 = $sortAttSel14 = $sortAttSel15 = $sortAttSel16 = $sortAttSel17 = '';
switch ($sortAttSelected) {
	case 0:
		$sortAttSel0 = $selected;
		break;
	case 1:
		$sortAttSel1 = $selected;
		break;
	case 2:
		$sortAttSel2 = $selected;
		break;
	case 3:
		$sortAttSel3 = $selected;
		break;
	case 4:
		$sortAttSel4 = $selected;
		break;
	case 5:
		$sortAttSel5 = $selected;
		break;
	case 6:
		$sortAttSel6 = $selected;
		break;
	case 7:
		$sortAttSel7 = $selected;
		break;
	case 8:
		$sortAttSel8 = $selected;
		break;
	case 9:
		$sortAttSel9 = $selected;
		break;
	case 10:
		$sortAttSel10 = $selected;
		break;
	case 11:
		$sortAttSel11 = $selected;
		break;
	case 12:
		$sortAttSel12 = $selected;
		break;
	case 13:
		$sortAttSel13 = $selected;
		break;
	case 14:
		$sortAttSel14 = $selected;
		break;
	case 15:
		$sortAttSel15 = $selected;
		break;
	case 16:
		$sortAttSel16 = $selected;
		break;
	case 17:
		$sortAttSel17 = $selected;
		break;
	default:
		$sortAttSel0 = $selected;
}

echo '<select name="sortAttSelect" id="sortAttSelect" style="margin-bottom:10px;" onchange="sortTeam();">';
echo '<option value="0"'.$sortAttSel0.'>'.$langUFA[24].'</option>';
echo '<option value="17"'.$sortAttSel17.'>'.$langUFA[27].'</option>';
echo '<option value="1"'.$sortAttSel1.'>'.$langUFA[5].'</option>';
echo '<option value="2"'.$sortAttSel2.'>'.$langUFA[6].'</option>';
echo '<option value="3"'.$sortAttSel3.'>'.$langUFA[7].'</option>';
echo '<option value="4"'.$sortAttSel4.'>'.$langUFA[9].'</option>';
echo '<option value="5"'.$sortAttSel5.'>'.$langUFA[10].'</option>';
echo '<option value="6"'.$sortAttSel6.'>'.$langUFA[11].'</option>';
echo '<option value="7"'.$sortAttSel7.'>'.$langUFA[12].'</option>';
echo '<option value="8"'.$sortAttSel8.'>'.$langUFA[13].'</option>';
echo '<option value="9"'.$sortAttSel9.'>'.$langUFA[14].'</option>';
echo '<option value="10"'.$sortAttSel10.'>'.$langUFA[15].'</option>';
echo '<option value="11"'.$sortAttSel11.'>'.$langUFA[16].'</option>';
echo '<option value="12"'.$sortAttSel12.'>'.$langUFA[17].'</option>';
echo '<option value="13"'.$sortAttSel13.'>'.$langUFA[18].'</option>';
echo '<option value="14"'.$sortAttSel14.'>'.$langUFA[19].'</option>';
echo '<option value="15"'.$sortAttSel15.'>'.$langUFA[20].'</option>';
echo '<option value="16"'.$sortAttSel16.'>'.$langUFA[21].'</option>';
echo '</select>';
echo '</form>';

function moneyFormat($money,$lang) {
	if($lang == "fr") $money2 = number_format($money, 0, ',', ' ')." $";
	if($lang == "en") $money2 = "$".number_format($money, 0, '.', ',');
	return $money2;
}

if(isset($dbLEAGUE)) {
	// Find the players in the UFA list selected
	$teamSQL = "";
	if($teamSelected != '') $teamSQL = " AND `TEAM` = '$teamSelected'";
	$yearSQL = $dbLEAGUE;
	if($yearSelected != '') $yearSQL = $yearSelected;
	$sql = "SELECT * FROM `".$db_table."_ufalist` WHERE `LEAGUE` = '$yearSQL'".$teamSQL;
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	$i = 0;
	if($query){
		while($data = mysqli_fetch_array($query)) {
			$dbINT[$i] = $data['INT'];
			$dbNAME[$i] = $data['NAME'];
			if($data['POSI'] == "00") $dbPOSI[$i] = "C";
			if($data['POSI'] == "01") $dbPOSI[$i] = "LW";
			if($data['POSI'] == "02") $dbPOSI[$i] = "RW";
			if($data['POSI'] == "03") $dbPOSI[$i] = "D";
			if($data['POSI'] == "04") $dbPOSI[$i] = "G";
			$dbPOS2[$i] = $data['POSI'];
			$dbNUMB[$i] = $data['NUMB'];
			if($data['HAND'] == "00") $dbHAND[$i] = "L";
			if($data['HAND'] == "01") $dbHAND[$i] = "R";
			$dbHEIG[$i] = $dbHEI2[$i] = $data['HEIG'];
			$height1 = floor($dbHEIG[$i] / 12);
			$height2 = $dbHEIG[$i] - ($height1 * 12);
			$dbHEIG[$i] = $height1.'\''.$height2.'"';
			$dbWEIG[$i] = $data['WEIG'];
			$dbAGES[$i] = $data['AGES'];
			if($data['COND'] == "00") $dbCOND[$i] = "FARM";
			if($data['COND'] == "64") $dbCOND[$i] = "PRO"; // Scratch
			if($data['COND'] == "c8") $dbCOND[$i] = "PRO";
			if(!isset($dbCOND[$i])) $dbCOND[$i] = "PRO";
			$dbINTE[$i] = $data['INTE'];
			$dbSPEE[$i] = $data['SPEE'];
			$dbSTRE[$i] = $data['STRE'];
			$dbENDU[$i] = $data['ENDU'];
			$dbDURA[$i] = $data['DURA'];
			$dbDISC[$i] = $data['DISC'];
			$dbSKAT[$i] = $data['SKAT'];
			$dbPASS[$i] = $data['PASS'];
			$dbPKCT[$i] = $data['PKCT'];
			$dbDEFS[$i] = $data['DEFS'];
			$dbOFFS[$i] = $data['OFFS'];
			$dbEXPE[$i] = $data['EXPE'];
			$dbLEAD[$i] = $data['LEAD'];
			$dbSALA[$i] = moneyFormat($data['SALA'], $league_langue);
			$dbSAL2[$i] = $data['SALA'];
			$dbBIRT[$i] = $data['BIRT'];
			$dbOVER[$i] = $data['OVER'];
			$dbMOVE[$i] = $data['NTC'];
			$dbLAST[$i] = $data['LAST_TEAM'];
			$dbPROT[$i] = $data['PROTECTED'];
			$dbDISA[$i] = $data['DISABLED'];
			$dbTEAM[$i] = $data['TEAM'];
			$dbDATE[$i] = $data['DATE'];
			if($data['SALARY'] != "") $dbSALARY[$i] = moneyFormat($data['SALARY'], $league_langue);
			else $dbSALARY[$i] = "";
			$dbYEAR[$i] = $data['YEAR'];
			$dbID[$i] = $i;
			$i++;
		}
	}
}

mysqli_close($con);

if(isset($dbINT)) {
	$cpNAME = $dbNAME;
	switch ($sortAttSelected) {
		case 0:
			$sortAttArr = $dbOVER;
			break;
		case 1:
			$sortAttArr = $dbHEI2;
			break;
		case 2:
			$sortAttArr = $dbWEIG;
			break;
		case 3:
			$sortAttArr = $dbAGES;
			break;
		case 4:
			$sortAttArr = $dbINTE;
			break;
		case 5:
			$sortAttArr = $dbSPEE;
			break;
		case 6:
			$sortAttArr = $dbSTRE;
			break;
		case 7:
			$sortAttArr = $dbENDU;
			break;
		case 8:
			$sortAttArr = $dbDURA;
			break;
		case 9:
			$sortAttArr = $dbDISC;
			break;
		case 10:
			$sortAttArr = $dbSKAT;
			break;
		case 11:
			$sortAttArr = $dbPASS;
			break;
		case 12:
			$sortAttArr = $dbPKCT;
			break;
		case 13:
			$sortAttArr = $dbDEFS;
			break;
		case 14:
			$sortAttArr = $dbOFFS;
			break;
		case 15:
			$sortAttArr = $dbEXPE;
			break;
		case 16:
			$sortAttArr = $dbLEAD;
			break;
		case 17:
			$sortAttArr = $dbSAL2;
			break;
		default:
			$sortAttArr = $dbOVER;
	}
	
	if($sortTypSelected == "0") {
		$sort1a = $sortAttArr;
		$sort1b = SORT_DESC;
		$sort2a = $dbPOS2;
		$sort2b = SORT_ASC;
	}
	if($sortTypSelected == "1") {
		$sort1a = $dbPOS2;
		$sort1b = SORT_ASC;
		$sort2a = $sortAttArr;
		$sort2b = SORT_DESC;
	}
	
	array_multisort($sort1a, $sort1b, $sort2a, $sort2b, $cpNAME, SORT_ASC, $dbID);
	echo '<table class="table">';
	echo '<tr class="tr">';
	echo '<td>'.$langUFA[1].'</td>';
	echo '<td>'.$langUFA[23].'</td>';
	echo '<td>'.$langUFA[2].'</td>';
	echo '<td>'.$langUFA[3].'</td>';
	echo '<td>'.$langUFA[4].'</td>';
	echo '<td>'.$langUFA[5].'</td>';
	echo '<td>'.$langUFA[6].'</td>';
	echo '<td>'.$langUFA[7].'</td>';
	echo '<td>'.$langUFA[8].'</td>';
	echo '<td>'.$langUFA[9].'</td>';
	echo '<td>'.$langUFA[10].'</td>';
	echo '<td>'.$langUFA[11].'</td>';
	echo '<td>'.$langUFA[12].'</td>';
	echo '<td>'.$langUFA[13].'</td>';
	echo '<td>'.$langUFA[14].'</td>';
	echo '<td>'.$langUFA[15].'</td>';
	echo '<td>'.$langUFA[16].'</td>';
	echo '<td>'.$langUFA[17].'</td>';
	echo '<td>'.$langUFA[18].'</td>';
	echo '<td>'.$langUFA[19].'</td>';
	echo '<td>'.$langUFA[20].'</td>';
	echo '<td>'.$langUFA[21].'</td>';
	echo '<td>'.$langUFA[24].'</td>';
	echo '<td>'.$langUFA[22].'</td>';
	echo '<td>'.$langUFA[35].'</td>';
	echo '<td>'.$langUFA[32].'</td>';
	echo '<td>'.$langUFA[25].'</td>';
	echo '<td>'.$langUFA[26].'</td>';
	echo '<td>'.$langUFA[27].'</td>';
	echo '<td>'.$langUFA[28].'</td>';
	echo '</tr>';
	
	for($i=0;$i<count($dbINT);$i++) {
		if($i % 2 == 0) $color = 1;
		else $color = 2;
		if($dbDISA[$dbID[$i]] == '0') echo '<tr class="tr_content'.$color.'"><td>'.$dbNAME[$dbID[$i]].'</td>';
		if($dbDISA[$dbID[$i]] == '1') echo '<tr class="tr_content'.$color.'"><td style="text-decoration: line-through;">'.$dbNAME[$dbID[$i]].'</td>';
		echo '<td style="text-align:left;">'.$dbBIRT[$dbID[$i]].'</td>';
		echo '<td style="text-align:right;">'.$dbPOSI[$dbID[$i]].'</td>';
		echo '<td style="text-align:right;">'.$dbNUMB[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbHAND[$dbID[$i]].'</td>';
		echo '<td style="text-align:left;">'.$dbHEIG[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbWEIG[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbAGES[$dbID[$i]].'</td>';
		echo '<td style="text-align:right;">'.$dbCOND[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbINTE[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbSPEE[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbSTRE[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbENDU[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbDURA[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbDISC[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbSKAT[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbPASS[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbPKCT[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbDEFS[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbOFFS[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbEXPE[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbLEAD[$dbID[$i]].'</td>';
		echo '<td style="text-align:center;">'.$dbOVER[$dbID[$i]].'</td>';
		echo '<td style="text-align:right;">'.$dbSALA[$dbID[$i]].'</td>';
		echo '<td style="text-align:right;">'.$dbLAST[$dbID[$i]].'</td>';
		if($dbMOVE[$dbID[$i]] == 1) echo '<td style="text-align:right;">'.$dbPROT[$dbID[$i]].'</td>';
		else echo '<td></td>';
		echo '<td style="text-align:right;">'.$dbTEAM[$dbID[$i]].'</td>';
		echo '<td style="text-align:right;">'.$dbDATE[$dbID[$i]].'</td>';
		echo '<td style="text-align:right;">'.$dbSALARY[$dbID[$i]].'</td>';
		echo '<td style="text-align:right;">'.$dbYEAR[$dbID[$i]].'</td>';
		echo '</tr>';
	}
	
	echo '</table>';
	
}
echo '</body>';
echo '</html>';
?>