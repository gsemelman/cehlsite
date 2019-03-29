<?php
extract($_POST,EXTR_OVERWRITE);

if(isset($userpasssend)) {
	$i = 0;
	include GMO_ROOT.'login/mysqli.php';
	
	while(isset($_POST['new_int'.$i])) {
		$username2 = mysqli_real_escape_string($con, $_POST['username'.$i]);
		$password2 = $_POST['password'.$i];
		$email2 = $_POST['email'.$i];
		if($password2 != "") $password2 = md5($password2);
		$new_int2 = $_POST['new_int'.$i];
		if(isset($_POST['ufaSignMan'.$i])) $new_ufaSignMan = "1";
		else $new_ufaSignMan = "0";
		if(isset($_POST['ufaListMan'.$i])) $new_ufaListMan = "1";
		else $new_ufaListMan = "0";
		if(isset($_POST['tradeMan'.$i])) $new_tradeMan = "1";
		else $new_tradeMan = "0";
		if(isset($_POST['historyTradeMan'.$i])) $new_historyTradeMan = "1";
		else $new_historyTradeMan = "0";
		
		$addSQL = ", `TRADE_MANAGER`='$new_tradeMan', `HISTORY_TRADE_MANAGER`='$new_historyTradeMan', `UFA_SIGN_MANAGER`='$new_ufaSignMan', `UFA_LIST_MANAGER`='$new_ufaListMan', `EMAIL`='$email2'";
		if($password2 != "") $sql = "UPDATE `$db_table` SET `USER`='$username2', `PASS`='$password2'$addSQL WHERE `INT` = '$new_int2'"; 
		else $sql = "UPDATE `$db_table` SET `USER`='$username2'$addSQL WHERE `INT` = '$new_int2'"; 
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		
		$i++;
	}
	mysqli_close($con);
	if($i!=0) $nameSaved = 1;
}

$i = 0;
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `EQUIPESIM`, `USER`, `PASS`, `INT`, `TRADE_MANAGER`, `HISTORY_TRADE_MANAGER`, `UFA_SIGN_MANAGER`, `UFA_LIST_MANAGER`, `EMAIL` FROM `$db_table` WHERE `EQUIPE` != 'ADMIN' ORDER BY `INT` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$bd_equipesim[$i] = $data['EQUIPESIM'];
	$bd_int[$i] = $data['INT'];
	$bd_username[$i] = $data['USER'];
	$bdEmail[$i] = $data['EMAIL'];
	if($data['PASS'] == 'none' || $data['PASS'] == '') $bd_password[$i] = 'No';
	else $bd_password[$i] = 'Yes';
	if($data['UFA_SIGN_MANAGER'] == "0") $ufaSignManager[$i] = '';
	else $ufaSignManager[$i] = ' checked="checked"';
	if($data['UFA_LIST_MANAGER'] == "0") $ufaListManager[$i] = '';
	else $ufaListManager[$i] = ' checked="checked"';
	if($data['TRADE_MANAGER'] == "0") $tradeManager[$i] = '';
	else $tradeManager[$i] = ' checked="checked"';
	if($data['HISTORY_TRADE_MANAGER'] == "0") $historyTradeManager[$i] = '';
	else $historyTradeManager[$i] = ' checked="checked"';
	$i++;
}
mysqli_close($con);

$link = 'admin=userpass';
if(isset($step) && $step == 4) {
	$link = 'admin=first&step='.$step;
}
if(isset($nameSaved) && $nameSaved == 1) {
	$tmpNext = '';
	if(isset($step) && $step == 4) $tmpNext = ' - <a href="?admin=first&step='.$nextStep.'">'.$db_admin_assist_langue[1].'</a>';
	echo '<span style="display:block; font-weight:bold; color:green; padding-top:25px;">'.$db_admin_userpass_langue[12].$tmpNext.'</span>';
}
?>

<script type="text/javascript">
<!--

function toCap(x) {
	x.value = x.value.toUpperCase();
}

function passwordGenerator() {
	var length = 8,
		charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
		retVal = "";
	for (var i = 0, n = charset.length; i < length; ++i) {
		retVal += charset.charAt(Math.floor(Math.random() * n));
	}
	return retVal;
}

