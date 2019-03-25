<script type="text/javascript" language="JavaScript">
<!--

function declineAll() {
	var playerID = document.getElementById('playerID').value;
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
			document.getElementById('playerBox').style.display = "none";
			document.body.style.cursor = "default";
			alert(document.getElementById('showPlayerName').textContent+": <?php echo $db_admin_ufaSign[17]; ?>");
			location.reload();
		}
	}
	var page = 'admin/ufaSign_decline.php';
	var parameters = "";
	parameters += "playerID=" + encodeURIComponent(playerID);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function signPlayer(signID,i) {
	var playerID = document.getElementById('playerID').value;
	var contract = document.getElementById('contract'+i).value;
	var salary = document.getElementById('salary'+i).value;
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
			document.getElementById('playerBox').style.display = "none";
			document.body.style.cursor = "default";
			alert(document.getElementById('showPlayerName').textContent+" <?php echo $db_admin_ufaSign[16]; ?> "+response);
			location.reload();
		}
	}
	var page = 'admin/ufaSign_player.php';
	var parameters = "";
	parameters += "signID=" + encodeURIComponent(signID);
	parameters += "&playerID=" + encodeURIComponent(playerID);
	parameters += "&contract=" + encodeURIComponent(contract);
	parameters += "&salary=" + encodeURIComponent(salary);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function counterSave() {
	var counterID = document.getElementById('counterID').value;
	var contract = document.getElementById('counterPlayerContract').value;
	var salary = document.getElementById('counterPlayerSalary').value;
	var other = document.getElementById('counterPlayerOther').value;
	
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
			if(response == "") { 
				document.body.style.cursor = "default";
				alert("<?php echo $db_admin_ufaSign[27]; ?> "+document.getElementById('counterPlayerTeam').textContent+" ("+document.getElementById('showPlayerName').textContent+")");
				document.getElementById('counterPlayerBox').style.display = "none";
			}
			else alert(response);
		}
	}
	var page = 'admin/ufaSign_counter.php';
	var parameters = "";
	parameters += "counterID=" + encodeURIComponent(counterID);
	parameters += "&contract=" + encodeURIComponent(contract);
	parameters += "&salary=" + encodeURIComponent(salary);
	parameters += "&other=" + encodeURIComponent(other);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function counterViewTeamPlayer(signID) {
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
			var jsonData = JSON.parse(response);
			var signTM = jsonData.tm;
			var signCT = jsonData.ct;
			var signSL = jsonData.sl;
			var signOT = jsonData.ot;
			var signOFCT = jsonData.ofct;
			var signOFSL = jsonData.ofsl;
			var signOFOT = jsonData.ofot;
			var signOFOF = jsonData.ofof; // 0: No CounterOffer | 1: CounterOffer done but not view by GM | 2: CounterOffer done and GM view it | 3: GM responded to the CounterOffer
			
			document.getElementById('counterID').value = signID;
			
			if(signOFOF == "0") {
				document.getElementById('counterPlayerContract').value = signCT;
				document.getElementById('counterPlayerSalary').value = signSL;
				document.getElementById('counterPlayerOther').value = "";
			}
			else {
				document.getElementById('counterPlayerContract').value = signOFCT;
				document.getElementById('counterPlayerSalary').value = signOFSL;
				document.getElementById('counterPlayerOther').value = signOFOT;
			}
			
			if(signOFOF == "0") document.getElementById('counterStatus').textContent = "<?php echo $db_admin_ufaSign[28]; ?>";
			if(signOFOF == "1") document.getElementById('counterStatus').textContent = "<?php echo $db_admin_ufaSign[29]; ?>";
			if(signOFOF == "2") document.getElementById('counterStatus').textContent = "<?php echo $db_admin_ufaSign[30]; ?>";
			
			document.getElementById('counterPlayerBox').style.display = "block";
			document.body.style.cursor = "default";
			document.getElementById('counterPlayerTeam').textContent = signTM;
		}
	}
	var page = 'admin/ufaSign_viewTeamPlayer.php';
	var parameters = "";
	parameters += "signID=" + encodeURIComponent(signID);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function viewPlayer(id,nameid,prevSalary) {
	document.getElementById('playerBox').style.display = "none";
	document.getElementById('counterPlayerBox').style.display = "none";
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
			var jsonData = JSON.parse(response);
			
			document.getElementById('showPlayerName').textContent = document.getElementById('playerName'+nameid).textContent;
			document.getElementById('playerID').value = id;
			
			document.getElementById("tbodyStats").innerHTML = "";
			var tbody = document.getElementById("tbodyStats");
			var tr = document.createElement('tr');
			tr.setAttribute("class", 'tr_content1');
			// PS
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.posi));
			tr.appendChild(td);
			// NB
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.numb));
			tr.appendChild(td);
			// HD
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.hand));
			tr.appendChild(td);
			// HT
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.heig));
			tr.appendChild(td);
			// WT
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.weig));
			tr.appendChild(td);
			// AG
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.ages));
			tr.appendChild(td);
			// CD
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.cond));
			tr.appendChild(td);
			// IN
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.inte));
			tr.appendChild(td);
			// SP
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.spee));
			tr.appendChild(td);
			// ST
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.stre));
			tr.appendChild(td);
			// EN
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.endu));
			tr.appendChild(td);
			// DU
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.dura));
			tr.appendChild(td);
			// DI
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.disc));
			tr.appendChild(td);
			// SK
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.skat));
			tr.appendChild(td);
			// PA
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.pass));
			tr.appendChild(td);
			// PK
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.pkct));
			tr.appendChild(td);
			// DF
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.defs));
			tr.appendChild(td);
			// OF
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.offs));
			tr.appendChild(td);
			// EX
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.expe));
			tr.appendChild(td);
			// LD
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.lead));
			tr.appendChild(td);
			// OV
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.over));
			tr.appendChild(td);
			// SL
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.sala));
			tr.appendChild(td);
			// BP
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.birt));
			tr.appendChild(td);
			// LAST TEAM
			var td = document.createElement('td');
				td.appendChild(document.createTextNode(jsonData.last));
			tr.appendChild(td);
			tbody.appendChild(tr);
			
			document.getElementById("tbody").innerHTML = "";
			var tbody = document.getElementById("tbody");
			for(var i=0;i<jsonData.id.length;i++) {
				var color = '1';
				if(i & 1) color = '2';
				var tr = document.createElement('tr');
				tr.setAttribute("class", 'tr_content'+color);
					// TM
					var td = document.createElement('td');
						td.appendChild(document.createTextNode(jsonData.tm[i]));
					tr.appendChild(td);
					// CT
					var td = document.createElement('td');
						var x = document.createElement("input");
							x.setAttribute("class", "inputText");
							x.setAttribute("type", "number");
							x.setAttribute("id", "contract"+i);
							x.setAttribute("style", "width:50px;");
							x.setAttribute("value", jsonData.ct[i]);
						td.appendChild(x);
					tr.appendChild(td);
					// SL
					var td = document.createElement('td');
						var x = document.createElement("input");
							x.setAttribute("class", "inputText");
							x.setAttribute("type", "number");
							x.setAttribute("id", "salary"+i);
							x.setAttribute("style", "width:100px;");
							x.setAttribute("value", jsonData.sl[i]);
						td.appendChild(x);
					tr.appendChild(td);
					// OT
					var td = document.createElement('td');
						td.appendChild(document.createTextNode(jsonData.ot[i]));
					tr.appendChild(td);
					// DATE
					var td = document.createElement('td');
						td.appendChild(document.createTextNode(jsonData.dt[i]));
					tr.appendChild(td);
					// SIGN WITH
					var td = document.createElement('td');
						var x = document.createElement("input");
						x.setAttribute("class", "button");
						x.setAttribute("type", "button");
						x.setAttribute("style", "width:115px;");
						x.setAttribute("value", "<?php echo $db_admin_ufaSign[11]; ?>");
						x.setAttribute("onclick", "signPlayer('"+jsonData.id[i]+"','"+i+"')");
						td.appendChild(x);
						var x = document.createElement("input");
						x.setAttribute("type", "hidden");
						x.setAttribute("id", "signID"+i);
						x.setAttribute("value", jsonData.id[i]);
						td.appendChild(x);
					tr.appendChild(td);
					// COUNTER OFFER
					var td = document.createElement('td');
						if(jsonData.ofof[i] != "3") {
							var x = document.createElement("input");
							x.setAttribute("class", "button");
							x.setAttribute("type", "button");
							x.setAttribute("style", "width:115px;");
							x.setAttribute("value", "<?php echo $db_admin_ufaSign[23]; ?>");
							x.setAttribute("onclick", "counterViewTeamPlayer('"+jsonData.id[i]+"')");
							td.appendChild(x);
						}
						else {
							td.appendChild(document.createTextNode("<?php echo $db_admin_ufaSign[32]; ?>"));
						}
					tr.appendChild(td);
				
				tbody.appendChild(tr);
			}
			
			document.getElementById('playerBox').style.display = "inline";
			document.body.style.cursor = "default";
			//console.log(jsonData.id);
			
		}
	}
	var page = 'admin/ufaSign_view.php';
	var parameters = "";
	parameters += "id=" + encodeURIComponent(id);
	
	xmlhttp.open("POST", page, true)
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(parameters)
}

function hidePlayer() {
	document.getElementById('playerBox').style.display = "none";
	document.getElementById('counterPlayerBox').style.display = "none";
}
function hideCounter() {
	document.getElementById('counterPlayerBox').style.display = "none";
}

//-->
</script>