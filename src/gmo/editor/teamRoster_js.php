<?php
include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `RANK` FROM `$db_table` WHERE `INT` = '$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$useLNS = 0;
if($query){
	while($data = mysqli_fetch_array($query)) {
		$teamRank = $data['RANK'];
	}
}

if($linesGame == 1){
    $SAVE_STAT = 'SAVE_STAT';
    $SAVE_PROT = 'SAVE_PROT';
    $LNS_DATE = 'LNS_DATE';
}
if($linesGame == 2){
    $SAVE_STAT = 'SAVE_STAT2';
    $SAVE_PROT = 'SAVE_PROT2';
    $LNS_DATE = 'LNS_DATE2';
}


// Search for .LNS on the server
$teamFHLSimName = $_SESSION['equipesim'];
$name_lines = $teamFHLSimName.'.lns';
//$server_file = $file_folder_lines.$name_lines;
$server_file = $file_folder_lines.$activeGameDay.'/'.$name_lines;
//error_log('----------------------'.$server_file.'----readable-'.var_export(is_readable($server_file), 1));
$loadlinesDisplay = "none";
$loadLinesAvailable = false;
if (is_readable($server_file)) {
    //$loadlinesDisplay = "inline";

    $file_date = date("Y-m-d H:i:s", filemtime($server_file));

    $lines_file_date = new DateTime($file_date);
    $db_last_updated = new DateTime($file_lastUpdate);

    error_log("lines old file date:" . $lines_file_date->format('Y-m-d H:i:s') . ' server update date:' . $db_last_updated->format('Y-m-d H:i:s'), 0);
    error_log(var_export($db_last_updated > $lines_file_date));

    if ($db_last_updated > $lines_file_date) {

        //include GMO_ROOT . 'login/mysqli.php';
        $savedLinesDate = '';
        $sql = "SELECT `" . $LNS_DATE . "` FROM `$db_table` WHERE `INT` = '$teamID' LIMIT 1";
        $query = mysqli_query($con, $sql) or die(mysqli_error($con));
        if ($query) {
            while ($data = mysqli_fetch_array($query)) {
                $savedLinesDate = $data[$LNS_DATE];
            }
        }
        //mysqli_close($con);

        if ($savedLinesDate) {

            $savedLinesDate = new DateTime($savedLinesDate);
            error_log('saved lines date: ' . $savedLinesDate->format('Y-m-d H:i:s'));

            error_log('saved lines date check: ' . var_export($db_last_updated > $savedLinesDate));
            if ($db_last_updated > $savedLinesDate) {
                $loadLinesAvailable = true;
                $loadlinesDisplay = "inline";
            }
        }
    }
}



$sql = "SELECT `ID`, `RANK`, `NAME`, `POSI`, `NUMB`, `PROT`, `HAND`, `HEIG`, `WEIG`, `AGES`, `STAT`, `COND`, 
`INTE`, `SPEE`, `STRE`, `ENDU`, `DURA`, `DISC`, `SKAT`, `PASS`, `PKCT`, `DEFS`, `OFFS`, `EXPE`, `LEAD`, `SALA`, `CONT`, 
`SUSP`, `GPGP`, `GOPM`, `ASAS`, `PLMN`, `PMGA`, `STST`, `PPSO`, `SHWN`, `GWLS`, `GTTI`, `HITS`, `BIRT`, `OVER`, `TEAM`,
`$SAVE_STAT` AS SAVE_STAT, `$SAVE_PROT` as SAVE_PROT FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank'";

if($gm_sortPlayer == 0){
    $sql .=" ORDER BY `NAME` ASC";
}else{
    $sql .=" ORDER BY substring_index(TRIM(`NAME`), ' ', -1) ASC";
}

