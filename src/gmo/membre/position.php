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

function deleteChangeTeam(playerID) {
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
	var page = '<?php echo BASE_URL?>gmo/admin/position_delete.php';
	var parameters = "";
	parameters += "playerID=" + encodeURIComponent(playerID);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
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

		if (xmlhttp.readyState==4 && xmlhttp.status==500) {
			var response = xmlhttp.responseText;
			if(response) console.log(response);
			document.body.style.cursor = "default";
			popupAlert("There was an error submitting position change");
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
	
	setTimeout(function(){
		location.reload();
    }, 2000);

	
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
<div class="row">
    <div class="col-12">
        <div class="card mt-2">
            <div class="card-header text-center"><?php echo $db_membre_Position[5]; ?></div>
            <div class="card-body ">
            
            	<div class = "col border pb-2 pt-2">
                <select id="selectPlayer" style="width:20em; text-align:center;" onchange="javascript:selectPlayer();">
                <option value="#"><?php echo $db_membre_Position[6]; ?></option>
                <?php
                for($i=0;$i<count($playerName);$i++) {
                	?>
                	<option data-pos="<?php echo $playerPosi[$i]; ?>" value="<?php echo $playerName[$i]; ?>"><?php echo $playerName[$i].' - '.$playerPosT[$i]; ?></option>
                	<?php
                }
                ?>
                </select>
                
                <div style="width:50%;  margin-top:20px;" id="selectedPlayerWindow">
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
                	
                	<div style = "width:13em"><input class="button" type = "button" value="Submit" onclick="javascript:save();"></div>
                	
                </div>
                
                </div>
                <!-- <div style="text-align:center; width:100%;">
                	<a class="tooltip" href="<?php //echo BASE_URL?>gmo/membre/position.php"><img class="menu2" src="<?php //echo BASE_URL?>gmo/images/design/position.png" alt="<?php //$db_membre_Position[14]; ?>"><span class="tooltiptext"><?php //echo $db_membre_Position[14]; ?></span></a>
                </div> -->
       		</div>
    	</div>

	</div> <!-- end col -->
	
	
	<!-- pending start -->
	<?php 

	
if($league_langue == "fr") {
    $langPosition[0] = 'Changement de Position';
    $langPosition[1] = 'C';
    $langPosition[2] = 'AG';
    $langPosition[3] = 'AD';
    $langPosition[4] = 'D';
    $langPosition[5] = 'G';
    $langPosition[6] = 'DATE';
    $langPosition[7] = 'JOUEUR';
    $langPosition[8] = 'ÉQUIPE';
    $langPosition[9] = 'AVANT';
    $langPosition[10] = 'APRÈS';
    $langPosition[11] = 'SUPPRIMER';
    $langPosition[12] = 'POSITION';
    $langPosition[13] = 'TRIER PAR';
    $langPosition[14] = 'ÉQUIPE';
    $langPosition[100] = 'Menu Principal';
    $langPosition[101] = 'Page des échanges';
    $langPosition[102] = 'Page des signatures';
    $langPosition[103] = 'Page des changements de position';
    $langPosition[104] = 'Page des votes';
}

if($league_langue == "en") {
    $langPosition[0] = 'Position Change';
    $langPosition[1] = 'C';
    $langPosition[2] = 'LW';
    $langPosition[3] = 'RW';
    $langPosition[4] = 'D';
    $langPosition[5] = 'G';
    $langPosition[6] = 'DATE';
    $langPosition[7] = 'PLAYER';
    $langPosition[8] = 'TEAM';
    $langPosition[9] = 'BEFORE';
    $langPosition[10] = 'AFTER';
    $langPosition[11] = 'DELETE';
    $langPosition[12] = 'POSITION';
    $langPosition[13] = 'SORT BY';
    $langPosition[14] = 'TEAM';
    $langPosition[100] = 'Home';
    $langPosition[101] = 'Trade Page';
    $langPosition[102] = 'Signing Page';
    $langPosition[103] = 'Position Change Page';
    $langPosition[104] = 'Poll Page';
}

$pendingRequests = false;
$sql = "SELECT YEAR(`DATE`) FROM `".$db_table."_position` GROUP BY YEAR(`DATE`) ORDER BY `DATE` DESC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if(mysqli_num_rows($query) != 0) {
    while($data = mysqli_fetch_array($query)) {
        $DB_YR[] = $data['YEAR(`DATE`)'];
    }
    
    $sqlYear = $DB_YR[0];
    //if(isset($currentYear)) $sqlYear = $currentYear;
    //$sqlTeam = "";
    //if(isset($currentTeam)) $sqlTeam = "`TEAM` = '".$currentTeam."' AND ";
    $sqlTeam = "`TEAM` = '".$_SESSION['equipesim']."' AND ";
    $sql = "SELECT * FROM `".$db_table."_position` WHERE ".$sqlTeam."`DATE` >= '".$sqlYear."-01-01 00:00:00' AND `DATE` <= '".$sqlYear."-12-31 23:59:59' ORDER BY `ID` DESC";
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if(mysqli_num_rows($query) != 0) {
        
        $pendingRequests= true;
        
        while($data = mysqli_fetch_array($query)) {
            $DB_ID[] = $data['ID'];
            $DB_DT[] = $data['DATE'];
            $DB_NM[] = $data['NAME'];
            $DB_TM[] = $data['TEAM'];
            if($data['POS_BF'] == '00') $DB_BF[] = $langPosition[1];
            if($data['POS_BF'] == '01') $DB_BF[] = $langPosition[2];
            if($data['POS_BF'] == '02') $DB_BF[] = $langPosition[3];
            if($data['POS_BF'] == '03') $DB_BF[] = $langPosition[4];
            if($data['POS_BF'] == '04') $DB_BF[] = $langPosition[5];
            if($data['POS_AF'] == '00') $DB_AF[] = $langPosition[1];
            if($data['POS_AF'] == '01') $DB_AF[] = $langPosition[2];
            if($data['POS_AF'] == '02') $DB_AF[] = $langPosition[3];
            if($data['POS_AF'] == '03') $DB_AF[] = $langPosition[4];
            if($data['POS_AF'] == '04') $DB_AF[] = $langPosition[5];
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


?>
	<div class="col-12" >
		<div class="card mt-2">
			<div class="card-header text-center">Pending Changes</div>
			<div class="card-body">
			
			<?php if(!$pendingRequests) echo '<h4>No Pending Changes</h4>'; ?>
			
				<table class="table text-center"
					style="line-height: 2; vertical-align: middle; <?php if(!$pendingRequests) echo 'display:none'; ?>">
					<tr class="tr">
						<td><?php echo $langPosition[6]; ?></td>
						<td><?php echo $langPosition[7]; ?></td>
						<td colspan="3" style="text-align: center;"><?php echo $langPosition[12]; ?></td>
						<td><?php echo $langPosition[11]; ?></td>
					</tr>
            <?php
            $colorRow = 2;
            if (isset($DB_ID)) {
                for ($i = 0; $i < count($DB_ID); $i ++) {
                    if ($colorRow == 1)
                        $colorRow = 2;
                    else
                        $colorRow = 1;
                    ?>
            	<tr class="tr_content<?php echo $colorRow; ?>">
						<td><?php echo $DB_DT[$i]; ?></td>
						<td><?php echo $DB_NM[$i]; ?></td>
						<td><?php echo $DB_BF[$i]; ?></td>
						<td><i style="margin-left:2px; margin-right:4px; border: solid #<?php echo $databaseColors['colorMainText']; ?>; border-width: 0 3px 3px 0; display: inline-block; padding: 3px; transform: rotate(-45deg); -webkit-transform: rotate(-45deg);"></i></td>
						<td><?php echo $DB_AF[$i]; ?></td>
						<td><input
							onclick="javascript:deleteChangeTeam('<?php echo $DB_ID[$i]; ?>');"
							class="button" type="button"
							value="<?php echo $langPosition[11]; ?>"></td>
					</tr>
            <?php
                }
            }
            ?>
            </table>
			</div>
		</div><!-- card end -->
	</div><!-- col end -->
	
</div> <!-- row end -->


<script type="text/javascript">
<!--

document.addEventListener("DOMContentLoaded", selectPlayer(), false);

//-->
</script>