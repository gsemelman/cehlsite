<?php
// Green : #4caf50 | Red : #ae654c
$good = "#4caf50";
$bad = "#ae654c";
?>
<script type="text/javascript">
<!--

function save() {
	var verify = document.querySelector('input[name="radio"]:checked');
	if(!verify) {
		popupAlert("<?php echo $db_membre_Poll[1]; ?>", "<?php echo $bad; ?>");
		return;
	}
	var pollChoice = verify.value;
	var inputPollID = document.getElementById('inputPollID').value;
	
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
			if(response) {
				console.log(response);
				return;
			}
			document.body.style.cursor = "default";
			location.reload();
		}
	}
	var page = 'membre/poll_save.php';
	var parameters = "";
	parameters += "pollChoice=" + encodeURIComponent(pollChoice);
	parameters += "&inputPollID=" + encodeURIComponent(inputPollID);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

//-->
</script>

<?php
include 'login/mysqli.php';

$sql = "SELECT * FROM `".$db_table."_poll` WHERE `DATE_END` >= '$date_time' AND `VOTERS` NOT LIKE '%".$teamFHLSimName."%' ORDER BY `ID` ASC LIMIT 0,1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query) {
	while($data = mysqli_fetch_array($query)) {
		$DB_MOD_ID = $data['ID'];
		$DB_MOD_DT_ST = $data['DATE'];
		$DB_MOD_DT_EN = $data['DATE_END'];
		$DB_MOD_QT = $data['QUESTION'];
		$DB_MOD_OPTIONS = explode("|$|",$data['OPTIONS']);
	}
}

mysqli_close($con);
?>

<div style="padding:5px;">

<div style="width:100%; font-weight:bold; text-align:center;"><?php echo $db_membre_Poll[0]; ?></div>

<?php
if(isset($DB_MOD_QT)) {
?>
<div style="margin-top:25px; margin-left:5px; margin-right:5px; border-radius: 4px; width:300px; border:1px solid #<?php echo $databaseColors['colorInputBorder']; ?>">
	<div style="width:95%; margin-left:auto; margin-right:auto;">
		<div style="font-weight:bold; padding-top:15px; padding-bottom:15px;"><?php echo $DB_MOD_QT; ?></div>
<?php
	for($i=0;$i<count($DB_MOD_OPTIONS);$i++) {
?>
		<label id="selectPoll<?php echo $i; ?>" class="labelContainer"><?php echo $DB_MOD_OPTIONS[$i]; ?>
			<input type="radio" name="radio" value="<?php echo $i; ?>">
			<span class="customRadio"></span>
		</label>
<?php
	}
?>
		<div style="margin-bottom:15px;"><?php echo $DB_MOD_DT_ST." - ".$DB_MOD_DT_EN; ?></div>
	</div>
	<input type="button" class="button" onclick="javascript:save();" value="<?php echo $db_membre_all_langue[1]; ?>">
	<input type="hidden" id="inputPollID" value="<?php echo $DB_MOD_ID; ?>">
</div>
<?php
}
?>

</div>