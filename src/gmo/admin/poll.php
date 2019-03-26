<?php
// Green : #4caf50 | Red : #ae654c
$good = "#4caf50";
$bad = "#ae654c";

date_default_timezone_set($TimeZone);
$datetime = date("Y-m-d H:i:s");
$datetime_exp = explode(' ', $datetime);
?>
<script type="text/javascript">
<!--

function start() {
	if(document.getElementById('selectPoll').value == "") {
		document.getElementById('newPoll').style.display = "block";
		document.getElementById('editPoll').style.display = "none";
		document.getElementById('pollNewQuestion').focus();
	}
	else {
		document.getElementById('newPoll').style.display = "none";
		document.getElementById('editPoll').style.display = "block";
	}
}

function sortYear() {
	var tmpYear = document.getElementById('selectYear').value;
	document.getElementById('pollForm').action = "?admin=poll&year="+tmpYear;
	document.getElementById('pollForm').submit();
}

function sortPoll() {
	var tmpYear = document.getElementById('selectYear').value;
	var tmpPoll = encodeURIComponent(document.getElementById('selectPoll').value);
	if(tmpPoll != "") {
		document.getElementById('pollForm').action = "?admin=poll&year="+tmpYear+"&poll="+tmpPoll;
		document.getElementById('pollForm').submit();
	}
	else {
		document.getElementById('editPoll').style.display = "none";
		document.getElementById('newPoll').style.display = "block";
		document.getElementById('pollNewQuestion').focus();
	}
}
function addOption(z) {
	var pollOptionsID = "pollNewOption";
	if(z == 1) pollOptionsID = "pollEditOption";
	var options = document.querySelectorAll('[id^="'+pollOptionsID+'"]');
	
	var pollTableID = "newPollTable";
	if(z == 1) pollTableID = "editPollTable";
	var tableRef = document.getElementById(pollTableID).getElementsByTagName('tbody')[0];
	
	var newRow = tableRef.insertRow(tableRef.rows.length);
	
	var newCell = newRow.insertCell(0);
	var newText = document.createTextNode('<?php echo $db_admin_poll[6]; ?> '+(options.length+1));
	newCell.appendChild(newText);
	
	var pollRowID = "pollNewOption";
	if(z == 1) pollRowID = "pollEditOption";
	var newCell = newRow.insertCell(1);
	var x = document.createElement("input");
	x.setAttribute("type", "text");
	x.setAttribute("id", pollRowID+options.length);
	x.setAttribute("class", "inputText");
	x.style.width = "100%";
	x.value = "";
	newCell.appendChild(x);
	document.getElementById(pollRowID+options.length).select();
}

function savePoll(z) {
	var pollDateID = "pollNewDate";
	if(z == 1) pollDateID = "pollEditDate";
	var date_end = document.getElementById(pollDateID).value
	if(date_end == "") return;
	
	var pollTimeID = "pollNewTime";
	if(z == 1) pollTimeID = "pollEditTime";
	var time_end = document.getElementById(pollTimeID).value
	if(time_end == "") return;
	
	var pollQuestionID = "pollNewQuestion";
	if(z == 1) pollQuestionID = "pollEditQuestion";
	var question = document.getElementById(pollQuestionID).value.trim();
	if(question == "") return;
	
	var pollOptionsID = "pollNewOption";
	if(z == 1) pollOptionsID = "pollEditOption";
	var options = document.querySelectorAll('[id^="'+pollOptionsID+'"]');
	var value = [];
	for(var i=0;i<options.length;i++) {
		var tmpValue = options[i].value.trim();
		if(tmpValue != "") value.push(tmpValue);
	}
	if(value.length < 2) return;
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
			document.body.style.cursor = "default";
			document.getElementById('pollForm').action = "?admin=poll&poll="+response;
			document.getElementById('pollForm').submit();
		}
	}
	var page = 'admin/poll_add.php';
	var parameters = "";
	parameters += "question=" + encodeURIComponent(question);
	parameters += "&z=" + encodeURIComponent(z);
	parameters += "&id=" + encodeURIComponent(document.getElementById('selectPoll').value);
	parameters += "&datetime=" + encodeURIComponent(date_end) + " " + encodeURIComponent(time_end);
	parameters += "&value=" + encodeURIComponent(JSON.stringify(value));
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function delPoll() {
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
			document.body.style.cursor = "default";
			document.getElementById('pollForm').action = "?admin=poll";
			document.getElementById('pollForm').submit();
		}
	}
	var page = 'admin/poll_del.php';
	var parameters = "";
	parameters += "id=" + encodeURIComponent(document.getElementById('selectPoll').value);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

