<?php
// Enregistrement des valeurs dans la base de donnée
if(isset($_POST['submit'])) {
	extract($_POST,EXTR_OVERWRITE);
	include FS_ROOT.'gmo/login/mysqli.php';
	if(isset($SessionName)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$SessionName' WHERE `PARAM`='SessionName'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($file_folder)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$file_folder' WHERE `PARAM`='file_folder'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($file_folder_lines)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$file_folder_lines' WHERE `PARAM`='file_folder_lines'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_name)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_name' WHERE `PARAM`='league_name'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_langue)) {
		// English : 1 | Français : 2
		if($league_langue == 1) $league_langue = 'en';
		if($league_langue == 2) $league_langue = 'fr';
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_langue' WHERE `PARAM`='league_langue'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_editorPassword)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_editorPassword' WHERE `PARAM`='league_editorPassword'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_cap)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_cap' WHERE `PARAM`='league_cap'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_capType)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_capType' WHERE `PARAM`='league_capType'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_capInjured)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_capInjured' WHERE `PARAM`='league_capInjured'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_GameInProPayroll)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_GameInProPayroll' WHERE `PARAM`='league_GameInProPayroll'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_players)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_players' WHERE `PARAM`='league_players'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_MaxPlayers)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_MaxPlayers' WHERE `PARAM`='league_MaxPlayers'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_FarmMaxOV)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_FarmMaxOV' WHERE `PARAM`='league_FarmMaxOV'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_AgeExemptFarmMaxOV)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_AgeExemptFarmMaxOV' WHERE `PARAM`='league_AgeExemptFarmMaxOV'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_FarmMaxAge)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_FarmMaxAge' WHERE `PARAM`='league_FarmMaxAge'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_GameInProWaivers)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_GameInProWaivers' WHERE `PARAM`='league_GameInProWaivers'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_AgeExemptWaivers)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_AgeExemptWaivers' WHERE `PARAM`='league_AgeExemptWaivers'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_OVSkatersWaivers)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_OVSkatersWaivers' WHERE `PARAM`='league_OVSkatersWaivers'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_OVGoaliesWaivers)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_OVGoaliesWaivers' WHERE `PARAM`='league_OVGoaliesWaivers'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_gmeditor)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_gmeditor' WHERE `PARAM`='league_gmeditor'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($TimeZone)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$TimeZone' WHERE `PARAM`='TimeZone'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_SalaryWaivers)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_SalaryWaivers' WHERE `PARAM`='league_SalaryWaivers'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_TradeToolStatus)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_TradeToolStatus' WHERE `PARAM`='league_TradeToolStatus'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_TradeToolDraft)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_TradeToolDraft' WHERE `PARAM`='league_TradeToolDraft'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_TradeToolDraftRounds)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_TradeToolDraftRounds' WHERE `PARAM`='league_TradeToolDraftRounds'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_TradeToolDisplay)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_TradeToolDisplay' WHERE `PARAM`='league_TradeToolDisplay'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_TradeToolOtherMandatory)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_TradeToolOtherMandatory' WHERE `PARAM`='league_TradeToolOtherMandatory'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_UFAToolStatus)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_UFAToolStatus' WHERE `PARAM`='league_UFAToolStatus'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	if(isset($league_position)) {
		$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$league_position' WHERE `PARAM`='league_position'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	
	$succesUpdate = 1;
	mysqli_close($con);
}



// Lecture des valeurs dans la base de donnée
include FS_ROOT.'gmo/login/mysqli.php';
$sql = "SELECT `VALUE`, `PARAM` FROM `".$db_table."_parameters`";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$i = 0;
while($data = mysqli_fetch_array($query)) {
	$dbParam[$i] = $data['PARAM'];
	$dbValue[$i] = $data['VALUE'];
	$i++;
}
mysqli_close($con);

?>

<script type="text/javascript">
<!--

function start() {
	var x = document.getElementById("league_langueHidden").value;
	if(x == 'en') document.getElementById("league_langue").value = 1;
	if(x == 'fr') document.getElementById("league_langue").value = 2;
}

