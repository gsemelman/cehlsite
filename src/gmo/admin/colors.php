<script type="text/javascript">
<!--

function start() {
	document.getElementById("demoGeneral").style.color = document.getElementById("colorMainText").value;
	document.getElementById("demoGeneral").style.backgroundColor = document.getElementById("colorMainBackground").value;
	document.getElementById("demoMenu1").style.color = document.getElementById("colorMenuText").value;
	document.getElementById("demoMenu1").style.backgroundColor = document.getElementById("colorMenuBackground").value;
	document.getElementById("demoMenu2").style.color = document.getElementById("colorMenuTextHover").value;
	document.getElementById("demoMenu2").style.backgroundColor = document.getElementById("colorMenuBackgroundHover").value;
	document.getElementById("demoMenu3").style.color = document.getElementById("colorMenuTextActive").value;
	document.getElementById("demoMenu3").style.backgroundColor = document.getElementById("colorMenuBackgroundActive").value;
	document.getElementById("demoTable1").style.color = document.getElementById("colorTableText1").value;
	document.getElementById("demoTable1").style.backgroundColor = document.getElementById("colorTableBackground1").value;
	document.getElementById("demoTable2").style.color = document.getElementById("colorTableText2").value;
	document.getElementById("demoTable2").style.backgroundColor = document.getElementById("colorTableBackground2").value;
	document.getElementById("demoTable3").style.color = document.getElementById("colorTableHeaderText").value;
	document.getElementById("demoTable3").style.backgroundColor = document.getElementById("colorTableHeaderBackground").value;
	document.getElementById("demoTable4").style.color = document.getElementById("colorTableTextHover").value;
	document.getElementById("demoTable4").style.backgroundColor = document.getElementById("colorTableBackgroundHover").value;
	document.getElementById("demoTable1").style.borderColor = document.getElementById("colorTableBorder").value;
	document.getElementById("demoTable2").style.borderColor = document.getElementById("colorTableBorder").value;
	document.getElementById("demoTable3").style.borderColor = document.getElementById("colorTableBorder").value;
	document.getElementById("demoTable4").style.borderColor = document.getElementById("colorTableBorder").value;
	document.getElementById("demoInput1").style.color = document.getElementById("colorInputText").value;
	document.getElementById("demoInput1").style.backgroundColor = document.getElementById("colorInputBackground").value;
	document.getElementById("demoInput1").style.borderColor = document.getElementById("colorInputBorder").value;
	document.getElementById("demoInput2").style.color = document.getElementById("colorInputText").value;
	document.getElementById("demoInput2").style.backgroundColor = document.getElementById("colorInputBackground").value;
	document.getElementById("demoInput2").style.borderColor = document.getElementById("colorInputBorderHover").value;
	document.getElementById("demoButton1").style.color = document.getElementById("colorButtonText").value;
	document.getElementById("demoButton1").style.backgroundColor = document.getElementById("colorButtonBackground").value;
	document.getElementById("demoButton1").style.borderColor = document.getElementById("colorButtonBorder").value;
	document.getElementById("demoButton2").style.color = document.getElementById("colorButtonText").value;
	document.getElementById("demoButton2").style.backgroundColor = document.getElementById("colorButtonBackground").value;
	document.getElementById("demoButton2").style.borderColor = document.getElementById("colorButtonBorderHover").value;
	document.getElementById("demoLink1").style.color = document.getElementById("colorAText").value;
	document.getElementById("demoLink2").style.color = document.getElementById("colorATextHover").value;
	document.getElementById("demoTooltip").style.color = document.getElementById("colorTooltipText").value;
	document.getElementById("demoTooltip").style.backgroundColor = document.getElementById("colorTooltipBackground").value;
	document.getElementById("demoTooltip").style.borderColor = document.getElementById("colorTooltipBorder").value;
	document.getElementById("demoDivActive").style.color = document.getElementById("colorDivTextActive").value;
	document.getElementById("demoDivActive").style.backgroundColor = document.getElementById("colorDivBackgroundActive").value;
}

