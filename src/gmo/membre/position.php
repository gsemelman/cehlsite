<?php
// Green : #4caf50 | Red : #ae654c
$good = "#4caf50";
$bad = "#ae654c";
?>
<script type="text/javascript">
<!--

function selectPlayer() {
	var playerName = document.getElementById('selectPlayer').value;
	
	var posAfter = document.querySelector('input[name="radio"]:checked');
	if(posAfter) posAfter.checked = false;
	
	if(playerName == "#") {
		document.getElementById('selectedPlayerWindow').style.display = "none";
		return;
	}
	document.getElementById('selectedPlayerWindow').style.display = "block";
	var playerPosition = document.getElementById('selectPlayer').querySelector(':checked').getAttribute('data-pos');
	var html = '';
	document.getElementById('selectPos0').style.display = "block";
	document.getElementById('selectPos1').style.display = "block";
	document.getElementById('selectPos2').style.display = "block";
	document.getElementById('selectPos3').style.display = "block";
	document.getElementById('selectPos4').style.display = "block";
	if(playerPosition == "00") document.getElementById('selectPos0').style.display = "none";
	if(playerPosition == "01") document.getElementById('selectPos1').style.display = "none";
	if(playerPosition == "02") document.getElementById('selectPos2').style.display = "none";
	if(playerPosition == "03") document.getElementById('selectPos3').style.display = "none";
	if(playerPosition == "04") document.getElementById('selectPos4').style.display = "none";
	
}

function save() {
	var verify = document.querySelector('input[name="radio"]:checked');
	if(!verify) {
		popupAlert("<?php echo $db_membre_Position[7]; ?>", "<?php echo $bad; ?>");
		return;
	}
	var playerName = document.getElementById('selectPlayer').value;
	var playerPosBf = document.getElementById('selectPlayer').querySelector(':checked').getAttribute('data-pos');
	var playerPosAf = verify.value;
	
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
			document.getElementById('selectPlayer').selectedIndex = 0;
			selectPlayer();
			document.body.style.cursor = "default";
			popupAlert("<?php echo $db_membre_Position[13]; ?>", "<?php echo $good; ?>");
		}
	}
	var page = '<?php echo BASE_URL?>gmo/membre/position_save.php';
	var parameters = "";
	parameters += "playerName=" + encodeURIComponent(playerName);
	parameters += "&playerPosBf=" + encodeURIComponent(playerPosBf);
	parameters += "&playerPosAf=" + encodeURIComponent(playerPosAf);

	console.log(page);
	console.log(parameters);

	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

//-->
</script>

<?php

//only init if not already set
if(!isset($teamRank)){
    include FS_ROOT.'gmo/login/mysqli.php';
    
    $sql = "SELECT `RANK` FROM `$db_table` WHERE `INT` = '$teamID' LIMIT 1";
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    $useLNS = 0;
    if($query){
        while($data = mysqli_fetch_array($query)) {
            $teamRank = $data['RANK'];
        }
    }
    
    if($gm_sortPlayer == 0) $sql = "SELECT * FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' ORDER BY `NAME` ASC"; // Sort by First Name
    else $sql = "SELECT * FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' ORDER BY substring_index(TRIM(`NAME`), ' ', -1) ASC"; // Sort by Last Name
    
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if($query){
        while($data = mysqli_fetch_array($query)) {
            $playerName[] = $data['NAME'];
            $playerPosi[] = $data['POSI'];
            if($data['POSI'] == '00') $playerPosT[] = $db_membre_Position[0];
            if($data['POSI'] == '01') $playerPosT[] = $db_membre_Position[1];
            if($data['POSI'] == '02') $playerPosT[] = $db_membre_Position[2];
            if($data['POSI'] == '03') $playerPosT[] = $db_membre_Position[3];
            if($data['POSI'] == '04') $playerPosT[] = $db_membre_Position[4];
        }
    }
    mysqli_close($con);
}

?>
<div style="padding:5px;">

<div style="width:100%; font-weight:bold; text-align:center;"><?php echo $db_membre_Position[5]; ?></div>

<select id="selectPlayer" style="width:30%; text-align:center; margin-top:10px;" onchange="javascript:selectPlayer();">
<option value="#"><?php echo $db_membre_Position[6]; ?></option>
<?php
for($i=0;$i<count($playerName);$i++) {
	?>
	<option data-pos="<?php echo $playerPosi[$i]; ?>" value="<?php echo $playerName[$i]; ?>"><?php echo $playerName[$i].' - '.$playerPosT[$i]; ?></option>
	<?php
}
?>
</select>

<div style="width:30%; margin-top:20px;" id="selectedPlayerWindow">
	<label id="selectPos0" class="labelContainer"><?php echo $db_membre_Position[8]; ?>
		<input type="radio" name="radio" value="00">
		<span class="customRadio"></span>
	</label>
	<label id="selectPos1" class="labelContainer"><?php echo $db_membre_Position[9]; ?>
		<input type="radio" name="radio" value="01">
		<span class="customRadio"></span>
	</label>
	<label id="selectPos2" class="labelContainer"><?php echo $db_membre_Position[10]; ?>
		<input type="radio" name="radio" value="02">
		<span class="customRadio"></span>
	</label>
	<label id="selectPos3" class="labelContainer"><?php echo $db_membre_Position[11]; ?>
		<input type="radio" name="radio" value="03">
		<span class="customRadio"></span>
	</label>
	<label id="selectPos4" class="labelContainer"><?php echo $db_membre_Position[12]; ?>
		<input type="radio" name="radio" value="04">
		<span class="customRadio"></span>
	</label>
	<br>
	<input class="button" value="<?php echo $db_membre_all_langue[1]; ?>" onclick="javascript:save();">
</div>

<div style="text-align:center; width:100%; margin-top:20px;">
	<a class="tooltip" href="<?php echo BASE_URL?>gmo/membre/position.php"><img class="menu2" src="<?php echo BASE_URL?>gmo/images/design/position.png" alt="<?php $db_membre_Position[14]; ?>"><span class="tooltiptext"><?php echo $db_membre_Position[14]; ?></span></a>
</div>
</div>

<script type="text/javascript">
<!--

document.addEventListener("DOMContentLoaded", selectPlayer(), false);

//-->
</script>