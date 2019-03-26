<style>
.positionButton {
    height:30px;
    width:30px;
    background-repeat:no-repeat;
    border-width:2px; 
    display:block;
	background-size: 100%;
}

</style>

<?php

if(!isset($playerRank)) {
	echo '<div style="width:100%;border:2px dashed red; font-size:20px; padding:3px; margin:5px 0px; border-radius: 5px;">';
	if($teamRank != "") echo $db_membre_gmo_langue[120]." (".$teamRank.")";
	else echo $db_membre_gmo_langue[120]." (".$db_membre_gmo_langue[121].")";
	echo '</div>';
}

?>

<div style="float:left;"><span id="trTotalPlayers"></span> <span id="trTotalPlayers2"></span></div><div id="trSalaryCop" style="float:right; font-weight:bold;"></div>
<div class="trDivSelect" style="clear:both; float:left; margin-right:10px;">
	<span style="font-weight:bold;"><?php echo $db_membre_gmo_langue[55]; ?></span><br>
	<div class="selectedPlayers" id="trSelectedPlayers1" style="width:100%; margin-bottom:7px; border:1px solid #<?php echo $databaseColors['colorMainText']; ?>; height:120px; overflow-x:scroll; overflow-x:hidden;"></div>
	<button class="trButton1 gmoActiveButton" style="height: 25px; width: 73px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/scratch.png'); background-repeat:no-repeat; margin-left:81px;" onclick="javascript:trProToScratch();"></button>
</div>
<button class="trButton2" style="height: 25px; width: 73px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/scratch.png'); background-repeat:no-repeat; float:left; position:relative; top:15px;" onclick="javascript:trProToScratch();"></button>

<div class="trDivSelect" style="float:left; margin-right:10px;">
	<span style="font-weight:bold;"><?php echo $db_membre_gmo_langue[56]; ?></span><br>
	<div class="selectedPlayers" id="trSelectedPlayers2" style="width:100%; margin-bottom:7px; border:1px solid #<?php echo $databaseColors['colorMainText']; ?>; height:120px; overflow-x:scroll; overflow-x:hidden;"></div>
	<button class="trButton1 gmoActiveButton" style="height: 25px; width: 73px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/dress.png'); background-repeat:no-repeat;" onclick="javascript:trScratchToPro();"></button>
	<button class="trButton1 gmoActiveButton" style="height: 25px; width: 73px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/tofarm.png'); background-repeat:no-repeat; margin-left:4px;" onclick="javascript:trScratchToFarm();"></button>
</div>
<div style="float:left;">
	<button class="trButton2 gmoActiveButton" style="height: 25px; width: 73px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/dress.png'); background-repeat:no-repeat; position:relative; top:15px;" onclick="javascript:trScratchToPro();"></button><br>
	<button class="trButton2 gmoActiveButton" style="height: 25px; width: 73px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/tofarm.png'); background-repeat:no-repeat; position:relative; top:87px;" onclick="javascript:trScratchToFarm();"></button>
</div>

<div style="float:right;">
	<span style="font-weight:bold;"></span><br>
	<button class="positionButton" id="trImgC" style="background-image:url('<?php echo BASE_URL?>gmo/images/ligne/c.png'); border-style:inset; " onclick="javascript:trShowPosition(this.id);"></button>
	<button class="positionButton" id="trImgLW" style="background-image:url('<?php echo BASE_URL?>gmo/images/ligne/lw.png'); border-style:inset;;" onclick="javascript:trShowPosition(this.id);"></button>
	<button class="positionButton" id="trImgRW" style="background-image:url('<?php echo BASE_URL?>gmo/images/ligne/rw.png'); border-style:inset;" onclick="javascript:trShowPosition(this.id);"></button>
	<button class="positionButton" id="trImgD" style="background-image:url('<?php echo BASE_URL?>gmo/images/ligne/d.png'); border-style:inset;" onclick="javascript:trShowPosition(this.id);"></button>
	<button class="positionButton" id="trImgG" style="background-image:url('<?php echo BASE_URL?>gmo/images/ligne/g.png'); border-style:inset;" onclick="javascript:trShowPosition(this.id);"></button>