function saveColors() {
	var colorInputs = document.querySelectorAll("[id^=color]");
	var colorsID = [];
	var colorsValue = [];
	for(var x=0;x<colorInputs.length;x++) {
		colorsID[x] = colorInputs[x].id;
		colorsValue[x] = colorInputs[x].value.substr(1);
	}
	var strID = JSON.stringify(colorsID);
	var strValue = JSON.stringify(colorsValue);
	
	document.body.style.cursor = "wait";

	if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
	else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var response = xmlhttp.responseText;
			document.body.style.cursor = "default";
			popupAlert("<?php echo $db_admin_all_langue[2]; ?>", "#4caf50");
		}
	}
var parameters="ID="+strID+"&VALUE="+strValue;
xmlhttp.open("POST", "<?php echo BASE_URL?>gmo/admin/colorsSave.php", true)
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
xmlhttp.send(parameters)
}

function selectColors(i) {
	// Dark Blue
	if(i == 0) {
		var colorMainText = "#FFFFFF";
		var colorMainBackground = "#000000";
		var colorMenuText = "#FFFFFF";
		var colorMenuBackground = "#004D99";
		var colorMenuTextHover = "#000000";
		var colorMenuBackgroundHover = "#AAAAAA";
		var colorMenuTextActive = "#000000";
		var colorMenuBackgroundActive = "#B3D9FF";
		var colorTableText1 = "#FFFFFF";
		var colorTableBackground1 = "#004D99";
		var colorTableText2 = "#FFFFFF";
		var colorTableBackground2 = "#003366";
		var colorTableHeaderText = "#FFFFFF";
		var colorTableHeaderBackground = "#0080FF";
		var colorTableTextHover = "#000000";
		var colorTableBackgroundHover = "#99CCFF";
		var colorInputText = "#000000";
		var colorInputBackground = "#FFFFFF";
		var colorInputBorder = "#0080FF";
		var colorInputBorderHover = "#B3D9FF";
		var colorButtonText = "#FFFFFF";
		var colorButtonBackground = "#0080FF";
		var colorButtonBorder = "#0080FF";
		var colorButtonBorderHover = "#B3D9FF";
		var colorAText = "#FFFFFF";
		var colorATextHover = "#B3D9FF";
		var colorTooltipText = "#FFFFFF";
		var colorTooltipBackground = "#0080FF";
		var colorTooltipBorder = "#B3D9FF";
		var colorTableBorder = "#555555";
		var colorDivTextActive = "#FFFFFF";
		var colorDivBackgroundActive = "#0080FF";
	}
	// Light Blue
	if(i == 1) {
		var colorMainText = "#000000";
		var colorMainBackground = "#FFFFFF";
		var colorMenuText = "#FFFFFF";
		var colorMenuBackground = "#0065CA";
		var colorMenuTextHover = "#000000";
		var colorMenuBackgroundHover = "#AAAAAA";
		var colorMenuTextActive = "#000000";
		var colorMenuBackgroundActive = "#B3D9FF";
		var colorTableText1 = "#000000";
		var colorTableBackground1 = "#E1F0FF";
		var colorTableText2 = "#000000";
		var colorTableBackground2 = "#BBDDFF";
		var colorTableHeaderText = "#FFFFFF";
		var colorTableHeaderBackground = "#0080FF";
		var colorTableTextHover = "#FFFFFF";
		var colorTableBackgroundHover = "#0065CA";
		var colorInputText = "#000000";
		var colorInputBackground = "#FFFFFF";
		var colorInputBorder = "#0080FF";
		var colorInputBorderHover = "#82C0FF";
		var colorButtonText = "#FFFFFF";
		var colorButtonBackground = "#0080FF";
		var colorButtonBorder = "#0080FF";
		var colorButtonBorderHover = "#0065CA";
		var colorAText = "#000000";
		var colorATextHover = "#0065CA";
		var colorTooltipText = "#FFFFFF";
		var colorTooltipBackground = "#0080FF";
		var colorTooltipBorder = "#82C0FF";
		var colorTableBorder = "#555555";
		var colorDivTextActive = "#FFFFFF";
		var colorDivBackgroundActive = "#0080FF";
	}
	if(i == 2) {
		var colorMainText = "#000000";
		var colorMainBackground = "#FFFFFF";
		var colorMenuText = "#000000";
		var colorMenuBackground = "#F0F0F0";
		var colorMenuTextHover = "#FFFFFF";
		var colorMenuBackgroundHover = "#555555";
		var colorMenuTextActive = "#FFFFFF";
		var colorMenuBackgroundActive = "#4CAF50";
		var colorTableText1 = "#000000";
		var colorTableBackground1 = "#FFFFFF";
		var colorTableText2 = "#000000";
		var colorTableBackground2 = "#EEEEEE";
		var colorTableHeaderText = "#FFFFFF";
		var colorTableHeaderBackground = "#4BAF50";
		var colorTableTextHover = "#000000";
		var colorTableBackgroundHover = "#FFC741";
		var colorInputText = "#000000";
		var colorInputBackground = "#FFFFFF";
		var colorInputBorder = "#4CAF50";
		var colorInputBorderHover = "#3E8E41";
		var colorButtonText = "#FFFFFF";
		var colorButtonBackground = "#4CAF50";
		var colorButtonBorder = "#4CAF50";
		var colorButtonBorderHover = "#3E8E41";
		var colorAText = "#000000";
		var colorATextHover = "#4CAF50";
		var colorTooltipText = "#FFFFFF";
		var colorTooltipBackground = "#4CAF50";
		var colorTooltipBorder = "#3E8E41";
		var colorTableBorder = "#000000";
		var colorDivTextActive = "#FFFFFF";
		var colorDivBackgroundActive = "#4CAF50";
	}
	document.getElementById("colorMainText").value = colorMainText;
	document.getElementById("colorMainBackground").value = colorMainBackground;
	document.getElementById("colorMenuText").value = colorMenuText;
	document.getElementById("colorMenuBackground").value = colorMenuBackground;
	document.getElementById("colorMenuTextHover").value = colorMenuTextHover;
	document.getElementById("colorMenuBackgroundHover").value = colorMenuBackgroundHover;
	document.getElementById("colorMenuTextActive").value = colorMenuTextActive;
	document.getElementById("colorMenuBackgroundActive").value = colorMenuBackgroundActive;
	document.getElementById("colorTableText1").value = colorTableText1;
	document.getElementById("colorTableBackground1").value = colorTableBackground1;
	document.getElementById("colorTableText2").value = colorTableText2;
	document.getElementById("colorTableBackground2").value = colorTableBackground2;
	document.getElementById("colorTableHeaderText").value = colorTableHeaderText;
	document.getElementById("colorTableHeaderBackground").value = colorTableHeaderBackground;
	document.getElementById("colorTableTextHover").value = colorTableTextHover;
	document.getElementById("colorTableBackgroundHover").value = colorTableBackgroundHover;
	document.getElementById("colorInputText").value = colorInputText;
	document.getElementById("colorInputBackground").value = colorInputBackground;
	document.getElementById("colorInputBorder").value = colorInputBorder;
	document.getElementById("colorInputBorderHover").value = colorInputBorderHover;
	document.getElementById("colorButtonText").value = colorButtonText;
	document.getElementById("colorButtonBackground").value = colorButtonBackground;
	document.getElementById("colorButtonBorder").value = colorButtonBorder;
	document.getElementById("colorButtonBorderHover").value = colorButtonBorderHover;
	document.getElementById("colorAText").value = colorAText;
	document.getElementById("colorATextHover").value = colorATextHover;
	document.getElementById("colorTooltipText").value = colorTooltipText;
	document.getElementById("colorTooltipBackground").value = colorTooltipBackground;
	document.getElementById("colorTooltipBorder").value = colorTooltipBorder;
	document.getElementById("colorTableBorder").value = colorTableBorder;
	document.getElementById("colorDivTextActive").value = colorDivTextActive;
	document.getElementById("colorDivBackgroundActive").value = colorDivBackgroundActive;
	
	start();
}

