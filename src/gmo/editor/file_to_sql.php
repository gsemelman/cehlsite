<?php

include 'login/mysqli.php';

// Read the .tms file
$filename = $file_folder.$file_tms;
$handle = fopen ($filename, "r");
$load_contents = '';
while (!feof($handle)) {
	$load_contents .= fread($handle, 8192);
}
fclose ($handle);
$hex = bin2hex($load_contents);

// Creating the team list & Save the lineup into the database
$teamNumber = 0;

$sql = "UPDATE `$db_table` SET `RANK` = ''"; // Delete all Team Ranks saved! Fix for multiple same name teams.
$query = mysqli_query($con, $sql) or die(mysqli_error($con));

for($x=0;$x<strlen($hex);$x=$x+508) {
	$teamName[$teamNumber] = substr($hex, $x, 20);
	$teamLine[$teamNumber] = substr($hex, $x+348, 130);
	$erreur = substr($hex, $x+506, 2);
	if((hexdec($erreur)>="32") && (hexdec($erreur)<="126")) $x = $x - 2;
	else {
		$strLength = strlen($teamName[$teamNumber]);
		$returnVal = '';
		for($k=0; $k<$strLength; $k += 2) {
			$dec_val = hexdec(substr($teamName[$teamNumber], $k, 2));
			$returnVal .= chr($dec_val);
		}
		$teamName[$teamNumber] = utf8_encode(trim($returnVal));
		
		$sqlTeamName = mysqli_real_escape_string($con, $teamName[$teamNumber]);
		
		$sql = "UPDATE `$db_table` SET `RANK` = '$teamNumber', `TMS_LINEUP` = '$teamLine[$teamNumber]' WHERE `EQUIPESIM` = '$sqlTeamName' AND `RANK` = ''";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		
		$teamNumber++;
	}
}

// Read the .ros file and save it to the database
$filename = $file_folder.$file_ros;
$handle = fopen ($filename, "r");
$contents = "";
while (!feof($handle)) {
  $contents .= fread($handle, 8192);
}
fclose ($handle);
$hex = bin2hex($contents);

// Flush the database
$sql = "TRUNCATE `".$db_table."_players`";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));

$sql = "UPDATE `".$db_table."_parameters` SET `VALUE`='$date_time' WHERE `PARAM`='file_last_update'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));

