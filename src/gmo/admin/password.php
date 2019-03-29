<?php

$user = $_SESSION['login'];
extract($_POST,EXTR_OVERWRITE);

if(isset($_POST['changer']) && isset($_POST['actpass']) && isset($_POST['new1']) && isset($_POST['new2'])) {
	$new1 = $_POST['new1'];
	$new2 = $_POST['new2'];
	$correct2 = 0;
	if($new1 == $new2) {
		$correct2 = 1;
		$actpass = $_POST['actpass'];
		include GMO_ROOT.'login/mysqli.php';
		$user = mysqli_real_escape_string($con, $user);
		$sql = "SELECT `PASS` FROM `".$db_table."` WHERE `USER` = '$user'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		while($data = mysqli_fetch_array($query)) {
				if(md5($actpass) == $data['PASS']) {
					$correct2 = 2;
				}
		}
		if(isset($correct2) && $correct2 == 2) {
			$new1 = md5($new1);
			include GMO_ROOT.'login/mysqli.php';
			$user = mysqli_real_escape_string($con, $user);
			$sql = "UPDATE `".$db_table."` SET `PASS`='$new1' WHERE `USER`='$user'";
			$query = mysqli_query($con, $sql) or die(mysqli_error($con));
			$adminPassword = 1;
		}
		mysqli_close($con);
	}
}

if(isset($_POST['notification']) ) {
	if(isset($_POST['checkboxNotification'])) {
		$checkboxNotification = 1;
		$e = $db_admin_pass_langue[9];
		$f = "#4caf50";
	}
	else {
		$checkboxNotification = 0;
		$e = $db_admin_pass_langue[8];
	}
	
	include GMO_ROOT.'login/mysqli.php';
	$sql = "UPDATE `".$db_table."` SET `NOTIFICATION`='$checkboxNotification', `EMAIL`='$inputEmail' WHERE `INT`='$teamID'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
}

if(isset($_POST['language']) ) {
	$inputLanguage = $_POST['inputLanguage'];
	if($inputLanguage == "en") $text = $db_admin_pass_langue[12];
	if($inputLanguage == "fr") $text = $db_admin_pass_langue[11];
	$e = $db_admin_pass_langue[13]." (".$text.")";
	$f = "#4caf50";
	$league_langue = $inputLanguage;
	include GMO_ROOT.'admin/lang.php';
	
	include GMO_ROOT.'login/mysqli.php';;
	$sql = "UPDATE `".$db_table."` SET `LANGUE`='$inputLanguage' WHERE `INT`='$teamID'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
}

$languageEN = "";
$languageFR = "";
include GMO_ROOT.'login/mysqli.php';;
$sql = "SELECT `NOTIFICATION`, `LANGUE`, `EMAIL` FROM `".$db_table."` WHERE `INT` = '$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	if($data['NOTIFICATION'] == 1) $notification = " checked";
	else $notification = "";
	if($data['LANGUE'] == "en") $languageEN = " checked";
	if($data['LANGUE'] == "fr") $languageFR = " checked";
	$teamEmail = $data['EMAIL'];
}
mysqli_close($con);

$link = 'admin=pass';
if(isset($step) && $step == 1) {
	$link = 'admin=first&step='.$step;
}
if(isset($adminPassword) && $adminPassword == 1) {
	$tmpNext = '';
	if(isset($step) && $step == 1) $tmpNext = ' - <a href="?admin=first&step='.$nextStep.'">'.$db_admin_assist_langue[1].'</a>';
	echo '<span style="display:block; font-weight:bold; color:green; padding-top:25px;">'.$db_admin_password_langue[0].$tmpNext.'</span>';
}
if(isset($correct2) && $correct2 == 0) {
	echo '<span style="display:block; font-weight:bold; color:red; padding-top:25px;">'.$db_admin_password_langue[1].'</span>';
}
if(isset($correct2) && $correct2 == 1) {
	echo '<span style="display:block; font-weight:bold; color:red; padding-top:25px;">'.$db_admin_password_langue[2].'</span>';
}



if(isset($step) && $step == 1) echo '<br>'.$db_admin_assist_langue[4].'<br>';
?>

<form method="post" action="index.php?<?php echo $link; ?>">
<br><b><?php echo $db_admin_pass_langue[0]; ?></b><br>
<table><tr>
		<td><?php echo $db_admin_pass_langue[1]; ?></td>
		<td>
			<input type="password" name="actpass" size="20" required>
		</td>
	</tr>
	<tr>
		<td><?php echo $db_admin_pass_langue[2]; ?></td>
		<td>
			<input type="password" name="new1" size="20" required>
		</td>
	</tr>
	<tr>
		<td><?php echo $db_admin_pass_langue[3]; ?></td>
		<td>
			<input type="password" name="new2" size="20" required>
		</td>
	</tr>
</table>
<br><input class="button" type="submit" value="<?php echo $db_admin_all_langue[1]; ?>" name="changer">
</form>

<hr style="margin-top:25px; margin-bottom:25px;">

<form method="post" action="index.php?<?php echo $link; ?>">
<label for="checkboxNotification" style="font-weight:bold;"><?php echo $db_admin_pass_langue[7]; ?></label><input id="checkboxNotification" name="checkboxNotification" type="checkbox" value="" style="padding_left:25px;"<?php echo $notification; ?>><br>
<br><?php echo $db_admin_pass_langue[15]; ?><br>
<br><?php echo $db_admin_pass_langue[14]; ?>: <input name="inputEmail" value="<?php echo $teamEmail; ?>"><br>
<br><input class="button" type="submit" value="<?php echo $db_admin_all_langue[1]; ?>" name="notification">
</form>

<hr style="margin-top:25px; margin-bottom:25px;">

<form method="post" action="index.php?<?php echo $link; ?>">
<div style="font-weight:bold; margin-bottom:10px;"><?php echo $db_admin_pass_langue[10]; ?></div>
<label for="languageFR"><?php echo $db_admin_pass_langue[11]; ?></label>
<input id="languageFR" name="inputLanguage" type="radio" value="fr" style="padding_left:25px;"<?php echo $languageFR; ?>>
<label for="languageEN"><?php echo $db_admin_pass_langue[12]; ?></label>
<input id="languageEN" name="inputLanguage" type="radio" value="en" style="padding_left:25px;"<?php echo $languageEN; ?>><br>
<br><input class="button" type="submit" value="<?php echo $db_admin_all_langue[1]; ?>" name="language">
</form>
