<?php
include FS_ROOT.'gmo/login/mysqli.php';

$sql = "SELECT `RANK`, `LNS_FILE`, `LNS_DATE`, `TMS_LINEUP` FROM `$db_table` WHERE `INT` = '$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$useLNS = 0;
if($query){
	while($data = mysqli_fetch_array($query)) {
		$teamRank = $data['RANK'];
		$teamLineFile = $data['LNS_FILE'];
		$teamLineDate = $data['LNS_DATE'];
		$teamLineTMS = $data['TMS_LINEUP'];
	}
	$d1 = new DateTime($teamLineDate);
	$d2 = new DateTime($file_lastUpdate);
	if($d1 > $d2) { // If the saved .lns is greater than the last .ros file
		$useLNS = 1;
	}
}

if($gm_sortPlayer == 0) $sql = "SELECT * FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' ORDER BY `NAME` ASC"; // Sort by First Name
else $sql = "SELECT * FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' ORDER BY substring_index(TRIM(`NAME`), ' ', -1) ASC"; // Sort by Last Name

$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$playerRank[] = $data['RANK'];
		$playerName[] = $data['NAME'];
		$playerPosi[] = $data['POSI'];
		if($data['POSI'] == '00') $playerPosT[] = $db_membre_gmo_langue[31];
		if($data['POSI'] == '01') $playerPosT[] = $db_membre_gmo_langue[32];
		if($data['POSI'] == '02') $playerPosT[] = $db_membre_gmo_langue[33];
		if($data['POSI'] == '03') $playerPosT[] = $db_membre_gmo_langue[34];
		if($data['POSI'] == '04') $playerPosT[] = $db_membre_gmo_langue[98];
		
		if($data['HAND'] == 0) $playerHand[] = $db_membre_gmo_stats[13];
		else $playerHand[] = $db_membre_gmo_stats[14];
		
		$playerAges[] = $data['AGES'];
		$playerStat[] = $data['SAVE_STAT'];
		$playerCond[] = $data['COND'];
		$playerInte[] = $data['INTE'];
		$playerSpee[] = $data['SPEE'];
		$playerStre[] = $data['STRE'];
		$playerEndu[] = $data['ENDU'];
		$playerDura[] = $data['DURA'];
		$playerDisc[] = $data['DISC'];
		$playerSkat[] = $data['SKAT'];
		$playerPass[] = $data['PASS'];
		$playerPkct[] = $data['PKCT'];
		$playerDefs[] = $data['DEFS'];
		$playerOffs[] = $data['OFFS'];
		$playerExpe[] = $data['EXPE'];
		$playerLead[] = $data['LEAD'];
		$playerOver[] = $data['OVER'];
	}
}

mysqli_close($con);

function rankFinder($rank,$playerRank, $playerStat) {
	$rankID = 0;
	$rankID = array_search($rank,$playerRank);
	if($playerStat[$rankID] == 200) return $rankID;
	else {
		return "";
	}
}

// Use TMS file or LNS file for the lineup
if($useLNS == 0) $hex = $teamLineTMS; // Lineup only
if($useLNS == 1) $hex = substr($teamLineFile, 22, 130); // Get the lineup only!