//error_log($sql);

 //if($gm_sortPlayer == 0) $sql = "SELECT * FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' ORDER BY `NAME` ASC"; // Sort by First Name
 //else $sql = "SELECT * FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' ORDER BY substring_index(TRIM(`NAME`), ' ', -1) ASC"; // Sort by Last Name

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
		
		if($data['SAVE_PROT'] != "" && $data['SAVE_PROT'] == 1) {
			$playerProt[] = !$data['PROT'];
		}
		else $playerProt[] = $data['PROT'];
		$playerProt2[] = $data['PROT']; // Saving (Need to know the difference between them!)
		
		if($data['HAND'] == 0) $playerHand[] = $db_membre_gmo_stats[13];
		else $playerHand[] = $db_membre_gmo_stats[14];
		$playerAges[] = $data['AGES'];
		
		if($data['SAVE_STAT'] != "" && ($data['SAVE_STAT'] == "0" || $data['SAVE_STAT'] == "100" || $data['SAVE_STAT'] == "200")) {
			if($data['SUSP'] == 0) $playerStat[] = $data['SAVE_STAT'];
			else $playerStat[] = 100; // Scratch Suspended Players
		}
		else {
			if($data['SUSP'] == 0) $playerStat[] = $data['STAT'];
			else $playerStat[] = 100; // Scratch Suspended Players
			
		}
		if($data['SUSP'] == 0) $playerStat2[] = $data['STAT']; // Autoline
		else $playerStat2[] = 100; // Scratch Suspended Players
		
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
		$playerSusp[] = $data['SUSP'];
		
		// Injured
		/*
		STATUS
		C9|65: Injured DD
		CA|66|01: Injured 1W
		CB|67: Injured 3W
		CC|68|02: Injured 1M
		CD|69: Injured 3M
		CE|6A|03: Injured IN
		Pro to Scratch and Farm to Scratch directly
		AutoLine: Select the better OV first
		*/
		$playerStatus = 0;
		if(($data['STAT'] >= 201 && $data['STAT'] <= 206) || ($data['STAT'] >= 101 && $data['STAT'] <= 106) || ($data['STAT'] >= 1 && $data['STAT'] <= 3)) {
			$playerStatus = 1;
		}
		// Suspended
		if($data['SUSP'] != 0) {
			$playerStatus = 2;
		}
		$playerOffI[] = $playerStatus;
		
		$playerBirt[] = $data['BIRT'];
		$playerNumb[] = $data['NUMB'];
		$playerWeig[] = $data['WEIG'];
		
		$y=0;
		for($z=0;$z<=$data['HEIG'];$z=$z+12) {
			$y++;
		}
		$y--;
		$playerHeig[] = $y.''.$db_membre_gmo_stats[15].''.($data['HEIG'] - ($y*12));
		
		$playerCont[] = $data['CONT'];
		
		$playerSala[] = $data['SALA'];
		$tmpSala = 0;
		if($data['SALA'] >= 1000 && $data['SALA'] < 10000) $tmpSala = number_format($data['SALA'] / 1000, 2) . 'K';
		if($data['SALA'] >= 10000 && $data['SALA'] < 100000) $tmpSala = number_format($data['SALA'] / 1000, 1) . 'K';
		if($data['SALA'] >= 100000 && $data['SALA'] < 1000000) $tmpSala = number_format($data['SALA'] / 1000, 0) . 'K';
		if($data['SALA'] >= 1000000 && $data['SALA'] < 10000000) $tmpSala = number_format($data['SALA'] / 1000000, 2) . 'M';
		if($data['SALA'] >= 10000000 && $data['SALA'] < 100000000) $tmpSala = number_format($data['SALA'] / 1000000, 1) . 'M';
		if($data['SALA'] >= 100000000 && $data['SALA'] < 1000000000) $tmpSala = number_format($data['SALA'] / 1000000, 0) . 'M';
		$playerSalT[] = $tmpSala;
		
		$playerGPGP[] = $data['GPGP'];
		$playerGOPM[] = $data['GOPM'];
		$playerASAS[] = $data['ASAS'];
		$playerPMGA[] = $data['PMGA'];
		$playerPLMN[] = $data['PLMN'];
		
		if($data['POSI'] == '04') {
			if($data['PLMN'] != 0) {
				$playerHITS[] = round($data['PMGA'] * 60 / $data['PLMN'],2);
			}
			else $playerHITS[] = "-";
		}
		else $playerHITS[] = $data['HITS'];
		
		$playerPPSO[] = $data['PPSO'];
		$playerSHWN[] = $data['SHWN'];
		$playerGWLS[] = $data['GWLS'];
		$playerGTTI[] = $data['GTTI'];
		$playerSTST[] = $data['STST'];
		if($data['STST'] != 0) {
			if($data['POSI'] != '04') $playerSTPC[] = round($data['GOPM'] / $data['STST'] * 100, 1);
			else $playerSTPC[] = round(($data['STST']-$data['PMGA']) / $data['STST'] * 100, 1);
		}
		else $playerSTPC[] = "-";
	}
}

mysqli_close($con);

?>

<script type="text/javascript" language="JavaScript">
<!--

var playerRank = <?php echo json_encode($playerRank); ?>;
var playerName = <?php echo json_encode($playerName); ?>;
var playerPosi = <?php echo json_encode($playerPosi); ?>;
var playerPosT = <?php echo json_encode($playerPosT); ?>;
var playerProt = <?php echo json_encode($playerProt); ?>;
var playerProt2 = <?php echo json_encode($playerProt2); ?>; // Saving (Need to know the difference between them!)
var playerHand = <?php echo json_encode($playerHand); ?>;
var playerAges = <?php echo json_encode($playerAges); ?>;
var playerStat = <?php echo json_encode($playerStat); ?>;
var playerStat2 = <?php echo json_encode($playerStat2); ?>; // Autoline
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
var playerOffI = <?php echo json_encode($playerOffI); ?>;
var playerSusp = <?php echo json_encode($playerSusp); ?>;

var playerBirt = <?php echo json_encode($playerBirt); ?>;
var playerNumb = <?php echo json_encode($playerNumb); ?>;
var playerWeig = <?php echo json_encode($playerWeig); ?>;
var playerHeig = <?php echo json_encode($playerHeig); ?>;
var playerCont = <?php echo json_encode($playerCont); ?>;
var playerSala = <?php echo json_encode($playerSala); ?>; // Number Format
var playerSalT = <?php echo json_encode($playerSalT); ?>; // Text Format
var playerGPGP = <?php echo json_encode($playerGPGP); ?>;
var playerGOPM = <?php echo json_encode($playerGOPM); ?>;
var playerASAS = <?php echo json_encode($playerASAS); ?>;
var playerPMGA = <?php echo json_encode($playerPMGA); ?>;
var playerPLMN = <?php echo json_encode($playerPLMN); ?>;
var playerHITS = <?php echo json_encode($playerHITS); ?>;
var playerPPSO = <?php echo json_encode($playerPPSO); ?>;
var playerSHWN = <?php echo json_encode($playerSHWN); ?>;
var playerGWLS = <?php echo json_encode($playerGWLS); ?>;
var playerGTTI = <?php echo json_encode($playerGTTI); ?>;
var playerSTST = <?php echo json_encode($playerSTST); ?>;
var playerSTPC = <?php echo json_encode($playerSTPC); ?>;

