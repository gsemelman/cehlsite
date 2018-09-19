<?php

$chatBoxStatus = $_POST['s'];

// chatbox.txt
// Name - Text - DateTime - Hover
$Fnm = 'chatbox.txt';
$chatBoxLines = 49; // Number of lines max in the chat
date_default_timezone_set($leagueTimeZone); // TimeZone setupped in config.php
$chatBoxDateTime = date('Y-m-d H:i:s'); // DateTime from server
$chatBoxFileRows = 4; // Lenght of content in chatbox.txt

if($chatBoxStatus == 'read') {
	if(file_exists($Fnm)) {
		$chatBoxRead = file($Fnm);
		for($i=0;$i<(count($chatBoxRead)/$chatBoxFileRows);$i++) {
			$tmpi = $chatBoxFileRows * $i;
			echo '<div class="'.$chatBoxRead[$tmpi+3].'" style="width:100%;">'.$chatBoxRead[$tmpi+2].' - '.$chatBoxRead[$tmpi].': '.$chatBoxRead[$tmpi+1].'</div>';
		}
	}
	else echo 'No converstion found...<br>';
}

if($chatBoxStatus == 'write') {
	$chatBoxWrite = $_POST['write'];
	$chatBoxName = $_POST['name'];
	$chatBoxtmpWrite = '';
	$c = 1;
	
	// Read the file
	if(file_exists($Fnm)) {
		$chatBoxtmpRead = file($Fnm);
		$tmpCount = count($chatBoxtmpRead)/$chatBoxFileRows;
		if($tmpCount > $chatBoxLines) $tmpCount = $tmpCount - $chatBoxLines;
		else $tmpCount = 0;
		for($i=$tmpCount;$i<(count($chatBoxtmpRead)/$chatBoxFileRows);$i++) {
			$tmpi = $chatBoxFileRows * $i;
			$chatBoxtmpWrite .= $chatBoxtmpRead[$tmpi].$chatBoxtmpRead[$tmpi+1].$chatBoxtmpRead[$tmpi+2].$chatBoxtmpRead[$tmpi+3];
			if(substr_count($chatBoxtmpRead[$tmpi+3], 'chatHover1')) $c = 1;
			if(substr_count($chatBoxtmpRead[$tmpi+3], 'chatHover2')) $c = 2;
		}
	}
	// Write the file
	if($c == 1) $c = 2;
	else $c = 1;
	$error = 0;
	$chatBoxFile = fopen($Fnm, "w") or $error = 1;
	if($error == 1) {
		chmod(".", 0755);
		$chatBoxFile = fopen($Fnm, "w") or die("Unable to open file!<br>");
	}
	$chatBoxFileTxt = $chatBoxtmpWrite.$chatBoxName."\n".$chatBoxWrite."\n".$chatBoxDateTime."\nchatHover".$c."\n";
	fwrite($chatBoxFile, $chatBoxFileTxt);
	fclose($chatBoxFile);

	// Write on screen!
	echo '<div class="chatHover'.$c.'" style="width:100%;"><b>'.$chatBoxDateTime.' - '.$chatBoxName.'</b>: '.$chatBoxWrite.'</div>';

}

?>