$tlESL1CT = rankFinder(hexdec(substr($hex, 0, 2)), $playerRank, $playerStat);
$tlESL2CT = rankFinder(hexdec(substr($hex, 0+2, 2)), $playerRank, $playerStat);
$tlESL3CT = rankFinder(hexdec(substr($hex, 0+4, 2)), $playerRank, $playerStat);
$tlESL4CT = rankFinder(hexdec(substr($hex, 0+6, 2)), $playerRank, $playerStat);
$tlPPL1CT = rankFinder(hexdec(substr($hex, 0+8, 2)), $playerRank, $playerStat);
$tlPPL2CT = rankFinder(hexdec(substr($hex, 0+10, 2)), $playerRank, $playerStat);
$tlPPL3CT = rankFinder(hexdec(substr($hex, 0+12, 2)), $playerRank, $playerStat);
$tlPPL4CT = rankFinder(hexdec(substr($hex, 0+14, 2)), $playerRank, $playerStat);
$tlPKL1CT = rankFinder(hexdec(substr($hex, 0+16, 2)), $playerRank, $playerStat);
$tlPKL2CT = rankFinder(hexdec(substr($hex, 0+18, 2)), $playerRank, $playerStat);
$tlPKL3CT = rankFinder(hexdec(substr($hex, 0+20, 2)), $playerRank, $playerStat);
$tlPKL4CT = rankFinder(hexdec(substr($hex, 0+22, 2)), $playerRank, $playerStat);
$tlGOALS1 = rankFinder(hexdec(substr($hex, 0+24, 2)), $playerRank, $playerStat);
$tlESL1LW = rankFinder(hexdec(substr($hex, 0+26, 2)), $playerRank, $playerStat);
$tlESL2LW = rankFinder(hexdec(substr($hex, 0+28, 2)), $playerRank, $playerStat);
$tlESL3LW = rankFinder(hexdec(substr($hex, 0+30, 2)), $playerRank, $playerStat);
$tlESL4LW = rankFinder(hexdec(substr($hex, 0+32, 2)), $playerRank, $playerStat);
$tlPPL1LW = rankFinder(hexdec(substr($hex, 0+34, 2)), $playerRank, $playerStat);
$tlPPL2LW = rankFinder(hexdec(substr($hex, 0+36, 2)), $playerRank, $playerStat);
$tlPPL3WG = rankFinder(hexdec(substr($hex, 0+38, 2)), $playerRank, $playerStat);
$tlPPL4WG = rankFinder(hexdec(substr($hex, 0+40, 2)), $playerRank, $playerStat);
$tlPKL1WG = rankFinder(hexdec(substr($hex, 0+42, 2)), $playerRank, $playerStat);
$tlPKL2WG = rankFinder(hexdec(substr($hex, 0+44, 2)), $playerRank, $playerStat);
$tlPKL3D1 = rankFinder(hexdec(substr($hex, 0+46, 2)), $playerRank, $playerStat);
$tlPKL4D1 = rankFinder(hexdec(substr($hex, 0+48, 2)), $playerRank, $playerStat);
$tlEXTRA1 = rankFinder(hexdec(substr($hex, 0+50, 2)), $playerRank, $playerStat);
$tlESL1RW = rankFinder(hexdec(substr($hex, 0+52, 2)), $playerRank, $playerStat);
$tlESL2RW = rankFinder(hexdec(substr($hex, 0+54, 2)), $playerRank, $playerStat);
$tlESL3RW = rankFinder(hexdec(substr($hex, 0+56, 2)), $playerRank, $playerStat);
$tlESL4RW = rankFinder(hexdec(substr($hex, 0+58, 2)), $playerRank, $playerStat);
$tlPPL1RW = rankFinder(hexdec(substr($hex, 0+60, 2)), $playerRank, $playerStat);
$tlPPL2RW = rankFinder(hexdec(substr($hex, 0+62, 2)), $playerRank, $playerStat);
$tlPPL3D1 = rankFinder(hexdec(substr($hex, 0+64, 2)), $playerRank, $playerStat);
$tlPPL4D1 = rankFinder(hexdec(substr($hex, 0+66, 2)), $playerRank, $playerStat);
$tlPKL1D1 = rankFinder(hexdec(substr($hex, 0+68, 2)), $playerRank, $playerStat);
$tlPKL2D1 = rankFinder(hexdec(substr($hex, 0+70, 2)), $playerRank, $playerStat);
$tlPKL3D2 = rankFinder(hexdec(substr($hex, 0+72, 2)), $playerRank, $playerStat);
$tlPKL4D2 = rankFinder(hexdec(substr($hex, 0+74, 2)), $playerRank, $playerStat);

$tlEXTRA2 = rankFinder(hexdec(substr($hex, 0+76, 2)), $playerRank, $playerStat);
//if($FHLSimVersion == 1 || $FHLSimVersion == 3) $extra2 = substr($hex, 0+76, 2);
//if($FHLSimVersion == 2) $shoutout1 = substr($hex, 0+76, 2); // CHANGÉ: SHOOTOUT1

$tlESL1D1 = rankFinder(hexdec(substr($hex, 0+78, 2)), $playerRank, $playerStat);
$tlESL2D1 = rankFinder(hexdec(substr($hex, 0+80, 2)), $playerRank, $playerStat);
$tlESL3D1 = rankFinder(hexdec(substr($hex, 0+82, 2)), $playerRank, $playerStat);
$tlESL4D1 = rankFinder(hexdec(substr($hex, 0+84, 2)), $playerRank, $playerStat);
$tlPPL1D1 = rankFinder(hexdec(substr($hex, 0+86, 2)), $playerRank, $playerStat);
$tlPPL2D1 = rankFinder(hexdec(substr($hex, 0+88, 2)), $playerRank, $playerStat);
$tlPPL3D2 = rankFinder(hexdec(substr($hex, 0+90, 2)), $playerRank, $playerStat);
$tlPPL4D2 = rankFinder(hexdec(substr($hex, 0+92, 2)), $playerRank, $playerStat);
$tlPKL1D2 = rankFinder(hexdec(substr($hex, 0+94, 2)), $playerRank, $playerStat);
$tlPKL2D2 = rankFinder(hexdec(substr($hex, 0+96, 2)), $playerRank, $playerStat);

// 3 octets à 0xFF - 98-99-100-101-102-103
//if($FHLSimVersion == 2) $shoutout2 = substr($hex, 0+102, 2); // 102-103 : NOUVEAU SHOOTOUT2

$tlESL1D2 = rankFinder(hexdec(substr($hex, 0+104, 2)), $playerRank, $playerStat);
$tlESL2D2 = rankFinder(hexdec(substr($hex, 0+106, 2)), $playerRank, $playerStat);
$tlESL3D2 = rankFinder(hexdec(substr($hex, 0+108, 2)), $playerRank, $playerStat);
$tlESL4D2 = rankFinder(hexdec(substr($hex, 0+110, 2)), $playerRank, $playerStat);
$tlPPL1D2 = rankFinder(hexdec(substr($hex, 0+112, 2)), $playerRank, $playerStat);
$tlPPL2D2 = rankFinder(hexdec(substr($hex, 0+114, 2)), $playerRank, $playerStat);

