<?php
include 'config.php';
include 'lang.php';
?>
<script type="text/javascript">
<!--

function chatBox(x) {
	if(x == 'write' && document.getElementById("chatBoxName").value == '') {
		document.getElementById("chatBoxName").focus();
		document.getElementById("chatBox").innerHTML += "Enter your name...<br>";
		document.getElementById("chatBox").scrollTop = document.getElementById("chatBox").scrollHeight;
		return;
	}
	if(x == 'write' && document.getElementById("chatBoxText").value == '') {
		document.getElementById("chatBoxText").focus();
		document.getElementById("chatBox").innerHTML += "Enter your message...<br>";
		document.getElementById("chatBox").scrollTop = document.getElementById("chatBox").scrollHeight;
		return;
	}
	
	if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
	else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var response = xmlhttp.responseText;
			if(x == 'write') {
				document.getElementById("chatBox").innerHTML += response;
				document.getElementById("chatBoxText").value = '';
				document.getElementById("chatBoxText").focus();
				document.getElementById("chatBox").scrollTop = document.getElementById("chatBox").scrollHeight;
			}
			if(x == 'read') {
				if(document.getElementById("chatBox").innerHTML != response) {
					document.getElementById("chatBox").innerHTML = response;
					document.getElementById("chatBox").scrollTop = document.getElementById("chatBox").scrollHeight;
				}
			}
		}
	}
var parameters="s="+x;
if(x == 'write') parameters += "&write="+document.getElementById("chatBoxText").value+"&name="+document.getElementById("chatBoxName").value;
xmlhttp.open("POST", "ChatBox2.php", true)
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
xmlhttp.send(parameters)
}

function chatBoxTimeOut() {
	setTimeout(function(){ 
		chatBox('read');
		chatBoxTimeOut();
	}, 2000);
}

function chatBoxStart() {
	document.getElementById("chatBoxName").focus();
}

//-->
</script>

<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border:solid 1px <?php echo $couleur_contour; ?>">
<div class="titre"><span class="bold-blanc"><?php echo $langChatBoxTitle; ?></span></div>

<div style="width:100%; height:200px; overflow-y:scroll;" id="chatBox"></div>
<input id="chatBoxName" type="text" placeholder="Enter a name" style="width:100px;"><input id="chatBoxText" type="text" placeholder="Enter your message" style="width:400px;">

</div>

<script type="text/javascript">
<!--

document.getElementById("chatBoxText").addEventListener("keyup", function(event){
	if(event.which == 13) {
		chatBox('write');
	}
});

document.getElementById("chatBoxName").addEventListener("keyup", function(event){
	if(event.which == 13) {
		chatBox('write');
	}
});



document.addEventListener('DOMContentLoaded', chatBox('read'), false);
document.addEventListener('DOMContentLoaded', chatBoxTimeOut(), false);
document.addEventListener('DOMContentLoaded', chatBoxStart(), false);

//-->
</script>