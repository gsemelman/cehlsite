<?php
//error_reporting(E_ALL);
//ini_set("display_errors", "On");

// include GMO_ROOT.'login/mysqli.php';

include GMO_ROOT.'editor/lang.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
	    $file_folder = GMO_ROOT.$data['VALUE'];
	}
}

// $sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_last_update' LIMIT 1";
// $query = mysqli_query($con, $sql) or die(mysqli_error($con));
// if($query){
// 	while($data = mysqli_fetch_array($query)) {
// 		$file_lastUpdate = $data['VALUE'];
// 	}
// }

// mysqli_close($con);

// // Find the .ros and .tms
// $matches = glob($file_folder.'*.ros');
// if(isset($matches) && count($matches)) {
// 	$matchesDate = array_map('filemtime', $matches);
// 	arsort($matchesDate);
// 	foreach ($matchesDate as $j => $val) {
// 		break 1;
// 	}
// 	if(substr_count($matches[$j],"/")) $file_ros = substr($matches[$j],strrpos($matches[$j],"/")+1);
// 	else $file_ros = $matches[$j];
// }
// $matches = glob($file_folder.'*.tms');
// if(isset($matches) && count($matches)) {
// 	$matchesDate = array_map('filemtime', $matches);
// 	arsort($matchesDate);
// 	foreach ($matchesDate as $j => $val) {
// 		break 1;
// 	}
// 	if(substr_count($matches[$j],"/")) $file_tms = substr($matches[$j],strrpos($matches[$j],"/")+1);
// 	else $file_tms = $matches[$j];
// }

// // Update the .ros if new
// if(isset($file_ros) && isset($file_tms)) {
// 	$file_date = date ("Y-m-d H:i:s", filemtime($file_folder.$file_ros));
	
// 	error_log("checking for new new files!!!!!",0);
	
// 	$d1 = new DateTime($file_date);
// 	$d2 = new DateTime($file_lastUpdate);

	
// 	if($d1 > $d2) {
// 	    error_log("loading new files!!!!!",0);
// 	    include GMO_ROOT.'editor/file_to_sql.php';
// 		$txtFileUpdated =  $db_membre_File_Update[1].'<br><br>';
// 		error_log("new files loaded!!!!!",0);
// 	}
// }
// else {
// 	$error = '<br>'.$db_membre_File_Update[0].'<br>';
// 	die($error);
// }


?>


<?php
include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder_lines' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
	    $file_folder_lines = GMO_ROOT.$data['VALUE'];
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

// require_once 'config.php';
// include_once 'lang.php';
// include_once 'common.php';
// include_once 'nav.php';

// echo '<div class="header-content top-container"></div>';

include GMO_ROOT.'css.php'; // Styling Pages

include GMO_ROOT.'membre/js.php';

$divMaxWidth = "width:100%";

$modeGMO = 1;
//$linesGame = 1;
if(isset($_GET['lines']) || isset($_POST['lines'])) {
    $modeGMO = ( isset($_GET['lines']) ) ? $_GET['lines'] : $_POST['lines'];
    $modeGMO = htmlspecialchars($modeGMO);
    
//     if(isset($_GET['game']) || isset($_POST['game'])) {
//         $linesGame =( isset($_GET['game']) ) ? $_GET['game'] : $_POST['game'];
//         $linesGame = htmlspecialchars($linesGame);
//     }
}

$linesGame = 1;
if(isset($_GET['game']) || isset($_POST['game'])) {
    $linesGame =( isset($_GET['game']) ) ? $_GET['game'] : $_POST['game'];
    $linesGame = htmlspecialchars($linesGame);
}

?>


<?php 

include_once FS_ROOT.'classes/ScheduleHolder2.php';
error_log($file_folder.'cehl.scx');

$simTeamId = $_SESSION['teamId'] -1;
$scheduleHolder2 = new ScheduleHolder2($file_folder.'cehl.scx');
//$playsGameOne = $scheduleHolder2->playsInDays($_SESSION['teamId'] -1 , 1);
//$playsGameTwo = $scheduleHolder2->playsInDays($_SESSION['teamId'] -1 , 2);

$lastDaySimmed = $scheduleHolder2->getLastDayPlayed();
error_log('---------------------------------------------');
error_log("last played:".$lastDaySimmed);
error_log('---------------------------------------------');
$nextDay = $lastDaySimmed + 1;
$nextDay2 = $lastDaySimmed + 2;