// 7 octets à 0xFF - 116-117/118-119/120-121/122-123/124-125/126-127/128-129
//if($FHLSimVersion == 2) $shoutout3 = substr($hex, 0+128, 2); // 128-129 : NOUVEAU SHOOTOUT3

?>

<script type="text/javascript" language="JavaScript">
<!--

var playerRank = <?php echo json_encode($playerRank); ?>;
var playerName = <?php echo json_encode($playerName); ?>;
var playerPosi = <?php echo json_encode($playerPosi); ?>;
var playerPosT = <?php echo json_encode($playerPosT); ?>;
var playerHand = <?php echo json_encode($playerHand); ?>;
var playerAges = <?php echo json_encode($playerAges); ?>;
var playerStat = <?php echo json_encode($playerStat); ?>;
var playerCond = <?php echo json_encode($playerCond); ?>;
var playerInte = <?php echo json_encode($playerInte); ?>;
var playerSpee = <?php echo json_encode($playerSpee); ?>;
var playerStre = <?php echo json_encode($playerStre); ?>;
var playerEndu = <?php echo json_encode($playerEndu); ?>;
var playerDura = <?php echo json_encode($playerDura); ?>;
var playerDisc = <?php echo json_encode($playerDisc); ?>;
var playerSkat = <?php echo json_encode($playerSkat); ?>;
var playerPass = <?php echo json_encode($playerPass); ?>;
var playerPkct = <?php echo json_encode($playerPkct); ?>;
var playerDefs = <?php echo json_encode($playerDefs); ?>;
var playerOffs = <?php echo json_encode($playerOffs); ?>;
var playerExpe = <?php echo json_encode($playerExpe); ?>;
var playerLead = <?php echo json_encode($playerLead); ?>;
var playerOver = <?php echo json_encode($playerOver); ?>;

// Show the selected player Statistics
function tlGetPlayerInfos(x) {
	if(x != "") {
		var div = document.getElementById(x);
		var tlGRList = document.querySelectorAll('#tlSelectedPlayer div.selected');
		for(var i=0;i<tlGRList.length;i++) {
			if(tlGRList[i].classList.contains('selected')) tlGRList[i].classList.remove('selected');
		}
		div.classList.add('selected');
	}
	else {
		var tlGRList = document.querySelectorAll('#tlSelectedPlayer div.selected');
		for(var i=0;i<tlGRList.length;i++) {
			if(tlGRList[i].classList.contains('selected')) x = tlGRList[i].id;
		}
	}
	
	x = x.replace(/\D/g,'');

	document.getElementById('statsPosT').value = playerPosT[x];
	document.getElementById('statsAges').value = playerAges[x];
	document.getElementById('statsHand').value = playerHand[x];
	document.getElementById('statsCond').value = playerCond[x];
	document.getElementById('statsInte').value = playerInte[x];
	document.getElementById('statsSpee').value = playerSpee[x];
	document.getElementById('statsStre').value = playerStre[x];
	document.getElementById('statsEndu').value = playerEndu[x];
	document.getElementById('statsDura').value = playerDura[x];
	document.getElementById('statsDisc').value = playerDisc[x];
	document.getElementById('statsSkat').value = playerSkat[x];
	document.getElementById('statsPass').value = playerPass[x];
	document.getElementById('statsPkct').value = playerPkct[x];
	document.getElementById('statsDefs').value = playerDefs[x];
	document.getElementById('statsOffs').value = playerOffs[x];
	document.getElementById('statsExpe').value = playerExpe[x];
	document.getElementById('statsLead').value = playerLead[x];
	document.getElementById('statsOver').value = playerOver[x];
	
	document.getElementById('tlDivLineAverag').style.display = "none";
	document.getElementById('tlDivAssignedTo').style.display = "block";
	
	tlInLinePlayer();
}