function folderListening() {
	x = document.getElementById("file_folder").value;
	if(x == "/") {
		document.getElementById("file_folder").value = "";
		x = "";
	}
	if(x != "") {
		var xTMP = x.substr(-1);
		if(xTMP != "/") {
			x = x + "/";
			document.getElementById("file_folder").value = x;
		}
	}
	
	
	
	if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
	else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var response = xmlhttp.responseText;
			
			var update = new Array();
			if(response.indexOf('|$|' != -1)) {
				update = response.split('|$|');
			}
			
			if(update[0] == 'FOUND') document.getElementById("file_folderFound").textContent = "<?php echo $db_admin_param_langue[7]; ?>";
			if(update[0] == '') document.getElementById("file_folderFound").textContent = "<?php echo $db_admin_param_langue[6]; ?>";
			if(update[0] != '' && update[0] != 'FOUND') document.getElementById("file_folderFound").textContent = "<?php echo $db_admin_param_langue[8]; ?>";
			document.getElementById("file_folderPath").textContent = update[1];
		}
	}
var parameters="folder="+x;
xmlhttp.open("POST", "<?php echo BASE_URL?>gmo/admin/param2.php", true)
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
xmlhttp.send(parameters)
}

//-->
</script>
<?php
$link = 'admin=param';
if(isset($step) && $step == 2) {
	$link = 'admin=first&step='.$step;
}
if(isset($succesUpdate)) {
	$tmpNext = '';
	if(isset($step) && $step == 2) $tmpNext = ' - <a href="?admin=first&step='.$nextStep.'">'.$db_admin_assist_langue[1].'</a>';
	echo '<span style="display:block; font-weight:bold; color:green; padding-top:25px;">'.$db_admin_param_langue[26].$tmpNext.'</span>';
}
?>

<span style="display:block; font-weight:bold; padding-top:25px;"><?php echo $db_admin_param_langue[0]; ?></span>
<form method="post" enctype="multipart/form-data" action="?<?php echo $link; ?>">
<table class="table" style="width:550px;">

<?php

for($i=0;$i<count($dbParam);$i++) {
	if($dbParam[$i] == 'SessionName') {
		$leagueSessionName = $dbValue[$i];
	}
	if($dbParam[$i] == 'file_folder') {
		$leaguefile_folder = $dbValue[$i];
	}
	if($dbParam[$i] == 'file_folder_lines') {
		$leaguefile_folder_lines = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_name') {
		$leagueleague_name = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_langue') {
		$leagueleague_langue = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_editorPassword') {
		$leagueleague_editorPassword = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_cap') {
		$leagueleague_cap = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_capType') {
		$leagueleague_capType = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_capInjured') {
		$leagueleague_capInjured = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_GameInProPayroll') {
		$leagueleague_GameInProPayroll = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_players') {
		$leagueleague_players = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_MaxPlayers') {
		$leagueleague_MaxPlayers = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_FarmMaxOV') {
		$leagueleague_FarmMaxOV = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_AgeExemptFarmMaxOV') {
		$leagueleague_AgeExemptFarmMaxOV = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_FarmMaxAge') {
		$leagueleague_FarmMaxAge = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_GameInProWaivers') {
		$leagueleague_GameInProWaivers = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_AgeExemptWaivers') {
		$leagueleague_AgeExemptWaivers = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_OVSkatersWaivers') {
		$leagueleague_OVSkatersWaivers = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_OVGoaliesWaivers') {
		$leagueleague_OVGoaliesWaivers = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_SalaryWaivers') {
		$leagueleague_SalaryWaivers = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_gmeditor') {
		$leagueleague_gmeditor = $dbValue[$i];
	}
	if($dbParam[$i] == 'TimeZone') {
		$leagueTimeZone = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_TradeToolStatus') {
		$leagueleague_TradeToolStatus = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_TradeToolDraft') {
		$leagueleague_TradeToolDraft = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_TradeToolDraftRounds') {
		$leagueleague_TradeToolDraftRounds = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_TradeToolDisplay') {
		$leagueleague_TradeToolDisplay = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_TradeToolOtherMandatory') {
		$leagueleague_TradeToolOtherMandatory = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_UFAToolStatus') {
		$leagueleague_UFAToolStatus = $dbValue[$i];
	}
	if($dbParam[$i] == 'league_position') {
		$leagueleague_position = $dbValue[$i];
	}
}

