<script type="text/javascript" language="JavaScript">
<!--

function tradeManDelete(id) {
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
			if(response != 'done') alert(response);
			else {
				var i = document.getElementById("tr"+id).rowIndex;
				document.getElementById("tradeTable").deleteRow(i);
			}
		}
	}
	var page = 'admin/tradeMan_del.php';
	var parameters = "";
	parameters += "id=" + encodeURIComponent(id);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

//-->
</script>