// Calculate & Show the Line Average
function tlLineAverage(line) {
	var tlInputList = document.querySelectorAll("[id^='"+line+"']");
	var lineAveragePosT = 0;
	var lineAverageAges = 0;
	var lineAverageHand = 0;
	var lineAverageCond = 0;
	var lineAverageInte = 0;
	var lineAverageSpee = 0;
	var lineAverageStre = 0;
	var lineAverageEndu = 0;
	var lineAverageDura = 0;
	var lineAverageDisc = 0;
	var lineAverageSkat = 0;
	var lineAveragePass = 0;
	var lineAveragePkct = 0;
	var lineAverageDefs = 0;
	var lineAverageOffs = 0;
	var lineAverageExpe = 0;
	var lineAverageLead = 0;
	var lineAverageOver = 0;
	for(var i=0;i<tlInputList.length;i++) {
		var x = tlInputList[i].getAttribute('data-player-id');
		if(x != "") {
			lineAverageAges += Number(playerAges[x]);
			lineAverageCond += Number(playerCond[x]);
			lineAverageInte += Number(playerInte[x]);
			lineAverageSpee += Number(playerSpee[x]);
			lineAverageStre += Number(playerStre[x]);
			lineAverageEndu += Number(playerEndu[x]);
			lineAverageDura += Number(playerDura[x]);
			lineAverageDisc += Number(playerDisc[x]);
			lineAverageSkat += Number(playerSkat[x]);
			lineAveragePass += Number(playerPass[x]);
			lineAveragePkct += Number(playerPkct[x]);
			lineAverageDefs += Number(playerDefs[x]);
			lineAverageOffs += Number(playerOffs[x]);
			lineAverageExpe += Number(playerExpe[x]);
			lineAverageLead += Number(playerLead[x]);
			lineAverageOver += Number(playerOver[x]);
		}
	}
	lineAverageAges = Math.round(Number(lineAverageAges) / tlInputList.length);
	lineAverageCond = Math.round(Number(lineAverageCond) / tlInputList.length);
	lineAverageInte = Math.round(Number(lineAverageInte) / tlInputList.length);
	lineAverageSpee = Math.round(Number(lineAverageSpee) / tlInputList.length);
	lineAverageStre = Math.round(Number(lineAverageStre) / tlInputList.length);
	lineAverageEndu = Math.round(Number(lineAverageEndu) / tlInputList.length);
	lineAverageDura = Math.round(Number(lineAverageDura) / tlInputList.length);
	lineAverageDisc = Math.round(Number(lineAverageDisc) / tlInputList.length);
	lineAverageSkat = Math.round(Number(lineAverageSkat) / tlInputList.length);
	lineAveragePass = Math.round(Number(lineAveragePass) / tlInputList.length);
	lineAveragePkct = Math.round(Number(lineAveragePkct) / tlInputList.length);
	lineAverageDefs = Math.round(Number(lineAverageDefs) / tlInputList.length);
	lineAverageOffs = Math.round(Number(lineAverageOffs) / tlInputList.length);
	lineAverageExpe = Math.round(Number(lineAverageExpe) / tlInputList.length);
	lineAverageLead = Math.round(Number(lineAverageLead) / tlInputList.length);
	lineAverageOver = Math.round(Number(lineAverageOver) / tlInputList.length);
	document.getElementById('statsPosT').value = "-";
	document.getElementById('statsAges').value = lineAverageAges;
	document.getElementById('statsHand').value = "-";
	document.getElementById('statsCond').value = lineAverageCond;
	document.getElementById('statsInte').value = lineAverageInte;
	document.getElementById('statsSpee').value = lineAverageSpee;
	document.getElementById('statsStre').value = lineAverageStre;
	document.getElementById('statsEndu').value = lineAverageEndu;
	document.getElementById('statsDura').value = lineAverageDura;
	document.getElementById('statsDisc').value = lineAverageDisc;
	document.getElementById('statsSkat').value = lineAverageSkat;
	document.getElementById('statsPass').value = lineAveragePass;
	document.getElementById('statsPkct').value = lineAveragePkct;
	document.getElementById('statsDefs').value = lineAverageDefs;
	document.getElementById('statsOffs').value = lineAverageOffs;
	document.getElementById('statsExpe').value = lineAverageExpe;
	document.getElementById('statsLead').value = lineAverageLead;
	document.getElementById('statsOver').value = lineAverageOver;
	
	if(line == "tlESL1") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[30]; ?>";
	if(line == "tlESL2") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[36]; ?>";
	if(line == "tlESL3") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[35]; ?>";
	if(line == "tlESL4") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[37]; ?>";
	if(line == "tlPPL1") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[38]; ?>";
	if(line == "tlPPL2") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[41]; ?>";
	if(line == "tlPPL3") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[39]; ?>";
	if(line == "tlPPL4") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[42]; ?>";
	if(line == "tlPKL1") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[43]; ?>";
	if(line == "tlPKL2") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[45]; ?>";
	if(line == "tlPKL3") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[44]; ?>";
	if(line == "tlPKL4") document.getElementById('tlSpanLineAverag').textContent = "<?php echo $db_membre_gmo_langue[46]; ?>";
	
	document.getElementById('tlDivAssignedTo').style.display = "none";
	document.getElementById('tlDivLineAverag').style.display = "block";
}


// Found player already in the lineup (green select & assigned to)
function tlInLinePlayer() {
	var tlGRList = document.querySelectorAll('#tlSelectedPlayer div.selected');
	for(var i=0;i<tlGRList.length;i++) {
		var x = tlGRList[i].id.replace(/\D/g,'');
		break;
	}
	var tlAllInputsLines = document.querySelectorAll('.lines');
	for(var i=0;i<tlAllInputsLines.length;i++) {
		if(tlAllInputsLines[i].classList.contains('selected')) tlAllInputsLines[i].classList.remove('selected');
	}
	
	var tlAssignTo = "";
	for(var i=0;i<tlAllInputsLines.length;i++) {
		if(tlAllInputsLines[i].getAttribute('data-player-id') == x) {
			tlAllInputsLines[i].classList.add('selected');
			if(tlAssignTo != "") tlAssignTo += " ";
			tlAssignTo += tlAllInputsLines[i].getAttribute('data-assigned-id');
		}
	}
	
	document.getElementById('tlSpanAssignedTo').textContent = tlAssignTo;
}

