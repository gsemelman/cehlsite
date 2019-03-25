<!DOCTYPE html>
<html>
<head>
<title>OGME - Poll</title>
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
	$langPoll[0] = 'Vote';
	$langPoll[1] = 'TRIER PAR';
	$langPoll[2] = 'Aucun Vote';
	$langPoll[3] = 'votes';
	$langPoll[100] = 'Menu Principal';
	$langPoll[101] = 'Page des échanges';
	$langPoll[102] = 'Page des signatures';
	$langPoll[103] = 'Page des changements de position';
	$langPoll[104] = 'Page des votes';
}

if($league_langue == "en") {
	$langPoll[0] = 'Poll';
	$langPoll[1] = 'SORT BY';
	$langPoll[2] = 'No Poll';
	$langPoll[3] = 'votes';
	$langPoll[100] = 'Home';
	$langPoll[101] = 'Trade Page';
	$langPoll[102] = 'Signing Page';
	$langPoll[103] = 'Position Change Page';
	$langPoll[104] = 'Poll Page';
}
?>

<script type="text/javascript" language="JavaScript">
<!--

function sortYear() {
	var tmpYear = document.getElementById('selectYear').value;
	document.getElementById('pollForm').action = "poll.php?year="+tmpYear;
	document.getElementById('pollForm').submit();
}

function sortPoll() {
	var tmpYear = document.getElementById('selectYear').value;
	var tmpPoll = encodeURIComponent(document.getElementById('selectPoll').value);
	if(tmpPoll != "") {
		document.getElementById('pollForm').action = "poll.php?year="+tmpYear+"&poll="+tmpPoll;
		document.getElementById('pollForm').submit();
	}
}

//-->
</script>

</head>
<body>
<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

echo '<a class="tooltip" href="index.php"><img class="menu2" src="images/design/home.png" alt="'.$langPoll[100].'"><span class="tooltiptext">'.$langPoll[100].'</span></a>';
if(isset($league_TradeToolStatus) && $league_TradeToolStatus != 0) echo '<a class="tooltip" href="trade.php"><img class="menu2" src="images/design/trade.png" alt="'.$langPoll[101].'"><span class="tooltiptext">'.$langPoll[101].'</span></a>';
if(isset($league_UFAToolStatus) && $league_UFAToolStatus != 0) echo '<a class="tooltip" href="ufa.php"><img class="menu2" src="images/design/ufa.png" alt="'.$langPoll[102].'"><span class="tooltiptext">'.$langPoll[102].'</span></a>';
if(isset($league_position) && $league_position == 1) echo '<a class="tooltip" href="position.php"><img class="menu2" src="images/design/position.png" alt="'.$langPoll[103].'"><span class="tooltiptext">'.$langPoll[103].'</span></a>';
if($league_poll_active == 1) echo '<a class="tooltip" href="poll.php"><img class="menu2" src="images/design/poll.png" alt="'.$langPoll[104].'"><span class="tooltiptext">'.$langPoll[104].'</span></a>';

echo '<br><br>';

if ( isset($_GET['year']) || isset($_POST['year']) ) {
	$currentYear = ( isset($_GET['year']) ) ? $_GET['year'] : $_POST['year'];
	$currentYear = htmlspecialchars($currentYear);
}

if ( isset($_GET['poll']) || isset($_POST['poll']) ) {
	$currentPoll = ( isset($_GET['poll']) ) ? $_GET['poll'] : $_POST['poll'];
	$currentPoll = htmlspecialchars($currentPoll);
	if($currentPoll == "") unset($currentPoll);
}

include 'login/mysqli.php';

