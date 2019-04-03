<?php
extract($_POST,EXTR_OVERWRITE);

require_once __DIR__ .'/../../config.php';
include_once FS_ROOT.'common.php';

if(!isset($_SESSION)){
    session_name(SESSION_NAME);
    session_start();
}

if(!isAuthenticated()){
    http_response_code(401);
    exit;
}


$e = "";
$f = "#ae654c"; // Green : #4caf50 | Red : #ae654c

if (isset($_POST['changer']) && isset($_POST['actpass']) && isset($_POST['new1']) && isset($_POST['new2'])) {
	$correct2 = 0;
	$new1 = $_POST['new1'];
	$new2 = $_POST['new2'];
	if($new1 == $new2) {
		$actpass = $_POST['actpass'];
		include GMO_ROOT.'login/mysqli.php';
		$sql = "SELECT `PASS` FROM `".$db_table."` WHERE `INT` = '$teamID'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		while($data = mysqli_fetch_array($query)) {
			if(md5($actpass) == $data['PASS']) {
				$correct2 = 1;
			}
		}
		if($correct2) {
			$new1 = md5($new1);
			$sql = "UPDATE `".$db_table."` SET `PASS`='$new1' WHERE `INT`='$teamID'";
			$query = mysqli_query($con, $sql) or die(mysqli_error($con));
			$e = $db_membre_pass_langue[4];
			$f = "#4caf50";
		}
		else {
			$e = $db_membre_pass_langue[5];
		}
		mysqli_close($con);
	}
	else $e = $db_membre_pass_langue[6];
}

if(isset($_POST['notification']) ) {
	if(isset($_POST['checkboxNotification'])) {
		$checkboxNotification = 1;
		$e = $db_membre_pass_langue[9];
		$f = "#4caf50";
	}
	else {
		$checkboxNotification = 0;
		$e = $db_membre_pass_langue[8];
	}
	
	include GMO_ROOT.'login/mysqli.php';
	$sql = "UPDATE `".$db_table."` SET `NOTIFICATION`='$checkboxNotification' WHERE `INT`='$teamID'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
}

if(isset($_POST['language']) ) {
	$inputLanguage = $_POST['inputLanguage'];
	if($inputLanguage == "en") $text = $db_membre_pass_langue[12];
	if($inputLanguage == "fr") $text = $db_membre_pass_langue[11];
	$e = $db_membre_pass_langue[13]." (".$text.")";
	$f = "#4caf50";
	$league_langue = $inputLanguage;

	include GMO_ROOT.'login/mysqli.php';
	$sql = "UPDATE `".$db_table."` SET `LANGUE`='$inputLanguage' WHERE `INT`='$teamID'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
}

if(isset($_POST['sortPlayer']) ) {
	$inputSortPlayer = $_POST['inputSortPlayer'];
	if($inputSortPlayer == "0") $text = $db_membre_pass_langue[17];
	if($inputSortPlayer == "1") $text = $db_membre_pass_langue[18];
	$e = $db_membre_pass_langue[19]." (".$text.")";
	$f = "#4caf50";
	$gm_sortPlayer = $inputSortPlayer;
	
	include GMO_ROOT.'login/mysqli.php';
	$sql = "UPDATE `".$db_table."` SET `SORT_PLAYER`='$inputSortPlayer' WHERE `INT`='$teamID'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
}

$languageEN = "";
$languageFR = "";
$sortPlayerFirst = "";
$sortPlayerLast = "";
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `NOTIFICATION`, `LANGUE`, `EMAIL`, `SORT_PLAYER` FROM `".$db_table."` WHERE `INT` = '$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	if($data['NOTIFICATION'] == 1) $notification = " checked";
	else $notification = "";
	if($data['LANGUE'] == "en") $languageEN = " checked";
	if($data['LANGUE'] == "fr") $languageFR = " checked";
	$teamEmail = $data['EMAIL'];
	if($data['SORT_PLAYER'] == "0") $sortPlayerFirst = " checked";
	if($data['SORT_PLAYER'] == "1") $sortPlayerLast = " checked";
}
mysqli_close($con);

