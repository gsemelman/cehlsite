<?php 
function moneyFormat($money,$lang) {
	if($lang == "fr") $money2 = number_format($money, 0, ',', ' ')." $";
	if($lang == "en") $money2 = "$".number_format($money, 0, '.', ',');
	return $money2;
}

include 'login/mysqli.php';
$i = 0;
$sql = "SELECT * FROM `".$db_table."_trade` ORDER BY `INT` DESC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if(mysqli_num_rows($query) != 0) {
	while($data = mysqli_fetch_array($query)) {
		$dbTeam1[$i] = $data['TEAM1'];
		$dbPlayer1[$i] = explode('|',$data['PLAYER1']);
		$dbProspect1[$i] = explode('|',$data['PROSPECT1']);
		$dbDraft1[$i] = explode('|',$data['DRAFT1']);
		$dbTeam2[$i] = $data['TEAM2'];
		$dbPlayer2[$i] = explode('|',$data['PLAYER2']);
		$dbProspect2[$i] = explode('|',$data['PROSPECT2']);
		$dbDraft2[$i] = explode('|',$data['DRAFT2']);
		$dbDate1[$i] = $data['DATE1'];
		$dbDate2[$i] = $data['DATE2'];
		$dbApproval[$i] = $data['APPROVAL'];
		$dbINT[$i] = $data['INT'];
		if($data['CASH1'] != "") $dbCash1[$i] = moneyFormat($data['CASH1'], $league_langue);
		else $dbCash1[$i] = "";
		if($data['CASH2'] != "") $dbCash2[$i] = moneyFormat($data['CASH2'], $league_langue);
		else $dbCash2[$i] = "";
		$i++;
	}
}
else {
	echo $db_admin_tradeMan[1];
}

// Trade Numbers
$tradeNumber = mysqli_num_rows($query);

mysqli_close($con);
?>

<fieldset style="margin-top:25px;">
<legend style="font-weight:bold;"><?php echo $db_admin_tradeMan[1].' - '.$tradeNumber.' '.$db_admin_tradeMan[2]; ?></legend>
<table id="tradeTable" class="table" style="float:left; margin-right:25px;">
<tr class="tr">
	<td><?php echo $db_admin_tradeMan[5]; ?></td>
	<td><?php echo $db_admin_tradeMan[3]; ?></td>
	<td><?php echo $db_admin_tradeMan[4]; ?></td>
	<td><?php echo $db_admin_tradeMan[6]; ?></td>
	<td><?php echo $db_admin_tradeMan[7]; ?></td>
	<td><?php echo $db_admin_tradeMan[10]; ?></td>
	<td><?php echo $db_admin_tradeMan[8]; ?></td>
	<td><?php echo $db_admin_tradeMan[9]; ?></td>
	<td><?php echo $db_admin_tradeMan[11]; ?></td>
	<td><?php echo $db_admin_tradeMan[12]; ?></td>
	<td><?php echo $db_admin_tradeMan[13]; ?></td>
	<td><?php echo $db_admin_tradeMan[17]; ?></td>
</tr>
<?php
if(isset($dbTeam1)) {
	for($i=0;$i<count($dbTeam1);$i++) {
		if($i % 2 == 0) $color = 1;
		else $color = 2;
?>
<tr id="tr<?php echo $dbINT[$i]; ?>" class="tr_content<?php echo $color; ?>">
	<td><b><?php echo $dbTeam1[$i]; ?></b><br><?php echo $dbDate1[$i]; ?></td>
	<td>
<?php
	for($x=0;$x<count($dbPlayer1[$i]);$x++) {
		if($x!=0) echo '<br>';
		echo $dbPlayer1[$i][$x];
	}
?>
	</td>
	<td>
<?php
	for($x=0;$x<count($dbProspect1[$i]);$x++) {
		if($x!=0) echo '<br>';
		echo $dbProspect1[$i][$x];
	}
?>
	</td>
	<td>
<?php
	for($x=0;$x<count($dbDraft1[$i]);$x++) {
		if($x!=0) echo '<br>';
		echo $dbDraft1[$i][$x];
	}
?>
	</td>
	<td><?php echo $dbCash1[$i]; ?></td>
	<td><b><?php echo $dbTeam2[$i]; ?></b><br><?php echo $dbDate2[$i]; ?></td>
	<td>
<?php
	for($x=0;$x<count($dbPlayer2[$i]);$x++) {
		if($x!=0) echo '<br>';
		echo $dbPlayer2[$i][$x];
	}
?>
	</td>
	<td>
<?php
	for($x=0;$x<count($dbProspect2[$i]);$x++) {
		if($x!=0) echo '<br>';
		echo $dbProspect2[$i][$x];
	}
?>
	</td>
	<td>
<?php
	for($x=0;$x<count($dbDraft2[$i]);$x++) {
		if($x!=0) echo '<br>';
		echo $dbDraft2[$i][$x];
	}
?>
	</td>
	<td><?php echo $dbCash2[$i]; ?></td>
	<td>
<?php 
	if($dbDate2[$i] == '0000-00-00 00:00:00') echo $db_admin_tradeMan[14].' '.$dbTeam2[$i];
	if($dbApproval[$i] == '0000-00-00 00:00:00' && $dbDate2[$i] != '0000-00-00 00:00:00') echo $db_admin_tradeMan[15];
	if($dbApproval[$i] != '0000-00-00 00:00:00' && $dbDate2[$i] != '0000-00-00 00:00:00') echo $db_admin_tradeMan[16];
?>
	</td>
	<td style="text-align:center;"><a style="font-size:14px;" href="javascript:tradeManDelete('<?php echo $dbINT[$i]; ?>');">X</a></td>
</tr>
<?php
	}
}
?>
</table>
</fieldset>