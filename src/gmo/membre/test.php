<?php

// .TMS - Team List
$matches = glob($file_folder.'*.tms');
if(isset($matches) && count($matches)) {
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		break 1;
	}
	$fileTMS = $matches[$j];
}

if(isset($fileTMS)) {
	$filename = $fileTMS;
	$handle = fopen ($filename, "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$hex = '';
	$hex = bin2hex($load_contents);
	
	echo '<div style="float:left; margin-right:10px;"><b>.TMS FILE!</b><br>';
	
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
			$strLength = strlen($teamAbbr);
			$returnVal = '';
			for($k=0; $k<$strLength; $k += 2) {
				$dec_val = hexdec(substr($teamAbbr, $k, 2));
				$returnVal .= chr($dec_val);
			}
			$teamAbbr = utf8_encode(trim($returnVal));
			if($teamName == $teamFHLSimName) echo '<b>';
			echo $teamNumber.'. '.$teamName.' ('.$teamAbbr.')<br>';
			if($teamName == $teamFHLSimName) echo '</b>';
			$teamNumber++;
		}
	}
	echo '</div>';
}
else echo '<div style="float:left; margin-right:10px;"><b>.TMS FILE NOT FOUND!</b></div>';

// .DPK - Draft Pick
$matches = glob($file_folder.'*.dpk');
if(isset($matches) && count($matches)) {
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		break 1;
	}
	$fileDPK = $matches[$j];
}

if(isset($fileDPK)) {
	$filename = $fileDPK;
	$handle = fopen ($filename, "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$hex = '';
	$hex = bin2hex($load_contents);
	
	echo '<div style="float:left; margin-right:10px;"><b>.DPK FILE!</b><br>';
	
	echo '<table><tr><td style="border:1px solid #'.$databaseColors['colorMainText'].'; width:50px;">Year</td><td style="border:1px solid #'.$databaseColors['colorMainText'].'; width:50px;">#</td><td style="border:1px solid #'.$databaseColors['colorMainText'].'; width:50px;">Team</td><td style="border:1px solid #'.$databaseColors['colorMainText'].'; width:50px;">???</td></tr>';
	
	$teamNumber = 0;
	for($y=0;$y<strlen($hex);$y=$y+3072) {
		echo '<tr><td colspan="4"><b>Team #'.$teamNumber.' Prospects</b></td></tr>';
		$draftPickList = substr($hex, $y, 3072);
		for($x=0;$x<strlen($draftPickList);$x=$x+12) {
			$tmpNumber = hexdec(substr($draftPickList, $x+2, 2)) + 1;
			if(substr($draftPickList, $x+8, 2) == "ff" && substr($draftPickList, $x+10, 2) == "ff") echo '<tr><td style="border:1px solid #'.$databaseColors['colorMainText'].';">'.hexdec(substr($draftPickList, $x, 2)).'</td><td style="border:1px solid #'.$databaseColors['colorMainText'].';">'.$tmpNumber.'</td><td style="border:1px solid #'.$databaseColors['colorMainText'].';">'.hexdec(substr($draftPickList, $x+4, 2)).'</td><td style="border:1px solid #'.$databaseColors['colorMainText'].';">'.hexdec(substr($draftPickList, $x+6, 2)).'</td></tr>';
		}
		$teamNumber++;
	}
	
	echo '</table>';
	
	echo '</div>';
}
else echo '<div style="float:left; margin-right:10px;"><b>.DPK FILE NOT FOUND!</b></div>';

// PCT - Prospect
$matches = glob($file_folder.'*.pct');
if(isset($matches) && count($matches)) {
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		break 1;
	}
	$filePCT = $matches[$j];
}

if(isset($filePCT)) {
	$filename = $filePCT;
	$handle = fopen ($filename, "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$hex = '';
	$hex = bin2hex($load_contents);
	
	echo '<div style="float:left; margin-right:10px;"><b>.PCT FILE!</b>';
	
	$teamNumber = 0;
	for($y=0;$y<strlen($hex);$y=$y+5400) {
		echo '<br><b>Team #'.$teamNumber.' Prospects</b><br>';
		$prospectList = substr($hex, $y, 5400);
		for($x=0;$x<strlen($prospectList);$x=$x+44) {
			$prospectName = substr($prospectList, $x, 44);
			if(strpos($prospectName,"00") === false) {
				$strLength = strlen($prospectName);
				$returnVal = '';
				for($k=0; $k<$strLength; $k += 2) {
					$dec_val = hexdec(substr($prospectName, $k, 2));
					$returnVal .= chr($dec_val);
				}
				$prospectName2 = utf8_encode(trim($returnVal));
				if($prospectName2 != '') echo $prospectName2.'<br>';
			}
		}
		$teamNumber++;
	}
	
	echo '</div>';
}
else echo '<div style="float:left; margin-right:10px;"><b>.PCT FILE NOT FOUND!</b></div>';

// ROS - Rosters
$matches = glob($file_folder.'*.ros');
if(isset($matches) && count($matches)) {
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		break 1;
	}
	$fileROS = $matches[$j];
}

if(isset($fileROS)) {
	$filename = $fileROS;
	$handle = fopen ($filename, "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$hex = '';
	$hex = bin2hex($load_contents);
	
	echo '<div style="float:left; margin-right:10px;"><b>.ROS FILE!</b>';
	
	$teamNumber = 0;
	for($y=0;$y<strlen($hex);$y=$y+8600) {
		echo '<br><b>Team #'.$teamNumber.' Roster</b><br>';
		$rosterList = substr($hex, $y, 8600);
		$z = 0;
		for($x=0;$x<strlen($rosterList);$x=$x+172) {
			$rosterName = substr($rosterList, $x, 44);
			$strLength = strlen($rosterName);
			$returnVal = '';
			for($k=0; $k<$strLength; $k += 2) {
				$dec_val = hexdec(substr($rosterName, $k, 2));
				$returnVal .= chr($dec_val);
			}
			$rosterName = utf8_encode(trim($returnVal));
			
			if($rosterName != '') {
				echo $z.'. '.$rosterName.'<br>';
				$z++;
			}
		}
		$teamNumber++;
	}
	
	echo '</div>';
}
else echo '<div style="float:left; margin-right:10px;"><b>.ROS FILE NOT FOUND!</b></div>';

?>