var popupAlertTimeout;

// Show the selected player Statistics
function trGetPlayerInfos(x) {
	var div = document.getElementById(x);
	if(document.getElementById('trImgProtect').style.borderStyle == "outset") { // Expansion Draft
		if(div.classList.contains('selected')) div.classList.remove('selected');
		else div.classList.add('selected');
	}
	
	x = x.replace(/\D/g,'');

	document.getElementById('statsName').textContent = playerName[x];
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
	
	if(playerPosi[x] != '04') {
		// Foward Text
		document.getElementById('statsTxtGoalWin').textContent = '<?php echo $db_membre_gmo_stats[12]; ?>';
		document.getElementById('statsTxtGoalAssistLoose').textContent = '<?php echo $db_membre_gmo_stats[2]; ?>';
		document.getElementById('statsTxtPIMTies').textContent = '<?php echo $db_membre_gmo_stats[4]; ?>';
		document.getElementById('statsTxtplusMinusGA').textContent = '<?php echo $db_membre_gmo_stats[3]; ?>';
		document.getElementById('statsTxtHitsGAA').textContent = '<?php echo $db_membre_gmo_stats[10]; ?>';
		document.getElementById('statsTxtPPGPIM').textContent = '<?php echo $db_membre_gmo_stats[6]; ?>';
		document.getElementById('statsTxtSHGAs').textContent = '<?php echo $db_membre_gmo_stats[7]; ?>';
		document.getElementById('statsTxtGWSO').textContent = '<?php echo $db_membre_gmo_stats[8]; ?>';
		document.getElementById('statsTxtGT').textContent = '<?php echo $db_membre_gmo_stats[9]; ?>';
		document.getElementById('statsTxtSPctSvPct').textContent = '<?php echo $db_membre_gmo_stats[16]; ?>';
	}
	else {
		// Goalie Text
		document.getElementById('statsTxtGoalWin').textContent = '<?php echo $db_membre_gmo_stats[23]; ?>';
		document.getElementById('statsTxtGoalAssistLoose').textContent = '<?php echo $db_membre_gmo_stats[24]; ?>';
		document.getElementById('statsTxtPIMTies').textContent = '<?php echo $db_membre_gmo_stats[25]; ?>';
		document.getElementById('statsTxtplusMinusGA').textContent = '<?php echo $db_membre_gmo_stats[26]; ?>';
		document.getElementById('statsTxtHitsGAA').textContent = '<?php echo $db_membre_gmo_stats[27]; ?>';
		document.getElementById('statsTxtPPGPIM').textContent = '<?php echo $db_membre_gmo_stats[28]; ?>';
		document.getElementById('statsTxtSHGAs').textContent = '<?php echo $db_membre_gmo_stats[29]; ?>';
		document.getElementById('statsTxtGWSO').textContent = '<?php echo $db_membre_gmo_stats[30]; ?>';
		document.getElementById('statsTxtGT').textContent = '<?php echo $db_membre_gmo_stats[31]; ?>';
		document.getElementById('statsTxtSPctSvPct').textContent = '<?php echo $db_membre_gmo_stats[32]; ?>';
	}
	if(playerPosi[x] != '04') {
		// Foward Stats
		document.getElementById('statsBirt').textContent = playerBirt[x];
		document.getElementById('statsNumb').textContent = playerNumb[x];
		document.getElementById('statsHeig').textContent = playerWeig[x];
		document.getElementById('statsWeig').textContent = playerHeig[x];
		document.getElementById('statsCont').textContent = playerCont[x];
		document.getElementById('statsSalT').textContent = playerSalT[x];
		document.getElementById('statsGame').textContent = playerGPGP[x];
		document.getElementById('statsGoal').textContent = playerGOPM[x];
		document.getElementById('statsAssi').textContent = playerASAS[x];
		document.getElementById('statsPIMs').textContent = playerPMGA[x];
		document.getElementById('statsPLMN').textContent = playerPLMN[x];
		document.getElementById('statsHits').textContent = playerHITS[x];
		document.getElementById('statsPPGs').textContent = playerPPSO[x];
		document.getElementById('statsSHGs').textContent = playerSHWN[x];
		document.getElementById('statsGWSO').textContent = playerGWLS[x];
		document.getElementById('statsGTTI').textContent = playerGTTI[x];
		document.getElementById('statsShot').textContent = playerSTST[x];
		document.getElementById('statsSTPC').textContent = playerSTPC[x];
	}
	else {
		// Goalie Stats
		document.getElementById('statsBirt').textContent = playerBirt[x];
		document.getElementById('statsNumb').textContent = playerNumb[x];
		document.getElementById('statsHeig').textContent = playerWeig[x];
		document.getElementById('statsWeig').textContent = playerHeig[x];
		document.getElementById('statsCont').textContent = playerCont[x];
		document.getElementById('statsSalT').textContent = playerSalT[x];
		document.getElementById('statsGame').textContent = playerGPGP[x];
		document.getElementById('statsGoal').textContent = playerSHWN[x];
		document.getElementById('statsAssi').textContent = playerGWLS[x];
		document.getElementById('statsPIMs').textContent = playerGTTI[x];
		document.getElementById('statsPLMN').textContent = playerPMGA[x];
		document.getElementById('statsHits').textContent = playerHITS[x];
		document.getElementById('statsPPGs').textContent = playerGOPM[x];
		document.getElementById('statsSHGs').textContent = playerASAS[x];
		document.getElementById('statsGWSO').textContent = playerPPSO[x];
		document.getElementById('statsGTTI').textContent = "";
		document.getElementById('statsShot').textContent = playerSTST[x];
		document.getElementById('statsSTPC').textContent = playerSTPC[x];
	}
}