for($t=0;$t<$teamNumber;$t++) {
	$cpt = 0;
	$z = $t * 8600;
	$roster_file = substr($hex, $z, 8600);
	for($i=0;$i!=50;$i++) {
		$search = substr($roster_file, $cpt, 172);
		$bad = substr($roster_file, $cpt, 44);
		
		if(!substr_count($bad, '0000000000')) {
			$fileRosRank = $i;
			$fileROSName = substr($search, 0, 44);
			$strLength = strlen($fileROSName);
			$returnVal = '';
	
			for($k=0; $k<$strLength; $k += 2) {
				$dec_val = hexdec(substr($fileROSName, $k, 2));
				$returnVal .= chr($dec_val);
			}
			$fileROSName = utf8_encode(trim($returnVal));
			$fileROSPosi = substr($search, 44, 2); // 00 : C | 01 : LW | 02 : RW | 03 : D | 04 : G
			$fileROSNumb = hexdec(substr($search, 46, 2));
			$fileROSProt = hexdec(substr($search, 48, 2));
			if($fileROSProt == "00") $fileROSProt = 0;
			else $fileROSProt = 1;
			$fileROSHand = hexdec(substr($search, 52, 2)); // 00 : Left | 01 : Right
			$fileROSHeig = hexdec(substr($search, 54, 2));
			$fileROSWeig = hexdec(substr($search, 56, 2));
			$fileROSAges = hexdec(substr($search, 58, 2));
			$fileROSStat = hexdec(substr($search, 60, 2)); // C8 : Pro | 64 : Scratch | 00 : Farm
			
			// Put the injured/suspended player automaticly in the scratches list
			if($fileROSStat >= 201 && $fileROSStat <= 206) {
				$fileROSStat = $fileROSStat - 100;
			}
			if($fileROSStat >= 1 && $fileROSStat <= 3) {
				if($fileROSStat == 1) $fileROSStat = $fileROSStat + 101;
				if($fileROSStat == 2) $fileROSStat = $fileROSStat + 102;
				if($fileROSStat == 3) $fileROSStat = $fileROSStat + 103;
			}
			
			$fileROSCond = hexdec(substr($search, 62, 2)); // 64 : 100 (OK) | 5F > XX : Injured | 5F <= XX < 64 : Tired |
			
			$fileROSInte = hexdec(substr($search, 64, 2));
			$fileROSSpee = hexdec(substr($search, 66, 2));
			$fileROSStre = hexdec(substr($search, 68, 2));
			$fileROSEndu = hexdec(substr($search, 70, 2));
			$fileROSDura = hexdec(substr($search, 72, 2));
			$fileROSDisc = hexdec(substr($search, 74, 2));
			$fileROSSkat = hexdec(substr($search, 76, 2));
			$fileROSPass = hexdec(substr($search, 78, 2));
			$fileROSPKCT = hexdec(substr($search, 80, 2));
			
			if($fileROSPosi == '04') {
				$fileROSDefs = '0';
				$fileROSOffs = '0';
			}
			else {
				$fileROSDefs = hexdec(substr($search, 82, 2));
				$fileROSOffs = hexdec(substr($search, 84, 2));
			}
			
			$fileROSExpe = hexdec(substr($search, 86, 2));
			$fileROSLead = hexdec(substr($search, 88, 2));
	
			$fileROSSala = hexdec(substr($search, 92, 2)) + hexdec(substr($search, 94, 2)) * 256 + hexdec(substr($search, 96, 2)) * 65536 + hexdec(substr($search, 98, 2)) * 16777216;
	
			$fileROSYRCT = hexdec(substr($search, 100, 2));
			$fileROSSusp = hexdec(substr($search, 102, 2)); // 00 < XX : Suspended
			
			$fileROSBirt = substr($search, 152, 6);
			$strLength = strlen($fileROSBirt);
			$returnVal = '';
			for($k=0; $k<$strLength; $k += 2) {
				$dec_val = hexdec(substr($fileROSBirt, $k, 2));
				$returnVal .= chr($dec_val);
			}
			$fileROSBirt = utf8_encode(trim($returnVal));
			
			$fileROSGPGP = hexdec(substr($search, 104, 2));
			
			if($fileROSPosi != '04') {
				$fileROSGOPM = hexdec(substr($search, 106, 2));
				$fileROSASAS = hexdec(substr($search, 108, 2));
				
				$tmpPlusMinus = substr($search, 112, 2);
				
				if($tmpPlusMinus == 'ff') $fileROSPLMN = (256 - hexdec(substr($search, 110, 2))) * -1;
				else $fileROSPLMN = hexdec(substr($search, 110, 2)) + hexdec(substr($search, 112, 2)) * 256;
				
				$fileROSPMGA = hexdec(substr($search, 114, 2)) + hexdec(substr($search, 116, 2)) * 256;
				$fileROSSTST = hexdec(substr($search, 118, 2)) + hexdec(substr($search, 120, 2)) * 256;
				$fileROSPPSO = hexdec(substr($search, 122, 2));
				$fileROSSHWN = hexdec(substr($search, 124, 2));
				$fileROSGWLS = hexdec(substr($search, 126, 2));
				$fileROSGTTI = hexdec(substr($search, 128, 2));
				$fileROSHITS = hexdec(substr($search, 168, 2));
			}
			else {
				$fileROSGOPM = hexdec(substr($search, 106, 2));
				$fileROSASAS = hexdec(substr($search, 108, 2));
				$fileROSPLMN = hexdec(substr($search, 110, 2)) + hexdec(substr($search, 112, 2)) * 256;
				$fileROSPMGA = hexdec(substr($search, 114, 2)) + hexdec(substr($search, 116, 2)) * 256;
				$fileROSSTST = hexdec(substr($search, 118, 2)) + hexdec(substr($search, 120, 2)) * 256;
				$fileROSPPSO = hexdec(substr($search, 122, 2));
				$fileROSSHWN = hexdec(substr($search, 124, 2));
				$fileROSGWLS = hexdec(substr($search, 126, 2));
				$fileROSGTTI = hexdec(substr($search, 128, 2));
				$fileROSHITS = "0";
			}
			if($fileROSPMGA > 255) $fileROSPMGA = 255;
			
			$fileROSOver = 'NA';
			// Forward
			if($fileROSPosi == '00' || $fileROSPosi == '01' || $fileROSPosi == '02') {
				$fileROStmp = 
				($fileROSInte*5) + 
				($fileROSSpee*5) + 
				($fileROSStre*7) + 
				($fileROSEndu*3) + 
				($fileROSDura*1) + 
				($fileROSDisc*1) + 
				($fileROSSkat*6) + 
				($fileROSPass*10) + 
				($fileROSPKCT*8) + 
				($fileROSDefs*7) + 
				($fileROSOffs*13) + 
				($fileROSExpe*1) + 
				($fileROSLead*1);
				$fileROSOver = 5 + intval($fileROStmp / 68);
			}
			
			// D Defensive
			if($fileROSPosi == '03' && ($fileROSPass + $fileROSOffs) >= ($fileROSDefs + $fileROSStre)) {
				$fileROStmp = 
				($fileROSInte*4) + 
				($fileROSSpee*8) + 
				($fileROSStre*4) + 
				($fileROSEndu*3) + 
				($fileROSDura*1) + 
				($fileROSDisc*1) + 
				($fileROSSkat*8) + 
				($fileROSPass*11) + 
				($fileROSPKCT*9) + 
				($fileROSDefs*6) + 
				($fileROSOffs*11) + 
				($fileROSExpe*1) + 
				($fileROSLead*1);
				$fileROSOver = 5 + intval($fileROStmp / 68);
			}
			
			// D Offensive
			if($fileROSPosi == '03' && $fileROSOver == 'NA') {
				$fileROStmp = 
				($fileROSInte*8) + 
				($fileROSSpee*5) + 
				($fileROSStre*10) + 
				($fileROSEndu*3) + 
				($fileROSDura*1) + 
				($fileROSDisc*1) + 
				($fileROSSkat*6) + 
				($fileROSPass*8) + 
				($fileROSPKCT*6) + 
				($fileROSDefs*13) + 
				($fileROSOffs*5) + 
				($fileROSExpe*1) + 
				($fileROSLead*1);
				$fileROSOver = 5 + intval($fileROStmp / 68);
			}
			
			// Goalie
			if($fileROSPosi == '04') {
				$fileROStmp = 
				($fileROSInte*5) + 
				($fileROSSpee*17) + 
				($fileROSStre*4) + 
				($fileROSEndu*3) + 
				($fileROSDura*1) + 
				($fileROSDisc*1) + 
				($fileROSSkat*7) + 
				($fileROSPass*3) + 
				($fileROSPKCT*8) + 
				($fileROSExpe*1) + 
				($fileROSLead*1);
				$fileROSOver = intval($fileROStmp / 53);
			}
		}
		else {
			$fileROSName = '-';
		}

		// Updating the database
		if($fileROSName != "-") {
			$fileROSName = mysqli_real_escape_string($con, $fileROSName);
			$sql = "INSERT INTO `".$db_table."_players` (
			`RANK` ,
			`NAME`, 
			`POSI`, 
			`NUMB`, 
			`PROT`, 
			`HAND`, 
			`HEIG`, 
			`WEIG`, 
			`AGES`, 
			`STAT`, 
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
			`CONT`, 
			`SUSP`, 
			`GPGP`,
			`GOPM`,
			`ASAS`,
			`PLMN`,
			`PMGA`,
			`STST`,
			`PPSO`,
			`SHWN`,
			`GWLS`,
			`GTTI`,
			`HITS`,
			`BIRT`, 
			`OVER`, 
			`TEAM`, 
			`SAVE_STAT`,
			`SAVE_PROT`) 
			VALUES (
			'$fileRosRank',
			'$fileROSName',
			'$fileROSPosi',
			'$fileROSNumb',
			'$fileROSProt',
			'$fileROSHand',
			'$fileROSHeig',
			'$fileROSWeig',
			'$fileROSAges',
			'$fileROSStat',
			'$fileROSCond',
			'$fileROSInte',
			'$fileROSSpee',
			'$fileROSStre',
			'$fileROSEndu',
			'$fileROSDura',
			'$fileROSDisc',
			'$fileROSSkat',
			'$fileROSPass',
			'$fileROSPKCT',
			'$fileROSDefs',
			'$fileROSOffs',
			'$fileROSExpe',
			'$fileROSLead',
			'$fileROSSala',
			'$fileROSYRCT',
			'$fileROSSusp',
			'$fileROSGPGP',
			'$fileROSGOPM',
			'$fileROSASAS',
			'$fileROSPLMN',
			'$fileROSPMGA',
			'$fileROSSTST',
			'$fileROSPPSO',
			'$fileROSSHWN',
			'$fileROSGWLS',
			'$fileROSGTTI',
			'$fileROSHITS',
			'$fileROSBirt',
			'$fileROSOver',
			'$t',
			'',
			'')
			;";
			$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		}
	
		$cpt = $cpt + 172;
	}
}

mysqli_close($con);
?>