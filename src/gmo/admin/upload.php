<?php
// Lecture des valeurs dans la base de donnée
include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM`='file_folder'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	//$file_folder = $data['VALUE'];
    $file_folder = FS_ROOT.'gmo/'.$data['VALUE'];
	
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
if(isset($_POST['submit'])) {
	$succesUpdateTMS = 0;
	$succesUpdateROS = 0;
	
	// Online GM Editor
	if (isset($_FILES['leaguesTMS']) && is_uploaded_file($_FILES['leaguesTMS']['tmp_name']) && isset($_FILES['leaguesROS']) && is_uploaded_file($_FILES['leaguesROS']['tmp_name'])) {
		$res = copy($_FILES['leaguesTMS']['tmp_name'], $file_folder .$_FILES['leaguesTMS']['name']);
		if($res) $succesUpdateTMS = 1;
		$res = copy($_FILES['leaguesROS']['tmp_name'], $file_folder .$_FILES['leaguesROS']['name']);
		if($res) $succesUpdateROS = 1;
	}
	
	// Trade History
	if (isset($_FILES['leaguesHTR']) && is_uploaded_file($_FILES['leaguesHTR']['tmp_name'])) {
		$succesUpdateHTR = 1;
	}
	
	// Trade Tool
	if (isset($_FILES['leaguesPCT']) && is_uploaded_file($_FILES['leaguesPCT']['tmp_name'])) {
		$res = copy($_FILES['leaguesPCT']['tmp_name'], $file_folder .$_FILES['leaguesPCT']['name']);
		if($res) $succesUpdatePCT = 1;
	}
	if (isset($_FILES['leaguesDPK']) && is_uploaded_file($_FILES['leaguesDPK']['tmp_name'])) {
		$res = copy($_FILES['leaguesDPK']['tmp_name'], $file_folder .$_FILES['leaguesDPK']['name']);
		if($res) $succesUpdateDPK = 1;
	}
	
	// Email Notification
	if (isset($_FILES['leaguesEML']) && is_uploaded_file($_FILES['leaguesEML']['tmp_name'])) {
		$succesUpdateEML = 1;
	}
	if (isset($_FILES['leaguesEMLTMS']) && is_uploaded_file($_FILES['leaguesEMLTMS']['tmp_name'])) {
		$succesUpdateEML2 = 1;
	}
	
	header('Location: ' . $_SERVER['HTTP_REFERER'].'#Admin');
}

// Détecte si le fichier ROS existe
$matches = glob($file_folder.'*.ros');
if(isset($matches) && count($matches)) {
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		break 1;
	}
	$lastDate = '';
	$lastDate = date("Y-m-d H:i:s.",filemtime($matches[$j]));
}
else $lastDate = $db_admin_upload_langue[6];

// Trade History - Read file and Send data to database!
if(isset($succesUpdateHTR)) {
	$handle = fopen ($_FILES['leaguesHTR']['tmp_name'], "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$tradeHistory = explode("<BR>", utf8_encode($load_contents));
	
	$k = 0;
	for($i=0;$i<count($tradeHistory);$i++) {
		// Find trades
		if(substr(trim($tradeHistory[$i]), 0, 3) == "To ") {
			$tradeTeamFull = substr(trim($tradeHistory[$i]), 2);
			$tradeTeam[$k] = trim(substr($tradeTeamFull, 0, strpos($tradeTeamFull,":"))); // Team
			$tradePick[$k] = ""; // Draft Pick
			$tradePlayer[$k] = ""; // Player
			$tradeCash[$k] = ""; // Cash
			$tradeList = explode(",",substr($tradeTeamFull, strpos($tradeTeamFull,":")+1));
			for($j=0;$j<count($tradeList);$j++) {
				$tradeList[$j] = trim($tradeList[$j]);
				if(substr_count($tradeList[$j],"Rnd") == true) {
					if($tradePick[$k] == "") $tradePick[$k] = $tradeList[$j];
					else $tradePick[$k] .= '|'.$tradeList[$j];
				}
				if(substr_count($tradeList[$j],"$") == true) {
					if($tradeCash[$k] == "") {
						$tradeCash[$k] = $tradeList[$j];
						$tradeCash[$k] = str_replace("$", "", $tradeCash[$k]);
						$tradeCash[$k] = preg_replace('~\x{00a0}~siu', '', $tradeCash[$k]);
						
					}
					else $tradeCash[$k] .= '|'.$tradeList[$j];
				}
				if(substr_count($tradeList[$j],"$") == false && substr_count($tradeList[$j],"Rnd") == false) {
					if($tradePlayer[$k] == "") $tradePlayer[$k] = $tradeList[$j];
					else $tradePlayer[$k] .= '|'.$tradeList[$j];
				}
			}
			// echo $tradeTeam[$k].': '.$tradePlayer[$k].','.$tradeCash[$k].','.$tradePick[$k].'<br>'; // Test Purpose Only
			$k++;
		}
	}
	
	// Write datas to database!
	include 'login/mysqli.php';
	
	$sql = "TRUNCATE TABLE `".$db_table."_trade`";
	$query = mysqli_query($con, $sql);
	$homeDate = date("Y-m-d H:i:s");
	
	if(isset($tradeTeam)) {
		for($k=count($tradeTeam)-1;$k>=0;$k=$k-2) {
			$homePlayer = $tradePlayer[$k-1];
			$homeProspect = "";
			$homeDraft = $tradePick[$k-1];
			$homeCash = $tradeCash[$k-1];
			$homeTeam = $tradeTeam[$k-1];
			
			$awayPlayer = $tradePlayer[$k];
			$awayProspect = "";
			$awayDraft = $tradePick[$k];
			$awayCash = $tradeCash[$k];
			$awayTeam = $tradeTeam[$k];
			
			$homePlayerSQL = mysqli_real_escape_string($con, $homePlayer);
			$homeProspectSQL = mysqli_real_escape_string($con, $homeProspect);
			$homeDraftSQL = mysqli_real_escape_string($con, $homeDraft);
			$homeCashSQL = mysqli_real_escape_string($con, $homeCash);
			$homeTeamSQL = mysqli_real_escape_string($con, $homeTeam);
			
			$awayPlayerSQL = mysqli_real_escape_string($con, $awayPlayer);
			$awayProspectSQL = mysqli_real_escape_string($con, $awayProspect);
			$awayDraftSQL = mysqli_real_escape_string($con, $awayDraft);
			$awayCashSQL = mysqli_real_escape_string($con, $awayCash);
			$awayTeamSQL = mysqli_real_escape_string($con, $awayTeam);
			
			$sql = "INSERT INTO `".$db_table."_trade` (
			`DATE1`, 
			`TEAM1`, 
			`PLAYER1`, 
			`PROSPECT1`, 
			`DRAFT1`, 
			`CASH1`, 
			`DATE2`, 
			`TEAM2`, 
			`PLAYER2`, 
			`PROSPECT2`, 
			`DRAFT2`, 
			`CASH2`, 
			`APPROVAL`,
			`TEXT1`,
			`TEXT2`
			) 
			VALUES (
			'$homeDate', 
			'$homeTeamSQL', 
			'$homePlayerSQL', 
			'$homeProspectSQL', 
			'$homeDraftSQL', 
			'$homeCashSQL', 
			'$homeDate', 
			'$awayTeamSQL', 
			'$awayPlayerSQL', 
			'$awayProspectSQL', 
			'$awayDraftSQL', 
			'$awayCashSQL', 
			'$homeDate',
			'', 
			''
			)
			;";
			$query = mysqli_query($con, $sql);
		}
	}
    
	mysqli_close($con);
}

// Email Notification
if(isset($succesUpdateEML) && isset($succesUpdateEML)) {
	$handle = fopen ($_FILES['leaguesEMLTMS']['tmp_name'], "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$file_tms = bin2hex($load_contents);
	
	$j = 0;
	$cpt = 0;
	while($cpt != 100){
		$hex = substr($file_tms, $j, 20);
		$str = '';
		for($i=0;$i<strlen($hex);$i+=2) $str .= chr(hexdec(substr($hex,$i,2)));
		$teamName[] = trim($str);
		$erreur = substr($file_tms, $j+506, 2);
		if((hexdec($erreur)>="32") && (hexdec($erreur)<="126")) $j = $j + 506;
		else $j = $j + 508;
		$cpt++;
	}
	
	$handle = fopen ($_FILES['leaguesEML']['tmp_name'], "r");
	$load_contents = '';
	while (!feof($handle)) {
		$load_contents .= fread($handle, 8192);
	}
	fclose ($handle);
	$emlList = explode(PHP_EOL, utf8_encode($load_contents));
	
	for($x=0;$x<count($emlList);$x++) {
		$emlPos[] = trim(substr($emlList[$x], 0, strpos($emlList[$x],",")));
		$emlEml[] = trim(substr($emlList[$x], strpos($emlList[$x],",")+1));
	}
	
	// Write datas to database!
	include 'login/mysqli.php';
	
	if(isset($emlEml)) {
		for($k=0;$k<count($emlEml);$k++) {
			if($emlPos[$k] != "") {
				$sqlEml = mysqli_real_escape_string($con, $emlEml[$k]);
				$tmpTms = $teamName[$emlPos[$k]];
				
				$sql = "UPDATE `$db_table` SET `EMAIL` = '$sqlEml' WHERE `EQUIPESIM`='$tmpTms';";
				$query = mysqli_query($con, $sql);
			}
		}
	}
    
	mysqli_close($con);
}

?>


<?php
$link = 'admin=upload';
if(isset($step) && $step == 3) {
	$link = 'admin=first&step='.$step;
}
if(isset($succesUpdateTMS) && isset($succesUpdateROS) && $succesUpdateTMS == 1 && $succesUpdateROS == 1) {
	$tmpNext = '';
	if(isset($step) && $step == 3) $tmpNext = ' - <a href="?admin=first&step='.$nextStep.'">'.$db_admin_assist_langue[1].'</a>';
	echo '<span style="display:block; font-weight:bold; color:green; padding-top:25px;">'.$db_admin_upload_langue[1].' - files/'.$tmpNext.'</span>';
}
?>

<br><span style=""><?php echo $db_admin_upload_langue[5].$lastDate; ?></span><br>
<br><span style="font-weight:bold; padding-top:25px;"><?php echo $db_admin_upload_langue[0]; ?></span>
<br><?php echo $db_admin_upload_langue[19]; ?><br>

<form method="post" enctype="multipart/form-data" action="?<?php echo $link; ?>">
<br><?php echo $db_admin_upload_langue[3]; ?><br>
<input class="button" style="border:1px solid #dddddd; width:100%;" type="file" name="leaguesTMS" accept=".tms"><br>
<br><?php echo $db_admin_upload_langue[4]; ?><br>
<input class="button" style="border:1px solid #dddddd; width:100%;" type="file" name="leaguesROS" accept=".ros"><br>
<hr>
<span style="font-weight:bold;"><?php echo $db_admin_upload_langue[17]; ?></span>
<br><?php echo $db_admin_upload_langue[8]; ?><br>
<?php echo $db_admin_upload_langue[9]; ?><br>
<br><?php echo $db_admin_upload_langue[7]; ?><br>
<input class="button" style="border:1px solid #dddddd; width:100%;" type="file" name="leaguesHTR" accept=".htr"><br>
<hr>
<span style="font-weight:bold;"><?php echo $db_admin_upload_langue[16]; ?></span>
<br><?php echo $db_admin_upload_langue[18]; ?><br>
<br><?php echo $db_admin_upload_langue[10]; ?><br>
<input class="button" style="border:1px solid #dddddd; width:100%;" type="file" name="leaguesPCT" accept=".pct"><br>
<br><?php echo $db_admin_upload_langue[11]; ?><br>
<input class="button" style="border:1px solid #dddddd; width:100%;" type="file" name="leaguesDPK" accept=".dpk"><br>
<hr>
<span style="font-weight:bold;"><?php echo $db_admin_upload_langue[12]; ?></span><br>
<?php echo $db_admin_upload_langue[13]; ?><br>
<br><?php echo $db_admin_upload_langue[14]; ?><br>
<input class="button" style="border:1px solid #dddddd; width:100%;" type="file" name="leaguesEML" accept=".eml"><br>
<br><?php echo $db_admin_upload_langue[15]; ?><br>
<input class="button" style="border:1px solid #dddddd; width:100%;" type="file" name="leaguesEMLTMS" accept=".tms"><br>
<br><br><input class="button" type="submit" name="submit" value="<?php echo $db_admin_all_langue[1]; ?>" style="text-align:center; width:100%;">
</table>
</form>