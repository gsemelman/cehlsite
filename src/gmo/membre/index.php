<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
	    $file_folder = GMO_ROOT.$data['VALUE'];
	}
}

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_last_update' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$file_lastUpdate = $data['VALUE'];
	}
}

mysqli_close($con);

// Find the .ros and .tms
$matches = glob($file_folder.'*.ros');
if(isset($matches) && count($matches)) {
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		break 1;
	}
	if(substr_count($matches[$j],"/")) $file_ros = substr($matches[$j],strrpos($matches[$j],"/")+1);
	else $file_ros = $matches[$j];
}
$matches = glob($file_folder.'*.tms');
if(isset($matches) && count($matches)) {
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		break 1;
	}
	if(substr_count($matches[$j],"/")) $file_tms = substr($matches[$j],strrpos($matches[$j],"/")+1);
	else $file_tms = $matches[$j];
}

// Update the .ros if new
if(isset($file_ros) && isset($file_tms)) {
	$file_date = date ("Y-m-d H:i:s", filemtime($file_folder.$file_ros));
	
	error_log("checking for new new files!!!!!",0);
	
	$d1 = new DateTime($file_date);
	$d2 = new DateTime($file_lastUpdate);

	
	if($d1 > $d2) {
	    error_log("loading new files!!!!!",0);
	    include GMO_ROOT.'editor/file_to_sql.php';
		$txtFileUpdated =  $db_membre_File_Update[1].'<br><br>';
		error_log("new files loaded!!!!!",0);
	}
}
else {
	$error = '<br>'.$db_membre_File_Update[0].'<br>';
	die($error);
}



if(!isset($_GET['membre']) && !isset($_POST['membre'])) {
	$mode = 'gmonline';
}
else {
	$mode = ( isset($_GET['membre']) ) ? $_GET['membre'] : $_POST['membre'];
	$mode = htmlspecialchars($mode);
}


$title = 0;

if ( $mode == 'gmonline' ) $title = 1;
?>


<?php
include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder_lines' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$file_folder_lines = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_cap' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_cap = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_capType' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_capType = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_capInjured' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_capInjured = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_GameInProPayroll' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_GameInProPayroll = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_players' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_players = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_MaxPlayers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_MaxPlayers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_FarmMaxOV' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_FarmMaxOV = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_AgeExemptFarmMaxOV' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_AgeExemptFarmMaxOV = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_FarmMaxAge' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_FarmMaxAge = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_GameInProWaivers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_GameInProWaivers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_AgeExemptWaivers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_AgeExemptWaivers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_OVSkatersWaivers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_OVSkatersWaivers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_OVGoaliesWaivers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_OVGoaliesWaivers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_gmeditor' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_gmeditor = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_SalaryWaivers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_SalaryWaivers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_TradeToolStatus' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_TradeToolStatus = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_TradeToolOtherMandatory' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_TradeToolOtherMandatory = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_UFAToolStatus' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_UFAToolStatus = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_editorPassword' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_editorPassword = "";
		if($data['VALUE'] == 1) $league_editorPassword = " display:none;";
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_position' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_position = $data['VALUE'];
	}
}

$sql = "SELECT `SORT_PLAYER` FROM `$db_table` WHERE `INT` = '$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$gm_sortPlayer = $data['SORT_PLAYER'];
	}
}


mysqli_close($con);

$tableau_ligne2 = "#B0D6FF"; // #B0D6FF
$tableau_ligne1 = "#E1EFFF"; // #E1EFFF
$tableau_soustitre = "#1791CA"; // #1791CA
$tableau_titre1 = "#1B9DD4"; // #1B9DD4
$tableau_titre2 = "#014A92"; // #014A92

// include_once 'config.php';
// include_once 'lang.php';
// include_once 'common.php';
// include_once 'nav.php';

// echo '<div class="header-content top-container"></div>';

include GMO_ROOT.'css.php'; // Styling Pages

include GMO_ROOT.'membre/js.php';

$divMaxWidth = "width:100%";
if ( $mode == 'gmonline' ) {
	$modeGMO = 1;
	if(isset($_GET['lines']) || isset($_POST['lines'])) {
		$modeGMO = ( isset($_GET['lines']) ) ? $_GET['lines'] : $_POST['lines'];
		$modeGMO = htmlspecialchars($modeGMO);
	}

	include GMO_ROOT.'editor/lang.php';
	if($modeGMO == 1) {
	    include GMO_ROOT.'editor/teamRoster_js.php';
		$divMaxWidth = "max-width:530px";
	}
	if($modeGMO == 2) {
	    include GMO_ROOT.'editor/teamLines_js.php';
		$divMaxWidth = "max-width:530px";
	}
}

?>

</head>
<body>

<div id="popupAlert" style="display:none; position:fixed; top:60px; left:50%; transform: translateX(-50%); width:50%; z-index:20; text-align:center; padding:20px; background-color:#ae654c; color:#ffffff; font-weight:bold; border-radius:10px; border:0px;"></div>

<?php

if($db_lang == "en") $chg_lang = "fr";
else $chg_lang = "en";

?>



<div style="margin-top:10px; margin-left:auto; margin-right:auto; <?php echo $divMaxWidth; ?>;">

<?php

if(isset($txtFileUpdated)) echo $txtFileUpdated;

if ( $mode == 'gmonline' ) include GMO_ROOT.'editor/index.php';

echo '</div>';
?>