// Position Show/Hide
function tlShowPosition(id) {
	if(document.getElementById(id).style.borderStyle == "inset") {
		document.getElementById(id).style.borderStyle = "outset";
	}
	else {
		document.getElementById(id).style.borderStyle = "inset";
	}
	
	// Remove the selected player to get stats of the first at top of the list.
	var trGRList = document.querySelectorAll('#tlSelectedPlayer div.selected');
	for(var i=0;i<trGRList.length;i++) {
		if(trGRList[i].classList.contains('selected')) trGRList[i].classList.remove('selected');
	}
	tlDivCreateLists();
}

/* Create/Modify the DIV Lists */
function tlDivCreateLists() {
	var tlSelectedPlayer = document.getElementById('tlSelectedPlayer');
	var tlImgC, tlImgLW, tlImgRW, tlImgD, tlImgG = 0;
	if(document.getElementById('tlImgC').style.borderStyle == "inset") tlImgC = 1;
	if(document.getElementById('tlImgLW').style.borderStyle == "inset") tlImgLW = 1;
	if(document.getElementById('tlImgRW').style.borderStyle == "inset") tlImgRW = 1;
	if(document.getElementById('tlImgD').style.borderStyle == "inset") tlImgD = 1;
	if(document.getElementById('tlImgG').style.borderStyle == "inset") tlImgG = 1;
	var hoverColor = 4;
	tlSelectedPlayer.innerHTML = "";
	for(var j=0;j<playerRank.length;j++) {
		if(playerStat[j] == 200) {
			var div = document.createElement("div");
			div.id = "tlDivList"+j;
			div.style.clear = "both";
			if((playerPosi[j] == '00' && tlImgC == 1) || (playerPosi[j] == '01' && tlImgLW == 1) || (playerPosi[j] == '02' && tlImgRW == 1) || (playerPosi[j] == '03' && tlImgD == 1) || (playerPosi[j] == '04' && tlImgG == 1)) {
				div.style.display = "block";
				if(hoverColor == 3) hoverColor = 4;
				else hoverColor = 3;
				div.setAttribute("class", "stopSelection hover"+hoverColor);
				div.setAttribute("onclick", "tlGetPlayerInfos(this.id);");
			}
			else {
				div.style.display = "none";
			}
			div.appendChild(document.createTextNode(playerName[j]));
			tlSelectedPlayer.appendChild(div);
		}
	}
	tlSelectedPlayer.scrollTop = 0;
	
	// Select the first player if there is none
	var tlGRList = document.querySelectorAll('#tlSelectedPlayer div.selected');
	if(tlGRList.length == 0) {
		var tlGRList2 = document.querySelectorAll('#tlSelectedPlayer div');
		for(var x=0;x<tlGRList2.length;x++) {
			if(tlGRList2[x].style.display == "block") {
				tlGRList2[x].classList.add('selected');
				tlGetPlayerInfos(tlGRList2[x].id);
				break;
			}
		}
	}
}

/* When a player is entered in an input */
function tlInputClicked(inputID) {
	var tlGRList = document.querySelectorAll('#tlSelectedPlayer div.selected');
	for(var i=0;i<tlGRList.length;i++) {
		var playerIDList = tlGRList[i].id.replace(/\D/g,'');
	}
	if(playerIDList === undefined) return;
	
	// Do not allow goalies in the skater inputs
	if((playerPosi[playerIDList] == '04' && (inputID == "tlEXTRA1" || inputID == "tlEXTRA2")) || (playerPosi[playerIDList] == '04' && inputID != "tlGOALS1")) {
		popupAlert(playerName[playerIDList]+"<?php echo $db_membre_gmo_langue[107]; ?>", "#ae654c");
		return;
	}
	
	// Do not allow other players than goalies in goalie inputs
	if(playerPosi[playerIDList] != '04' && (inputID == "tlGOALS1")) {
		popupAlert(playerName[playerIDList]+"<?php echo $db_membre_gmo_langue[108]; ?>", "#ae654c");
		return;
	}
	
	// Same Line Player Detection
	var shrinkID = inputID.substring(0, 6);
	var tlInputList = document.querySelectorAll("[id^='"+shrinkID+"']");
	var tlInputIDToSwap = "";
	for(var i=0;i<tlInputList.length;i++) {
		var playerIDInput = tlInputList[i].getAttribute('data-player-id');
		if(playerIDInput == playerIDList && inputID != tlInputList[i].id) {
			tlInputIDToSwap = tlInputList[i].id;
			break;
		}
	}
	if(tlInputIDToSwap != "") {
		var tlInputDataPlayerID = document.getElementById(inputID).getAttribute('data-player-id');
		document.getElementById(tlInputIDToSwap).setAttribute('data-player-id',tlInputDataPlayerID);
		document.getElementById(tlInputIDToSwap).value = document.getElementById(inputID).value;
	}
	
	// Enter in the input the new player value
	var playerIDStored = document.getElementById(inputID).getAttribute('data-player-id');
	if(playerIDList != playerIDStored) {
		document.getElementById(inputID).setAttribute('data-player-id',playerIDList);
		document.getElementById(inputID).value = playerName[playerIDList];
	}
	
	tlInLinePlayer(); // Green Background & Assign To
	tlLineAverage(shrinkID);
}