</div>

<div class="trDivSelect" style="float:left;">
	<span style="font-weight:bold;"><?php echo $db_membre_gmo_langue[57]; ?></span><br>
	<div class="selectedPlayers" id="trSelectedPlayers3" style="width:100%; margin-bottom:7px; border:1px solid #<?php echo $databaseColors['colorMainText']; ?>; height:120px; overflow-x:scroll; overflow-x:hidden;"></div>
	<button class="trButton1 gmoActiveButton" style="height: 25px; width: 73px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/topros.png'); background-repeat:no-repeat; margin-bottom:8px;" onclick="javascript:trFarmToScratch();"></button>
</div>
<button class="trButton2 gmoActiveButton" style="height: 25px; width: 73px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/topros.png'); background-repeat:no-repeat; float:left; margin-left:10px; position:relative; top:15px;" onclick="javascript:trFarmToScratch();"></button>

<div style="clear:both; float:left; margin-bottom:5px;">
	<button class="gmoActiveButton" id="trButtonAuto" style="margin-right:5px; vertical-align:top; height: 25px; width: 105px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/auto.png'); background-repeat:no-repeat;" onclick="javascript:trAutoLine();"></button>
	<button id="trImgProtect" style="display:none; height: 25px; width: 105px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/protect.png'); background-repeat:no-repeat; border-style:outset; border-width:2px;" onclick="javascript:trShowProtected();"></button>

</div>

<div style="float:right; text-align:right;">
	<button class="gmoActiveButton" id="trImgLoadLines" style="display:<?php echo $loadlinesDisplay; ?>; vertical-align:top; height: 25px; width: 97px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/loadline.png'); background-repeat:no-repeat;" onclick="javascript:trLoadLines();"></button>
	<button class="gmoActiveButton" id="trImgTeamLines" style="margin-left:5px; height: 25px; width: 105px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/teamlines.png'); background-repeat:no-repeat;" onclick="trExit();"></button>
</div>

<hr id="trHrStats" style="clear:both; width:100%;">

<div id="trDivTableStats">
<table style="float:left; text-align:center; border-collapse: collapse;">
<tr>
<td id="statsName" style="width:67px; font-size:10px;" rowspan="2"></td>
<td>POS</td>
<td><?php echo $db_membre_gmo_langue[10]; ?></td>
<td><?php echo $db_membre_gmo_langue[11]; ?></td>
<td><?php echo $db_membre_gmo_langue[12]; ?></td>
<td><?php echo $db_membre_gmo_langue[26]; ?></td>
</tr>
<tr>
<td><input type="text" id="statsPosT" readonly="readonly" style="width:16px; font-size:10px; padding:1px 0px;"></td>
<td><input type="text" id="statsAges" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsHand" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsCond" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsOver" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
</tr></table>
<div id="trTableStats3" style="margin-left:25px; padding-top:10px; padding-bottom:10px; cursor:pointer;" onclick="javascript:trMoreStatsToggle();"><?php echo $db_membre_gmo_langue[105]; ?></div>

<table id="trTableStats" style="text-align:center; border-collapse: collapse;">
<tr>
<td><?php echo $db_membre_gmo_langue[13]; ?></td>
<td><?php echo $db_membre_gmo_langue[14]; ?></td>
<td><?php echo $db_membre_gmo_langue[15]; ?></td>
<td><?php echo $db_membre_gmo_langue[16]; ?></td>
<td><?php echo $db_membre_gmo_langue[17]; ?></td>
<td><?php echo $db_membre_gmo_langue[18]; ?></td>
<td><?php echo $db_membre_gmo_langue[19]; ?></td>
<td><?php echo $db_membre_gmo_langue[20]; ?></td>
<td><?php echo $db_membre_gmo_langue[21]; ?></td>
<td><?php echo $db_membre_gmo_langue[22]; ?></td>
<td><?php echo $db_membre_gmo_langue[23]; ?></td>
<td><?php echo $db_membre_gmo_langue[24]; ?></td>
<td><?php echo $db_membre_gmo_langue[25]; ?></td>
</tr>
<tr>
<td><input type="text" id="statsInte" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsSpee" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsStre" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsEndu" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsDura" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsDisc" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsSkat" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsPass" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsPkct" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsDefs" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsOffs" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsExpe" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
<td><input type="text" id="statsLead" readonly="readonly" style="width:16px; font-size:10px; text-align:center; padding:1px 0px;"></td>
</tr></table>