echo '<tr class="tr"><td style="width:175px;">'.$db_admin_param_langue[1].'</td><td>'.$db_admin_param_langue[2].'</td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[3].'</td></tr>';
echo '<tr><td>SessionName</td><td><input class="inputText" required type="text" style="width:150px;" name="SessionName" value="'.$leagueSessionName.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[5].'</td></tr>';
echo '<tr><td>file_folder</td><td><input class="inputText" type="text" style="width:150px;" id="file_folder" name="file_folder" value="'.$leaguefile_folder.'"><input class="button" style="width:100px;" type="button" value="'.$db_admin_param_langue[10].'" onclick="javascript:folderListening();"><br>Status: <span id="file_folderFound"></span><br>'.$db_admin_param_langue[9].': <span id="file_folderPath"></span></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[11].'</td></tr>';
echo '<tr><td>file_folder_lines</td><td><input class="inputText" type="text" style="width:150px;" name="file_folder_lines" value="'.$leaguefile_folder_lines.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[13].'</td></tr>';
echo '<tr><td>league_name</td><td><input class="inputText" required type="text" style="width:320px;" name="league_name" value="'.$leagueleague_name.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[4].'</td></tr>';
echo '<tr><td>league_langue<input type="hidden" value="'.$leagueleague_langue.'" id="league_langueHidden"></td>';
echo '<td>';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_langue\').value = 1;">EN</span>';
echo '<input style="display:block; float:left; width:50px;" type="range" id="league_langue" name="league_langue" min="1" max="2" step="1" value="">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_langue\').value = 2;">FR</span>';
echo '</td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[21].'</td></tr>';
echo '<tr><td>league_gmeditor</td>';
echo '<td>';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_gmeditor\').value = 0;">Online Editor Only</span>';
echo '<input style="display:block; float:left; width:50px;" type="range" id="league_gmeditor" name="league_gmeditor" min="0" max="1" step="1" value="'.$leagueleague_gmeditor.'">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_gmeditor\').value = 1;">Online Editor + .LNS</span>';
echo '</td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[56].'</td></tr>';
echo '<tr><td>league_editorPassword</td>';
echo '<td>';
echo '<span style="cursor:pointer; display:block; clear:both; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_editorPassword\').value = 0;">'.$db_admin_param_langue[51].'</span>';
echo '<input style="display:block; float:left; width:160px;" type="range" id="league_editorPassword" name="league_editorPassword" min="0" max="1" step="1" value="'.$leagueleague_editorPassword.'">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_editorPassword\').value = 1;">'.$db_admin_param_langue[52].'</span>';
echo '</td></tr>';

echo '<tr class="tr"><td style="width:175px;">'.$db_admin_param_langue[1].'</td><td>'.$db_admin_param_langue[38].'</td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[14].'</td></tr>';
echo '<tr><td>league_cap</td><td><input class="inputText" required type="number" style="width:150px;" name="league_cap" value="'.$leagueleague_cap.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[15].'</td></tr>';
echo '<tr><td>league_capType</td>';
echo '<td>';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_capType\').value = 0;">Pro</span>';
echo '<input style="display:block; float:left; width:50px;" type="range" id="league_capType" name="league_capType" min="0" max="1" step="1" value="'.$leagueleague_capType.'">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_capType\').value = 1;">Pro + Farm</span>';
echo '</td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[57].'</td></tr>';
echo '<tr><td>league_capInjured</td><td>';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_capInjured\').value = 0;">Off</span>';
echo '<input style="display:block; float:left; width:50px;" type="range" id="league_capInjured" name="league_capInjured" min="0" max="1" step="1" value="'.$leagueleague_capInjured.'">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_capInjured\').value = 1;">On</span>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[16].'</td></tr>';
echo '<tr><td>league_GameInProPayroll</td><td><input class="inputText" required type="number" style="width:150px;" name="league_GameInProPayroll" value="'.$leagueleague_GameInProPayroll.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[17].'</td></tr>';
echo '<tr><td>league_players</td><td>';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_players\').value = 0;">Off</span>';
echo '<input style="display:block; float:left; width:50px;" type="range" id="league_players" name="league_players" min="0" max="1" step="1" value="'.$leagueleague_players.'">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_players\').value = 1;">On</span>';