//-->
</script>

<?php
if ( isset($_GET['year']) || isset($_POST['year']) ) {
	$currentYear = ( isset($_GET['year']) ) ? $_GET['year'] : $_POST['year'];
	$currentYear = htmlspecialchars($currentYear);
}

if ( isset($_GET['poll']) || isset($_POST['poll']) ) {
	$currentPoll = ( isset($_GET['poll']) ) ? $_GET['poll'] : $_POST['poll'];
	$currentPoll = htmlspecialchars($currentPoll);
	if($currentPoll == "") unset($currentPoll);
}

include FS_ROOT.'gmo/login/mysqli.php';

$sql = "SELECT YEAR(`DATE`) FROM `".$db_table."_poll` GROUP BY YEAR(`DATE`) ORDER BY `DATE` DESC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if(mysqli_num_rows($query) != 0) {
	while($data = mysqli_fetch_array($query)) {
		$$ADMIN_DB_YR[] = $data['YEAR(`DATE`)'];
	}

	$sqlYear = $$ADMIN_DB_YR[0];
	if(isset($currentYear)) $sqlYear = $currentYear;
	$sql = "SELECT * FROM `".$db_table."_poll` WHERE `DATE` >= '".$sqlYear."-01-01 00:00:00' AND `DATE` <= '".$sqlYear."-12-31 23:59:59' ORDER BY `ID` DESC";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	if(mysqli_num_rows($query) != 0) {
		while($data = mysqli_fetch_array($query)) {
			$ADMIN_DB_ID[] = $data['ID'];
			$DB_QT[] = $data['QUESTION'];
		}
	}
	if(isset($currentPoll)) {
		$sql = "SELECT * FROM `".$db_table."_poll` WHERE `ID` = '$currentPoll' LIMIT 1";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		if(mysqli_num_rows($query) != 0) {
			while($data = mysqli_fetch_array($query)) {
				$DB_MOD_QT = $data['QUESTION'];
				$DB_MOD_OPTIONS = explode("|$|",$data['OPTIONS']);
				$DB_MOD_EN = explode(' ',$data['DATE_END']);
				$DB_MOD_VOTERS = explode("|$|",$data['VOTERS']);
			}
		}
	}
}

mysqli_close($con);
?>
<br><b><?php echo $db_admin_poll[0]; ?></b><br>
<br>
<form id="pollForm" method="post" enctype="multipart/form-data" action="?admin=poll">
<span style="margin-right:15px;"><?php echo $db_admin_poll[2]; ?></span>
<select id="selectYear" onchange="javascript:sortYear();">
<?php
if(isset($$ADMIN_DB_YR)) {
	for($i=0; $i<count($$ADMIN_DB_YR);$i++){
		$currentYearSelected = '';
		if(isset($currentYear) && $currentYear == $$ADMIN_DB_YR[$i]) $currentYearSelected = ' selected';
?>
	<option value="<?php echo $$ADMIN_DB_YR[$i]; ?>"<?php echo $currentYearSelected; ?>><?php echo $$ADMIN_DB_YR[$i]; ?></option>
<?php
	}
}
else {
?>
	<option value=""><?php echo $db_admin_poll[3]; ?></option>
<?php
}
?>
</select>
<select id="selectPoll" onchange="javascript:sortPoll();">
<option value=""><?php echo $db_admin_poll[1]; ?></option>
<?php
if(isset($ADMIN_DB_ID)) {
	for($i=0; $i<count($ADMIN_DB_ID);$i++){
		$currentPollSelected = '';
		if(isset($currentPoll) && $currentPoll == $ADMIN_DB_ID[$i]) $currentPollSelected = ' selected';
?>
	<option value="<?php echo $ADMIN_DB_ID[$i]; ?>"<?php echo $currentPollSelected; ?>><?php echo $DB_QT[$i]; ?></option>
<?php
	}
}
?>
</select>
</form>

