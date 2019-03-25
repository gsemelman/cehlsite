<script type="text/javascript" language="JavaScript">
<!--

function deleteTrade(id) {
	document.body.style.cursor = "wait";
	
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var response = xmlhttp.responseText;
			document.body.style.cursor = "default";
			if(response == "done") alert("<?php echo $db_admin_trade[15]; ?>");
			else alert('Error! ' + response);
			location.reload();
		}
	}
	var page = 'admin/trade_deleted.php';
	var parameters = "";
	parameters += "id=" + encodeURIComponent(id);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function acceptedTrade(id) {
	document.body.style.cursor = "wait";
	
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var response = xmlhttp.responseText;
			document.body.style.cursor = "default";
			if(response == "done") alert("<?php echo $db_admin_trade[14]; ?>");
			else alert('Error! ' + response);
			location.reload();
		}
	}
	var page = 'admin/trade_accepted.php';
	var parameters = "";
	parameters += "id=" + encodeURIComponent(id);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

//-->
</script>