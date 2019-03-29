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

//override TODO:FIX HARD CODED
//$file_folder = FS_ROOT.'league_files/';
//$file_folder = FS_ROOT.'gmo/files/';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_last_update' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$file_lastUpdate = $data['VALUE'];
	}
}
$league_poll_active = 0;
$query = mysqli_query($con, "SELECT `ID` FROM `".$db_table."_poll` LIMIT 0,1");
if(mysqli_num_rows($query) != 0) {
	$league_poll_active = 1;
	$query = mysqli_query($con, "SELECT `ID` FROM `".$db_table."_poll` WHERE `DATE_END` >= '$date_time' AND `VOTERS` NOT LIKE '%".$teamFHLSimName."%' LIMIT 0,1");
	if(mysqli_num_rows($query) != 0) {
		$league_poll_active = 2;
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
	
	error_log("checking for new new files!!!!!");
	
	$d1 = new DateTime($file_date);
	$d2 = new DateTime($file_lastUpdate);
	
	error_log($d1);
	error_log($d2);
	
	if($d1 > $d2) {
	    include GMO_ROOT.'editor/file_to_sql.php';
		$txtFileUpdated =  $db_membre_File_Update[1].'<br><br>';
		error_log("loading new files!!!!!");
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
if($league_poll_active == 2) $mode = 'poll';

$title = 0;

if ( $mode == 'gmonline' ) $title = 1;
if ( $mode == 'settings' ) $title = 13;
if ( $mode == 'send' ) $title = 2;
if ( $mode == 'trade' ) $title = 7;
if ( $mode == 'test' ) $title = 14;
if ( $mode == 'ufa' ) $title = 8;
if ( $mode == 'ufaSignManager') $title = 8;
if ( $mode == 'tradeManager') $title = 7;
if ( $mode == 'ufaListManager') $title = 8;
if ( $mode == 'historyTradeManager') $title = 7;
if ( $mode == 'league') $title = 15;
if ( $mode == 'ov') $title = 16;
if ( $mode == 'position') $title = 17;
if ( $mode == 'poll') $title = 18;
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

$sql = "SELECT `UFA_LIST_MANAGER`, `UFA_SIGN_MANAGER`, `TRADE_MANAGER`, `HISTORY_TRADE_MANAGER`, `SORT_PLAYER` FROM `$db_table` WHERE `INT` = '$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$gm_ufaSignMan = $data['UFA_SIGN_MANAGER'];
		$gm_tradeMan = $data['TRADE_MANAGER'];
		$gm_ufaListMan = $data['UFA_LIST_MANAGER'];
		$gm_historyTradeMan = $data['HISTORY_TRADE_MANAGER'];
		$gm_sortPlayer = $data['SORT_PLAYER'];
	}
}


// Trade - Waiting Offer
if(isset($league_TradeToolStatus) && $league_TradeToolStatus == 2) {
	$sql = "SELECT * FROM `".$db_table."_trade` WHERE `DATE2` = '0000-00-00 00:00:00' AND `TEAM2` = '$teamFHLSimName'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	$tradeWaitingOffer = mysqli_num_rows($query);
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
if ( $mode == 'trade' ) include GMO_ROOT.'trade/js.php';
if ( $mode == 'ufa' ) include GMO_ROOT.'ufa/js.php';

if ( $mode == 'ufaListManager' && $gm_ufaListMan == 1 ) {
    include GMO_ROOT.'admin/lang.php';
    include GMO_ROOT.'admin/ufa_js.php';
}
if ( $mode == 'tradeManager' && $gm_tradeMan == 1 ) {
    include GMO_ROOT.'admin/lang.php';
    include GMO_ROOT.'admin/trade_js.php';
}
if ( $mode == 'ufaSignManager' && $gm_ufaSignMan == 1 ) {
    include GMO_ROOT.'admin/lang.php';
    include GMO_ROOT.'admin/ufaSign_js.php';
}
if ( $mode == 'historyTradeManager' && $gm_historyTradeMan == 1 ) {
    include GMO_ROOT.'admin/lang.php';
    include GMO_ROOT.'admin/tradeMan_js.php';
}

if ( $mode == 'settings') $divMaxWidth = "max-width:530px";
if ( $mode == 'send') $divMaxWidth = "max-width:530px";
if ( $mode == 'league') $divMaxWidth = "max-width:530px";
if ( $mode == 'ov') $divMaxWidth = "max-width:250px";
if ( $mode == 'trade') $divMaxWidth = "max-width:530px";
if ( $mode == 'position') $divMaxWidth = "max-width:250px";
if ( $mode == 'poll') $divMaxWidth = "max-width:300px";
?>

</head>
<body>

<!--  <div id="popupAlert" style="display:none; position:fixed; top:5px; left:50%; transform: translateX(-50%); width:85%; z-index:20; text-align:center; padding:20px; background-color:#ae654c; color:#ffffff; font-weight:bold; border-radius:10px; border:0px;"></div>-->
<div id="popupAlert" style="display:none; position:fixed; top:60px; left:50%; transform: translateX(-50%); width:50%; z-index:20; text-align:center; padding:20px; background-color:#ae654c; color:#ffffff; font-weight:bold; border-radius:10px; border:0px;"></div>


<!-- <div style="width:100%; height:60px; box-shadow: 0px 5px 5px #<?php echo $databaseColors['colorMenuBackground']; ?>; background-color:#<?php echo $databaseColors['colorMenuBackground']; ?>; position:fixed; top:0px; left:0px; z-index:1;">
	<img class="menu" src="images/design/menu.png" alt="Menu" onclick="javascript:showMenu();" style="display:block; float:left; cursor:pointer;">
	<div style="float:left; margin-left:5px; position:relative; top:13px; height:60px; width:190px; overflow:hidden; color:#<?php echo $databaseColors['colorMenuText']; ?>"><?php echo $teamFullName; ?><br><?php echo $league_name; ?></div>
	<a href="login/logout.php"><img class="menu" src="images/design/logout.png" alt="<?php echo $db_membre_menu_langue[4]; ?>" style="display:block; float:right;"></a>
</div> -->

<!--<div style="width:100%; height:60px; box-shadow: 0px 5px 5px #<?php echo $databaseColors['colorMenuBackground']; ?>; background-color:#<?php echo $databaseColors['colorMenuBackground']; ?>;">
	<a href="gmo/login/logout.php"><img class="menu" src="gmo/images/design/logout.png" alt="<?php echo $db_membre_menu_langue[4]; ?>" style="display:block; float:right;"></a>
 </div> -->

<?php

if($db_lang == "en") $chg_lang = "fr";
else $chg_lang = "en";

$classMenu1 = $classMenu2 = $classMenu3 = $classMenu4 = $classMenu5 = $classMenu6 = $classMenu7 = $classMenu8 = $classMenu9 = $classMenu10 = $classMenu11 = $classMenu12 = $classMenu13 = $classMenu14 = "";
if ( $mode == 'gmonline' ) $classMenu1 = "active";
if ( $mode == 'settings') $classMenu2 = "active";
if ( $mode == 'send' AND $league_gmeditor ) $classMenu3 = "active";
if ( $mode == 'trade' && $league_TradeToolStatus == 2) $classMenu4 = "active";
if ( $mode == 'test') $classMenu5 = "active";
if ( $mode == 'ufa' && $league_UFAToolStatus == 2) $classMenu6 = "active";
if ( $mode == 'ufaSignManager' && $gm_ufaSignMan == 1) $classMenu7 = "active";
if ( $mode == 'tradeManager' && $gm_tradeMan == 1) $classMenu8 = "active";
if ( $mode == 'ufaListManager' && $gm_ufaListMan == 1) $classMenu9 = "active";
if ( $mode == 'historyTradeManager' && $gm_historyTradeMan == 1) $classMenu10 = "active";
if ( $mode == 'league') $classMenu11 = "active";
if ( $mode == 'ov') $classMenu12 = "active";
if ( $mode == 'position') $classMenu13 = "active";
if ( $mode == 'poll') $classMenu14 = "active";
?>



<div style="margin-top:10px; margin-left:auto; margin-right:auto; <?php echo $divMaxWidth; ?>;">

<?php

if(isset($txtFileUpdated)) echo $txtFileUpdated;

if ( $mode == 'gmonline' ) include GMO_ROOT.'editor/index.php';
if ( $mode == 'send' AND $league_gmeditor ) include GMO_ROOT.'membre/send.php';
if ( $mode == 'settings' ) include GMO_ROOT.'membre/settings.php';
if ( $mode == 'league' ) include GMO_ROOT.'membre/league.php';
if ( $mode == 'ov' ) include GMO_ROOT.'membre/ov.php';
if ( $mode == 'position' ) include GMO_ROOT.'membre/position.php';
if ( $mode == 'poll' ) include GMO_ROOT.'membre/poll.php';

if ( $mode == 'trade' && $league_TradeToolStatus == 2) include GMO_ROOT.'trade/index.php';
if ( $mode == 'test') include GMO_ROOT.'membre/test.php';
if ( $mode == 'ufa' && $league_UFAToolStatus == 2) include GMO_ROOT.'ufa/index.php';


if ( $mode == 'ufaSignManager' && $gm_ufaSignMan == 1) include GMO_ROOT.'admin/ufaSign.php';
if ( $mode == 'tradeManager' && $gm_tradeMan == 1) include GMO_ROOT.'admin/trade.php';
if ( $mode == 'ufaListManager' && $gm_ufaListMan == 1) include GMO_ROOT.'admin/ufaSend.php';
if ( $mode == 'historyTradeManager' && $gm_historyTradeMan == 1) include GMO_ROOT.'admin/tradeMan.php';

echo '</div>';
?>

<script type="text/javascript" language="JavaScript">
<!--

<?php if(isset($league_TradeToolStatus) && $league_TradeToolStatus == 2 && isset($tradeWaitingOffer) && $tradeWaitingOffer != 0) { ?>
// Trade - Waiting Offer Popup
document.addEventListener("DOMContentLoaded", popupAlert("<?php echo $db_membre_trade[37]; ?>", "#95ae4c"));
<?php } ?>

//-->
</script>