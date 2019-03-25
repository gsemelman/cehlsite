<?php
//extract($_POST,EXTR_OVERWRITE);

// Green : #4caf50 | Red : #ae654c
$good = "#4caf50";
$bad = "#ae654c";

$name_lines = $teamFHLSimName.'.lns';
$server_file = $file_folder_lines.$name_lines;

// Search for .LNS on the server
$fileShow1 = "none";
$fileShow2 = "none";
if( is_readable($server_file) ) {
	$fileShow1 = "inline";
}
else {
	$fileShow2 = "inline";
}
$fileText1 = $db_membre_send_langue[11].'<br><br>'.$db_membre_send_langue[16].'<a href="'.$server_file.'">'.$name_lines.'</a><br>';
$fileText2 = $db_membre_send_langue[13].'<br>';
?>

<script type="text/javascript">
<!--

function convert() {
	if(document.getElementById('userLNS').files.length == 0) return;
	var file = document.getElementById('userLNS').files[0];
	var fileBlob = new Blob([file]);
	if(file.name != "<?php echo $teamFHLSimName; ?>.lns") {
		popupAlert("<?php echo $db_membre_send_langue[2].' '.$teamFHLSimName; ?>", "<?php echo $bad; ?>");
		return;
	}
	var fr = new FileReader();
	fr.addEventListener('load', function () {
		var u = new Uint8Array(this.result),
			a = new Array(u.length),
			i = u.length;
		if(i > 226) {
			popupAlert("<?php echo $db_membre_send_langue[0]; ?>", "<?php echo $bad; ?>");
			return;
		}
		if(i < 226) {
			popupAlert("<?php echo $db_membre_send_langue[1]; ?>", "<?php echo $bad; ?>");
			return;
		}
		while (i--) a[i] = (u[i] < 16 ? '0' : '') + u[i].toString(16);
		u = null;
		send(a);
	});
	fr.readAsArrayBuffer(fileBlob);
}
  
function send(ArrLNS_File) {
	var LNS_File = ArrLNS_File.join("");
	document.body.style.cursor = "wait";

	if (window.XMLHttpRequest) var xmlhttp = new XMLHttpRequest();
	else var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var response = xmlhttp.responseText;
			document.body.style.cursor = "default";
			if(response != "") {
				popupAlert(response, "<?php echo $bad; ?>");
				return;
			}
			else {
				popupAlert("<?php echo $db_membre_send_langue[7]; ?>", "<?php echo $good; ?>");
				document.getElementById('fileFound1').style.display = "inline";
				document.getElementById('fileFound2').style.display = "none";
				return;
			}
		}
	}
	
	var parameters = "LNS_File="+LNS_File;
	xmlhttp.open("POST", "membre/sendUpload.php");
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(parameters);
}

//-->
</script>

<b><?php echo $db_membre_send_langue[14]; ?></b><br>
<span id="fileFound1" style="display:<?php echo $fileShow1; ?>;"><?php echo $fileText1; ?></span>
<span id="fileFound2" style="display:<?php echo $fileShow2; ?>;"><?php echo $fileText2; ?></span>
<br><?php echo $db_membre_send_langue[15]; ?><br>
<br><input class="button" type="file" name="userLNS" id="userLNS" accept=".lns" required>

<script type="text/javascript">
<!--

document.getElementById('userLNS').addEventListener("change", convert);

//-->
</script>