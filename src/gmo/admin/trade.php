<?php
function moneyFormat($money,$lang) {
	if($lang == "fr") $money2 = number_format($money, 0, ',', ' ')." $";
	if($lang == "en") $money2 = "$".number_format($money, 0, '.', ',');
	return $money2;
}

// Find if a trade is pending and NOT waiting for a GM!
include 'login/mysqli.php';
$sql = "SELECT * FROM `".$db_table."_trade` WHERE `APPROVAL` = '0000-00-00 00:00:00' AND `DATE2` != '0000-00-00 00:00:00'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
$i = 0;
if(mysqli_num_rows($query) > 0) {
	while($data = mysqli_fetch_array($query)) {
		$dbINT[$i] = $data['INT'];
		$dbDATE1[$i] = $data['DATE1'];
		$dbDATE2[$i] = $data['DATE2'];
		$dbTEAM1[$i] = $data['TEAM1'];
		$dbTEAM2[$i] = $data['TEAM2'];
		if($data['PLAYER1'] != "") $dbPLAYER1[$i] = explode('|',$data['PLAYER1']);
		if($data['PLAYER2'] != "") $dbPLAYER2[$i] = explode('|',$data['PLAYER2']);
		if($data['PROSPECT1'] != "") $dbPROSPECT1[$i] = explode('|',$data['PROSPECT1']);
		if($data['PROSPECT2'] != "") $dbPROSPECT2[$i] = explode('|',$data['PROSPECT2']);
		if($data['DRAFT1'] != "") $dbDRAFT1[$i] = explode('|',$data['DRAFT1']);
		if($data['DRAFT2'] != "") $dbDRAFT2[$i] = explode('|',$data['DRAFT2']);
		$dbTEXT1[$i] = $data['TEXT1'];
		$dbTEXT2[$i] = $data['TEXT2'];
		if($data['CASH1'] != "") $dbCASH1[$i] = moneyFormat($data['CASH1'], $league_langue);
		else $dbCASH1[$i] = "";
		if($data['CASH2'] != "") $dbCASH2[$i] = moneyFormat($data['CASH2'], $league_langue);
		else $dbCASH2[$i] = "";
		$i++;
	}
}
mysqli_close($con);
echo '<br>';

