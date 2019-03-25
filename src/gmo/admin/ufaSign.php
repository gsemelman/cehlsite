<?php 
$sortBy = "ORDER BY DATE ASC";
$mode2 = 0;
$sortByBold1 = "font-weight:bold;";
$sortByBold2 = "font-weight:normal;";
if( isset($_GET['sort']) || isset($_POST['sort']) ) {
	$mode2 = ( isset($_GET['sort']) ) ? $_GET['sort'] : $_POST['sort'];
	$mode2 = htmlspecialchars($mode2);
	if($mode2 == "1") {
		$sortBy = "ORDER BY `TEAM` ASC, `DATE` ASC";
		$sortByBold1 = "font-weight:normal;";
		$sortByBold2 = "font-weight:bold;";
	}
}

include 'login/mysqli.php';
$sql = "SELECT `PLAYERID`, COUNT(*), `DATE`, `TEAM` FROM `".$db_table."_ufalistsend` WHERE `LEAGUE` = (SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` DESC LIMIT 1) AND `APPR` = '0' GROUP BY `PLAYERID` $sortBy";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if(mysqli_num_rows($query) != 0) {
	$i = 0;
	while($data = mysqli_fetch_array($query)) {
		$dbPLAYERID[$i] = $data['PLAYERID'];
		$dbPLAYERTOT[$i] = $data['COUNT(*)'];
		$dbPLAYERDATE[$i] = $data['DATE'];
		$dbPLAYERTM[$i] = $data['TEAM'];
		
		$sql2 = "SELECT `NAME`, `SALA`, `NTC` FROM `".$db_table."_ufalist` WHERE `LEAGUE` = (SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` DESC LIMIT 1) AND `INT` = '$dbPLAYERID[$i]' LIMIT 1";
		$query2 = mysqli_query($con, $sql2) or die(mysqli_error($con));
		while($data2 = mysqli_fetch_array($query2)) {
			$dbPLAYERNAME[$i] = $data2['NAME'];
			$dbPLAYERSALA[$i] = $data2['SALA'];
			$dbPLAYERNTC[$i] = $data2['NTC'];
		}
		
		$dbPLAYERVIEWED[$i] = 0;
		$sql2 = "SELECT `VIEWED` FROM `".$db_table."_ufalistsend` WHERE `LEAGUE` = (SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` DESC LIMIT 1) AND `PLAYERID` = '$dbPLAYERID[$i]' AND `VIEWED` = '1' AND `APPR` = '0'";
		$query2 = mysqli_query($con, $sql2) or die(mysqli_error($con));
		while($data2 = mysqli_fetch_array($query2)) {
			$dbPLAYERVIEWED[$i]++;
		}
		$i++;
	}
}
else {
	echo '<br><span style="font-weight:bold;">'.$db_admin_ufaSign[1]."</span>";
}

// Signature Player Numbers
$playerNumber = mysqli_num_rows($query);

// Signature Requested Numbers
$sql = "SELECT * FROM `".$db_table."_ufalistsend` WHERE `APPR` = '0'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$league_UFAPendingRows = mysqli_num_rows($query);
mysqli_close($con);

$sortLink = "admin=ufasign";
if($mode == 'ufaSignManager') $sortLink = "membre=ufaSignManager";