function generatePassword(x) {
	if(x == 'all') var elms = document.querySelectorAll("[id^='password']");
	else var elms = document.querySelectorAll("[id='password"+x+"']");
	for(var i = 0; i < elms.length; i++) {
		elms[i].value = passwordGenerator();
	}
}

function sendEmail() {
	var x = document.getElementById("email").value;
	x = encodeURIComponent(x);
	
	var elmsPassword = document.querySelectorAll("[id^='password']");
	var elmsUsername = document.querySelectorAll("[id^='username']");
	var userPassSend = "";
	for(var i = 0; i < elmsPassword.length; i++) {
		if(elmsPassword[i].value != "") userPassSend += "\n" + elmsUsername[i].value + "\n" + elmsPassword[i].value + "\n";
	}
	if(userPassSend == "") {
		alert('Create a new password before you send your message!');
		return;
	}
	userPassSend = encodeURIComponent(userPassSend);
	
	if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
	else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var response = xmlhttp.responseText.trim();
			if(response == 'OK') alert('Email sent! Don\'t forget to save your modification.');
			else alert(response);
		}
	}

var parameters="email="+x+"&userPass="+userPassSend;
xmlhttp.open("POST", "<?php echo BASE_URL?>gmo/admin/userpass2.php", true)
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
xmlhttp.send(parameters)
}

//-->
</script>

<?php error_log('LINK IS :'.$link,0); ?>

<form method="post" action="<?php echo BASE_URL?>MyCehl.php?<?php echo $link; ?>#Admin">
<br><b><?php echo $db_admin_userpass_langue[0]; ?></b><br><?php echo $db_admin_userpass_langue[1]; ?><br><?php echo $db_admin_userpass_langue[18]; ?><br>
<br><input class="button" onclick="generatePassword('all');" type="button" value="<?php echo $db_admin_userpass_langue[9]; ?>"><br>
<table style="margin-top:25px;">
<tr>
<td><?php echo $db_admin_userpass_langue[2]; ?></td>
<td><?php echo $db_admin_userpass_langue[3]; ?></td>
<td><?php echo $db_admin_userpass_langue[4]; ?></td>
<td><?php echo $db_admin_userpass_langue[8]; ?></td>
<td><?php echo $db_admin_userpass_langue[7]; ?></td>
<td><?php echo $db_admin_userpass_langue[13]; ?></td>
<td><?php echo $db_admin_userpass_langue[15]; ?></td>
<td><?php echo $db_admin_userpass_langue[14]; ?></td>
<td><?php echo $db_admin_userpass_langue[16]; ?></td>
<td><?php echo $db_admin_userpass_langue[17]; ?></td>
</tr>
<?php

for($i=0;$i<count($bd_int);$i++){
	echo '<tr>
	<td>'.$bd_equipesim[$i].'</td>
	<td><input class="inputText" onkeyup="javascript:toCap(this);" type="text" id="username'.$i.'" name="username'.$i.'" size="15" value="'.$bd_username[$i].'" required></td>
	<td><input class="inputText" type="text" id="password'.$i.'" name="password'.$i.'" size="15"><input type="hidden" value="'.$bd_int[$i].'" name="new_int'.$i.'"></td>
	<td><input class="button" onclick="generatePassword(\''.$i.'\');" type="button" value="'.$db_admin_userpass_langue[8].'"></td>
	<td>'.$bd_password[$i].'</td>
	<td><input type="checkbox" name="ufaSignMan'.$i.'"'.$ufaSignManager[$i].'></td>
	<td><input type="checkbox" name="ufaListMan'.$i.'"'.$ufaListManager[$i].'></td>
	<td><input type="checkbox" name="tradeMan'.$i.'"'.$tradeManager[$i].'></td>
	<td><input type="checkbox" name="historyTradeMan'.$i.'"'.$historyTradeManager[$i].'></td>
	<td><input class="inputText" type="text" name="email'.$i.'" value="'.$bdEmail[$i].'"></td>
	</tr>';
}

?>
</table>
<br><?php echo $db_admin_userpass_langue[11]; ?><br>
<input class="inputText" type="email" id="email" value="" style="width:200px;"><input class="button" style="width:100px;" onclick="sendEmail();" type="button" value="<?php echo $db_admin_userpass_langue[10]; ?>" name="userpasssend">
<br><br>
<input class="button" type="submit" value="<?php echo $db_admin_all_langue[1]; ?>" name="userpasssend">

</form>