<div id="newPoll" style="margin-top:25px; width:300px;">
	<table class="table" id="newPollTable" style="width:300px;">
		<thead>
		<tr class="tr">
			<td colspan="2" style="text-align:center;"><?php echo $db_admin_poll[1]; ?></td>
		</tr>
		<tr>
			<td><?php echo $db_admin_poll[11]; ?></td>
			<td><input id="pollNewDate" type="date" class="inputText" style="width:60%;" value="<?php echo $datetime_exp[0]; ?>"><input id="pollNewTime" type="time" class="inputText" style="width:40%;" value="<?php echo $datetime_exp[1]; ?>"></td>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<td><input type="button" class="button" style="width:100%;" onclick="javascript:savePoll(0);" value="<?php echo $db_admin_all_langue[1]; ?>"></td>
			<td><input type="button" class="button" style="width:100%;" onclick="javascript:addOption(0);" value="<?php echo $db_admin_poll[4]; ?>"></td>
		</tr>
		</tfoot>
		<tbody id="tableNewTbody">
		<tr>
			<td><?php echo $db_admin_poll[5]; ?></td>
			<td><input id="pollNewQuestion" type="text" class="inputText" style="width:100%;" value=""></td>
		</tr>
		<tr>
			<td><?php echo $db_admin_poll[6]; ?> 1</td>
			<td><input id="pollNewOption0" type="text" class="inputText" style="width:100%;" value=""></td>
		</tr>
		<tr>
			<td><?php echo $db_admin_poll[6]; ?> 2</td>
			<td><input id="pollNewOption1" type="text" class="inputText" style="width:100%;" value=""></td>
		</tr>
		</tbody>
	</table>
</div>

<div id="editPoll" style="margin-top:25px; width:300px;">
<?php
	if(isset($DB_MOD_VOTERS)) {
		echo '<div style="margin-bottom:25px;">'.$db_admin_poll[12].': ';
		for($i=0;$i<count($DB_MOD_VOTERS);$i++) {
			if($i != 0) echo ", ";
			echo $DB_MOD_VOTERS[$i];
		}
		echo '</div>';
	}
?>
	<table class="table" id="editPollTable" style="width:300px;">
		<thead>
		<tr class="tr">
			<td colspan="2" style="text-align:center;"><?php echo $db_admin_poll[7]; ?></td>
		</tr>
		<tr>
			<td><?php echo $db_admin_poll[11]; ?></td>
			<td><input id="pollEditDate" type="date" class="inputText" style="width:60%;" value="<?php if(isset($DB_MOD_QT)) echo $DB_MOD_EN[0]; ?>"><input id="pollEditTime" type="time" class="inputText" style="width:40%;" value="<?php if(isset($DB_MOD_QT)) echo $DB_MOD_EN[1]; ?>"></td>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<td><input type="button" class="button" style="width:100%;" onclick="javascript:savePoll(1);" value="<?php echo $db_admin_all_langue[1]; ?>"></td>
			<td><input type="button" class="button" style="width:100%;" onclick="javascript:addOption(1);" value="<?php echo $db_admin_poll[4]; ?>"></td>
		</tr>
		</tfoot>
		<tbody id="tableEditTbody">
		<tr>
			<td><?php echo $db_admin_poll[5]; ?></td>
			<td><input id="pollEditQuestion" type="text" class="inputText" style="width:100%;" value="<?php if(isset($DB_MOD_QT)) echo $DB_MOD_QT; ?>"></td>
		</tr>
<?php
if(isset($DB_MOD_QT)) {
	for($i=0;$i<count($DB_MOD_OPTIONS);$i++) {
?>
		<tr>
			<td><?php echo $db_admin_poll[6]." ".($i+1); ?></td>
			<td><input id="pollEditOption<?php echo $i; ?>" type="text" class="inputText" style="width:100%;" value="<?php echo $DB_MOD_OPTIONS[$i]; ?>"></td>
		</tr>
<?php
	}
}
?>
		</tbody>
	</table>
	<br>
	<div style="text-align:center; margin-bottom:15px; width:100%;"><input type="button" class="button" style="width:90%;" onclick="javascript:delPoll();" value="<?php echo $db_admin_poll[10]; ?>"></div>
	<?php echo $db_admin_poll[8]; ?>
</div>
<br>
<?php echo $db_admin_poll[9]; ?>

<script type="text/javascript">
<!--

document.addEventListener("DOMContentLoaded", start(), false);

//-->
</script>