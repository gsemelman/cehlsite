<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = 'Unassigned';
$CurrentTitle = $langUnassignedPlayers;
$CurrentPage = 'Unassigned';
include 'head.php';
?>

<div class="container">

<div class="card">
	<div class="card-header wow fadeIn">
		<h3><?php echo $CurrentTitle; ?></h3>
	</div>
	<div class="card-body">
	<div class = "table-responsive">

<?php
$matches = glob($folder.'*'.$playoff.'Unassigned.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Unassigned')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'Unassigned.html';
$a = 0;
$i = 0;
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '</PRE>')) {
			$a = 0;
		}
		if($a == 1) {
			$reste = trim($val);
			$unassignedOV[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedLD[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedEX[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedSC[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedDF[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedPC[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedPA[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedSK[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedDI[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedDU[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedEN[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedST[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedSP[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedIT[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedPO[$i] = trim(substr($reste, strrpos($reste, ' ')));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedAG[$i] = substr($reste, strrpos($reste, ' '));
			$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
			$unassignedPL[$i] = $reste;
			$i++;
		}
		if(substr_count($val, '<PRE>Player')) {
			$a = 1;
		}
	}
	if(isset($unassignedPL)) {
		for($i=0;$i<count($unassignedPL);$i++) {
			$unassignedCT[$i] = $i;
		}

		echo '<div class="col-sm-2 offset-sm-5">
		  <select onchange="javascript:result(\'NA\');" class="form-control mb-3" id="pos">
			  <option value="POS" selected>'.$langCareerLeadersAllFoward.'</option>
			  <option value="C">'.$langCareerLeadersCenter.'</option>
			  <option value="LW">'.$langCareerLeadersLeft.'</option>
			  <option value="RW">'.$langCareerLeadersRight.'</option>
			  <option value="D">'.$langCareerLeadersDef.'</option>
			  <option value="G">'.$langCareerLeadersGoalies.'</option>
		  </select>
		</div>';
		echo '<div id="windowResult"></div>';
	}
	else echo $langUnassignedPlayersNotFound;
}
else echo $allFileNotFound.' - '.$Fnm;
?>

<script type="text/javascript">
<!--
var unassignedOV = <?php echo json_encode($unassignedOV)?>;
var unassignedLD = <?php echo json_encode($unassignedLD)?>;
var unassignedEX = <?php echo json_encode($unassignedEX)?>;
var unassignedSC = <?php echo json_encode($unassignedSC)?>;
var unassignedDF = <?php echo json_encode($unassignedDF)?>;
var unassignedPC = <?php echo json_encode($unassignedPC)?>;
var unassignedPA = <?php echo json_encode($unassignedPA)?>;
var unassignedSK = <?php echo json_encode($unassignedSK)?>;
var unassignedDI = <?php echo json_encode($unassignedDI)?>;
var unassignedDU = <?php echo json_encode($unassignedDU)?>;
var unassignedEN = <?php echo json_encode($unassignedEN)?>;
var unassignedST = <?php echo json_encode($unassignedST)?>;
var unassignedSP = <?php echo json_encode($unassignedSP)?>;
var unassignedIT = <?php echo json_encode($unassignedIT)?>;
var unassignedPO = <?php echo json_encode($unassignedPO)?>;
var unassignedAG = <?php echo json_encode($unassignedAG)?>;
var unassignedPL = <?php echo json_encode($unassignedPL)?>;
var unassignedCT = <?php echo json_encode($unassignedCT)?>;
var type = '';
var reverse = 0;

function result(x) {
	if(x != 'NA' && x != 'OVR') {
		if(type == x) {
			if(reverse == 1) reverse = 0;
			else reverse = 1;
		}
		else {
			type = x;
			reverse = 0;
		}
	}
	else {
		type = 'OV';
		reverse = 0;
	}
	//var currentPosition = document.querySelector('input[name="position"]:checked').value;
	var select = document.getElementById('pos');
	var currentPosition = select.options[select.selectedIndex].value; 

	document.getElementById("windowResult").textContent = "";
	var result = document.getElementById("windowResult");
	var tbl = document.createElement('table');
		tbl.style.width='100%';
		tbl.className = "table table-sm";
	var tbdy = document.createElement('tbody');
	// Entête
	var tr = document.createElement('tr');
		tr.className = "tableau-top";
		var td = document.createElement('td');
				if(type == 'PO') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:return;";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('PO'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersPosition; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
				if(type == 'PL') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('PL');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersName; ?>'));
				td.appendChild(a);
			tr.appendChild(td);
		var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'AG') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('AG');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('AGE'));
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'IT') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('IT');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersIT; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersITF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'SP') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('SP');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersSP; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersSPF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'ST') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('ST');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersST; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersSTF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'EN') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('EN');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersEN; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersENF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'DU') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('DU');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersDU; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersDUF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'DI') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('DI');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersDI; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersDIF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'SK') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('SK');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersSK; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersSKF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'PA') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('PA');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersPA; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersPAF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'PC') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('PC');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersPC; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersPCF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'DF') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('DF');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersDF; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersDFF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'SC') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('SC');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersOF; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersOFF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'EX') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('EX');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersEX; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersEXF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'LD') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('LD');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersLD; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersLDF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
			var td = document.createElement('td');
				td.style.textAlign = "right";
				if(type == 'OV') td.style.fontWeight = "bold";
					var a = document.createElement('a');
						a.href = "javascript:result('OV');";
						a.className = "info";
						a.style.width = "100%";
						a.style.display = "block";
						a.appendChild(document.createTextNode('<?php echo $rostersOV; ?>'));
					var span = document.createElement('span');
						span.appendChild(document.createTextNode('<?php echo $rostersOVF; ?>'));
					a.appendChild(span);
				td.appendChild(a);
			tr.appendChild(td);
		tbdy.appendChild(tr);
	var zipped = [];
	var tmpTransF = [];
	if(type == 'PL') tmpTransF = unassignedPL;
	if(type == 'AG') tmpTransF = unassignedAG;
	if(type == 'PO') tmpTransF = unassignedPO;
	if(type == 'IT') tmpTransF = unassignedIT;
	if(type == 'SP') tmpTransF = unassignedSP;
	if(type == 'ST') tmpTransF = unassignedST;
	if(type == 'EN') tmpTransF = unassignedEN;
	if(type == 'DU') tmpTransF = unassignedDU;
	if(type == 'DI') tmpTransF = unassignedDI;
	if(type == 'SK') tmpTransF = unassignedSK;
	if(type == 'PA') tmpTransF = unassignedPA;
	if(type == 'PC') tmpTransF = unassignedPC;
	if(type == 'DF') tmpTransF = unassignedDF;
	if(type == 'SC') tmpTransF = unassignedSC;
	if(type == 'EX') tmpTransF = unassignedEX;
	if(type == 'LD') tmpTransF = unassignedLD;
	if(type == 'OV') tmpTransF = unassignedOV;
	for(i=0; i<unassignedPL.length; ++i) {
		zipped.push({
			attr: tmpTransF[i],
			id: unassignedCT[i]
		});
	}
	zipped.sort(function(left, right) {
		var leftArray1elem = left.attr,
			rightArray1elem = right.attr;
		return leftArray1elem === rightArray1elem ? 0 : (leftArray1elem < rightArray1elem ? -1 : 1);
	});
	if(reverse == 0) zipped.reverse(); 
	var c = 1;
	var d = 0;
	for(var i=0;i<unassignedPL.length;i++) {
		if(currentPosition == unassignedPO[zipped[i]['id']] || currentPosition == 'POS') {
			if(c == 2) c = 1;
			else c = 2;
			d++;
			var tr = showPlayer(zipped[i]['id'],c,d,type);
		}
		tbdy.appendChild(tr);
	}
	tbl.appendChild(tbdy);
	result.appendChild(tbl);
}

