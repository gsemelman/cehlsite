<!DOCTYPE html>
<html>
<head>
<title>OGME - Position</title>
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

include 'css.php';

if($league_langue == "fr") {
	$langPosition[0] = 'Changement de Position';
	$langPosition[1] = 'C';
	$langPosition[2] = 'AG';
	$langPosition[3] = 'AD';
	$langPosition[4] = 'D';
	$langPosition[5] = 'G';
	$langPosition[6] = 'DATE';
	$langPosition[7] = 'JOUEUR';
	$langPosition[8] = 'ÉQUIPE';
	$langPosition[9] = 'AVANT';
	$langPosition[10] = 'APRÈS';
	$langPosition[11] = 'SUPPRIMER';
	$langPosition[12] = 'POSITION';
	$langPosition[13] = 'TRIER PAR';
	$langPosition[14] = 'ÉQUIPE';
	$langPosition[100] = 'Menu Principal';
	$langPosition[101] = 'Page des échanges';
	$langPosition[102] = 'Page des signatures';
	$langPosition[103] = 'Page des changements de position';
	$langPosition[104] = 'Page des votes';
}

if($league_langue == "en") {
	$langPosition[0] = 'Position Change';
	$langPosition[1] = 'C';
	$langPosition[2] = 'LW';
	$langPosition[3] = 'RW';
	$langPosition[4] = 'D';
	$langPosition[5] = 'G';
	$langPosition[6] = 'DATE';
	$langPosition[7] = 'PLAYER';
	$langPosition[8] = 'TEAM';
	$langPosition[9] = 'BEFORE';
	$langPosition[10] = 'AFTER';
	$langPosition[11] = 'DELETE';
	$langPosition[12] = 'POSITION';
	$langPosition[13] = 'SORT BY';
	$langPosition[14] = 'TEAM';
	$langPosition[100] = 'Home';
	$langPosition[101] = 'Trade Page';
	$langPosition[102] = 'Signing Page';
	$langPosition[103] = 'Position Change Page';
	$langPosition[104] = 'Poll Page';
}
?>

<script type="text/javascript" language="JavaScript">
<!--

function sortYear() {
	var tmpYear = document.getElementById('selectYear').value;
	document.getElementById('positionForm').action = "position.php?year="+tmpYear;
	document.getElementById('positionForm').submit();
}

function sortTeam() {
	var tmpYear = document.getElementById('selectYear').value;
	var tmpTeam = encodeURIComponent(document.getElementById('selectTeam').value);
	if(tmpTeam != "") document.getElementById('positionForm').action = "position.php?year="+tmpYear+"&team="+tmpTeam;
	else document.getElementById('positionForm').action = "position.php?year="+tmpYear;
	document.getElementById('positionForm').submit();
}

//-->
</script>

</head>
<body>
<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

echo '<a class="tooltip" href="index.php"><img class="menu2" src="images/design/home.png" alt="'.$langPosition[100].'"><span class="tooltiptext">'.$langPosition[100].'</span></a>';
if(isset($league_TradeToolStatus) && $league_TradeToolStatus != 0) echo '<a class="tooltip" href="trade.php"><img class="menu2" src="images/design/trade.png" alt="'.$langPosition[101].'"><span class="tooltiptext">'.$langPosition[101].'</span></a>';
if(isset($league_UFAToolStatus) && $league_UFAToolStatus != 0) echo '<a class="tooltip" href="ufa.php"><img class="menu2" src="images/design/ufa.png" alt="'.$langPosition[102].'"><span class="tooltiptext">'.$langPosition[102].'</span></a>';
if(isset($league_position) && $league_position == 1) echo '<a class="tooltip" href="position.php"><img class="menu2" src="images/design/position.png" alt="'.$langPosition[103].'"><span class="tooltiptext">'.$langPosition[103].'</span></a>';
if($league_poll_active == 1) echo '<a class="tooltip" href="poll.php"><img class="menu2" src="images/design/poll.png" alt="'.$langPosition[104].'"><span class="tooltiptext">'.$langPosition[104].'</span></a>';

echo '<br><br>';


if ( isset($_GET['year']) || isset($_POST['year']) ) {
	$currentYear = ( isset($_GET['year']) ) ? $_GET['year'] : $_POST['year'];
	$currentYear = htmlspecialchars($currentYear);
}

if ( isset($_GET['team']) || isset($_POST['team']) ) {
	$currentTeam = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
	$currentTeam = htmlspecialchars($currentTeam);
	if($currentTeam == "") unset($currentTeam);
}

echo '<br><b>'.$langPosition[0].'</b><br>';

include 'login/mysqli.php';