/* Change lines view */
function tlShowLines(id) {
	if(document.getElementById(id).style.borderStyle == "outset") {
		var tlIMGList = document.querySelectorAll("[id^='tlImgLine']");
		for(var i=0;i<tlIMGList.length;i++) {
			tlIMGList[i].style.borderStyle = "outset";
		}
		document.getElementById(id).style.borderStyle = "inset";
		
		document.getElementById("tlDivLinesEV").style.display = "none";
		document.getElementById("tlDivLinesPP").style.display = "none";
		document.getElementById("tlDivLinesPK").style.display = "none";
		
		if(id == "tlImgLineEV") document.getElementById("tlDivLinesEV").style.display = "block";
		if(id == "tlImgLinePP") document.getElementById("tlDivLinesPP").style.display = "block";
		if(id == "tlImgLinePK") document.getElementById("tlDivLinesPK").style.display = "block";
		
		tlGetPlayerInfos('');
	}
}

/* Auto Lines Button */
function tlAutoLine() {
	// Players sort by OVERALL
	var y = 0;
	var tmpOV = [];
	var tmpI = [];
	for(var i=0;i<playerStat.length;i++) {
		if(playerStat[i] == 200) {
			tmpOV[y] = playerOver[i];
			tmpI[y] = i;
			y++;
		}
	}
	
	var players = [];
	for (var i = 0; i < tmpOV.length; i++) {
		players.push({ov:tmpOV[i], rank:tmpI[i]});
	}
	players.sort(function(a, b) {
		return b.ov - a.ov;
	});
	
	var countC = 0;
	var countL = 0;
	var countR = 0;
	var countD = 0;
	var countG = 0;
	for(var i=0;i<players.length;i++) {
		var x = players[i].rank;
		if(playerPosi[x] == '00') {
			if(countC == 0) {
				document.getElementById("tlESL1CT").value = playerName[x];
				document.getElementById("tlESL1CT").setAttribute('data-player-id', x);
				document.getElementById("tlPPL1CT").value = playerName[x];
				document.getElementById("tlPPL1CT").setAttribute('data-player-id', x);
				document.getElementById("tlPPL3CT").value = playerName[x];
				document.getElementById("tlPPL3CT").setAttribute('data-player-id', x);
				document.getElementById("tlPKL1CT").value = playerName[x];
				document.getElementById("tlPKL1CT").setAttribute('data-player-id', x);
				document.getElementById("tlPKL3CT").value = playerName[x];
				document.getElementById("tlPKL3CT").setAttribute('data-player-id', x);
			}
			if(countC == 1) {
				document.getElementById("tlESL2CT").value = playerName[x];
				document.getElementById("tlESL2CT").setAttribute('data-player-id', x);
				document.getElementById("tlPPL2CT").value = playerName[x];
				document.getElementById("tlPPL2CT").setAttribute('data-player-id', x);
				document.getElementById("tlPPL4CT").value = playerName[x];
				document.getElementById("tlPPL4CT").setAttribute('data-player-id', x);
				document.getElementById("tlPKL2CT").value = playerName[x];
				document.getElementById("tlPKL2CT").setAttribute('data-player-id', x);
				document.getElementById("tlPKL4CT").value = playerName[x];
				document.getElementById("tlPKL4CT").setAttribute('data-player-id', x);
			}
			if(countC == 2) {
				document.getElementById("tlESL3CT").value = playerName[x];
				document.getElementById("tlESL3CT").setAttribute('data-player-id', x);
				
			}
			if(countC == 3) {
				document.getElementById("tlESL4CT").value = playerName[x];
				document.getElementById("tlESL4CT").setAttribute('data-player-id', x);
				
			}
			countC++;
		}
		if(playerPosi[x] == '01') {
			if(countL == 0) {
				document.getElementById("tlESL1LW").value = playerName[x];
				document.getElementById("tlESL1LW").setAttribute('data-player-id', x);
				document.getElementById("tlPPL1LW").value = playerName[x];
				document.getElementById("tlPPL1LW").setAttribute('data-player-id', x);
			}
			if(countL == 1) {
				document.getElementById("tlESL2LW").value = playerName[x];
				document.getElementById("tlESL2LW").setAttribute('data-player-id', x);
				document.getElementById("tlPPL2LW").value = playerName[x];
				document.getElementById("tlPPL2LW").setAttribute('data-player-id', x);
			}
			if(countL == 2) {
				document.getElementById("tlESL3LW").value = playerName[x];
				document.getElementById("tlESL3LW").setAttribute('data-player-id', x);
			}
			if(countL == 3) {
				document.getElementById("tlESL4LW").value = playerName[x];
				document.getElementById("tlESL4LW").setAttribute('data-player-id', x);
			}
			countL++;
		}
		if(playerPosi[x] == '02') {
			if(countR == 0) {
				document.getElementById("tlESL1RW").value = playerName[x];
				document.getElementById("tlESL1RW").setAttribute('data-player-id', x);
				document.getElementById("tlPPL1RW").value = playerName[x];
				document.getElementById("tlPPL1RW").setAttribute('data-player-id', x);
			}
			if(countR == 1) {
				document.getElementById("tlESL2RW").value = playerName[x];
				document.getElementById("tlESL2RW").setAttribute('data-player-id', x);
				document.getElementById("tlPPL2RW").value = playerName[x];
				document.getElementById("tlPPL2RW").setAttribute('data-player-id', x);
			}
			if(countR == 2) {
				document.getElementById("tlESL3RW").value = playerName[x];
				document.getElementById("tlESL3RW").setAttribute('data-player-id', x);
			}
			if(countR == 3) {
				document.getElementById("tlESL4RW").value = playerName[x];
				document.getElementById("tlESL4RW").setAttribute('data-player-id', x);
			}
			countR++;
		}
		if(playerPosi[x] == '03') {
			if(countD == 0) {
				document.getElementById("tlESL1D1").value = playerName[x];
				document.getElementById("tlESL1D1").setAttribute('data-player-id', x);
				document.getElementById("tlESL4D1").value = playerName[x];
				document.getElementById("tlESL4D1").setAttribute('data-player-id', x);
				document.getElementById("tlPPL1D1").value = playerName[x];
				document.getElementById("tlPPL1D1").setAttribute('data-player-id', x);
				document.getElementById("tlPPL3D1").value = playerName[x];
				document.getElementById("tlPPL3D1").setAttribute('data-player-id', x);
				document.getElementById("tlPKL1D1").value = playerName[x];
				document.getElementById("tlPKL1D1").setAttribute('data-player-id', x);
				document.getElementById("tlPKL3D1").value = playerName[x];
				document.getElementById("tlPKL3D1").setAttribute('data-player-id', x);
			}
			if(countD == 1) {
				document.getElementById("tlESL1D2").value = playerName[x];
				document.getElementById("tlESL1D2").setAttribute('data-player-id', x);
				document.getElementById("tlESL4D2").value = playerName[x];
				document.getElementById("tlESL4D2").setAttribute('data-player-id', x);
				document.getElementById("tlPPL1D2").value = playerName[x];
				document.getElementById("tlPPL1D2").setAttribute('data-player-id', x);
				document.getElementById("tlPPL3D2").value = playerName[x];
				document.getElementById("tlPPL3D2").setAttribute('data-player-id', x);
				document.getElementById("tlPKL1D2").value = playerName[x];
				document.getElementById("tlPKL1D2").setAttribute('data-player-id', x);
				document.getElementById("tlPKL3D2").value = playerName[x];
				document.getElementById("tlPKL3D2").setAttribute('data-player-id', x);
			}
			if(countD == 2) {
				document.getElementById("tlESL2D1").value = playerName[x];
				document.getElementById("tlESL2D1").setAttribute('data-player-id', x);
				document.getElementById("tlPPL2D1").value = playerName[x];
				document.getElementById("tlPPL2D1").setAttribute('data-player-id', x);
				document.getElementById("tlPPL4D1").value = playerName[x];
				document.getElementById("tlPPL4D1").setAttribute('data-player-id', x);
				document.getElementById("tlPKL2D1").value = playerName[x];
				document.getElementById("tlPKL2D1").setAttribute('data-player-id', x);
				document.getElementById("tlPKL4D1").value = playerName[x];
				document.getElementById("tlPKL4D1").setAttribute('data-player-id', x);
			}
			if(countD == 3) {
				document.getElementById("tlESL2D2").value = playerName[x];
				document.getElementById("tlESL2D2").setAttribute('data-player-id', x);
				document.getElementById("tlPPL2D2").value = playerName[x];
				document.getElementById("tlPPL2D2").setAttribute('data-player-id', x);
				document.getElementById("tlPPL4D2").value = playerName[x];
				document.getElementById("tlPPL4D2").setAttribute('data-player-id', x);
				document.getElementById("tlPKL2D2").value = playerName[x];
				document.getElementById("tlPKL2D2").setAttribute('data-player-id', x);
				document.getElementById("tlPKL4D2").value = playerName[x];
				document.getElementById("tlPKL4D2").setAttribute('data-player-id', x);
			}
			if(countD == 4) {
				document.getElementById("tlESL3D1").value = playerName[x];
				document.getElementById("tlESL3D1").setAttribute('data-player-id', x);
			}
			if(countD == 5) {
				document.getElementById("tlESL3D2").value = playerName[x];
				document.getElementById("tlESL3D2").setAttribute('data-player-id', x);
			}
			countD++;
		}
		if(playerPosi[x] == '04') {
			if(countG == 0) {
				document.getElementById("tlGOALS1").value = playerName[x];
				document.getElementById("tlGOALS1").setAttribute('data-player-id', x);
			}
			countG++;
		}
	}
	
	// Players sort by OVERALL (Wings only!)
	var y = 0;
	var tmpOV = [];
	var tmpI = [];
	for(var i=0;i<playerStat.length;i++) {
		if(playerStat[i] == 200 && (playerPosi[i] == '01' || playerPosi[i] == '02')) {
			tmpOV[y] = playerOver[i];
			tmpI[y] = i;
			y++;
		}
	}
	
	var players = [];
	for (var i = 0; i < tmpOV.length; i++) {
		players.push({ov:tmpOV[i], rank:tmpI[i]});
	}
	players.sort(function(a, b) {
		return b.ov - a.ov;
	});
	
	var countWings = 0;
	for(var i=0;i<players.length;i++) {
		var x = players[i].rank;
		if(countWings == 0) {
			document.getElementById("tlPPL3WG").value = playerName[x];
			document.getElementById("tlPPL3WG").setAttribute('data-player-id', x);
			document.getElementById("tlPKL1WG").value = playerName[x];
			document.getElementById("tlPKL1WG").setAttribute('data-player-id', x);
		}
		if(countWings == 1) {
			document.getElementById("tlPPL4WG").value = playerName[x];
			document.getElementById("tlPPL4WG").setAttribute('data-player-id', x);
			document.getElementById("tlPKL2WG").value = playerName[x];
			document.getElementById("tlPKL2WG").setAttribute('data-player-id', x);
			break;
		}
		countWings++;
	}
	
	// Players sort by ENDURANCE (Extra Skaters)
	var y = 0;
	var tmpEN = [];
	var tmpI = [];
	for(var i=0;i<playerStat.length;i++) {
		if(playerStat[i] == 200 && playerPosi[i] != '04') {
			tmpEN[y] = playerEndu[i];
			tmpI[y] = i;
			y++;
		}
	}
	
	var players = [];
	for (var i = 0; i < tmpEN.length; i++) {
		players.push({en:tmpEN[i], rank:tmpI[i]});
	}
	players.sort(function(a, b) {
		return b.en - a.en;
	});
	
	var countExtra = 0;
	for(var i=0;i<players.length;i++) {
		var x = players[i].rank;
		if(countExtra == 0) {
			document.getElementById("tlEXTRA1").value = playerName[x];
			document.getElementById("tlEXTRA1").setAttribute('data-player-id', x);
		}
		if(countExtra == 1) {
			document.getElementById("tlEXTRA2").value = playerName[x];
			document.getElementById("tlEXTRA2").setAttribute('data-player-id', x);
			break;
		}
		countExtra++;
	}
	
	tlGetPlayerInfos('');
}

