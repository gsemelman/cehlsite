<!DOCTYPE html>
<html>
<head>
<title>Pending/History Trades</title>
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
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_TradeToolDisplay' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_TradeToolDisplay = $data['VALUE'];
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
	$langTrade[0] = 'Échange en attente';
	$langTrade[1] = 'Équipe 1';
	$langTrade[2] = 'Joueur 1';
	$langTrade[3] = 'Espoir 1';
	$langTrade[4] = 'Choix 1';
	$langTrade[5] = 'Argent 1';
	$langTrade[6] = 'Équipe 2';
	$langTrade[7] = 'Joueur 2';
	$langTrade[8] = 'Espoir 2';
	$langTrade[9] = 'Choix 2';
	$langTrade[10] = 'Argent 2';
	$langTrade[11] = 'Trié par une équipe';
	$langTrade[12] = 'Menu Principal';
	$langTrade[13] = 'Page des échanges';
	$langTrade[14] = 'Page des signatures';
	$langTrade[15] = 'Page des changements de position';
	$langTrade[16] = 'Page des votes';
}

if($league_langue == "en") {
	$langTrade[0] = 'Pending trade';
	$langTrade[1] = 'Team 1';
	$langTrade[2] = 'Player 1';
	$langTrade[3] = 'Prospect 1';
	$langTrade[4] = 'Draft Pick 1';
	$langTrade[5] = 'Cash 1';
	$langTrade[6] = 'Team 2';
	$langTrade[7] = 'Player 2';
	$langTrade[8] = 'Prospect 2';
	$langTrade[9] = 'Draft Pick 2';
	$langTrade[10] = 'Cash 2';
	$langTrade[11] = 'Sort By A Team';
	$langTrade[12] = 'Home';
	$langTrade[13] = 'Trade Page';
	$langTrade[14] = 'Signing Page';
	$langTrade[15] = 'Position Change Page';
	$langTrade[16] = 'Poll Page';
}
?>

<script type="text/javascript" language="JavaScript">
<!--

function sortTeam() {
	//
	if(document.getElementById('teamSelect').value == "") document.getElementById('tradeHistory').action = "trade.php";
	else document.getElementById('tradeHistory').action = "trade.php?team="+document.getElementById('teamSelect').value;
	document.getElementById('tradeHistory').submit();
}

//-->
</script>

</head>
<body>
<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

function moneyFormat($money,$lang) {
	if($lang == "fr") $money2 = number_format($money, 0, ',', ' ')." $";
	if($lang == "en") $money2 = "$".number_format($money, 0, '.', ',');
	return $money2;
}

// Find if a trade is pending (accepted by the two teams)
include 'login/mysqli.php';
$sql = "SELECT * FROM `".$db_table."_trade` WHERE `APPROVAL` = '0000-00-00 00:00:00' AND `DATE2` != '0000-00-00 00:00:00'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$i = 0;
if($query && $league_TradeToolDisplay == 0){
	while($data = mysqli_fetch_array($query)) {
		$dbINT[$i] = $data['INT'];
		$dbDATE1[$i] = $data['DATE1'];
		$dbDATE2[$i] = $data['DATE2'];
		$dbTEAM1[$i] = $data['TEAM1'];
		$dbTEAM2[$i] = $data['TEAM2'];
		$dbPLAYER1[$i] = explode('|',$data['PLAYER1']);
		$dbPLAYER2[$i] = explode('|',$data['PLAYER2']);
		$dbPROSPECT1[$i] = explode('|',$data['PROSPECT1']);
		$dbPROSPECT2[$i] = explode('|',$data['PROSPECT2']);
		$dbDRAFT1[$i] = explode('|',$data['DRAFT1']);
		$dbDRAFT2[$i] = explode('|',$data['DRAFT2']);
		if($data['CASH1'] != "") $dbCASH1[$i] = moneyFormat($data['CASH1'], $league_langue);
		else $dbCASH1[$i] = "";
		if($data['CASH2'] != "") $dbCASH2[$i] = moneyFormat($data['CASH2'], $league_langue);
		else $dbCASH2[$i] = "";
		$i++;
	}
}
mysqli_close($con);

