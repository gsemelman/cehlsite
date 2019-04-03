<?php
include GMO_ROOT.'login/mysqli.php';

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

if($league_TradeToolStatus == 2) {
	$sql = "SELECT * FROM `".$db_table."_trade` WHERE `APPROVAL` = '0000-00-00 00:00:00' AND `DATE2` != '0000-00-00 00:00:00'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	$league_TradePendingRows = mysqli_num_rows($query);
}
if($league_TradeToolStatus > 0) {
	$sql = "SELECT `INT` FROM `".$db_table."_trade`";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	$league_TradeRows = mysqli_num_rows($query);
}
if($league_UFAToolStatus == 2) {
	$sql = "SELECT * FROM `".$db_table."_ufalistsend` WHERE `APPR` = '0'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	$league_UFAPendingRows = mysqli_num_rows($query);
}
mysqli_close($con);

echo '<div style="font-size:20px;">';
echo '<br><b>'.$db_admin_menu_langue[0].'</b><br>';
echo '<a href="?admin=userpass#Admin">'.$db_admin_menu_langue[1].'</a><br>';
echo '<a href="?admin=param#Admin">'.$db_admin_menu_langue[9].'</a><br>';
echo '<a href="?admin=upload#Admin">'.$db_admin_menu_langue[10].'</a><br>';
if($league_TradeToolStatus > 0) echo '<a href="?admin=trademan#Admin">'.$db_admin_menu_langue[15].' ('.$league_TradeRows.')</a><br>';
if($league_TradeToolStatus == 2) echo '<a href="?admin=trade#Admin">'.$db_admin_menu_langue[12].' ('.$league_TradePendingRows.')</a><br>';
if($league_UFAToolStatus == 2) echo '<a href="?admin=ufa#Admin">'.$db_admin_menu_langue[13].'</a><br>';
if($league_UFAToolStatus == 2) echo '<a href="?admin=ufasign#Admin">'.$db_admin_menu_langue[14].' ('.$league_UFAPendingRows.')</a><br>';
if($league_position == 1) echo '<a href="?admin=position#Admin">'.$db_admin_menu_langue[17].'</a><br>';
echo '<a href="?admin=tickets#Admin">Ticket Changes</a><br>';
echo '<a href="?admin=playerRelease#Admin">Player Release</a><br>';

echo '<br><b>'.$db_admin_menu_langue[2].'</b><br>';
echo '<a href="?admin=noms#Admin">'.$db_admin_menu_langue[3].'</a><br>';
echo '<a href="?admin=fhlteam#Admin">'.$db_admin_menu_langue[6].'</a><br>';
echo '<a href="?admin=triche#Admin">'.$db_admin_menu_langue[4].'</a><br>';
echo '<a href="?admin=actif#Admin">'.$db_admin_menu_langue[5].'</a><br>';
echo '<a href="?admin=colors#Admin">'.$db_admin_menu_langue[16].'</a><br>';
echo '<a href="?admin=poll#Admin">'.$db_admin_menu_langue[18].'</a><br>';
echo '<a href="?admin=first#Admin">'.$db_admin_menu_langue[11].'</a><br>';


echo '-----------------<br>';
echo '<a href="?admin=pass#Admin">'.$db_admin_menu_langue[7].'</a><br>';
echo '<a href="'.BASE_URL.'gmo/login/logout.php">'.$db_admin_menu_langue[8].'</a><br>';
echo '</div>';
?>