$gameDay1 = $scheduleHolder2->getGameByTeamAndDay($simTeamId , $nextDay);
$gameDay2 = $scheduleHolder2->getGameByTeamAndDay($simTeamId, $nextDay2);
$playsGameOne = !is_null($gameDay1);
$playsGameTwo = !is_null($gameDay2);

$game1Display = 'Day ' . $nextDay;
$game2Display = 'Day ' . $nextDay2;

$vsTeam1 = '';
$vsTeam2 = '';

$game1Day = $lastDaySimmed + 1;
$game2Day = 0;

if($playsGameOne){
    
    $opponent1Id = $gameDay1['HOME'] !== $simTeamId ? $gameDay1['HOME'] : $gameDay1['AWAY'];

    include GMO_ROOT.'login/mysqli.php';
    
    error_log('--------------------------------------------------------');
    error_log('game 1 team:'.$opponent1Id);
    error_log('--------------------------------------------------------');
    $sql = "SELECT EQUIPE FROM ".$db_table." WHERE `RANK` = ".$opponent1Id." LIMIT 1";
    
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if($query){
        while($data = mysqli_fetch_array($query)) {
            $vsTeam1 = $data['EQUIPE'];
        }
    }
    
    error_log('--------------------------------------------------------');
    error_log('game 1 team:'.$vsTeam1);
    error_log('--------------------------------------------------------');
    
    mysqli_close($con);
    
    $game1Display = $game1Display.' ('.$vsTeam1.')';
    $game1Day = $gameDay1['DAY'];
}else{
    $game1Display = $game1Display. ' (No Game)';
}

if($playsGameTwo){
    
    $opponent2Id = $gameDay2['HOME'] != $simTeamId ? $gameDay2['HOME'] : $gameDay2['AWAY'];
    
    include GMO_ROOT.'login/mysqli.php';
    
    error_log('--------------------------------------------------------');
    error_log('game 2 team id:'.$opponent2Id);
    error_log('--------------------------------------------------------');
    $sql = "SELECT EQUIPE FROM ".$db_table." WHERE `RANK` = ".$opponent2Id." LIMIT 1";
    error_log($sql);
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if($query){
        while($data = mysqli_fetch_array($query)) {
            $vsTeam2 = $data['EQUIPE'];
        }
    }
    
    error_log('--------------------------------------------------------');
    error_log('game 2 team:'.$vsTeam2);
    error_log('--------------------------------------------------------');
    
    mysqli_close($con);
    
    $game2Display = $game2Display.' ('.$vsTeam2.')';
    $game2Day = $gameDay2['DAY'];
}else{
    $game2Display = $game2Display. ' (No Game)';
}

//set active game day for use when uploading (teamLines_js)
$activeGameDay = $linesGame == 1 ? $game1Day : $game2Day;
?>

<?php 
if($modeGMO == 1) {
    include GMO_ROOT.'editor/teamRoster_js.php';
    $divMaxWidth = "max-width:530px";
}
if($modeGMO == 2) {
    include GMO_ROOT.'editor/teamLines_js.php';
    $divMaxWidth = "max-width:530px";
}

?>

<!-- </head> -->
<!-- <body> -->

<!--<div id="popupAlert" style="display:none; position:fixed; top:60px; left:50%; transform: translateX(-50%); width:50%; z-index:20; text-align:center; padding:20px; background-color:#ae654c; color:#ffffff; font-weight:bold; border-radius:10px; border:0px;"></div>-->

<div id="popupAlert" class="popupAlert-fixed"></div>

<?php

if($db_lang == "en") $chg_lang = "fr";
else $chg_lang = "en";

?>

<style>

.popupAlert-fixed {
    display:none; 
    position:fixed; 
    top:60px; 
    left:50%;
    transform: translateX(-50%); 
    text-align:center; 
    padding:20px; 
    background-color:#ae654c;
    color:#ffffff;
    font-weight:bold; 
    border-radius:10px; 
    border:0px;
/*     width: 75%; */
    z-index:9999; 
}

</style>

<div style="margin-top:10px; margin-left:auto; margin-right:auto; <?php echo $divMaxWidth; ?>;">

<?php

if(isset($txtFileUpdated)) echo $txtFileUpdated;

//if ( $mode == 'gmonline' ) include GMO_ROOT.'editor/index.php';
include GMO_ROOT.'editor/index.php';

?>
</div>
