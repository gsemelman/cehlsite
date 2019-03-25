<?php
function overall($POS,$IN,$SP,$ST,$EN,$DU,$DI,$SK,$PA,$PC,$DF,$OF,$EX,$LD){
	$OV = 'NA';
	// Forward
	if($POS == '00' || $POS == '01' || $POS == '02') {
		$tmpOV = 
		($IN*5) + 
		($SP*5) + 
		($ST*7) + 
		($EN*3) + 
		($DU*1) + 
		($DI*1) + 
		($SK*6) + 
		($PA*10) + 
		($PC*8) + 
		($DF*7) + 
		($OF*13) + 
		($EX*1) + 
		($LD*1);
		$OV = 5 + intval($tmpOV / 68);
	}
	
	// D Defensive
	if($POS == '03' && ($PA + $OF) >= ($DF + $ST)) {
		$tmpOV = 
		($IN*4) + 
		($SP*8) + 
		($ST*4) + 
		($EN*3) + 
		($DU*1) + 
		($DI*1) + 
		($SK*8) + 
		($PA*11) + 
		($PC*9) + 
		($DF*6) + 
		($OF*11) + 
		($EX*1) + 
		($LD*1);
		$OV = 5 + intval($tmpOV / 68);
	}
	
	// D Offensive
	if($POS == '03' && $OV == 'NA') {
		$tmpOV = 
		($IN*8) + 
		($SP*5) + 
		($ST*10) + 
		($EN*3) + 
		($DU*1) + 
		($DI*1) + 
		($SK*6) + 
		($PA*8) + 
		($PC*6) + 
		($DF*13) + 
		($OF*5) + 
		($EX*1) + 
		($LD*1);
		$OV = 5 + intval($tmpOV / 68);
	}
	
	// Goalie
	if($POS == '04') {
		$tmpOV = 
		($IN*5) + 
		($SP*17) + 
		($ST*4) + 
		($EN*3) + 
		($DU*1) + 
		($DI*1) + 
		($SK*7) + 
		($PA*3) + 
		($PC*8) + 
		($EX*1) + 
		($LD*1);
		$OV = intval($tmpOV / 53);
	}
	return $OV;
}

