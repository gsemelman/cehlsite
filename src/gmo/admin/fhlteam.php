<?php

extract($_POST,EXTR_OVERWRITE);

$message = '';

if(isset($press_drop) && isset($table_drop)){
	include FS_ROOT.'gmo/login/mysqli.php';
	$sql = "DELETE FROM `$db_table` WHERE `INT`='$table_drop'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
	$message = $db_admin_fhlteam_langue[6];
}
if(isset($press_add) && isset($add) && $add != ""){
	$add2 = strtoupper($add);
	include FS_ROOT.'gmo/login/mysqli.php';
	$add = mysqli_real_escape_string($con, $add);
	$add2 = mysqli_real_escape_string($con, $add2);
	$sql = "INSERT INTO `$db_table` (EQUIPE,EQUIPESIM,USER,PASS) VALUES('$add','$add','$add2','none')";
	$sql = "INSERT INTO `$db_table` (
	`EQUIPE`,
	`EQUIPESIM`,
	`DB_USER`, 
	`USER`,
	`PASS`,
	`LANGUE`, 
	`LAST`,
	`IP`,
	`SEND`,
	`HISTORY_TRADE_MANAGER`,
	`TRADE_MANAGER`,
	`UFA_SIGN_MANAGER`,
	`UFA_LIST_MANAGER`,
	`EMAIL`,
	`NOTIFICATION`,
	`RANK`,
	`LNS_DATE`,
	`LNS_FILE`,
	`TMS_LINEUP`
	) VALUES(
	'$add',
	'$add',
	'',
	'$add2',
	'none',
	'$league_langue',
	'0000-00-00 00:00:00',
	'',
	'',
	'0',
	'0',
	'0',
	'0',
	'',
	'1',
	'',
	'0000-00-00 00:00:00',
	'',
	''
	);";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	// Reset the last league file datetime.
	$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='0000-00-00 00:00:00' WHERE `PARAM`='file_last_update'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	mysqli_close($con);
	$message = $db_admin_fhlteam_langue[5]."( ".$add." )";
}
if(isset($changer)) {
	if($mod != "") {
	    include FS_ROOT.'gmo/login/mysqli.php';
		
		$mod = mysqli_real_escape_string($con, $mod);
		$sql = "UPDATE `$db_table` SET `EQUIPESIM`='$mod' WHERE `INT` = '$mod_int'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		
		// Reset the last league file datetime.
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='0000-00-00 00:00:00' WHERE `PARAM`='file_last_update'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		
		mysqli_close($con);
		$message = $db_admin_fhlteam_langue[7];
	}
	else $message2 = $db_admin_fhlteam_langue[10];
}

$i = 0;
include FS_ROOT.'gmo/login/mysqli.php';
$sql = "SELECT `EQUIPESIM`, `INT` FROM `$db_table` WHERE `EQUIPESIM` != 'ADMIN'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$db_fhlteam[$i] = $data['EQUIPESIM'];
	$db_int[$i] = $data['INT'];
	$i++;
}
mysqli_close($con);

echo '<br><b>'.$db_admin_fhlteam_langue[0].'</b>';
echo '<br>'.$db_admin_fhlteam_langue[1];
echo '<br><br><a style="display:block; margin-top:10px; margin-bottom:10px;" href="?admin=userpass">'.$db_admin_fhlteam_langue[9].'</a>';

if($message) echo '<br><br><b><span style="color:green";>'.$message.'</span></b><br><br>';
if(isset($message2)) echo '<br><br><b><span style="color:red";>'.$message2.'</span></b><br><br>';

echo '<form method="post" action="index.php?admin=fhlteam">';

echo '<br><input class="inputText" type="text" name="add" style="width:200px;" maxlength="22" value="">';
echo '<input class="button" style="width:100px; margin-left:20px;" type="submit" value="'.$db_admin_fhlteam_langue[3].'" name="press_add"><br>';

echo '<br><br><select style="width:200px;" name="table_drop">';
for($i=0;$i<count($db_fhlteam);$i++) {
	echo '<option value="'.$db_int[$i].'">'.$db_fhlteam[$i].'</option>';
}
echo '</select>';
echo '<input class="button" style="width:100px; margin-left:20px;" type="submit" value="'.$db_admin_fhlteam_langue[2].'" name="press_drop">';
echo '<input class="button" style="width:100px; margin-left:20px;" type="submit" value="'.$db_admin_fhlteam_langue[4].'" name="press_mod">';

if(isset($press_mod)) {

    include FS_ROOT.'gmo/login/mysqli.php';
	$sql = "SELECT `EQUIPESIM`, `INT` FROM `$db_table` WHERE `INT` = '$table_drop'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	while($data = mysqli_fetch_array($query)) {
		$db_fhlteam2 = $data['EQUIPESIM'];
	}
	mysqli_close($con);

	echo '<br><br>'.$db_admin_fhlteam_langue[8].'<br>';
	echo '<input class="inputText" type="text" name="mod" style="width:200px;" maxlength="22" value="'.$db_fhlteam2.'">';
	echo '<input type="hidden" name="mod_int" value="'.$table_drop.'">';
	echo '<input class="button" style="width:100px; margin-left:20px;" type="submit" value="'.$db_admin_all_langue[1].'" name="changer"></form>';
}
?>