if(isset($dbINT)) {
	echo '<span style="font-weight:bold;">'.$db_admin_trade[0].'</span><br>'.$db_admin_trade[18].'<br>';
	echo '<table class="table" style="margin-bottom:20px;">';
	echo '<tr class="tr">';
	echo '<td>'.$db_admin_trade[1].'</td>';
	echo '<td>'.$db_admin_trade[16].'</td>';
	echo '<td>'.$db_admin_trade[6].'</td>';
	echo '<td>'.$db_admin_trade[17].'</td>';
	echo '<td></td>';
	echo '</tr>';
	for($i=0;$i<count($dbINT);$i++) {
		echo '<tr>';
		echo '<td style="vertical-align: top;">'.$dbTEAM1[$i].'<br>'.$dbDATE1[$i].'</td>';
		echo '<td style="vertical-align: top;">';
		$x = $y = $z = 0;
		if(isset($dbPLAYER1[$i])) {
			for($x=0;$x<count($dbPLAYER1[$i]);$x++) {
				$plusStats = "";
				include 'login/mysqli.php';
				$tmp = mysqli_real_escape_string($con, $dbPLAYER1[$i][$x]);
				$sql = "SELECT * FROM `".$db_table."_players` WHERE `NAME` = '$tmp' LIMIT 1";
				$query = mysqli_query($con, $sql) or die(mysqli_error($con));
				if(mysqli_num_rows($query) > 0) {
					while($data = mysqli_fetch_array($query)) {
						$dbOVER = $data['OVER'];
						if($data['POSI'] == "00") $dbPOSI = "C";
						if($data['POSI'] == "01") $dbPOSI = "LW";
						if($data['POSI'] == "02") $dbPOSI = "RW";
						if($data['POSI'] == "03") $dbPOSI = "D";
						if($data['POSI'] == "04") $dbPOSI = "G";
					}
					$plusStats = " (".$dbPOSI." - ".$dbOVER.")";
				}
				mysqli_close($con);
				if($x!=0) echo '<br>';
				echo $dbPLAYER1[$i][$x].$plusStats;
			}
		}
		if(isset($dbPROSPECT1[$i])) {
			for($y=0;$y<count($dbPROSPECT1[$i]);$y++) {
				if($y!=0 || $x!=0) echo '<br>';
				echo '*'.$dbPROSPECT1[$i][$y];
			}
		}
		if(isset($dbDRAFT1[$i])) {
			for($z=0;$z<count($dbDRAFT1[$i]);$z++) {
				if($z!=0 || $y!=0 || $x!=0) echo '<br>';
				echo $dbDRAFT1[$i][$z];
			}
		}
		if($dbCASH1[$i] != "") echo '<br>';
		echo $dbCASH1[$i];
		echo '</td>';

		echo '<td style="vertical-align: top;">'.$dbTEAM2[$i].'<br>'.$dbDATE2[$i].'</td>';
		echo '<td style="vertical-align: top;">';
		$x = $y = $z = 0;
		if(isset($dbPLAYER2[$i])) {
			for($x=0;$x<count($dbPLAYER2[$i]);$x++) {
				$plusStats = "";
				include 'login/mysqli.php';
				$tmp = mysqli_real_escape_string($con, $dbPLAYER2[$i][$x]);
				$sql = "SELECT * FROM `".$db_table."_players` WHERE `NAME` = '$tmp' LIMIT 1";
				$query = mysqli_query($con, $sql) or die(mysqli_error($con));
				if(mysqli_num_rows($query) > 0) {
					while($data = mysqli_fetch_array($query)) {
						$dbOVER = $data['OVER'];
						if($data['POSI'] == "00") $dbPOSI = "C";
						if($data['POSI'] == "01") $dbPOSI = "LW";
						if($data['POSI'] == "02") $dbPOSI = "RW";
						if($data['POSI'] == "03") $dbPOSI = "D";
						if($data['POSI'] == "04") $dbPOSI = "G";
					}
					$plusStats = " (".$dbPOSI." - ".$dbOVER.")";
				}
				mysqli_close($con);
				if($x!=0) echo '<br>';
				echo $dbPLAYER2[$i][$x].$plusStats;
			}
		}
		if(isset($dbPROSPECT2[$i])) {
			for($y=0;$y<count($dbPROSPECT2[$i]);$y++) {
				if($y!=0 || $x!=0) echo '<br>';
				echo '*'.$dbPROSPECT2[$i][$y];
			}
		}
		if(isset($dbDRAFT2[$i])) {
			for($z=0;$z<count($dbDRAFT2[$i]);$z++) {
				if($z!=0 || $y!=0 || $x!=0) echo '<br>';
				echo $dbDRAFT2[$i][$z];
			}
		}
		if($dbCASH2[$i] != "") echo '<br>';
		echo $dbCASH2[$i];
		echo '</td>';
		
		$rowspan = "";
		if($dbTEXT1[$i] != "" || $dbTEXT2[$i] != "") $rowspan = ' rowspan="2"';
		
		echo '<td'.$rowspan.' style="font-weight:bold; text-align:center;">
		<input style="background-color:green; margin-bottom:10px;" class="button" type="button" value="'.$db_admin_trade[12].'" onclick="javascript:acceptedTrade('.$dbINT[$i].');">
		<input style="background-color:red;" class="button" type="button" value="'.$db_admin_trade[13].'" onclick="javascript:deleteTrade('.$dbINT[$i].');">
		</td>';
		echo '</tr>';
		
		if($dbTEXT1[$i] != "" || $dbTEXT2[$i] != "") {
			echo '<tr><td colspan="2">'.$dbTEXT1[$i].'</td><td colspan="2">'.$dbTEXT2[$i].'</td></tr>';
		}
	}
	echo '</table>';
}
else {
	echo '<span style="font-weight:bold;">'.$db_admin_trade[11].'</span>';
}

?>