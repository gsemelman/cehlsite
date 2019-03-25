<script type="text/javascript" language="JavaScript">
<!--

function ufaNTCSelect() {
	document.getElementById('divNTC').style.display = "none";
	document.getElementById('divNTC2').style.display = "none";
	var id = document.getElementById('PLAYER').value;
	if(id == 'none') {
		return;
	}
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
			var data = JSON.parse(response);
			
			if(data.ntc == '1') document.getElementById('checkboxNTC').checked = true;
			else document.getElementById('checkboxNTC').checked = false;
			if(data.ntcDisabled == '1') document.getElementById('checkboxDisabled').checked = true;
			else document.getElementById('checkboxDisabled').checked = false;
			
			// Split protected team list
			var dbTeamList = data.ntcTeam.split(",");
			
			// Getting all teams checkboxes
			var checkboxTeamList = document.querySelectorAll('*[id^="teamNTC"]');
			
			// Uncheck all checkboxes
			for(var i=0;i<checkboxTeamList.length;i++) {
				document.getElementById(checkboxTeamList[i].id).checked = false;
			}
			
			// Check if the same team (checkbox vs database)
			for(var j=0;j<dbTeamList.length;j++) {
				for(var i=0;i<checkboxTeamList.length;i++) {
					if(checkboxTeamList[i].value == dbTeamList[j]) {
						document.getElementById(checkboxTeamList[i].id).checked = true;
						break;
					}
				}
			}
			document.body.style.cursor = "default";
			document.getElementById('divNTC').style.display = "inline";
			document.getElementById('divNTC2').style.display = "inline";
		}
	}
	var page = 'admin/ufa_ntc_select.php';
	var parameters = "";
	parameters += "id=" + encodeURIComponent(id);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function ufaNTCChange() {
	var NTC = 0;
	if(document.getElementById('checkboxNTC').checked == false) NTC = 0;
	else NTC = 1;
	var id = document.getElementById('PLAYER').value;
	document.getElementById('divNTC').style.display = "none";
	document.getElementById('divNTC2').style.display = "none";
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
			document.getElementById('divNTC').style.display = "inline";
			document.getElementById('divNTC2').style.display = "inline";
		}
	}
	var page = 'admin/ufa_ntc_change.php';
	var parameters = "";
	parameters += "id=" + encodeURIComponent(id);
	parameters += "&ntc=" + encodeURIComponent(NTC);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function ufaNTCTeamChange(number) {
	var NTC = 0;
	if(document.getElementById('teamNTC'+number).checked == false) NTC = 0;
	else NTC = 1;
	var team = document.getElementById('teamNTC'+number).value;
	var id = document.getElementById('PLAYER').value;
	//document.getElementById('divNTC').style.display = "none";
	//document.getElementById('divNTC2').style.display = "none";
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
			document.getElementById("teamNTC"+number).selectedIndex = "0";
			document.body.style.cursor = "default";
			if(response != 'done') alert(response);
			//document.getElementById('divNTC').style.display = "inline";
			//document.getElementById('divNTC2').style.display = "inline";
		}
	}
	var page = 'admin/ufa_ntc_changeTeam.php';
	var parameters = "";
	parameters += "id=" + encodeURIComponent(id);
	parameters += "&ntc=" + encodeURIComponent(NTC);
	parameters += "&team=" + encodeURIComponent(team);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function ufaDisabledChange() {
	var NTC = 0;
	if(document.getElementById('checkboxDisabled').checked == false) NTC = 0;
	else NTC = 1;
	var id = document.getElementById('PLAYER').value;
	document.getElementById('divNTC').style.display = "none";
	document.getElementById('divNTC2').style.display = "none";
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
			document.getElementById('divNTC').style.display = "inline";
			document.getElementById('divNTC2').style.display = "inline";
		}
	}
	var page = 'admin/ufa_ntc_changeDisabled.php';
	var parameters = "";
	parameters += "id=" + encodeURIComponent(id);
	parameters += "&ntc=" + encodeURIComponent(NTC);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function ufaDisableAll(NTC) {
	// NTC : 0 - Enabled
	// NTC : 1 - Disabled
	document.getElementById('divNTC').style.display = "none";
	document.getElementById('divNTC2').style.display = "none";
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
			document.getElementById("PLAYER").selectedIndex = "0";
			document.body.style.cursor = "default";
			if(response != 'done') alert(response);
		}
	}
	var page = 'admin/ufa_ntc_changeDisabledAll.php';
	var parameters = "";
	parameters += "ntc=" + encodeURIComponent(NTC);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function ufaProtectAll(protect) {
	// protect : 0 - Disabled
	// protect : 1 - Enabled
	document.getElementById('divNTC').style.display = "none";
	document.getElementById('divNTC2').style.display = "none";
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
			document.getElementById("PLAYER").selectedIndex = "0";
			document.body.style.cursor = "default";
			if(response != 'done') alert(response);
		}
	}
	var page = 'admin/ufa_ntc_changeProtectedAll.php';
	var parameters = "";
	parameters += "protect=" + encodeURIComponent(protect);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

//-->
</script>