// Expansion Draft: Show/Hide the protected players
function trShowProtected() {
	var allSelectBoxes = document.querySelectorAll('.selectedPlayers div');
	for(var i=0;i<allSelectBoxes.length;i++) {
		var x = allSelectBoxes[i].id.replace(/\D/g,'');
		if(playerProt[x] == "1") {
			if(document.getElementById('trImgProtect').style.borderStyle == "inset") allSelectBoxes[i].innerHTML = allSelectBoxes[i].innerHTML.substr(1);
			else allSelectBoxes[i].innerHTML = "*"+allSelectBoxes[i].innerHTML;
		}
	}
	if(document.getElementById('trImgProtect').style.borderStyle == "inset") {
		document.getElementById('trImgProtect').style.borderStyle = "outset";
	}
	else {
		document.getElementById('trImgProtect').style.borderStyle = "inset";
	}
}

// Expansion draft: Change Protection status for a player
function trChangeProtected(id) {
	var x = id.replace(/\D/g,'');
	if(document.getElementById(id).innerHTML.substr(0, 1) == "*") {
		document.getElementById(id).innerHTML = document.getElementById(id).innerHTML.substr(1);
		playerProt[x] = "0";
	}
	else {
		document.getElementById(id).innerHTML = "*"+document.getElementById(id).innerHTML;
		playerProt[x] = "1";
	}
}

// Count the total players
function trTotalPlayer() {
	var trGRList = document.querySelectorAll('#trSelectedPlayers1 > div');
	var count = trGRList.length;
	var ok = 0;
	
	// 3 C-LW-RW
	// 6 D
	// 18 Forwards (C-LW-RW-D)
	// 2 Goalies
	
	var countC = 0;
	var countL = 0;
	var countR = 0;
	var countD = 0;
	var countG = 0;
	for(var i=0;i<trGRList.length;i++) {
		var x = trGRList[i].id.replace(/\D/g,'');
		if(playerPosi[x] == '00') countC++;
		if(playerPosi[x] == '01') countL++;
		if(playerPosi[x] == '02') countR++;
		if(playerPosi[x] == '03') countD++;
		if(playerPosi[x] == '04') countG++;
	}
	var countF = countC + countL + countR + countD;
	if(countF == 18 && countC >= 3 && countL >= 3 && countR >= 3 && countD >= 6 && countG == 2) ok = 1;
	if(count != 20 || (count == 20 && ok == 0)) {
		document.getElementById('trTotalPlayers').textContent = count;
		document.getElementById('trTotalPlayers2').textContent = '<?php echo $db_membre_gmo_langue[100]; ?>';
	}
	else {
		document.getElementById('trTotalPlayers').textContent = '<?php echo $db_membre_gmo_langue[99]; ?>';
		document.getElementById('trTotalPlayers2').textContent = '';
	}
}

// Position Show/Hide
function trShowPosition(id) {
	if(document.getElementById(id).style.borderStyle == "inset") {
		document.getElementById(id).style.borderStyle = "outset";
	}
	else {
		document.getElementById(id).style.borderStyle = "inset";
	}
	trDivCreateLists();
}

/* Create/Modify the DIV Lists */
function trDivCreateLists() {
	var allSelectBoxes = document.querySelectorAll('.selectedPlayers');
	var trImgC, trImgLW, trImgRW, trImgD, trImgG = 0;
	if(document.getElementById('trImgC').style.borderStyle == "inset") trImgC = 1;
	if(document.getElementById('trImgLW').style.borderStyle == "inset") trImgLW = 1;
	if(document.getElementById('trImgRW').style.borderStyle == "inset") trImgRW = 1;
	if(document.getElementById('trImgD').style.borderStyle == "inset") trImgD = 1;
	if(document.getElementById('trImgG').style.borderStyle == "inset") trImgG = 1;
	var tmpStatus = 0;
	for(var i=0;i<allSelectBoxes.length;i++) {
		var hoverColor = 4;
		if(i == 0) tmpStatus = 200;
		if(i == 1) tmpStatus = 100;
		if(i == 2) tmpStatus = 0;
		allSelectBoxes[i].innerHTML = "";
		for(var j=0;j<playerRank.length;j++) {
			if((playerStat[j] == tmpStatus && playerOffI[j] == 0) || (tmpStatus == 100 && playerOffI[j] != 0)) {
				var div = document.createElement("div");
				div.id = "trDivList"+j;
				div.style.clear = "both";
				if((playerPosi[j] == '00' && trImgC == 1) || (playerPosi[j] == '01' && trImgLW == 1) || (playerPosi[j] == '02' && trImgRW == 1) || (playerPosi[j] == '03' && trImgD == 1) || (playerPosi[j] == '04' && trImgG == 1)) {
					div.style.display = "block";
					if(hoverColor == 3) hoverColor = 4;
					else hoverColor = 3;
					div.setAttribute("class", "stopSelection hover"+hoverColor);
					div.setAttribute("onclick", "if(document.getElementById('trImgProtect').style.borderStyle == 'inset') { trChangeProtected(this.id); trGetPlayerInfos(this.id); } else trGetPlayerInfos(this.id);");
				}
				else {
					div.style.display = "none";
				}
				var addProtected = "";
				if(document.getElementById('trImgProtect').style.borderStyle == "inset" && playerProt[j] == "1") addProtected = "*"; // Expansion Draft
				div.appendChild(document.createTextNode(addProtected+playerName[j]));
				var div2 = document.createElement("div");
				div2.style.float = "right";
				div2.style.paddingRight = "5px";
				if(playerOffI[j] != 0) {
					if(playerOffI[j] == 2) div2.appendChild(document.createTextNode('S'+playerSusp[j]));
					if(playerOffI[j] == 1 && (playerStat[j] == 101 || playerStat[j] == 201)) div2.appendChild(document.createTextNode('DD'));
					if(playerOffI[j] == 1 && (playerStat[j] == 102 || playerStat[j] == 202 || playerStat[j] == 01)) div2.appendChild(document.createTextNode('1W'));
					if(playerOffI[j] == 1 && (playerStat[j] == 103 || playerStat[j] == 203)) div2.appendChild(document.createTextNode('3W'));
					if(playerOffI[j] == 1 && (playerStat[j] == 104 || playerStat[j] == 204 || playerStat[j] == 02)) div2.appendChild(document.createTextNode('1M'));
					if(playerOffI[j] == 1 && (playerStat[j] == 105 || playerStat[j] == 205)) div2.appendChild(document.createTextNode('3M'));
					if(playerOffI[j] == 1 && (playerStat[j] == 106 || playerStat[j] == 206 || playerStat[j] == 03)) div2.appendChild(document.createTextNode('IN'));
				}
				div.appendChild(div2);
				allSelectBoxes[i].appendChild(div);
			}
		}
		allSelectBoxes[i].scrollTop = 0;
	}
	trTotalPlayer(); // Count the Total Players
	trSalaryCap(); // Salary Cap
}