/* Save to the database the lineup */
function dechex(x) {
	var dec = playerRank[x];
	var tmpdec = (+dec).toString(16).toUpperCase();
	if(tmpdec.length == 1) tmpdec = "0"+tmpdec;
	return tmpdec;
}
function ascii_to_hexa(str) {
	for(var i = str.length; str.length != 10; i++) {
		str = str + " ";
	}
	var arr1 = [];
	for (var n = 0, l = str.length; n < l; n ++) {
		var hex = Number(str.charCodeAt(n)).toString(16);
		arr1.push(hex);
	}
	return arr1.join('');
}

function tlSave() {
	
	// Look for an empty box!
	var tlAllInputsLines = document.querySelectorAll('.lines');
	var tlInputNotFill = "";
	for(var i=0;i<tlAllInputsLines.length;i++) {
		if(tlAllInputsLines[i].value == "") {
			tlInputNotFill += tlAllInputsLines[i].getAttribute('data-assigned-id') + ", ";
		}
	}
	if(tlInputNotFill != "") {
		popupAlert("<?php echo $db_membre_gmo_langue[109]; ?>"+tlInputNotFill, "#ae654c");
		return;
	}
	var tlLNSLineup = "";
	tlLNSLineup += dechex(document.getElementById("tlESL1CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL2CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL3CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL4CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL1CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL2CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL3CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL4CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL1CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL2CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL3CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL4CT").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlGOALS1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL1LW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL2LW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL3LW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL4LW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL1LW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL2LW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL3WG").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL4WG").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL1WG").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL2WG").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL3D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL4D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlEXTRA1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL1RW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL2RW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL3RW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL4RW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL1RW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL2RW").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL3D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL4D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL1D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL2D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL3D2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL4D2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlEXTRA2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL1D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL2D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL3D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL4D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL1D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL2D1").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL3D2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL4D2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL1D2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPKL2D2").getAttribute('data-player-id'));
	tlLNSLineup += "FFFFFF";
	tlLNSLineup += dechex(document.getElementById("tlESL1D2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL2D2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL3D2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlESL4D2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL1D2").getAttribute('data-player-id'));
	tlLNSLineup += dechex(document.getElementById("tlPPL2D2").getAttribute('data-player-id'));
	tlLNSLineup += "FFFFFFFFFFFFFF";
	
	var tlPasswd = ascii_to_hexa(document.getElementById("tlPASSWD").value);
	
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
			if(response == "done") {
				popupAlert("<?php echo $db_membre_gmo_langue[110]; ?>", "#4caf50");
			}
			else alert('Error! ' + response);
		}
	}
	var page = 'gmo/editor/teamLinesSave.php';
	var parameters = "";
	parameters += "lineup=" + encodeURIComponent(tlLNSLineup);
	parameters += "&passwd=" + encodeURIComponent(tlPasswd);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function tlButtonReset() {
	var tlAllInputsLines = document.querySelectorAll('.lines');
	for(var i=0;i<tlAllInputsLines.length;i++) {
		if(tlAllInputsLines[i].classList.contains('selected')) tlAllInputsLines[i].classList.remove('selected');
		tlAllInputsLines[i].setAttribute('data-player-id',"");
		tlAllInputsLines[i].value = "";
	}
}

//-->
</script>