function showPlayer(i,c,d,currentSearch) {
	//d = d + 1;
	var tr = document.createElement('tr');
		tr.className = "hover"+c;
		var td = document.createElement('td');
			if(currentSearch == 'PO') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedPO[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			if(currentSearch == 'PL') td.style.fontWeight = "bold";
			var a = document.createElement('a');
				a.className = "lien-noir";
				a.style.display = "block";
				a.style.width = "100%";
				a.href = "CareerStatsPlayer.php?csName="+encodeURIComponent(unassignedPL[i]);
				a.appendChild(document.createTextNode(unassignedPL[i]));
			td.appendChild(a);
			td.style.textAlign = "left";
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'AG') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedAG[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'IT') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedIT[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'SP') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedSP[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'ST') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedST[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'EN') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedEN[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'DU') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedDU[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'DI') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedDI[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'SK') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedSK[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'PA') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedPA[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'PC') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedPC[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'DF') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedDF[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'SC') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedSC[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'EX') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedEX[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'LD') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedLD[i]));
		tr.appendChild(td);
		var td = document.createElement('td');
			td.style.textAlign = "center";
			if(currentSearch == 'OV') td.style.fontWeight = "bold";
			td.appendChild(document.createTextNode(unassignedOV[i]));
		tr.appendChild(td);
	return tr;
}

document.addEventListener('DOMContentLoaded', result('OV'), false);

//-->
</script>
</div>
</div>
</div>
</body>
</html>