/* Pro To Scratch Player */
function trProToScratch() {
	var trGRList = document.querySelectorAll('#trSelectedPlayers1 div.selected');
	for(var i=0;i<trGRList.length;i++) {
		var x = trGRList[i].id.replace(/\D/g,'');
		playerStat[x] = 100;
	}
	if(trGRList.length > 0) trDivCreateLists();
}

/* Scratch To Pro */
function trScratchToPro() {
	var trGRList = document.querySelectorAll('#trSelectedPlayers2 div.selected');
	for(var i=0;i<trGRList.length;i++) {
		var x = trGRList[i].id.replace(/\D/g,'');
		if(playerOffI[x] != 0) {
			popupAlert(playerName[x]+"<?php echo $db_membre_gmo_langue[101]; ?>", "#ae654c");
		}
		else playerStat[x] = 200;
	}
	if(trGRList.length > 0) trDivCreateLists();
}

/* Scratch To Farm */
function trScratchToFarm() {
	var trGRList = document.querySelectorAll('#trSelectedPlayers2 div.selected');
	var trValid = 1;
	for(var i=0;i<trGRList.length;i++) {
		var x = trGRList[i].id.replace(/\D/g,'');
		trValid = trFarmRestrict(x); // Farm Restriction (Age/OV)
		trWaiversList(x); // Waivers List Alert (GP/Age/OV/Salary)
		if(playerOffI[x] != 0) popupAlert(playerName[x]+"<?php echo $db_membre_gmo_langue[102]; ?>", "#ae654c"); // Injured or Suspended
		if(trValid == 1 && playerOffI[x] == 0) playerStat[x] = 0;
	}
	if(trGRList.length > 0) trDivCreateLists();
}

/* Farm To Scratch */
function trFarmToScratch() {
	var trGRList = document.querySelectorAll('#trSelectedPlayers3 div.selected');
	for(var i=0;i<trGRList.length;i++) {
		var x = trGRList[i].id.replace(/\D/g,'');
		playerStat[x] = 100;
	}
	if(trGRList.length > 0) trDivCreateLists();
}