// Lecture des valeurs dans la base de donnée
include 'login/mysqli.php';
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM`='file_folder'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$file_folder = $data['VALUE'];
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$TimeZone = $data['VALUE'];
	}
}
date_default_timezone_set($TimeZone);
mysqli_close($con);
	
// Envoie des fichiers dans le répertoire désigné!
if(isset($_POST['submit1'])) {
	$succesUpdateROS = 0;
	if (isset($_FILES['leaguesROS']) && is_uploaded_file($_FILES['leaguesROS']['tmp_name'])) {
		$succesUpdateROS = 1;
	}
	$succesUpdateTMS = 0;
	if (isset($_FILES['leaguesTMS']) && is_uploaded_file($_FILES['leaguesTMS']['tmp_name'])) {
		$succesUpdateTMS = 1;
	}
}

// Supprimer la liste
if(isset($_POST['submit2']) && isset($_POST['LEAGUE'])) {
	$deleteLeague = $_POST['LEAGUE'];
	
	include 'login/mysqli.php';
	$deleteLeague = mysqli_real_escape_string($con, $deleteLeague);
	$sql = "DELETE FROM `".$db_table."_ufalist` WHERE `LEAGUE` = '$deleteLeague'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	$sql = "DELETE FROM `".$db_table."_ufalistsend` WHERE `LEAGUE` = '$deleteLeague'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
}

if(isset($succesUpdateROS) && $succesUpdateROS == 1 && isset($succesUpdateTMS) && $succesUpdateTMS == 1) {
	// TMS File
	$handle = fopen ($_FILES['leaguesTMS']['tmp_name'], "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$hex = '';
	$hex = bin2hex($load_contents);
	
	$teamNumber = 0;
	for($x=0;$x<strlen($hex);$x=$x+508){
		$teamName = substr($hex, $x, 20);
		$teamAbbr = substr($hex, $x+122, 6);
		$erreur = substr($hex, $x+506, 2);
		if((hexdec($erreur)>="32") && (hexdec($erreur)<="126")) $x = $x - 2;
		else {
			$strLength = strlen($teamName);
			$returnVal = '';
			for($k=0; $k<$strLength; $k += 2) {
				$dec_val = hexdec(substr($teamName, $k, 2));
				$returnVal .= chr($dec_val);
			}
			$teamName = utf8_encode(trim($returnVal));
			$fileTMSName[$teamNumber] = $teamName;
			
			$teamNumber++;
		}
	}
	
	// ROS File
	$handle = fopen ($_FILES['leaguesROS']['tmp_name'], "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$hex = '';
	$hex = bin2hex($load_contents);
	
	$teamPos = 0;
	include 'login/mysqli.php';
	for($y=0;$y<strlen($hex);$y=$y+8600) {
		$rosterList = substr($hex, $y, 8600);
		$z = 0;
		for($x=0;$x<strlen($rosterList);$x=$x+172) {
			$rosterName = substr($rosterList, $x, 44);
			$rosterAge = hexdec(substr($rosterList, $x+58, 2));
			$rosterCT = hexdec(substr($rosterList, $x+100, 2));
			$strLength = strlen($rosterName);
			$returnVal = '';
			for($k=0; $k<$strLength; $k += 2) {
				$dec_val = hexdec(substr($rosterName, $k, 2));
				$returnVal .= chr($dec_val);
			}
			$rosterName = utf8_encode(trim($returnVal));
			
			if($rosterName != '' && $rosterAge >= $_POST['age'] && $rosterCT == $_POST['contract']) {
				$fileROSLast[$z] = $fileTMSName[$teamPos];
				$fileROSName[$z] = $rosterName; // 0
				$fileROSPosi[$z] = substr($rosterList, $x+44, 2); // 00 : C | 01 : LW | 02 : RW | 03 : D | 04 : G
				$fileROSNumb[$z] = hexdec(substr($rosterList, $x+46, 2));
				$fileROSHand[$z] = substr($rosterList, $x+52, 2); // 00 : Left | 01 : Right
				$fileROSHeig[$z] = hexdec(substr($rosterList, $x+54, 2));
				$fileROSWeig[$z] = hexdec(substr($rosterList, $x+56, 2));
				$fileROSAges[$z] = $rosterAge; // 58
				$fileROSCond[$z] = substr($rosterList, $x+60, 2); // C8 : Pro | 64 : Scratch | 00 : Farm
				$fileROSInju[$z] = substr($rosterList, $x+62, 2); // 64 : 100 (OK) | 5F > XX : Injured | 5F <= XX < 64 : Tired |
				
				$fileROSInte[$z] = hexdec(substr($rosterList, $x+64, 2));
				$fileROSSpee[$z] = hexdec(substr($rosterList, $x+66, 2));
				$fileROSStre[$z] = hexdec(substr($rosterList, $x+68, 2));
				$fileROSEndu[$z] = hexdec(substr($rosterList, $x+70, 2));
				$fileROSDura[$z] = hexdec(substr($rosterList, $x+72, 2));
				$fileROSDisc[$z] = hexdec(substr($rosterList, $x+74, 2));
				$fileROSSkat[$z] = hexdec(substr($rosterList, $x+76, 2));
				$fileROSPass[$z] = hexdec(substr($rosterList, $x+78, 2));
				$fileROSPKCT[$z] = hexdec(substr($rosterList, $x+80, 2));
				
				if($fileROSPosi[$z] == '04') {
					$fileROSDefs[$z] = 'NA';
					$fileROSOffs[$z] = 'NA';
				}
				else {
					$fileROSDefs[$z] = hexdec(substr($rosterList, $x+82, 2));
					$fileROSOffs[$z] = hexdec(substr($rosterList, $x+84, 2));
				}
				
				$fileROSExpe[$z] = hexdec(substr($rosterList, $x+86, 2));
				$fileROSLead[$z] = hexdec(substr($rosterList, $x+88, 2));
				
				$fileROSSala[$z] = hexdec(substr($rosterList, $x+92, 2)) + hexdec(substr($rosterList, $x+94, 2)) * 256 + hexdec(substr($rosterList, $x+96, 2)) * 65536 + hexdec(substr($rosterList, $x+98, 2)) * 16777216;
				
				$fileROSYRCT[$z] = $rosterCT; // 100
				$fileROSSusp[$z] = substr($rosterList, $x+102, 2); // 00 < XX : Suspended
				
				$fileROSBirt[$z] = substr($rosterList, $x+152, 6);
				$returnVal = '';
				$strLength = strlen($fileROSBirt[$z]);
				for($k=0; $k<$strLength; $k += 2) {
					$dec_val = hexdec(substr($fileROSBirt[$z], $k, 2));
					$returnVal .= chr($dec_val);
				}
				$fileROSBirt[$z] = utf8_encode(trim($returnVal));
				
				// OV
				$fileROSOver[$z] = 'NA';
				if($fileROSPosi[$z] == '00' || $fileROSPosi[$z] == '01' || $fileROSPosi[$z] == '02') {
					$fileROSOver[$z] = 
					round(($fileROSInte[$z]*0.0735) + 
					($fileROSSpee[$z]*0.0735) + 
					($fileROSStre[$z]*0.103) + 
					($fileROSEndu[$z]*0.044) + 
					($fileROSDura[$z]*0.0148) + 
					($fileROSDisc[$z]*0.0147) + 
					($fileROSSkat[$z]*0.089) + 
					($fileROSPass[$z]*0.147) + 
					($fileROSPKCT[$z]*0.1175) + 
					($fileROSDefs[$z]*0.1025) + 
					($fileROSOffs[$z]*0.191) + 
					($fileROSExpe[$z]*0.0147) + 
					($fileROSLead[$z]*0.0148) + 
					(1*4.505));
				}
				if($fileROSPosi[$z] == '03' && ($fileROSPass[$z] + $fileROSOffs[$z]) >= ($fileROSDefs[$z] + $fileROSStre[$z])) {
					$fileROSOver[$z] = 
					round(($fileROSInte[$z]*0.059) + 
					($fileROSSpee[$z]*0.1175) + 
					($fileROSStre[$z]*0.059) + 
					($fileROSEndu[$z]*0.044) + 
					($fileROSDura[$z]*0.0148) + 
					($fileROSDisc[$z]*0.0147) + 
					($fileROSSkat[$z]*0.1175) + 
					($fileROSPass[$z]*0.162) + 
					($fileROSPKCT[$z]*0.132) + 
					($fileROSDefs[$z]*0.089) + 
					($fileROSOffs[$z]*0.161) + 
					($fileROSExpe[$z]*0.0147) + 
					($fileROSLead[$z]*0.0148) + 
					(1*4.51));
				}
				if($fileROSPosi[$z] == '03' && $fileROSOver[$z] == 'NA') {
					$fileROSOver[$z] = 
					round(($fileROSInte[$z]*0.1175) + 
					($fileROSSpee[$z]*0.0735) + 
					($fileROSStre[$z]*0.147) + 
					($fileROSEndu[$z]*0.044) + 
					($fileROSDura[$z]*0.0148) + 
					($fileROSDisc[$z]*0.0147) + 
					($fileROSSkat[$z]*0.0885) + 
					($fileROSPass[$z]*0.118) + 
					($fileROSPKCT[$z]*0.088) + 
					($fileROSDefs[$z]*0.191) + 
					($fileROSOffs[$z]*0.0735) + 
					($fileROSExpe[$z]*0.0147) + 
					($fileROSLead[$z]*0.0148) + 
					(1*4.505));
				}
				if($fileROSPosi[$z] == '04') {
					$fileROSOver[$z] = 
					round(($fileROSInte[$z]*0.0945) + 
					($fileROSSpee[$z]*0.3215) + 
					($fileROSStre[$z]*0.0755) + 
					($fileROSEndu[$z]*0.0565) + 
					($fileROSDura[$z]*0.0188) + 
					($fileROSDisc[$z]*0.0187) + 
					($fileROSSkat[$z]*0.1325) + 
					($fileROSPass[$z]*0.0565) + 
					($fileROSPKCT[$z]*0.151) + 
					($fileROSExpe[$z]*0.0187) + 
					($fileROSLead[$z]*0.0188) + 
					(-1*0.475));
				}
				
				$fileROSName[$z] = mysqli_real_escape_string($con, $fileROSName[$z]);
				$fileROSLeague = mysqli_real_escape_string($con, $_POST['season']);
				$fileROSLast[$z] = mysqli_real_escape_string($con, $fileROSLast[$z]);
				$sql = "INSERT INTO `".$db_table."_ufalist` (
				`LEAGUE`, 
				`NAME`, 
				`POSI`, 
				`NUMB`, 
				`HAND`, 
				`HEIG`, 
				`WEIG`, 
				`AGES`, 
				`COND`, 
				`INTE`, 
				`SPEE`, 
				`STRE`, 
				`ENDU`, 
				`DURA`, 
				`DISC`, 
				`SKAT`, 
				`PASS`, 
				`PKCT`, 
				`DEFS`, 
				`OFFS`, 
				`EXPE`, 
				`LEAD`, 
				`SALA`, 
				`BIRT`, 
				`OVER`, 
				`NTC`, 
				`LAST_TEAM`, 
				`PROTECTED`, 
				`DISABLED`, 
				`TEAM`, 
				`DATE`, 
				`SALARY`, 
				`YEAR`
				) 
				VALUES (
				'$fileROSLeague', 
				'$fileROSName[$z]', 
				'$fileROSPosi[$z]', 
				'$fileROSNumb[$z]', 
				'$fileROSHand[$z]', 
				'$fileROSHeig[$z]', 
				'$fileROSWeig[$z]', 
				'$fileROSAges[$z]', 
				'$fileROSCond[$z]', 
				'$fileROSInte[$z]', 
				'$fileROSSpee[$z]', 
				'$fileROSStre[$z]', 
				'$fileROSEndu[$z]', 
				'$fileROSDura[$z]', 
				'$fileROSDisc[$z]', 
				'$fileROSSkat[$z]', 
				'$fileROSPass[$z]', 
				'$fileROSPKCT[$z]', 
				'$fileROSDefs[$z]', 
				'$fileROSOffs[$z]', 
				'$fileROSExpe[$z]', 
				'$fileROSLead[$z]', 
				'$fileROSSala[$z]', 
				'$fileROSBirt[$z]', 
				'$fileROSOver[$z]', 
				'0', 
				'$fileROSLast[$z]', 
				'', 
				'0', 
				'', 
				'0000-00-00 00:00:00', 
				'', 
				''
				)
				;";
				$query = mysqli_query($con, $sql) or die(mysqli_error($con));
				
				//echo $fileROSName[$z].' - '.$fileROSAges[$z].' - '.$fileROSYRCT[$z].' - '.$fileROSOver[$z].'<br>';
				$z++;
			}
		}
		$teamPos++;
	}
	mysqli_close($con);
}


// Envoie des fichiers dans le répertoire désigné!
if(isset($_POST['submitAdd'])) {
	$succesUpdateDRS = 0;
	if (isset($_FILES['leaguesDRS']) && is_uploaded_file($_FILES['leaguesDRS']['tmp_name'])) {
		$succesUpdateDRS = 1;
	}
	$succesUpdateROS2 = 0;
	if (isset($_FILES['leaguesAddROS']) && is_uploaded_file($_FILES['leaguesAddROS']['tmp_name'])) {
		$succesUpdateROS2 = 1;
	}
	if($_POST['leaguesAddAge2'] < $_POST['leaguesAddAge1'] && $_POST['leaguesAddOV2'] < $_POST['leaguesAddOV1']) {
		$succesUpdateDRS = 0;
		$succesUpdateROS2 = 0;
	}
}

if(isset($succesUpdateDRS) && $succesUpdateDRS == 1 && isset($succesUpdateROS2) && $succesUpdateROS2 == 1) {
	// ROS File
	$handle2 = fopen ($_FILES['leaguesAddROS']['tmp_name'], "r");
	$load_contents2 = '';
	while (!feof($handle2)) {
		$load_contents2 .= fread($handle2, 8192);
	}
	fclose ($handle2);
	$hex2 = '';
	$hex2 = bin2hex($load_contents2);
	$y = 0;
	for($x=0;$x<strlen($hex2);$x=$x+172) {
		$rosterName = substr($hex2, $x, 44);
		$strLength = strlen($rosterName);
		$returnVal = '';
		for($k=0; $k<$strLength; $k += 2) {
			$dec_val = hexdec(substr($rosterName, $k, 2));
			$returnVal .= chr($dec_val);
		}
		$rosterName = utf8_encode(trim($returnVal));
		if($rosterName != "") {
			$rosterList[$y] = $rosterName;
			$y++;
		}
	}
	
	// DRS File
	$handle = fopen ($_FILES['leaguesDRS']['tmp_name'], "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$hex = '';
	$hex = bin2hex($load_contents);
	
	include 'login/mysqli.php';
	$z = 0;
	for($x=0;$x<strlen($hex);$x=$x+176) {
		$x = $x + 4;
		$rosterName = substr($hex, $x, 44);
		$strLength = strlen($rosterName);
		$returnVal = '';
		for($k=0; $k<$strLength; $k += 2) {
			$dec_val = hexdec(substr($rosterName, $k, 2));
			$returnVal .= chr($dec_val);
		}
		$rosterName = utf8_encode(trim($returnVal));
		$nameFound = 0;
		for($y=0;$y<count($rosterList);$y++) {
			if($rosterList[$y] == $rosterName) {
				$nameFound = 1;
				break 1;
			}
		}

		$DRSPosi = substr($hex, $x+44, 2); // 00 : C | 01 : LW | 02 : RW | 03 : D | 04 : G
		$rosterAge = hexdec(substr($hex, $x+58, 2));
		$DRSInte = hexdec(substr($hex, $x+64, 2));
		$DRSSpee = hexdec(substr($hex, $x+66, 2));
		$DRSStre = hexdec(substr($hex, $x+68, 2));
		$DRSEndu = hexdec(substr($hex, $x+70, 2));
		$DRSDura = hexdec(substr($hex, $x+72, 2));
		$DRSDisc = hexdec(substr($hex, $x+74, 2));
		$DRSSkat = hexdec(substr($hex, $x+76, 2));
		$DRSPass = hexdec(substr($hex, $x+78, 2));
		$DRSPKCT = hexdec(substr($hex, $x+80, 2));
		if($DRSPosi == '04') {
			$DRSDefs = 'NA';
			$DRSOffs = 'NA';
		}
		else {
			$DRSDefs = hexdec(substr($hex, $x+82, 2));
			$DRSOffs = hexdec(substr($hex, $x+84, 2));
		}
		$DRSExpe = hexdec(substr($hex, $x+86, 2));
		$DRSLead = hexdec(substr($hex, $x+88, 2));
		$DRSOver = overall($DRSPosi,$DRSInte,$DRSSpee,$DRSStre,$DRSEndu,$DRSDura,$DRSDisc,$DRSSkat,$DRSPass,$DRSPKCT,$DRSDefs,$DRSOffs,$DRSExpe,$DRSLead);
		
		if($rosterName != "" && $nameFound == 0 && $_POST['leaguesAddAge2'] >= $rosterAge && $_POST['leaguesAddAge1'] <= $rosterAge && $_POST['leaguesAddOV2'] >= $DRSOver && $_POST['leaguesAddOV1'] <= $DRSOver) {
			$rosterCT = hexdec(substr($hex, $x+100, 2));
			
			$fileDRSName[$z] = $rosterName; // 0
			$fileDRSPosi[$z] = $DRSPosi;
			$fileDRSNumb[$z] = hexdec(substr($hex, $x+46, 2));
			$fileDRSHand[$z] = substr($hex, $x+52, 2); // 00 : Left | 01 : Right
			$fileDRSHeig[$z] = hexdec(substr($hex, $x+54, 2));
			$fileDRSWeig[$z] = hexdec(substr($hex, $x+56, 2));
			$fileDRSAges[$z] = $rosterAge; // 58
			$fileDRSCond[$z] = substr($hex, $x+60, 2); // C8 : Pro | 64 : Scratch | 00 : Farm
			$fileDRSInju[$z] = substr($hex, $x+62, 2); // 64 : 100 (OK) | 5F > XX : Injured | 5F <= XX < 64 : Tired |
			
			$fileDRSInte[$z] = $DRSInte;
			$fileDRSSpee[$z] = $DRSSpee;
			$fileDRSStre[$z] = $DRSStre;
			$fileDRSEndu[$z] = $DRSEndu;
			$fileDRSDura[$z] = $DRSDura;
			$fileDRSDisc[$z] = $DRSDisc;
			$fileDRSSkat[$z] = $DRSSkat;
			$fileDRSPass[$z] = $DRSPass;
			$fileDRSPKCT[$z] = $DRSPKCT;
			if($fileDRSPosi[$z] == '04') {
				$fileDRSDefs[$z] = 'NA';
				$fileDRSOffs[$z] = 'NA';
			}
			else {
				$fileDRSDefs[$z] = $DRSDefs;
				$fileDRSOffs[$z] = $DRSOffs;
			}
			$fileDRSExpe[$z] = $DRSExpe;
			$fileDRSLead[$z] = $DRSLead;
		
			$fileDRSSala[$z] = hexdec(substr($hex, $x+92, 2)) + hexdec(substr($hex, $x+94, 2)) * 256 + hexdec(substr($hex, $x+96, 2)) * 65536 + hexdec(substr($hex, $x+98, 2)) * 16777216;
			
			$fileDRSYRCT[$z] = $rosterCT; // 100
			$fileDRSSusp[$z] = substr($hex, $x+102, 2); // 00 < XX : Suspended
			
			$fileDRSBirt[$z] = substr($hex, $x+152, 6);
			$returnVal = '';
			$strLength = strlen($fileDRSBirt[$z]);
			for($k=0; $k<$strLength; $k += 2) {
				$dec_val = hexdec(substr($fileDRSBirt[$z], $k, 2));
				$returnVal .= chr($dec_val);
			}
			$fileDRSBirt[$z] = utf8_encode(trim($returnVal));
		
			$fileDRSOver[$z] = $DRSOver;
			
			$sql = "SELECT * FROM `".$db_table."_ufalist` WHERE `LEAGUE` = (SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` desc LIMIT 1)";
			$query = mysqli_query($con, $sql) or die(mysqli_error($con));
			$i = 0;
			if($query){
				while($data = mysqli_fetch_array($query)) {
					$dbLEAGUE = $data['LEAGUE'];
				}
			}

			$sqlDRSName = mysqli_real_escape_string($con, $fileDRSName[$z]);
			$sqlDRSAges = mysqli_real_escape_string($con, $fileDRSAges[$z]);
			$fileDRSLeague = mysqli_real_escape_string($con, $dbLEAGUE);
			$sql = "SELECT * FROM `".$db_table."_ufalist` WHERE `LEAGUE` = '$fileDRSLeague' AND `NAME` = '$sqlDRSName' AND `AGES` = '$sqlDRSAges' LIMIT 1";
			$query2 = mysqli_query($con, $sql) or die(mysqli_error($con));
			if($query2 && mysqli_num_rows($query2) == 0) {
				$sql = "INSERT INTO `".$db_table."_ufalist` (
				`LEAGUE`, 
				`NAME`, 
				`POSI`, 
				`NUMB`, 
				`HAND`, 
				`HEIG`, 
				`WEIG`, 
				`AGES`, 
				`COND`, 
				`INTE`, 
				`SPEE`, 
				`STRE`, 
				`ENDU`, 
				`DURA`, 
				`DISC`, 
				`SKAT`, 
				`PASS`, 
				`PKCT`, 
				`DEFS`, 
				`OFFS`, 
				`EXPE`, 
				`LEAD`, 
				`SALA`, 
				`BIRT`, 
				`OVER`, 
				`NTC`, 
				`LAST_TEAM`, 
				`PROTECTED`, 
				`DISABLED`, 
				`TEAM`, 
				`DATE`, 
				`SALARY`, 
				`YEAR`
				) 
				VALUES (
				'$fileDRSLeague', 
				'$fileDRSName[$z]', 
				'$fileDRSPosi[$z]', 
				'$fileDRSNumb[$z]', 
				'$fileDRSHand[$z]', 
				'$fileDRSHeig[$z]', 
				'$fileDRSWeig[$z]', 
				'$fileDRSAges[$z]', 
				'$fileDRSCond[$z]', 
				'$fileDRSInte[$z]', 
				'$fileDRSSpee[$z]', 
				'$fileDRSStre[$z]', 
				'$fileDRSEndu[$z]', 
				'$fileDRSDura[$z]', 
				'$fileDRSDisc[$z]', 
				'$fileDRSSkat[$z]', 
				'$fileDRSPass[$z]', 
				'$fileDRSPKCT[$z]', 
				'$fileDRSDefs[$z]', 
				'$fileDRSOffs[$z]', 
				'$fileDRSExpe[$z]', 
				'$fileDRSLead[$z]', 
				'$fileDRSSala[$z]', 
				'$fileDRSBirt[$z]', 
				'$fileDRSOver[$z]', 
				'0', 
				'', 
				'', 
				'0', 
				'', 
				'0000-00-00 00:00:00', 
				'', 
				''
				)
				;";
				$query = mysqli_query($con, $sql) or die(mysqli_error($con));
				//echo $fileDRSName[$z].' - '.$fileDRSAges[$z].' - '.$fileDRSYRCT[$z].' - '.$fileDRSOver[$z].'<br>';
				$z++;
			}
		}
		$x = $x - 4;
	}
	mysqli_close($con);
	//echo "<br>".$z."<br>";
}