$sql = "SELECT YEAR(`DATE`) FROM `".$db_table."_position` GROUP BY YEAR(`DATE`) ORDER BY `DATE` DESC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if(mysqli_num_rows($query) != 0) {
	while($data = mysqli_fetch_array($query)) {
		$DB_YR[] = $data['YEAR(`DATE`)'];
	}

	$sqlYear = $DB_YR[0];
	if(isset($currentYear)) $sqlYear = $currentYear;
	$sqlTeam = "";
	if(isset($currentTeam)) $sqlTeam = "`TEAM` = '".$currentTeam."' AND ";
	$sql = "SELECT * FROM `".$db_table."_position` WHERE ".$sqlTeam."`DATE` >= '".$sqlYear."-01-01 00:00:00' AND `DATE` <= '".$sqlYear."-12-31 23:59:59' ORDER BY `ID` DESC";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	if(mysqli_num_rows($query) != 0) {
		while($data = mysqli_fetch_array($query)) {
			$DB_ID[] = $data['ID'];
			$DB_DT[] = $data['DATE'];
			$DB_NM[] = $data['NAME'];
			$DB_TM[] = $data['TEAM'];
			if($data['POS_BF'] == '00') $DB_BF[] = $langPosition[1];
			if($data['POS_BF'] == '01') $DB_BF[] = $langPosition[2];
			if($data['POS_BF'] == '02') $DB_BF[] = $langPosition[3];
			if($data['POS_BF'] == '03') $DB_BF[] = $langPosition[4];
			if($data['POS_BF'] == '04') $DB_BF[] = $langPosition[5];
			if($data['POS_AF'] == '00') $DB_AF[] = $langPosition[1];
			if($data['POS_AF'] == '01') $DB_AF[] = $langPosition[2];
			if($data['POS_AF'] == '02') $DB_AF[] = $langPosition[3];
			if($data['POS_AF'] == '03') $DB_AF[] = $langPosition[4];
			if($data['POS_AF'] == '04') $DB_AF[] = $langPosition[5];
		}
	}
	
	$sql = "SELECT `TEAM` FROM `".$db_table."_position` WHERE `DATE` >= '".$sqlYear."-01-01 00:00:00' AND `DATE` <= '".$sqlYear."-12-31 23:59:59' GROUP BY `TEAM` ORDER BY `TEAM` ASC";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	if(mysqli_num_rows($query) != 0) {
		while($data = mysqli_fetch_array($query)) {
			$DB_LSTM[] = $data['TEAM'];
		}
	}
}

mysqli_close($con);
?>
<br>
<form id="positionForm" method="post" enctype="multipart/form-data" action="position.php">
<span style="margin-right:15px;"><?php echo $langPosition[13]; ?></span>
<select id="selectYear" onchange="javascript:sortYear();">
<?php
if(isset($DB_YR)) {
	for($i=0; $i<count($DB_YR);$i++){
		$currentYearSelected = '';
		if(isset($currentYear) && $currentYear == $DB_YR[$i]) $currentYearSelected = ' selected';
?>
	<option value="<?php echo $DB_YR[$i]; ?>"<?php echo $currentYearSelected; ?>><?php echo $DB_YR[$i]; ?></option>
<?php
	}
}
?>
</select>
<select id="selectTeam" onchange="javascript:sortTeam();">
<option value=""><?php echo $langPosition[14]; ?></option>
<?php
if(isset($DB_LSTM)) {
	for($i=0; $i<count($DB_LSTM);$i++){
		$currentTeamSelected = '';
		if(isset($currentTeam) && $currentTeam == $DB_LSTM[$i]) $currentTeamSelected = ' selected';
?>
	<option value="<?php echo $DB_LSTM[$i]; ?>"<?php echo $currentTeamSelected; ?>><?php echo $DB_LSTM[$i]; ?></option>
<?php
	}
}
?>
</select>
</form>
<br>
<table class="table">
	<tr class="tr">
		<td><?php echo $langPosition[6]; ?></td>
		<td><?php echo $langPosition[7]; ?></td>
		<td><?php echo $langPosition[8]; ?></td>
		<td colspan="3" style="text-align:center;"><?php echo $langPosition[12]; ?></td>
	</tr>
<?php
$colorRow = 2;
if(isset($DB_ID)) {
for($i=0; $i<count($DB_ID);$i++){
	if($colorRow == 1) $colorRow = 2;
	else $colorRow = 1;
?>
	<tr class="tr_content<?php echo $colorRow; ?>">
		<td><?php echo $DB_DT[$i]; ?></td>
		<td><?php echo $DB_NM[$i]; ?></td>
		<td><?php echo $DB_TM[$i]; ?></td>
		<td style="text-align:right;"><?php echo $DB_BF[$i]; ?></td>
		<td><i style="margin-left:2px; margin-right:4px; border: solid #<?php echo $databaseColors['colorMainText']; ?>; border-width: 0 3px 3px 0; display: inline-block; padding: 3px; transform: rotate(-45deg); -webkit-transform: rotate(-45deg);"></i></td>
		<td style="text-align:left;"><?php echo $DB_AF[$i]; ?></td>
	</tr>
<?php
}
}
?>
</table>


</body>
</html>