if($languageEN == "" & $languageFR == "") {
	if($league_langue == "fr") $languageFR = " checked";
	if($league_langue == "en") $languageEN = " checked";
}
if($sortPlayerFirst == "" & $sortPlayerLast == "") {
	if($gm_sortPlayer == "0") $sortPlayerFirst = " checked";
	if($gm_sortPlayer == "1") $sortPlayerLast = " checked";
}

?>
<form method="post" action="">
<div style="font-weight:bold; margin-bottom:10px;"><?php echo $db_membre_pass_langue[0]; ?></div>
<div style="float:left;"><?php echo $db_membre_pass_langue[1]; ?></div>
<div style="float:right;"><input class="inputText" type="password" name="actpass" size="20" required></div>

<div style="clear:both; float:left;"><?php echo $db_membre_pass_langue[2]; ?></div>
<div style="float:right;"><input class="inputText" type="password" name="new1" size="20" required></div>

<div style="clear:both; float:left;"><?php echo $db_membre_pass_langue[3]; ?></div>
<div style="float:right;"><input class="inputText" type="password" name="new2" size="20" required></div>

<div style="clear:both; padding-top:25px;"><input class="button" type="submit" value="<?php echo $db_membre_all_langue[1]; ?>" name="changer"></div>
</form>

<hr style="margin-top:25px; margin-bottom:25px;">

<form method="post" action="">
<label for="checkboxNotification" style="font-weight:bold;"><?php echo $db_membre_pass_langue[7]; ?></label><input id="checkboxNotification" name="checkboxNotification" type="checkbox" value="" style="padding_left:25px;"<?php echo $notification; ?>><br>
<br><?php echo $db_membre_pass_langue[15]; ?><br>
<br><?php echo $db_membre_pass_langue[14]; ?>: <?php echo $teamEmail; ?><br>
<br><input class="button" type="submit" value="<?php echo $db_membre_all_langue[1]; ?>" name="notification">
</form>

<hr style="margin-top:25px; margin-bottom:25px;">

<form method="post" action="">
<div style="font-weight:bold; margin-bottom:10px;"><?php echo $db_membre_pass_langue[10]; ?></div>
<label for="languageFR"><?php echo $db_membre_pass_langue[11]; ?></label>
<input id="languageFR" name="inputLanguage" type="radio" value="fr" style="padding_left:25px;"<?php echo $languageFR; ?>>
<label for="languageEN"><?php echo $db_membre_pass_langue[12]; ?></label>
<input id="languageEN" name="inputLanguage" type="radio" value="en" style="padding_left:25px;"<?php echo $languageEN; ?>><br>
<br><input class="button" type="submit" value="<?php echo $db_membre_all_langue[1]; ?>" name="language">
</form>

<hr style="margin-top:25px; margin-bottom:25px;">

<form method="post" action="">
<div style="font-weight:bold; margin-bottom:10px;"><?php echo $db_membre_pass_langue[16]; ?></div>
<label for="inputSortPlayerFirst"><?php echo $db_membre_pass_langue[17]; ?></label>
<input id="inputSortPlayerFirst" name="inputSortPlayer" type="radio" value="0" style="padding_left:25px;"<?php echo $sortPlayerFirst; ?>>
<label for="inputSortPlayerLast"><?php echo $db_membre_pass_langue[18]; ?></label>
<input id="inputSortPlayerLast" name="inputSortPlayer" type="radio" value="1" style="padding_left:25px;"<?php echo $sortPlayerLast; ?>><br>
<br><input class="button" type="submit" value="<?php echo $db_membre_all_langue[1]; ?>" name="sortPlayer">
</form>

<script type="text/javascript">
<!--

<?php if(isset($e) && $e != '') { ?>
document.addEventListener("DOMContentLoaded", popupAlert("<?php echo $e; ?>", "<?php echo $f; ?>"), false);
<?php } ?>

//-->
</script>