if ( $mode != 'ufaListManager') {
?>

<form method="post" enctype="multipart/form-data" action="?admin=ufa">
<fieldset style="margin-top:25px;">
<legend style="font-weight:bold;"><?php echo $db_admin_ufa[0]; ?></legend>
<?php echo $db_admin_ufa[1]; ?><br>
<input type="file" name="leaguesROS" accept=".ros" required><br>
<br><?php echo $db_admin_ufa[16]; ?><br>
<input type="file" name="leaguesTMS" accept=".tms" required><br>
<br><b><?php echo $db_admin_ufa[5]; ?></b><br>
<?php echo $db_admin_ufa[2]; ?><br>
<input class="inputText" type="text" name="season" value="" required><br>
<br><b><?php echo $db_admin_ufa[6]; ?></b><br>
<?php echo $db_admin_ufa[3]; ?><br>
<input type="radio" name="contract" id="ct0" value="0" checked><label for="ct0">0 <?php echo $db_admin_ufa[7]; ?></label><br>
<input type="radio" name="contract" id="ct1" value="1"><label for="ct1">1 <?php echo $db_admin_ufa[7]; ?></label><br>
<br><b><?php echo $db_admin_ufa[8]; ?></b><br>
<?php echo $db_admin_ufa[4]; ?><br>
<input class="inputText" type="number" name="age" value="27" required><br>

<br><input type="submit" name="submit1" value="<?php echo $db_admin_ufa[11]; ?>">
</fieldset>
</form>

<form method="post" enctype="multipart/form-data" action="?admin=ufa">
<fieldset style="margin-top:25px;">
<legend style="font-weight:bold;"><?php echo $db_admin_ufa[9]; ?></legend>
<?php 
echo $db_admin_ufa[13].'<br>';
include 'login/mysqli.php';
$sql = "SELECT `LEAGUE` FROM `".$db_table."_ufalist` GROUP BY `LEAGUE`";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if(mysqli_num_rows($query) != 0) {
	echo '<select name="LEAGUE">';
	$i = 0;
	while($data = mysqli_fetch_array($query)) {
		$LEAGUE[$i] = $data['LEAGUE'];
		$i++;
	}
	for($i=0;$i<count($LEAGUE);$i++) {
		echo '<option value="'.$LEAGUE[$i].'">'.$LEAGUE[$i].'</option>';
	}
	echo '</select>';
	echo '<input type="submit" name="submit2" value="'.$db_admin_ufa[10].'">';
}
else {
	echo $db_admin_ufa[12];
}
mysqli_close($con);
?>
</fieldset>
</form>

<form method="post" enctype="multipart/form-data" action="?admin=ufa">
<fieldset style="margin-top:25px;">
<legend style="font-weight:bold;"><?php echo $db_admin_ufa[51]; ?></legend>
<?php echo $db_admin_ufa[54]; ?><br>
<input type="file" name="leaguesDRS" accept=".drs" required><br><br>
<?php echo $db_admin_ufa[55]; ?><br>
<input type="file" name="leaguesAddROS" accept=".ros" required>
<br><br><b><?php echo $db_admin_ufa[56]; ?></b><br>
<?php echo $db_admin_ufa[57]; ?><br>
<input class="inputText" style="width:100px;" type="number" name="leaguesAddAge1" value="18" required><input class="inputText" style="width:100px;" type="number" name="leaguesAddAge2" value="45" required>
<br><br><b><?php echo $db_admin_ufa[58]; ?></b><br>
<?php echo $db_admin_ufa[59]; ?><br>
<input class="inputText" style="width:100px;" type="number" name="leaguesAddOV1" value="50" required><input class="inputText" style="width:100px;" type="number" name="leaguesAddOV2" value="99" required>
<br><br>
<input type="submit" name="submitAdd" value="<?php echo $db_admin_ufa[52]; ?>">
</fieldset>
</form>


<?php
}
?>