<table class="statsPadding" id="trTableStats2" style="margin-top:10px; border-collapse: collapse; width:100%;">
<tr>
<td style="border:0px; text-align:right;"><?php echo $db_membre_gmo_stats[17]; ?></td>
<td style="border:0px; text-align:right;" id="statsBirt"></td>
<td style="border:0px; text-align:right;"><?php echo $db_membre_gmo_stats[18]; ?></td>
<td style="border:0px; text-align:right;" id="statsNumb"></td>
<td style="border:0px; text-align:right;"><?php echo $db_membre_gmo_stats[20]; ?></td>
<td style="border:0px; text-align:right;" id="statsHeig"></td>
<td style="border:0px; text-align:right;"><?php echo $db_membre_gmo_stats[19]; ?></td>
<td style="border:0px; text-align:right;" id="statsWeig"></td>
<td style="border:0px; text-align:right;"><?php echo $db_membre_gmo_stats[21]; ?></td>
<td style="border:0px; text-align:right;" id="statsCont"></td>
<td style="border:0px; text-align:right;"><?php echo $db_membre_gmo_stats[22]; ?></td>
<td style="border:0px; text-align:right;" id="statsSalT"></td>
</tr>

<tr>
<td style="border:0px; text-align:right;"><?php echo $db_membre_gmo_stats[1]; ?></td>
<td style="border:0px; text-align:right;" id="statsGame"></td>
<td style="border:0px; text-align:right;" id="statsTxtGoalWin"><?php echo $db_membre_gmo_stats[12]; ?></td>
<td style="border:0px; text-align:right;" id="statsGoal"></td>
<td style="border:0px; text-align:right;" id="statsTxtGoalAssistLoose"><?php echo $db_membre_gmo_stats[2]; ?></td>
<td style="border:0px; text-align:right;" id="statsAssi"></td>
<td style="border:0px; text-align:right;" id="statsTxtPIMTies"><?php echo $db_membre_gmo_stats[4]; ?></td>
<td style="border:0px; text-align:right;" id="statsPIMs"></td>
<td style="border:0px; text-align:right;" id="statsTxtplusMinusGA"><?php echo $db_membre_gmo_stats[3]; ?></td>
<td style="border:0px; text-align:right;" id="statsPLMN"></td>
<td style="border:0px; text-align:right;" id="statsTxtHitsGAA"><?php echo $db_membre_gmo_stats[10]; ?></td>
<td style="border:0px; text-align:right;" id="statsHits"></td>
</tr>
<tr>
<td style="border:0px; text-align:right;" id="statsTxtPPGPIM"><?php echo $db_membre_gmo_stats[6]; ?></td>
<td style="border:0px; text-align:right;" id="statsPPGs"></td>
<td style="border:0px; text-align:right;" id="statsTxtSHGAs"><?php echo $db_membre_gmo_stats[7]; ?></td>
<td style="border:0px; text-align:right;" id="statsSHGs"></td>
<td style="border:0px; text-align:right;" id="statsTxtGWSO"><?php echo $db_membre_gmo_stats[8]; ?></td>
<td style="border:0px; text-align:right;" id="statsGWSO"></td>
<td style="border:0px; text-align:right;" id="statsTxtGT"><?php echo $db_membre_gmo_stats[9]; ?></td>
<td style="border:0px; text-align:right;" id="statsGTTI"></td>
<td style="border:0px; text-align:right;"><?php echo $db_membre_gmo_stats[5]; ?></td>
<td style="border:0px; text-align:right;" id="statsShot"></td>
<td style="border:0px; text-align:right;" id="statsTxtSPctSvPct"><?php echo $db_membre_gmo_stats[16]; ?></td>
<td style="border:0px; text-align:right;" id="statsSTPC"></td>
</tr>
</table>
</div>