echo '</td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[18].'</td></tr>';
echo '<tr><td>league_MaxPlayers</td><td><input class="inputText" required type="number" style="width:150px;" name="league_MaxPlayers" value="'.$leagueleague_MaxPlayers.'"></td></tr>';

echo '<tr class="tr"><td style="width:175px;">'.$db_admin_param_langue[1].'</td><td>'.$db_admin_param_langue[39].'</td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[29].'</td></tr>';
echo '<tr><td>league_FarmMaxOV</td><td><input class="inputText" required type="number" style="width:150px;" name="league_FarmMaxOV" value="'.$leagueleague_FarmMaxOV.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[34].'</td></tr>';
echo '<tr><td>league_AgeExemptFarmMaxOV</td><td><input class="inputText" required type="number" style="width:150px;" name="league_AgeExemptFarmMaxOV" value="'.$leagueleague_AgeExemptFarmMaxOV.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[30].'</td></tr>';
echo '<tr><td>league_FarmMaxAge</td><td><input class="inputText" required type="number" style="width:150px;" name="league_FarmMaxAge" value="'.$leagueleague_FarmMaxAge.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[19].'</td></tr>';
echo '<tr><td>league_GameInProWaivers</td><td><input class="inputText" required type="number" style="width:150px;" name="league_GameInProWaivers" value="'.$leagueleague_GameInProWaivers.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[20].'</td></tr>';
echo '<tr><td>league_AgeExemptWaivers</td><td><input class="inputText" required type="number" style="width:150px;" name="league_AgeExemptWaivers" value="'.$leagueleague_AgeExemptWaivers.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[31].'</td></tr>';
echo '<tr><td>league_OVSkatersWaivers</td><td><input class="inputText" required type="number" style="width:150px;" name="league_OVSkatersWaivers" value="'.$leagueleague_OVSkatersWaivers.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[32].'</td></tr>';
echo '<tr><td>league_OVGoaliesWaivers</td><td><input class="inputText" required type="number" style="width:150px;" name="league_OVGoaliesWaivers" value="'.$leagueleague_OVGoaliesWaivers.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[33].'</td></tr>';
echo '<tr><td>league_SalaryWaivers</td><td><input class="inputText" required type="number" style="width:150px;" name="league_SalaryWaivers" value="'.$leagueleague_SalaryWaivers.'"></td></tr>';

echo '<tr class="tr"><td style="width:175px;"></td><td>'.$db_admin_param_langue[40].'</td></tr>';

$zones_array = array();
$timestamp = time();
foreach(timezone_identifiers_list() as $key => $zone) {
	date_default_timezone_set($zone);
	$zones_array[$key]['zone'] = $zone;
	$zones_array[$key]['diff_from_GMT'] = 'GMT ' . date('P', $timestamp);
}
echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[28].'</td></tr>';
echo '<tr><td>TimeZone</td><td>';
echo '<select name="TimeZone">';
for($j=0;$j<count($zones_array);$j++) {
	$selected = '';
	if($leagueTimeZone == $zones_array[$j]['zone']) $selected = 'selected="selected"';
	echo '<option value="'.$zones_array[$j]['zone'].'" '.$selected.'>';
	echo $zones_array[$j]['diff_from_GMT'].' - '.$zones_array[$j]['zone'];
	echo '</option>';
}
echo '</select>';
echo '</td></tr>';