//-->
</script>

<span style="display:block; font-weight:bold; padding-top:25px;"><?php echo $db_admin_menu_langue[16]; ?></span>
<?php echo $db_admin_colors[32]; ?>
<table class="table" style="width:400px;">
<tr class="tr"><td><?php echo $db_admin_colors[33]; ?></td><td style="width:75px;"><?php echo $db_admin_colors[34]; ?></td><td style="width:100px;"><?php echo $db_admin_colors[35]; ?></td></tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[0]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorMainText" value="#<?php echo $databaseColors['colorMainText']; ?>"></td>
	<td rowspan="2" id="demoGeneral" style="text-align:center;"><?php echo $db_admin_colors[36]; ?></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[1]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorMainBackground" value="#<?php echo $databaseColors['colorMainBackground']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[2]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorMenuText" value="#<?php echo $databaseColors['colorMenuText']; ?>"></td>
	<td rowspan="6" style="text-align:center; background-color:#<?php echo $databaseColors['colorMainBackground']; ?>">
		<ul style="position:relative; top: 0px; display:block; width:100px;">
			<li><a href="#" id="demoMenu1"><?php echo $db_admin_colors[37]; ?></a></li>
			<li><a href="#" id="demoMenu2"><?php echo $db_admin_colors[46]; ?></a></li>
			<li><a href="#" id="demoMenu3"><?php echo $db_admin_colors[45]; ?></a></li>
		</ul>
	</td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[3]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorMenuBackground" value="#<?php echo $databaseColors['colorMenuBackground']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[4]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorMenuTextHover" value="#<?php echo $databaseColors['colorMenuTextHover']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[5]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorMenuBackgroundHover" value="#<?php echo $databaseColors['colorMenuBackgroundHover']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[6]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorMenuTextActive" value="#<?php echo $databaseColors['colorMenuTextActive']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[7]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorMenuBackgroundActive" value="#<?php echo $databaseColors['colorMenuBackgroundActive']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[8]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTableText1" value="#<?php echo $databaseColors['colorTableText1']; ?>"></td>
	<td rowspan="9" style="text-align:center; background-color:#<?php echo $databaseColors['colorMainBackground']; ?>">
		<table class="table" style="width:100px;">
			<tr><td id="demoTable3"><?php echo $db_admin_colors[47]; ?></td></tr>
			<tr><td id="demoTable1"><?php echo $db_admin_colors[48]; ?> 1</td></tr>
			<tr><td id="demoTable2"><?php echo $db_admin_colors[48]; ?> 2</td></tr>
			<tr><td id="demoTable4"><?php echo $db_admin_colors[46]; ?></td></tr>
		</table>
	</td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[9]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTableBackground1" value="#<?php echo $databaseColors['colorTableBackground1']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[10]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTableText2" value="#<?php echo $databaseColors['colorTableText2']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[11]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTableBackground2" value="#<?php echo $databaseColors['colorTableBackground2']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[12]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTableHeaderText" value="#<?php echo $databaseColors['colorTableHeaderText']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[13]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTableHeaderBackground" value="#<?php echo $databaseColors['colorTableHeaderBackground']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[14]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTableTextHover" value="#<?php echo $databaseColors['colorTableTextHover']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[15]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTableBackgroundHover" value="#<?php echo $databaseColors['colorTableBackgroundHover']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[16]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTableBorder" value="#<?php echo $databaseColors['colorTableBorder']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[17]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorInputText" value="#<?php echo $databaseColors['colorInputText']; ?>"></td>
	<td rowspan="4" style="background-color:#<?php echo $databaseColors['colorMainBackground']; ?>">
		<input id="demoInput1" class="inputText" style="width:100px; text-align:center;" type="text" value="<?php echo $db_admin_colors[39]; ?>"><br><br>
		<input id="demoInput2" class="inputText" style="width:100px; text-align:center;" type="text" value="<?php echo $db_admin_colors[46]; ?>">
	</td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[18]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorInputBackground" value="#<?php echo $databaseColors['colorInputBackground']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[19]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorInputBorder" value="#<?php echo $databaseColors['colorInputBorder']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[20]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorInputBorderHover" value="#<?php echo $databaseColors['colorInputBorderHover']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[21]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorButtonText" value="#<?php echo $databaseColors['colorButtonText']; ?>"></td>
	<td rowspan="4" style="background-color:#<?php echo $databaseColors['colorMainBackground']; ?>">
		<input id="demoButton1" class="button" style="width:100px; text-align:center;" type="button" value="<?php echo $db_admin_colors[40]; ?>"><br><br>
		<input id="demoButton2" class="button" style="width:100px; text-align:center;" type="button" value="<?php echo $db_admin_colors[46]; ?>">
	</td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[22]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorButtonBackground" value="#<?php echo $databaseColors['colorButtonBackground']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[23]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorButtonBorder" value="#<?php echo $databaseColors['colorButtonBorder']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[24]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorButtonBorderHover" value="#<?php echo $databaseColors['colorButtonBorderHover']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[25]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorAText" value="#<?php echo $databaseColors['colorAText']; ?>"></td>
	<td id="demoLink1" style="text-align:center; background-color:#<?php echo $databaseColors['colorMainBackground']; ?>"><?php echo $db_admin_colors[41]; ?></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[26]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorATextHover" value="#<?php echo $databaseColors['colorATextHover']; ?>"></td>
	<td id="demoLink2" style="text-align:center; background-color:#<?php echo $databaseColors['colorMainBackground']; ?>"><?php echo $db_admin_colors[41]; ?></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[27]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTooltipText" value="#<?php echo $databaseColors['colorTooltipText']; ?>"></td>
	<td rowspan="3" style="text-align:center; background-color:#<?php echo $databaseColors['colorMainBackground']; ?>">
	<a class="tooltip" href="#"><?php echo $db_admin_colors[42]; ?><span class="tooltiptext" id="demoTooltip"><?php echo $db_admin_colors[42]; ?></span></a>
	</td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[28]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTooltipBackground" value="#<?php echo $databaseColors['colorTooltipBackground']; ?>"></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[29]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorTooltipBorder" value="#<?php echo $databaseColors['colorTooltipBorder']; ?>"></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_admin_colors[30]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorDivTextActive" value="#<?php echo $databaseColors['colorDivTextActive']; ?>"></td>
	<td rowspan="2" style="text-align:center; background-color:#<?php echo $databaseColors['colorMainBackground']; ?>">
		<input id="demoDivActive" class="lines" style="width:100px;" type="text" value="<?php echo $db_admin_colors[43]; ?>">
	</td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_admin_colors[31]; ?></td>
	<td><input oninput="javascript:start();" style="width:75px;" type="color" id="colorDivBackgroundActive" value="#<?php echo $databaseColors['colorDivBackgroundActive']; ?>"></td>
</tr>

<tr><td colspan="3"><input onclick="javascript:saveColors();" class="button" type="button" value="<?php echo $db_admin_all_langue[1]; ?>"></td></tr>
</table>
<br>
<input onclick="javascript:selectColors('2');" style="width:100px; background-color:#4caf50; color:#ffffff;" class="button" type="button" value="<?php echo $db_admin_colors[50]; ?>">
<input onclick="javascript:selectColors('0');" style="width:100px; background-color:#004D99; color:#ffffff;" class="button" type="button" value="<?php echo $db_admin_colors[44]; ?>">
<input onclick="javascript:selectColors('1');" style="width:100px; background-color:#0080ff; color:#ffffff;" class="button" type="button" value="<?php echo $db_admin_colors[49]; ?>">

<script type="text/javascript">
<!--
document.addEventListener("DOMContentLoaded", start(), false);
//-->
</script>