$sql = "SELECT YEAR(`DATE`) FROM `".$db_table."_poll` GROUP BY YEAR(`DATE`) ORDER BY `DATE` DESC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if(mysqli_num_rows($query) != 0) {
	while($data = mysqli_fetch_array($query)) {
		$DB_YR[] = $data['YEAR(`DATE`)'];
	}

	$sqlYear = $DB_YR[0];
	if(isset($currentYear)) $sqlYear = $currentYear;
	$sql = "SELECT * FROM `".$db_table."_poll` WHERE `DATE` >= '".$sqlYear."-01-01 00:00:00' AND `DATE` <= '".$sqlYear."-12-31 23:59:59' ORDER BY `ID` DESC";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	if(mysqli_num_rows($query) != 0) {
		while($data = mysqli_fetch_array($query)) {
			$DB_ID[] = $data['ID'];
			$DB_QT[] = $data['QUESTION'];
		}
	}
	
	$sqlPoll = $DB_ID[0];
	if(isset($currentPoll)) $sqlPoll = $currentPoll;
	if(!isset($currentPoll)) $currentPoll = $DB_ID[0];
	$sql = "SELECT * FROM `".$db_table."_poll` WHERE `ID` = '$sqlPoll' LIMIT 1";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	if(mysqli_num_rows($query) != 0) {
		while($data = mysqli_fetch_array($query)) {
			$DB_MOD_DT_ST = $data['DATE'];
			$DB_MOD_DT_EN = $data['DATE_END'];
			$DB_MOD_QT = $data['QUESTION'];
			$DB_MOD_OPTIONS = explode("|$|",$data['OPTIONS']);
			$DB_MOD_VOTES = explode("|$|",$data['VOTES']);
		}
		$DB_MOD_TOT_VOTES = array_sum($DB_MOD_VOTES);
	}
}

mysqli_close($con);
?>
<br><b><?php echo $langPoll[0]; ?></b><br>
<br>
<form id="pollForm" method="post" enctype="multipart/form-data" action="poll.php">
<span style="margin-right:15px;"><?php echo $langPoll[1]; ?></span>
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
else {
?>
	<option value=""><?php echo $langPoll[2]; ?></option>
<?php
}
?>
</select>
<select id="selectPoll" onchange="javascript:sortPoll();">
<?php
if(isset($DB_ID)) {
	for($i=0; $i<count($DB_ID);$i++){
		$currentPollSelected = '';
		if(isset($currentPoll) && $currentPoll == $DB_ID[$i]) $currentPollSelected = ' selected';
?>
	<option value="<?php echo $DB_ID[$i]; ?>"<?php echo $currentPollSelected; ?>><?php echo $DB_QT[$i]; ?></option>
<?php
	}
}
?>
</select>
</form>
<?php
if(isset($DB_MOD_QT)) {
?>
<div style="margin-top:25px; margin-left:5px; margin-right:5px; border-radius: 4px; width:300px; border:1px solid #<?php echo $databaseColors['colorInputBorder']; ?>">
	<div style="width:95%; margin-left:auto; margin-right:auto;">
	<div style="font-weight:bold; margin-top:15px; margin-bottom:15px;"><?php echo $DB_MOD_QT; ?></div>
<?php
	for($i=0;$i<count($DB_MOD_OPTIONS);$i++) {
		if($DB_MOD_VOTES[$i] == '') $DB_MOD_VOTES[$i] = 0;
		if($DB_MOD_VOTES[$i] != 0) {
			$DB_MOD_PCT_DISP = $DB_MOD_VOTES[$i] / $DB_MOD_TOT_VOTES * 100;
			$DB_MOD_PCT = round($DB_MOD_VOTES[$i] / $DB_MOD_TOT_VOTES * 100, 1);
		}
		else {
			$DB_MOD_PCT_DISP = 1;
			$DB_MOD_PCT = 0;
		}
?>
	
		<div style="float:left; margin-bottom:2px;"><?php echo $DB_MOD_OPTIONS[$i]; ?></div>
		<div style="float:right; margin-bottom:2px;"><?php echo $DB_MOD_PCT.'% - '.$DB_MOD_VOTES[$i]; ?></div>
		<div style="clear:both; width:100%; border-radius: 4px; border:1px solid #<?php echo $databaseColors['colorInputBorder']; ?>; margin-bottom:15px;">
			<div style="width:<?php echo $DB_MOD_PCT_DISP; ?>%; background-color:#<?php echo $databaseColors['colorInputBorder']; ?>; height:15px;"></div>
		</div>
	
<?php
	}
?>
		<div style="margin-bottom:15px;">Total: <?php echo $DB_MOD_TOT_VOTES; ?> <?php echo $langPoll[3]; ?><br><?php echo $DB_MOD_DT_ST." - ".$DB_MOD_DT_EN; ?></div>
	</div>
</div>
<?php
}
?>

<br>

</body>
</html>