if($playerNumber != 0) {
?>

<fieldset style="margin-top:25px;">
	<legend style="font-weight:bold;"><?php echo $db_admin_ufaSign[0].' - '.$playerNumber.$db_admin_ufaSign[2].$league_UFAPendingRows.$db_admin_ufaSign[4]; ?></legend>
	<?php echo $db_admin_ufaSign[21]; ?>: <a style="<?php echo $sortByBold1; ?>" href="?<?php echo $sortLink; ?>&sort=0">Date</a> - <a style="<?php echo $sortByBold2; ?>" href="?<?php echo $sortLink; ?>&sort=1"><?php echo $db_admin_ufaSign[20]; ?></a>
	<br>
	<table class="table" style="float:left; margin-bottom:30px; margin-right:25px;">
		<tr class="tr">
		<td style="width:130px;"><?php echo $db_admin_ufaSign[3]; ?></td>
		<td style="width:40px; text-align:center;"><?php echo $db_admin_ufaSign[5]; ?></td>
		<td><?php echo $db_admin_ufaSign[13]; ?></td>
		<td style="text-align:center;"><?php echo $db_admin_ufaSign[19]; ?></td>
<?php if($mode2 == "1") { ?><td><?php echo $db_admin_ufaSign[20]; ?></td><?php } ?>
		</tr>
<?php
if(isset($dbPLAYERID)) {
	for($i=0;$i<count($dbPLAYERID);$i++) {
		if($i % 2 == 0) $color = 1;
		else $color = 2;
		$protected = '';
		if($dbPLAYERNTC[$i] == 1) $protected = $db_admin_ufaSign[14];
		echo '<tr onclick="javascript:viewPlayer(\''.$dbPLAYERID[$i].'\',\''.$i.'\',\''.$dbPLAYERSALA[$i].'\')" class="tr_content'.$color.'">
		<td id="playerName'.$i.'">'.$dbPLAYERNAME[$i].'</td>';
		echo '<td style="text-align:center;">'.$dbPLAYERVIEWED[$i].'/'.$dbPLAYERTOT[$i].'</td>
		<td style="text-align:center;">'.$protected.'</td>
		<td style="text-align:center;">'.$dbPLAYERDATE[$i].'</td>';
		if($mode2 == "1") echo '<td>'.$dbPLAYERTM[$i].'</td>';
		echo '</tr>';
	}
}
?>
	</table>
	<div id="playerBox" style="display:none; float:left; margin-bottom:30px; margin-right:25px; background-color:#<?php echo $databaseColors['colorMainBackground']; ?>; border:1px solid #<?php echo $databaseColors['colorMenuBackground']; ?>;">
		<div style="background-color:#<?php echo $databaseColors['colorMenuBackground']; ?>; width:100%; height:40px;">
			<div style="width:100%; text-align:right;">
				<div style="text-align:right; position:relative; left:-10px; top:3px;"><a style="color:#<?php echo $databaseColors['colorMenuText']; ?>; font-size:28px;" href="javascript:hidePlayer();">X</a></div>
			</div>
			<div id="showPlayerName" style="position:relative; top:-28px; left:5px; width:300px; font-weight:bold; font-size:28px; color:#<?php echo $databaseColors['colorMenuText']; ?>;">Signature</div>
		</div>
		<div style="padding:10px 10px 10px 10px; text-align:center;">
		<table class="table">
			<thead>
				<tr class="tr">
				<td><?php echo $db_admin_ufa[25]; ?></td>
				<td><?php echo $db_admin_ufa[26]; ?></td>
				<td><?php echo $db_admin_ufa[27]; ?></td>
				<td><?php echo $db_admin_ufa[28]; ?></td>
				<td><?php echo $db_admin_ufa[29]; ?></td>
				<td><?php echo $db_admin_ufa[30]; ?></td>
				<td><?php echo $db_admin_ufa[31]; ?></td>
				<td><?php echo $db_admin_ufa[32]; ?></td>
				<td><?php echo $db_admin_ufa[33]; ?></td>
				<td><?php echo $db_admin_ufa[34]; ?></td>
				<td><?php echo $db_admin_ufa[35]; ?></td>
				<td><?php echo $db_admin_ufa[36]; ?></td>
				<td><?php echo $db_admin_ufa[37]; ?></td>
				<td><?php echo $db_admin_ufa[38]; ?></td>
				<td><?php echo $db_admin_ufa[39]; ?></td>
				<td><?php echo $db_admin_ufa[40]; ?></td>
				<td><?php echo $db_admin_ufa[41]; ?></td>
				<td><?php echo $db_admin_ufa[42]; ?></td>
				<td><?php echo $db_admin_ufa[43]; ?></td>
				<td><?php echo $db_admin_ufa[44]; ?></td>
				<td><?php echo $db_admin_ufa[47]; ?></td>
				<td><?php echo $db_admin_ufa[45]; ?></td>
				<td><?php echo $db_admin_ufa[46]; ?></td>
				<td><?php echo $db_admin_ufa[48]; ?></td>
				</tr>
			</thead>
			<tbody id="tbodyStats">
				
			</tbody>
			</table>
			<br>
			<table class="table">
			<thead>
				<tr class="tr">
					<td><?php echo $db_admin_ufaSign[10]; ?></td>
					<td><?php echo $db_admin_ufaSign[7]; ?></td>
					<td><?php echo $db_admin_ufaSign[8]; ?></td>
					<td><?php echo $db_admin_ufaSign[9]; ?></td>
					<td><?php echo $db_admin_ufaSign[18]; ?></td>
					<td><?php echo $db_admin_ufaSign[6]; ?></td>
					<td><?php echo $db_admin_ufaSign[22]; ?></td>
				</tr>
			</thead>
			<tbody id="tbody">
				
			</tbody>
			</table>
		</div>
		<input type="hidden" value="" id="playerID">
		<div style="clear:both; padding:10px;">
			<input class="button" style="width:150px; background-color:red;" type="button" value="<?php echo $db_admin_ufaSign[12]; ?>" onclick="javascript:declineAll();">
		</div>
	</div>
	<div id="counterPlayerBox" style="display:none; float:left; background-color:#<?php echo $databaseColors['colorMainBackground']; ?>; border:1px solid #<?php echo $databaseColors['colorMenuBackground']; ?>;">
		<div style="background-color:#<?php echo $databaseColors['colorMainBackground']; ?>; width:350px;">
			<div style="background-color:#<?php echo $databaseColors['colorMenuBackground']; ?>; width:100%; height:40px;">
				<div style="width:100%; text-align:right;">
					<div style="text-align:right; position:relative; left:-10px; top:3px;"><a style="color:#<?php echo $databaseColors['colorMenuText']; ?>; font-size:28px;" href="javascript:hideCounter();">X</a></div>
				</div>
				<div id="counterPlayerTeam" style="position:relative; top:-28px; left:5px; width:300px; font-weight:bold; font-size:28px; color:#<?php echo $databaseColors['colorMenuText']; ?>;"></div>
			</div>
			<div style="padding:10px 10px 10px 10px; text-align:center;">
				<div style="float:left; height:30px;"><?php echo $db_admin_ufaSign[31]; ?></div><div id="counterStatus" style="float:right; height:30px;"></div>
				<div style="clear:both; float:left;"><?php echo $db_admin_ufaSign[24]; ?></div><input class="inputText" type="number" min="1" max="10" value="1" id="counterPlayerContract" style="display:block; width:50px; float:right;">
				<div style="clear:both; float:left; margin-top:5px;"><?php echo $db_admin_ufaSign[25]; ?></div><input class="inputText" type="number" min="0" value="0" id="counterPlayerSalary" style="display:block; width:100px; float:right; margin-top:5px;">
				<div style="clear:both; float:left; padding-top:5px;"><?php echo $db_admin_ufaSign[26]; ?></div><input class="inputText" id="counterPlayerOther" type="text" value="" style="display:block; width:250px; float:right; margin-top:5px;">
				<div style="clear:both; padding-top:10px;"><input class="button" onclick="counterSave();" type="button" value="<?php echo $db_admin_ufaSign[23]; ?>"></div>
				<input type="hidden" value="" id="counterID">
			</div>
		</div>
	</div>
</fieldset>

<?php
}
?>