<fieldset style="margin-top:25px;">
<legend style="font-weight:bold;"><?php echo $db_admin_ufa[14]; ?></legend>
<?php 
echo $db_admin_ufa[15].'<br>';
include 'login/mysqli.php';

// Team List
$sql = "SELECT `EQUIPESIM`, `INT` FROM `".$db_table."` WHERE `EQUIPESIM` != '' ORDER BY `EQUIPESIM` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$i = 0;
while($data = mysqli_fetch_array($query)) {
	$db_fhlteam[$i] = $data['EQUIPESIM'];
	$i++;
}

// Player List
$sql = "SELECT `INT`, `NAME` FROM `".$db_table."_ufalist` WHERE `LEAGUE` = (SELECT `LEAGUE` from `".$db_table."_ufalist` ORDER BY `INT` desc LIMIT 1) ORDER BY `NAME` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if(mysqli_num_rows($query) != 0) {
	echo '<select style="float:left;" id="PLAYER" onchange="javascript:ufaNTCSelect();">';
	echo '<option selected="selected" value="none">'.$db_admin_ufa[17].'</option>';
	$i = 0;
	while($data = mysqli_fetch_array($query)) {
		$dbINT[$i] = $data['INT'];
		$dbNAME[$i] = $data['NAME'];
		$i++;
	}
	for($i=0;$i<count($dbINT);$i++) {
		echo '<option value="'.$dbINT[$i].'">'.$dbNAME[$i].'</option>';
	}
	echo '</select>';
	echo '<div id="divNTC" style="display:none; float:left; margin-left:40px; border:1px solid #000000;">';
	echo '<table>';
	echo '<tr><td>'.$db_admin_ufa[19].'</td><td style="text-align:left;"><input style="transform:scale(1.5)" type="checkbox" id="checkboxNTC" value="" onchange="ufaNTCChange();"></td></tr>';
	echo '<tr><td>'.$db_admin_ufa[20].'</td><td style="text-align:left;">';
	for($i=0;$i<count($db_fhlteam);$i++) {
		echo '<input onchange="javascript:ufaNTCTeamChange(\''.$i.'\');" id="teamNTC'.$i.'" type="checkbox" value="'.$db_fhlteam[$i].'"><label for="teamNTC'.$i.'">'.$db_fhlteam[$i].'</label><br>';
	}
	echo '</td></tr>';
	echo '</table>';
	
	echo '</div>';
	
	echo '<div id="divNTC2" style="display:none; float:left; margin-left:40px; border:1px solid #000000; padding:3px;">';
	echo $db_admin_ufa[22].'<input style="transform:scale(1.5); margin-left:40px;" type="checkbox" id="checkboxDisabled" value="" onchange="ufaDisabledChange();">';
	
	echo '</div>';
	
	echo '<div style="float:left; margin-left:40px; border:1px solid #000000; padding:3px;">';
	echo '<input type="button" value="'.$db_admin_ufa[23].'" onclick="ufaDisableAll(\'1\');"><br>';
	echo '<input type="button" value="'.$db_admin_ufa[24].'" onclick="ufaDisableAll(\'0\');">';
	echo '</div>';
	
	echo '<div style="float:left; margin-left:40px; border:1px solid #000000; padding:3px;">';
	echo '<input type="button" value="'.$db_admin_ufa[49].'" onclick="ufaProtectAll(\'1\');"><br>';
	echo '<input type="button" value="'.$db_admin_ufa[50].'" onclick="ufaProtectAll(\'0\');">';
	echo '</div>';
}
else {
	echo $db_admin_ufa[12];
}
mysqli_close($con);
?>
</fieldset>