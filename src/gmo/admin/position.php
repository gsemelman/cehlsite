<?php
// Green : #4caf50 | Red : #ae654c
$good = "#4caf50";
$bad = "#ae654c";
?>
<script type="text/javascript">
<!--

function deleteChange(playerID) {
	document.body.style.cursor = "wait";
	
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var response = xmlhttp.responseText;
			if(response) console.log(response);
			document.body.style.cursor = "default";
			location.reload();
		}
	}
	var page = 'admin/position_delete.php';
	var parameters = "";
	parameters += "playerID=" + encodeURIComponent(playerID);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function sortYear() {
	var tmpYear = document.getElementById('selectYear').value;
	document.getElementById('positionForm').action = "?admin=position&year="+tmpYear;
	document.getElementById('positionForm').submit();
}

function sortTeam() {
	var tmpYear = document.getElementById('selectYear').value;
	var tmpTeam = encodeURIComponent(document.getElementById('selectTeam').value);
	if(tmpTeam != "") document.getElementById('positionForm').action = "?admin=position&year="+tmpYear+"&team="+tmpTeam;
	else document.getElementById('positionForm').action = "?admin=position&year="+tmpYear;
	document.getElementById('positionForm').submit();
}

//-->
</script>

<?php
if ( isset($_GET['year']) || isset($_POST['year']) ) {
	$currentYear = ( isset($_GET['year']) ) ? $_GET['year'] : $_POST['year'];
	$currentYear = htmlspecialchars($currentYear);
}

if ( isset($_GET['team']) || isset($_POST['team']) ) {
	$currentTeam = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
	$currentTeam = htmlspecialchars($currentTeam);
	if($currentTeam == "") unset($currentTeam);
}

echo '<br><b>'.$db_admin_position[0].'</b><br>';

include FS_ROOT.'gmo/login/mysqli.php';

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
			if($data['POS_BF'] == '00') $DB_BF[] = $db_admin_position[1];
			if($data['POS_BF'] == '01') $DB_BF[] = $db_admin_position[2];
			if($data['POS_BF'] == '02') $DB_BF[] = $db_admin_position[3];
			if($data['POS_BF'] == '03') $DB_BF[] = $db_admin_position[4];
			if($data['POS_BF'] == '04') $DB_BF[] = $db_admin_position[5];
			if($data['POS_AF'] == '00') $DB_AF[] = $db_admin_position[1];
			if($data['POS_AF'] == '01') $DB_AF[] = $db_admin_position[2];
			if($data['POS_AF'] == '02') $DB_AF[] = $db_admin_position[3];
			if($data['POS_AF'] == '03') $DB_AF[] = $db_admin_position[4];
			if($data['POS_AF'] == '04') $DB_AF[] = $db_admin_position[5];
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

// TABLEAU
?>
<br>
<form id="positionForm" method="post" enctype="multipart/form-data" action="?admin=position">
<span style="margin-right:15px;"><?php echo $db_admin_position[13]; ?></span>
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
<option value=""><?php echo $db_admin_position[14]; ?></option>
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
		<td><?php echo $db_admin_position[6]; ?></td>
		<td><?php echo $db_admin_position[7]; ?></td>
		<td><?php echo $db_admin_position[8]; ?></td>
		<td><?php echo $db_admin_position[9]; ?></td>
		<td><?php echo $db_admin_position[10]; ?></td>
		<td><?php echo $db_admin_position[11]; ?></td>
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
		<td><?php echo $DB_BF[$i]; ?></td>
		<td><?php echo $DB_AF[$i]; ?></td>
		<td><input onclick="javascript:deleteChange('<?php echo $DB_ID[$i]; ?>');" class="button" type="button" value="<?php echo $db_admin_position[11]; ?>"></td>
	</tr>
<?php
}
}
?>
</table>