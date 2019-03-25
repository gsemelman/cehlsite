<script type="text/javascript">
<!--

function Calc() {
	// pos
	// 0 : Forward
	// 1 : Defense
	// 2 : Goalie
	var pos = document.getElementById('selectPos').value;
	var tot = "NA";
	
	if(pos != "2") {
		document.getElementById('statsDF').disabled = false;
		document.getElementById('statsSC').disabled = false;
	}
	
	if(pos == "0") {
		var weighted_total = 
		(document.getElementById('statsIT').value * 5) + 
		(document.getElementById('statsSP').value * 5) + 
		(document.getElementById('statsST').value * 7) + 
		(document.getElementById('statsEN').value * 3) + 
		(document.getElementById('statsDU').value * 1) + 
		(document.getElementById('statsDI').value * 1) + 
		(document.getElementById('statsSK').value * 6) + 
		(document.getElementById('statsPA').value * 10) + 
		(document.getElementById('statsPC').value * 8) + 
		(document.getElementById('statsDF').value * 7) + 
		(document.getElementById('statsSC').value * 13) + 
		(document.getElementById('statsEX').value * 1) + 
		(document.getElementById('statsLD').value * 1);
		tot = 5 + parseInt(weighted_total / 68);
		document.getElementById('overall').textContent = tot;
	}
	
	// D Defensive
	if(pos == "1" && (Number(document.getElementById('statsPA').value) + Number(document.getElementById('statsSC').value)) >= (Number(document.getElementById('statsDF').value) + Number(document.getElementById('statsST').value))) {
		var weighted_total = 
		(document.getElementById('statsIT').value * 4) + 
		(document.getElementById('statsSP').value * 8) + 
		(document.getElementById('statsST').value * 4) + 
		(document.getElementById('statsEN').value * 3) + 
		(document.getElementById('statsDU').value * 1) + 
		(document.getElementById('statsDI').value * 1) + 
		(document.getElementById('statsSK').value * 8) + 
		(document.getElementById('statsPA').value * 11) + 
		(document.getElementById('statsPC').value * 9) + 
		(document.getElementById('statsDF').value * 6) + 
		(document.getElementById('statsSC').value * 11) + 
		(document.getElementById('statsEX').value * 1) + 
		(document.getElementById('statsLD').value * 1);
		tot = 5 + parseInt(weighted_total / 68);
		document.getElementById('overall').textContent = tot;
	}
	
	// D Offensive
	if(pos == "1" && tot == "NA") {
		var weighted_total = 
		(document.getElementById('statsIT').value * 8) + 
		(document.getElementById('statsSP').value * 5) + 
		(document.getElementById('statsST').value * 10) + 
		(document.getElementById('statsEN').value * 3) + 
		(document.getElementById('statsDU').value * 1) + 
		(document.getElementById('statsDI').value * 1) + 
		(document.getElementById('statsSK').value * 6) + 
		(document.getElementById('statsPA').value * 8) + 
		(document.getElementById('statsPC').value * 6) + 
		(document.getElementById('statsDF').value * 13) + 
		(document.getElementById('statsSC').value * 5) + 
		(document.getElementById('statsEX').value * 1) + 
		(document.getElementById('statsLD').value * 1);
		tot = 5 + parseInt(weighted_total / 68);
		document.getElementById('overall').textContent = tot;
	}
	
	// Goalie
	if(pos == "2") {
		var weighted_total = 
		(document.getElementById('statsIT').value * 5) + 
		(document.getElementById('statsSP').value * 17) + 
		(document.getElementById('statsST').value * 4) + 
		(document.getElementById('statsEN').value * 3) + 
		(document.getElementById('statsDU').value * 1) + 
		(document.getElementById('statsDI').value * 1) + 
		(document.getElementById('statsSK').value * 7) + 
		(document.getElementById('statsPA').value * 3) + 
		(document.getElementById('statsPC').value * 8) + 
		(document.getElementById('statsEX').value * 1) + 
		(document.getElementById('statsLD').value * 1);
		tot = parseInt(weighted_total / 53);
		document.getElementById('overall').textContent = tot;
		document.getElementById('statsDF').disabled = true;
		document.getElementById('statsSC').disabled = true;
	}
}

function reset() {
	document.getElementById('selectPos').options.selectedIndex = 0;
	var inputs = document.querySelectorAll("input[type=number][id^='stats']");
	for(var i=0;i<inputs.length;i++) {
		inputs[i].value = "70";
	}
	Calc();
}

//-->
</script>

<div style="padding:5px;">

<div style="width:100%; font-weight:bold; text-align:center;"><?php echo $db_membre_OVCalc[0]; ?></div>

<select id="selectPos" style="width:100%; text-align:center;" onchange="Calc();">
<option value="0" selected><?php echo $db_membre_OVCalc[1]; ?></option>
<option value="1"><?php echo $db_membre_OVCalc[2]; ?></option>
<option value="2"><?php echo $db_membre_OVCalc[3]; ?></option>
</select>
<br>
<table class="calc" style="width:100%; margin-top:20px;">
<tr><td style="font-weight:bold;"><?php echo $db_membre_OVCalc[4]; ?></td><td style="font-weight:bold;"><?php echo $db_membre_OVCalc[5]; ?></td></tr>
<tr><td><?php echo $db_membre_OVCalc[6]; ?></td><td><input class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsIT" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[7]; ?></td><td><input class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsSP" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[8]; ?></td><td><input class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsST" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[9]; ?></td><td><input class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsEN" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[10]; ?></td><td><input  class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsDU" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[11]; ?></td><td><input  class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsDI" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[12]; ?></td><td><input  class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsSK" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[13]; ?></td><td><input  class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsPA" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[14]; ?></td><td><input  class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsPC" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[15]; ?></td><td><input  class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsDF" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[16]; ?></td><td><input  class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsSC" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[17]; ?></td><td><input  class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsEX" type="number" min="0" max="100" value="70"></td></tr>
<tr><td><?php echo $db_membre_OVCalc[18]; ?></td><td><input  class="inputText" style="padding-left:5px;" oninput="javascript:Calc();" id="statsLD" type="number" min="0" max="100" value="70"></td></tr>
<tr><td style="font-weight:bold;"><?php echo $db_membre_OVCalc[19]; ?></td><td style="font-weight:bold; font-size:16px;"><span id="overall">XX</span></td></tr>
</table>

<input class="button" type="button" style="width:100%; text-align:center; margin-top:20px;" onclick="javascript:reset();" value="<?php echo $db_membre_OVCalc[20]; ?>">

</div>

<script type="text/javascript">
<!--

document.addEventListener("DOMContentLoaded", Calc(), false);

//-->
</script>