// Autoline
function trAutoLine() {
	playerStat = playerStat2.slice(0);
	
	var y = 0;
	var tmpOV = [];
	var tmpI = [];
	for(var i=0;i<playerStat.length;i++) {
		if((playerStat[i] == 100 || playerStat[i] == 200) && playerOffI[i] == 0) {
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
	
	
	// Get the minimal requirement: 3C-3LW-3RW-6D-2G
	var countC = 0;
	var countL = 0;
	var countR = 0;
	var countD = 0;
	var countG = 0;
	for(var i=0;i<players.length;i++) {
		var x = players[i].rank;
		if(playerPosi[x] == '00') {
			if(countC < 3) {
				countC++;
				playerStat[x] = 200;
			}
			else playerStat[x] = 100;
		}
		if(playerPosi[x] == '01') {
			if(countL < 3) {
				countL++;
				playerStat[x] = 200;
			}
			else playerStat[x] = 100;
		}
		if(playerPosi[x] == '02') {
			if(countR < 3) {
				countR++;
				playerStat[x] = 200;
			}
			else playerStat[x] = 100;
		}
		if(playerPosi[x] == '03') {
			if(countD < 6) {
				countD++;
				playerStat[x] = 200;
			}
			else playerStat[x] = 100;
		}
		if(playerPosi[x] == '04') {
			if(countG < 2) {
				playerStat[x] = 200;
				countG++;
			}
			else playerStat[x] = 100;
		}
	}
	
	// Get the minimal requirement and look at the farm
	if(countC != 3 || countL != 3 || countR != 3 || countD != 6 || countG != 2) {
		var y = 0;
		var tmpOV = [];
		var tmpI = [];
		for(var i=0;i<playerStat.length;i++) {
			if(playerStat[i] == 0 && playerOffI[i] == 0) {
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
		})
		
		for(var i=0;i<players.length;i++) {
			var x = players[i].rank;
			if(playerPosi[x] == '00') {
				if(countC < 3) {
					countC++;
					playerStat[x] = 200;
				}
			}
			if(playerPosi[x] == '01') {
				if(countL < 3) {
					countL++;
					playerStat[x] = 200;
				}
			}
			if(playerPosi[x] == '02') {
				if(countR < 3) {
					countR++;
					playerStat[x] = 200;
				}
			}
			if(playerPosi[x] == '03') {
				if(countD < 6) {
					countD++;
					playerStat[x] = 200;
				}
			}
			if(playerPosi[x] == '04') {
				if(countG < 2) {
					playerStat[x] = 200;
					countG++;
				}
			}
		}
	}
	
	// Get the 20 players requirement with scratch players
	var countF = countC + countL + countR + countD;
	var y = 0;
	var tmpOV = [];
	var tmpI = [];
	for(var i=0;i<playerStat.length;i++) {
		if(playerStat[i] == 100 && playerOffI[i] == 0) {
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
	})
	
	for(var i=0;i<players.length;i++) {
		var x = players[i].rank;
		if(playerPosi[x] == '00' || playerPosi[x] == '01' || playerPosi[x] == '02' || playerPosi[x] == '03') {
			playerStat[x] = 200;
			if(playerPosi[x] == '00') countC++;
			if(playerPosi[x] == '01') countL++;
			if(playerPosi[x] == '02') countR++;
			if(playerPosi[x] == '03') countD++;
			countF++;
			if(countF == 18) break;
		}
	}
	
	// Get the 20 players requirement with farm roster
	if(countF != 18) {
		
		var y = 0;
		var tmpOV = [];
		var tmpI = [];
		for(var i=0;i<playerStat.length;i++) {
			if(playerStat[i] == 0 && playerOffI[i] == 0) {
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
		})
		
		for(var i=0;i<players.length;i++) {
			var x = players[i].rank;
			if(playerPosi[x] == '00' || playerPosi[x] == '01' || playerPosi[x] == '02' || playerPosi[x] == '03') {
				playerStat[x] = 200;
				if(playerPosi[x] == '00') countC++;
				if(playerPosi[x] == '01') countL++;
				if(playerPosi[x] == '02') countR++;
				if(playerPosi[x] == '03') countD++;
				countF++;
				if(countF == 18) break;
			}
		}
	}
	
	trDivCreateLists();
}

/* Roster Complete */
function trRosterComplete() {
	if(document.getElementById('trTotalPlayers2').textContent != "") {
		popupAlert("<?php echo $db_membre_gmo_langue[112]; ?>", "#ae654c");
		return false;
	}
	return true;
}

/* 23 Mans Rules | Maximum of players */
function tr23ManRules() {
	var trPlayerLength = 0;
	for(var i=0; i<playerOffI.length; i++) {
		if(playerStat[i] >= 100 && playerOffI[i] != 1) trPlayerLength++;
	}
	if(trPlayerLength > <?php echo $league_MaxPlayers; ?>) {
		popupAlert("<?php echo $db_membre_gmo_langue[93]; ?> ("+trPlayerLength+"/<?php echo $league_MaxPlayers; ?>)", "#ae654c");
		return false;
	}
	return true;
}

/* Salary Cap */
function trSalaryCap() {
	var trleague_cap = <?php echo $league_cap; ?>;
	var trleague_capType = <?php echo $league_capType; ?>;
	var trleague_capInjured = <?php echo $league_capInjured; ?>;
	var trPlayerProInFarm = <?php echo $league_GameInProPayroll; ?>;
	var trSalaryCapPros = 0;
	var trSalaryCapFarm = 0;
	
	for(var i=0; i<playerSala.length; i++) {
		if(playerOffI[i] != 2) { // Suspended Players doesn't count his salary!
			if(trleague_capInjured == 1 || (playerOffI[i] != 1 && trleague_capInjured == 0)) { // Injured Players with option activated doesn't count his salary! 0: Not Inc. 1: Inc.
				if(playerStat[i] >= 100) { // Game Roster & Scratches Salaries
					trSalaryCapPros += Number(playerSala[i]);
				}
				else { // Farm Roster Salary
					if(trPlayerProInFarm != 0 && playerGPGP[i] >= trPlayerProInFarm) trSalaryCapFarm += Number(playerSala[i]);
					if(trPlayerProInFarm != 0 && playerGPGP[i] < trPlayerProInFarm) trSalaryCapFarm += Number(playerSala[i]) * 10 / 100;
					if(trPlayerProInFarm == 0) trSalaryCapFarm += playerSala[i] * 10 / 100;
				}
			}
		}
	}
	
	var trSalaryCapTota = 0;
	if(trleague_capType == 0) trSalaryCapTota = trSalaryCapPros;
	if(trleague_capType == 1) trSalaryCapTota = trSalaryCapPros + trSalaryCapFarm;
	
	if("<?php echo $league_langue; ?>" == "en") {
		var txt_trleague_cap = "$" + number_format(trleague_cap, 0, '.', ',');
		var txt_trSalaryCapTota = "$" + number_format(trSalaryCapTota, 0, '.', ',');
	}
	if("<?php echo $league_langue; ?>" == "fr") {
		var txt_trleague_cap = number_format(trleague_cap, 0, '.', ' ') +" $";
		var txt_trSalaryCapTota = number_format(trSalaryCapTota, 0, '.', ' ') +" $";
	}
	
	// Show the team salary
	document.getElementById('trSalaryCop').textContent = txt_trSalaryCapTota;
	document.getElementById('trSalaryCop').style.color = "#4caf50";
	
	// If the salary cap is over...
	if(trleague_cap != 0 && trSalaryCapTota > trleague_cap) {
		document.getElementById('trSalaryCop').style.color = "#ae654c";
		if(trleague_capType == 0) popupAlert("<?php echo $db_membre_gmo_langue[77]; ?> ("+txt_trSalaryCapTota+" / "+txt_trleague_cap+")", "#ae654c");
		if(trleague_capType == 1) popupAlert("<?php echo $db_membre_gmo_langue[95]; ?> ("+txt_trSalaryCapTota+" / "+txt_trleague_cap+")", "#ae654c");
		return false;
	}
	return true;
}

function trFarmRestrict(id) {
	var trLeague_FarmMaxOV = <?php echo $league_FarmMaxOV; ?>;
	var trLeague_AgeExemptFarmMaxOV = <?php echo $league_AgeExemptFarmMaxOV; ?>;
	var trLeague_FarmMaxAge = <?php echo $league_FarmMaxAge; ?>;
	
	if(id == "") {
		// Button Save
		for(var i=0; i<playerOver.length; i++) {
			if(trLeague_FarmMaxOV != 0 && playerStat[i] < 100 && playerOver[i] > trLeague_FarmMaxOV && playerAges[i] > trLeague_AgeExemptFarmMaxOV ) {
				popupAlert(playerName[i] + " <?php echo $db_membre_gmo_langue[113]; ?>", "#ae654c");
				return false;
			}
			if(trLeague_FarmMaxAge != 0 && playerStat[i] < 100 && playerAges[i] > trLeague_FarmMaxAge ) {
				popupAlert(playerName[i] + " <?php echo $db_membre_gmo_langue[97]; ?>", "#ae654c");
				return false;
			}
		}
	}
	else {
		// Button To Farm
		if(trLeague_FarmMaxOV != 0 && playerOver[id] > trLeague_FarmMaxOV && playerAges[id] > trLeague_AgeExemptFarmMaxOV ) {
			popupAlert(playerName[id] + " <?php echo $db_membre_gmo_langue[113]; ?>", "#ae654c");
			return false;
		}
		if(trLeague_FarmMaxAge != 0 && playerAges[id] > trLeague_FarmMaxAge ) {
			popupAlert(playerName[id] + " <?php echo $db_membre_gmo_langue[97]; ?>", "#ae654c");
			return false;
		}
	}
	return true;
}

function trWaiversList(id) {
	var trLeague_GameInProWaivers = <?php echo $league_GameInProWaivers; ?>;
	var trLeague_AgeExemptWaivers = <?php echo $league_AgeExemptWaivers; ?>;
	var trLeague_OVSkatersWaivers = <?php echo $league_OVSkatersWaivers; ?>;
	var trLeague_OVGoaliesWaivers = <?php echo $league_OVGoaliesWaivers; ?>;
	var trLeague_SalaryWaivers = <?php echo $league_SalaryWaivers; ?>;
	
	if(id == "") {
		// Button Save
		for(var i=0; i<playerOver.length; i++) {
			// GP Max & Age Exemption
			if( trLeague_GameInProWaivers != 0 && playerStat[i] < 100 && playerGPGP[i] > trLeague_GameInProWaivers && ((playerAges[i] > trLeague_AgeExemptWaivers && trLeague_AgeExemptWaivers != 0) || trLeague_AgeExemptWaivers == 0) ) {
				alert(playerName[i] + " <?php echo $db_membre_gmo_langue[114]; ?>");
			}
			
			// Skater & Goalie OV Max
			if( (trLeague_OVSkatersWaivers != 0 && playerStat[i] < 100 && playerOver[i] > trLeague_OVSkatersWaivers) || (trLeague_OVGoaliesWaivers != 0 && playerStat[i] < 100 && playerOver[i] > trLeague_OVGoaliesWaivers) ) {
				alert(playerName[i] + " <?php echo $db_membre_gmo_langue[115]; ?>");
			}
			
			// Salary Max
			if( trLeague_SalaryWaivers != 0 && playerStat[i] < 100 && playerSala[i] > trLeague_SalaryWaivers ) {
				alert(playerName[i] + " <?php echo $db_membre_gmo_langue[116]; ?>");
			}
		}
	}
	else {
		// Button To Farm
		// GP Max & Age Exemption
		if( trLeague_GameInProWaivers != 0 && playerGPGP[id] > trLeague_GameInProWaivers && ((playerAges[id] > trLeague_AgeExemptWaivers && trLeague_AgeExemptWaivers != 0) || trLeague_AgeExemptWaivers == 0) ) {
			popupAlert(playerName[id] + " <?php echo $db_membre_gmo_langue[114]; ?>", "#ae654c");
		}
		
		// Skater & Goalie OV Max
		if( (trLeague_OVSkatersWaivers != 0 && playerOver[id] > trLeague_OVSkatersWaivers) || (trLeague_OVGoaliesWaivers != 0 && playerOver[id] > trLeague_OVGoaliesWaivers) ) {
			popupAlert(playerName[id] + " <?php echo $db_membre_gmo_langue[115]; ?>", "#ae654c");
		}
		
		// Salary Max
		if( trLeague_SalaryWaivers != 0 && playerSala[id] > trLeague_SalaryWaivers ) {
			popupAlert(playerName[id] + " <?php echo $db_membre_gmo_langue[116]; ?>", "#ae654c");
		}
	}
}

/* Exit button action */
function trExit() {
	var trValid = 1;
	<?php if($league_players == 1) echo "trValid = trRosterComplete();"; ?>
	if(trValid == 0) return;
	
	<?php if($league_MaxPlayers != 0) echo "trValid = tr23ManRules();"; ?>
	if(trValid == 0) return;
	
	<?php if($league_cap != 0) echo "trValid = trSalaryCap();"; ?>
	if(trValid == 0) return;
	
	<?php if($league_FarmMaxOV != 0 || $league_FarmMaxAge != 0) echo "trValid = trFarmRestrict('');"; ?>
	if(trValid == 0) return;
	
	<?php if($league_GameInProWaivers != 0 || $league_OVSkatersWaivers != 0 || $league_OVGoaliesWaivers != 0 || $league_SalaryWaivers != 0) echo "trWaiversList('');"; ?>
	
	trSave();
}

/* Save to the database the status and protection */
function trSave() {
	// Get the difference between protection
	var playerProt3 = [];
	for(var i=0;i<playerProt.length;i++) {
		if(playerProt[i] == playerProt2[i]) playerProt3[i] = "0";
		else playerProt3[i] = "1";
	}
	var playerStatJSON = JSON.stringify(playerStat);
	var playerRankJSON = JSON.stringify(playerRank);
	var playerProtJSON = JSON.stringify(playerProt3);
	
	document.body.style.cursor = "wait";
	
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
// 	xmlhttp.onreadystatechange=function() {
// 		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
// 			var response = xmlhttp.responseText;
// 			document.body.style.cursor = "default";
// 			if(response == "done") {
				popupAlert("<?php echo $db_membre_gmo_langue[104]; ?>", "#4caf50");
				document.location.href="?lines=2&game=<?php echo $linesGame;?>#Lines";
// 			}
// 			else alert('Error! ' + response);
// 		}
// 	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4) {
			document.body.style.cursor = "default";
			if( xmlhttp.status==200){
				var response = xmlhttp.responseText;
				document.body.style.cursor = "default";
				if(response == "done") {
					popupAlert("<?php echo $db_membre_gmo_langue[104]; ?>", "#4caf50");
					document.location.href="?lines=2&game=<?php echo $linesGame;?>#Lines";
				}
				else{
					console.log("Error", response);
					popupAlert("Error Loading Lines! "+ response, "#ae654c");
				}
			}else{
				console.log("Error", xmlhttp.statusText + xmlhttp.responseText);
				popupAlert("Error Loading Lines!", "#ae654c");
			}					
	
		}
	}
	var page = 'gmo/editor/teamRosterSave.php';
	var parameters = "";
	parameters += "stat=" + encodeURIComponent(playerStatJSON);
	parameters += "&rank=" + encodeURIComponent(playerRankJSON);
	parameters += "&prot=" + encodeURIComponent(playerProtJSON);
	parameters += "&game=" + encodeURIComponent(<?php echo $linesGame;?>);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

/* Load lines from file */
function trLoadLines() {
	document.body.style.cursor = "wait";
	
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
// 		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
// 			var response = xmlhttp.responseText;
// 			document.body.style.cursor = "default";
// 			if(response == "") {
				popupAlert("<?php echo $db_membre_gmo_langue[119]; ?>", "#4caf50");
// 				//document.location.href="";
// 				//need to reload after db is refreshed.
// 				location.reload();
// 			}
// 			else alert('Error! ' + response);
// 		}else{
// 			var response = xmlhttp.responseText;
// 			document.body.style.cursor = "default";
// 			//popupAlert("Error Loading Lines!", "#ae654c");
// 		}
		if (xmlhttp.readyState==4) {
			document.body.style.cursor = "default";
			if(xmlhttp.status==200){
				var response = xmlhttp.responseText;
				//document.body.style.cursor = "default";
				if(response == "") {
					popupAlert("<?php echo $db_membre_gmo_langue[119]; ?>", "#4caf50");
					//document.location.href="";
					//need to reload after db is refreshed.
					location.reload();
				}else alert('Error! ' + response);
			}	
			else{
				//var response = xmlhttp.responseText;
				//alert('Error! ' + response);
				console.log("Error", xmlhttp.statusText + xmlhttp.responseText);
				popupAlert("Error Loading Lines!", "#ae654c");
			}
		}
	}
	var page = '<?php echo BASE_URL?>gmo/editor/teamRosterLoadLines.php';
	var parameters = "";
	parameters += "&game=" + encodeURIComponent(<?php echo $linesGame;?>);
	parameters += "&day=" + encodeURIComponent(<?php echo $activeGameDay?>);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	
	xmlhttp.send(parameters)


	
}


/* More stats for mobile */
function trMoreStatsToggle() {
	if(document.getElementById('trTableStats2').style.display == "table") {
		document.getElementById('trTableStats2').style.display = "none";
		document.getElementById('trTableStats3').textContent = "<?php echo $db_membre_gmo_langue[105]; ?>";
	}
	else {
		document.getElementById('trTableStats2').style.display = "table";
		document.getElementById('trTableStats3').textContent = "<?php echo $db_membre_gmo_langue[106]; ?>";
	}
}

//-->
</script>

<!-- check if new files have been loaded if saved lines file is found
prompt user if file exists but no new lines have been saved to the db.
once the saved lines db date is larger than the saved file date (i.e they've since updated their line)
don't prompt
 -->
<?php if ($loadLinesAvailable) { ?>
 <script>
    	$(document).ready(function() {
    		popupAlert("Existing Lines available to be loaded!", "#4caf50");
    	});
</script>
<?php }?>


  