echo '<tr class="tr"><td style="width:175px;">'.$db_admin_param_langue[41].'</td><td>'.$db_admin_param_langue[42].'</td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[35].'</td></tr>';
echo '<tr><td>league_TradeToolStatus</td>';
echo '<td>';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-left:80px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_TradeToolStatus\').value = 1;">'.$db_admin_param_langue[47].'</span>';
echo '<span style="cursor:pointer; display:block; clear:both; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_TradeToolStatus\').value = 0;">'.$db_admin_param_langue[36].'</span>';
echo '<input style="display:block; float:left; width:160px;" type="range" id="league_TradeToolStatus" name="league_TradeToolStatus" min="0" max="2" step="1" value="'.$leagueleague_TradeToolStatus.'">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_TradeToolStatus\').value = 2;">'.$db_admin_param_langue[37].'</span>';
echo '</td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[48].'</td></tr>';
echo '<tr><td>league_TradeToolDraft</td><td><input class="inputText" required type="number" style="width:150px;" name="league_TradeToolDraft" value="'.$leagueleague_TradeToolDraft.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[49].'</td></tr>';
echo '<tr><td>league_TradeToolDraftROunds</td><td><input class="inputText" required type="number" min="1" max="9" style="width:150px;" name="league_TradeToolDraftRounds" value="'.$leagueleague_TradeToolDraftRounds.'"></td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[50].'</td></tr>';
echo '<tr><td>league_TradeToolDisplay</td>';
echo '<td>';
echo '<span style="cursor:pointer; display:block; clear:both; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_TradeToolDisplay\').value = 0;">'.$db_admin_param_langue[51].'</span>';
echo '<input style="display:block; float:left; width:160px;" type="range" id="league_TradeToolDisplay" name="league_TradeToolDisplay" min="0" max="1" step="1" value="'.$leagueleague_TradeToolDisplay.'">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_TradeToolDisplay\').value = 1;">'.$db_admin_param_langue[52].'</span>';
echo '</td></tr>';

echo '<tr class="tr"><td colspan="2" style="height:0px;"></td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[53].'</td></tr>';
echo '<tr><td>league_TradeToolOtherMandatory</td>';
echo '<td>';
echo '<span style="cursor:pointer; display:block; clear:both; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_TradeToolOtherMandatory\').value = 0;">'.$db_admin_param_langue[54].'</span>';
echo '<input style="display:block; float:left; width:160px;" type="range" id="league_TradeToolOtherMandatory" name="league_TradeToolOtherMandatory" min="0" max="1" step="1" value="'.$leagueleague_TradeToolOtherMandatory.'">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_TradeToolOtherMandatory\').value = 1;">'.$db_admin_param_langue[55].'</span>';
echo '</td></tr>';

echo '<tr class="tr"><td style="width:175px;">'.$db_admin_param_langue[43].'</td><td>'.$db_admin_param_langue[44].'</td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[45].'</td></tr>';
echo '<tr><td>league_UFAToolStatus</td>';
echo '<td>';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-left:80px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_UFAToolStatus\').value = 1;">'.$db_admin_param_langue[46].'</span>';
echo '<span style="cursor:pointer; display:block; clear:both; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_UFAToolStatus\').value = 0;">'.$db_admin_param_langue[36].'</span>';
echo '<input style="display:block; float:left; width:160px;" type="range" id="league_UFAToolStatus" name="league_UFAToolStatus" min="0" max="2" step="1" value="'.$leagueleague_UFAToolStatus.'">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_UFAToolStatus\').value = 2;">'.$db_admin_param_langue[37].'</span>';
echo '</td></tr>';

echo '<tr class="tr"><td style="width:175px;">'.$db_admin_param_langue[58].'</td><td>'.$db_admin_param_langue[60].'</td></tr>';

echo '<tr class="tr_content1"><td colspan="2">'.$db_admin_param_langue[59].'</td></tr>';
echo '<tr><td>league_position</td>';
echo '<td>';
echo '<span style="cursor:pointer; display:block; clear:both; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_position\').value = 0;">'.$db_admin_param_langue[36].'</span>';
echo '<input style="display:block; float:left; width:160px;" type="range" id="league_position" name="league_position" min="0" max="1" step="1" value="'.$leagueleague_position.'">';
echo '<span style="cursor:pointer; display:block; float:left; height:20px; padding-top:2px;" onclick="javascript:document.getElementById(\'league_position\').value = 1;">'.$db_admin_param_langue[37].'</span>';
echo '</td></tr>';

?>

<tr class="tr"><td colspan="2" style="text-align:right;"><input class="button" type="submit" name="submit" value="<?php echo $db_admin_all_langue[1]; ?>"></td></tr>
</table>
</form>

<script type="text/javascript">
<!--

document.addEventListener("DOMContentLoaded", start(), false);

//-->
</script>