echo '<a class="tooltip" href="index.php"><img class="menu2" src="images/design/home.png" alt="'.$langTrade[12].'"><span class="tooltiptext">'.$langTrade[12].'</span></a>';
if(isset($league_TradeToolStatus) && $league_TradeToolStatus != 0) echo '<a class="tooltip" href="trade.php"><img class="menu2" src="images/design/trade.png" alt="'.$langTrade[13].'"><span class="tooltiptext">'.$langTrade[13].'</span></a>';
if(isset($league_UFAToolStatus) && $league_UFAToolStatus != 0) echo '<a class="tooltip" href="ufa.php"><img class="menu2" src="images/design/ufa.png" alt="'.$langTrade[14].'"><span class="tooltiptext">'.$langTrade[14].'</span></a>';
if(isset($league_position) && $league_position == 1) echo '<a class="tooltip" href="position.php"><img class="menu2" src="images/design/position.png" alt="'.$langTrade[15].'"><span class="tooltiptext">'.$langTrade[15].'</span></a>';
if($league_poll_active == 1) echo '<a class="tooltip" href="poll.php"><img class="menu2" src="images/design/poll.png" alt="'.$langTrade[16].'"><span class="tooltiptext">'.$langTrade[16].'</span></a>';

echo '<br><br>';

