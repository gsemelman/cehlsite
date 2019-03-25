	<div style="text-align:center;">
<form method="post" action="gmo/login/validation.php">
	<?php echo $db_login_langue[1]; ?><br>
	<input class="inputText" type="text" name="user" style="width:100%; text-align:center;" required><br><br>
	<?php echo $db_login_langue[2]; ?><br>
	<input class="inputText" type="password" name="pass" style="width:100%; text-align:center;" required><br><br>
	<input class="button" type="submit" value="<?php echo $db_login_langue[3]; ?>" name="login"><br><br>
</form>
</div>

<?php
$file = 'https://richmondstpats.org/sim/GMO.txt';
$file_headers = @get_headers($file);
if($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers == "") {
    echo '<br><div style="text-align:center;"><a href="https://richmondstpats.org/sim/">'.$db_login_langue[8].'</a></div>';
}
else {
	$data = file($file);
	if(trim($version) != trim($data[0])) echo '<br><div style="text-align:center;"><a href="'.$data[1].'">'.$db_login_langue[5].' - v'.$data[0].'</a></div>';
}

include 'mysqli.php';
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
mysqli_close($con);

echo '<div style="text-align:center; margin-top:25px;">';

if(isset($league_TradeToolStatus) && $league_TradeToolStatus != 0) echo '<a class="tooltip" href="trade.php"><img class="menu2" src="images/design/trade.png" alt="'.$db_login_langue[6].'"><span class="tooltiptext">'.$db_login_langue[6].'</span></a>';
if(isset($league_UFAToolStatus) && $league_UFAToolStatus != 0) echo '<a class="tooltip" href="ufa.php"><img class="menu2" src="images/design/ufa.png" alt="'.$db_login_langue[7].'"><span class="tooltiptext">'.$db_login_langue[7].'</span></a>';
if(isset($league_position) && $league_position == 1) echo '<a class="tooltip" href="position.php"><img class="menu2" src="images/design/position.png" alt="'.$db_login_langue[9].'"><span class="tooltiptext">'.$db_login_langue[9].'</span></a>';
if($league_poll_active == 1) echo '<a class="tooltip" href="poll.php"><img class="menu2" src="images/design/poll.png" alt="'.$db_login_langue[10].'"><span class="tooltiptext">'.$db_login_langue[10].'</span></a>';

echo '</div>';
?>