if(isset($dbINT)) {
	echo '<br><span style="font-weight:bold;">'.$langTrade[0].'</span><br>';
	echo '<table class="table" style="margin-bottom:20px;">';
	echo '<tr class="tr">';
	echo '<td>'.$langTrade[1].'</td>';
	echo '<td>'.$langTrade[2].'</td>';
	echo '<td>'.$langTrade[3].'</td>';
	echo '<td>'.$langTrade[4].'</td>';
	echo '<td>'.$langTrade[5].'</td>';
	echo '<td>'.$langTrade[6].'</td>';
	echo '<td>'.$langTrade[7].'</td>';
	echo '<td>'.$langTrade[8].'</td>';
	echo '<td>'.$langTrade[9].'</td>';
	echo '<td>'.$langTrade[10].'</td>';
	echo '</tr>';
	for($i=0;$i<count($dbINT);$i++) {
		if($i % 2 == 0) $color = 1;
		else $color = 2;
		echo '<tr class="tr_content'.$color.'">';
		echo '<td><b>'.$dbTEAM1[$i].'</b><br>'.$dbDATE1[$i].'</td>';
		echo '<td>';
		for($x=0;$x<count($dbPLAYER1[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbPLAYER1[$i][$x];
		}
		echo '</td>';
		echo '<td>';
		for($x=0;$x<count($dbPROSPECT1[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbPROSPECT1[$i][$x];
		}
		echo '</td>';
		echo '<td>';
		for($x=0;$x<count($dbDRAFT1[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbDRAFT1[$i][$x];
		}
		echo '</td>';
		echo '<td>'.$dbCASH1[$i].'</td>';
		echo '<td><b>'.$dbTEAM2[$i].'</b><br>'.$dbDATE2[$i].'</td>';
		echo '<td>';
		for($x=0;$x<count($dbPLAYER2[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbPLAYER2[$i][$x];
		}
		echo '</td>';
		echo '<td>';
		for($x=0;$x<count($dbPROSPECT2[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbPROSPECT2[$i][$x];
		}
		echo '</td>';
		echo '<td>';
		for($x=0;$x<count($dbDRAFT2[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbDRAFT2[$i][$x];
		}
		echo '</td>';
		echo '<td>'.$dbCASH2[$i].'</td>';
		echo '</tr>';
	}
	echo '</table>';
}

 // Create the team list from database (Just teams already trade atleast one time.)
 include 'login/mysqli.php';
$sql = "SELECT `TEAM1` FROM `".$db_table."_trade` WHERE `APPROVAL` != '0000-00-00 00:00:00' GROUP BY `TEAM1`";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$i = 0;
if($query){
	while($data = mysqli_fetch_array($query)) {
		$fileTMSName[$i] = $data['TEAM1'];
		$i++;
	}
}
$sql = "SELECT `TEAM2` FROM `".$db_table."_trade` WHERE `APPROVAL` != '0000-00-00 00:00:00' GROUP BY `TEAM2`";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$fileTMSName[$i] = $data['TEAM2'];
		$i++;
	}
}
mysqli_close($con);
if(isset($fileTMSName)) {
	$fileTMSName = array_unique($fileTMSName);
	sort($fileTMSName);
}

// Show all trades approved by the league!
include 'login/mysqli.php';
if($teamSelected != "") $add = "AND (`TEAM1` = '$teamSelected' OR `TEAM2` = '$teamSelected') ";
else $add = "";
$sql = "SELECT * FROM `".$db_table."_trade` WHERE `APPROVAL` != '0000-00-00 00:00:00' $add ORDER BY `INT` DESC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$i = 0;
if($query){
	while($data = mysqli_fetch_array($query)) {
		$dbHistoryINT[$i] = $data['INT'];
		$dbHistoryDATE1[$i] = $data['DATE1'];
		$dbHistoryDATE2[$i] = $data['DATE2'];
		$dbHistoryTEAM1[$i] = $data['TEAM1'];
		$dbHistoryTEAM2[$i] = $data['TEAM2'];
		$dbHistoryPLAYER1[$i] = explode('|',$data['PLAYER1']);
		$dbHistoryPLAYER2[$i] = explode('|',$data['PLAYER2']);
		$dbHistoryPROSPECT1[$i] = explode('|',$data['PROSPECT1']);
		$dbHistoryPROSPECT2[$i] = explode('|',$data['PROSPECT2']);
		$dbHistoryDRAFT1[$i] = explode('|',$data['DRAFT1']);
		$dbHistoryDRAFT2[$i] = explode('|',$data['DRAFT2']);
		if($data['CASH1'] != "") $dbHistoryCASH1[$i] = moneyFormat($data['CASH1'], $league_langue);
		else $dbHistoryCASH1[$i] = "";
		if($data['CASH2'] != "") $dbHistoryCASH2[$i] = moneyFormat($data['CASH2'], $league_langue);
		else $dbHistoryCASH2[$i] = "";
		$i++;
	}
}
mysqli_close($con);

if(isset($dbHistoryINT)) {
	echo '<br><span style="font-weight:bold;">Trade History</span><br>';
	echo '<form id="tradeHistory" method="post" enctype="multipart/form-data" action="trade.php"><select name="teamSelect" id="teamSelect" style="margin-bottom:10px;" onchange="sortTeam();">';
	if($teamSelected == "") echo '<option value="" selected="selected">'.$langTrade[11].'</option>';
	else echo '<option value="">Sort By A Team</option>';
	for($x=0;$x<count($fileTMSName);$x++) {
		if($teamSelected == $fileTMSName[$x]) echo '<option value="'.$fileTMSName[$x].'" selected="selected">'.$fileTMSName[$x].'</option>';
		else echo '<option value="'.$fileTMSName[$x].'">'.$fileTMSName[$x].'</option>';
	}
	echo '</select></form>';
	echo '<table class="table" style="margin-bottom:20px;">';
	echo '<tr class="tr">';
	echo '<td>'.$langTrade[1].'</td>';
	echo '<td>'.$langTrade[2].'</td>';
	echo '<td>'.$langTrade[3].'</td>';
	echo '<td>'.$langTrade[4].'</td>';
	echo '<td>'.$langTrade[5].'</td>';
	echo '<td>'.$langTrade[6].'</td>';
	echo '<td>'.$langTrade[7].'</td>';
	echo '<td>'.$langTrade[8].'</td>';
	echo '<td>'.$langTrade[9].'</td>';
	echo '<td>'.$langTrade[10].'</td>';
	echo '</tr>';
	for($i=0;$i<count($dbHistoryINT);$i++) {
		if($i % 2 == 0) $color = 1;
		else $color = 2;
		echo '<tr class="tr_content'.$color.'">';
		echo '<td><b>'.$dbHistoryTEAM1[$i].'</b><br>'.$dbHistoryDATE1[$i].'</td>';
		echo '<td>';
		for($x=0;$x<count($dbHistoryPLAYER1[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbHistoryPLAYER1[$i][$x];
		}
		echo '</td>';
		echo '<td>';
		for($x=0;$x<count($dbHistoryPROSPECT1[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbHistoryPROSPECT1[$i][$x];
		}
		echo '</td>';
		echo '<td>';
		for($x=0;$x<count($dbHistoryDRAFT1[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbHistoryDRAFT1[$i][$x];
		}
		echo '</td>';
		echo '<td>'.$dbHistoryCASH1[$i].'</td>';
		echo '<td><b>'.$dbHistoryTEAM2[$i].'</b><br>'.$dbHistoryDATE2[$i].'</td>';
		echo '<td>';
		for($x=0;$x<count($dbHistoryPLAYER2[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbHistoryPLAYER2[$i][$x];
		}
		echo '</td>';
		echo '<td>';
		for($x=0;$x<count($dbHistoryPROSPECT2[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbHistoryPROSPECT2[$i][$x];
		}
		echo '</td>';
		echo '<td>';
		for($x=0;$x<count($dbHistoryDRAFT2[$i]);$x++) {
			if($x!=0) echo '<br>';
			echo $dbHistoryDRAFT2[$i][$x];
		}
		echo '</td>';
		echo '<td>'.$dbHistoryCASH2[$i].'</td>';
		echo '</tr>';
	}
	echo '</table>';
}
echo '</body>';
echo '</html>';
?>