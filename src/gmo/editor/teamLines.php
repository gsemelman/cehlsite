<style>
.positionButton {
    height:28px;
    width:28px;
	background-repeat: no-repeat;
/* 	border-style: inset; */
	border-width: 2px;
	display: block;
	float: left;
	background-size: 100%;
}

.gmoActiveButton{
    height: 25px; width: 97px; 
    background-size: 100%;
    background-repeat: no-repeat;
}

#tlDivSelect{
    cursor: pointer;
    line-height:24px;
}

#tlDivLinesEV label{
   margin-bottom: 0px;
   padding: 1px 0px;
}

#tlDivLinesEV table, #tlDivLinesPP table, #tlDivLinesEV table{
    border-style: solid;
    border-width: 1px;
    margin-top:5px;
    margin-right:5px;
}
</style>

<div id="tlDivTableStats" style="width:100%;">
	<div id="tlDivAssignedTo" style="display:block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100%;"><span style="font-weight:bold;"><?php echo $db_membre_gmo_langue[76]; ?>: </span><span id="tlSpanAssignedTo"></span></div>
	<div id="tlDivLineAverag" style="display:none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100%;"><span style="font-weight:bold;"><?php echo $db_membre_gmo_langue[117]; ?>: </span><span id="tlSpanLineAverag"></span></div>
	<table style="float:left; text-align:center; border-collapse: collapse;">
		<tr>
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
		</tr>
	</table>
		
	<table id="tlTableStatsRight" style="text-align:center; border-collapse: collapse;">
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
		</tr>
	</table>
	<div style="clear:both;"></div>
</div>

<div style="float:left;">
	<div id="tlDivSelect" style="margin-right:10px; width:140px;">
		<span style="font-weight:bold;"><?php echo $db_membre_gmo_langue[73]; ?></span><br>
		<div id="tlSelectedPlayer" style="width:100%; height:160px; border-style:inset; overflow-x:scroll; overflow-x:hidden;"></div>
	</div>
	<button class = "positionButton" id="tlImgC" style="border-style: inset; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/c.png');" onclick="javascript:tlShowPosition(this.id);"></button>
	<button class = "positionButton" id="tlImgLW" style="border-style: inset; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/lw.png');" onclick="javascript:tlShowPosition(this.id);"></button>
	<button class = "positionButton" id="tlImgRW" style="border-style: inset; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/rw.png');" onclick="javascript:tlShowPosition(this.id);"></button>
	<button class = "positionButton" id="tlImgD" style="border-style: inset; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/d.png');" onclick="javascript:tlShowPosition(this.id);"></button>
	<button class = "positionButton" id="tlImgG" style="border-style: inset; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/g.png');" onclick="javascript:tlShowPosition(this.id);"></button>
	<table style="clear:left; margin-top:45px; width:150px; border-collapse: collapse;">
		<tr>
			<td></td>
			<td style="font-weight:bold;"><?php echo $db_membre_gmo_langue[49]; ?><td>
		</tr>
		<tr>
			<td><label for="tlGOALS1" class="linesPos">#1</label></td>
			<td><input id="tlGOALS1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlGOALS1) != 0) echo $tlGOALS1; ?>" data-assigned-id="G1" class="lines" value="<?php if(strlen($tlGOALS1) != 0) echo $playerName[$tlGOALS1]; ?>" readonly></td>
		</tr>
		<tr>
			<td></td>
			<td style="font-weight:bold;"><?php echo $db_membre_gmo_langue[48]; ?></td>
		</tr>
		<tr>
			<td><label for="tlEXTRA1" class="linesPos">#1</label></td>
			<td><input id="tlEXTRA1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlEXTRA1) != 0) echo $tlEXTRA1; ?>" data-assigned-id="EX1" class="lines" value="<?php if(strlen($tlEXTRA1) != 0) echo $playerName[$tlEXTRA1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlEXTRA2" class="linesPos">#2</label></td>
			<td><input id="tlEXTRA2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlEXTRA2) != 0) echo $tlEXTRA2; ?>" data-assigned-id="EX2" class="lines" value="<?php if(strlen($tlEXTRA2) != 0) echo $playerName[$tlEXTRA2]; ?>" readonly></td>
		</tr>
		<tr>
			<td></td>
			<td style="font-weight:bold;<?php echo $league_editorPassword; ?>"><?php echo $db_membre_gmo_langue[111]; ?></td>
		</tr>
		<tr>
			<td></td>
			<td><input id="tlPASSWD" type="password" value="" maxlength="10" style="width: 100px; font-size:11px; line-height: 17px;<?php echo $league_editorPassword; ?>"></td>
		</tr>
		<tr>
			<!-- <td colspan="2" style="text-align:center;"><input type="button" style="height: 25px; width: 97px; background-image:url('<?php //echo BASE_URL?>gmo/images/ligne/reset.png'); background-repeat:no-repeat; border-style:inset; border-width:2px; display:block;" onclick="javascript:tlButtonReset();"></td>-->
			<td colspan="2" style="text-align:center;"><button class="gmoActiveButton" id="tlImgRoster" style="border-width:2px; display:block; background:url('<?php echo BASE_URL?>gmo/images/ligne/teamroster.png');" onclick="window.location='<?php echo BASE_URL?>MyCehl.php?membre=gmonline&lines=1#Lines';"></button></td>
		
		</tr>
	</table>
</div>

<div id="tlDivLinesEV" style="float:left;">
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bolder; cursor:pointer;" onclick="javascript:tlLineAverage('tlESL1');"><?php echo $db_membre_gmo_langue[30]; ?></td>
		</tr>
		<tr>
			<td><label for="tlESL1CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlESL1CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL1CT) != 0) echo $tlESL1CT; ?>" data-assigned-id="L1C" class="lines" value="<?php if(strlen($tlESL1CT) != 0) echo $playerName[$tlESL1CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL1LW" class="linesPos"><?php echo $db_membre_gmo_langue[32]; ?></label></td>
			<td><input id="tlESL1LW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL1LW) != 0) echo $tlESL1LW; ?>" data-assigned-id="L1<?php echo $db_membre_gmo_langue[32]; ?>" class="lines" value="<?php if(strlen($tlESL1LW) != 0) echo $playerName[$tlESL1LW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL1RW" class="linesPos"><?php echo $db_membre_gmo_langue[33]; ?></label></td>
			<td><input id="tlESL1RW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL1RW) != 0) echo $tlESL1RW; ?>" data-assigned-id="L1<?php echo $db_membre_gmo_langue[33]; ?>" class="lines" value="<?php if(strlen($tlESL1RW) != 0) echo $playerName[$tlESL1RW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL1D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlESL1D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL1D1) != 0) echo $tlESL1D1; ?>" data-assigned-id="L1D1" class="lines" value="<?php if(strlen($tlESL1D1) != 0) echo $playerName[$tlESL1D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL1D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlESL1D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL1D2) != 0) echo $tlESL1D2; ?>" data-assigned-id="L1D2" class="lines" value="<?php if(strlen($tlESL1D2) != 0) echo $playerName[$tlESL1D2]; ?>" readonly></td>
		</tr>
	</table>
	
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlESL2');"><?php echo $db_membre_gmo_langue[36]; ?></td>
		</tr>
		<tr>
			<td><label for="tlESL2CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlESL2CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL2CT) != 0) echo $tlESL2CT; ?>" data-assigned-id="L2C" class="lines" value="<?php if(strlen($tlESL2CT) != 0) echo $playerName[$tlESL2CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL2LW" class="linesPos"><?php echo $db_membre_gmo_langue[32]; ?></label></td>
			<td><input id="tlESL2LW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL2LW) != 0) echo $tlESL2LW; ?>" data-assigned-id="L2<?php echo $db_membre_gmo_langue[32]; ?>" class="lines" value="<?php if(strlen($tlESL2LW) != 0) echo $playerName[$tlESL2LW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL2RW" class="linesPos"><?php echo $db_membre_gmo_langue[33]; ?></label></td>
			<td><input id="tlESL2RW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL2RW) != 0) echo $tlESL2RW; ?>" data-assigned-id="L2<?php echo $db_membre_gmo_langue[33]; ?>" class="lines" value="<?php if(strlen($tlESL2RW) != 0) echo $playerName[$tlESL2RW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL2D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlESL2D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL2D1) != 0) echo $tlESL2D1; ?>" data-assigned-id="L2D1" class="lines" value="<?php if(strlen($tlESL2D1) != 0) echo $playerName[$tlESL2D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL2D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlESL2D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL2D2) != 0) echo $tlESL2D2; ?>" data-assigned-id="L2D2" class="lines" value="<?php if(strlen($tlESL2D2) != 0) echo $playerName[$tlESL2D2]; ?>" readonly></td>
		</tr>
	</table>
	
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlESL3');"><?php echo $db_membre_gmo_langue[35]; ?></td>
		</tr>
		<tr>
			<td><label for="tlESL3CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlESL3CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL3CT) != 0) echo $tlESL3CT; ?>" data-assigned-id="L3C" class="lines" value="<?php if(strlen($tlESL3CT) != 0) echo $playerName[$tlESL3CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL3LW" class="linesPos"><?php echo $db_membre_gmo_langue[32]; ?></label></td>
			<td><input id="tlESL3LW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL3LW) != 0) echo $tlESL3LW; ?>" data-assigned-id="L3<?php echo $db_membre_gmo_langue[32]; ?>" class="lines" value="<?php if(strlen($tlESL3LW) != 0) echo $playerName[$tlESL3LW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL3RW" class="linesPos"><?php echo $db_membre_gmo_langue[33]; ?></label></td>
			<td><input id="tlESL3RW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL3RW) != 0) echo $tlESL3RW; ?>" data-assigned-id="L3<?php echo $db_membre_gmo_langue[33]; ?>" class="lines" value="<?php if(strlen($tlESL3RW) != 0) echo $playerName[$tlESL3RW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL3D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlESL3D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL3D1) != 0) echo $tlESL3D1; ?>" data-assigned-id="L3D2" class="lines" value="<?php if(strlen($tlESL3D1) != 0) echo $playerName[$tlESL3D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL3D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlESL3D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL3D2) != 0) echo $tlESL3D2; ?>" data-assigned-id="L3D2" class="lines" value="<?php if(strlen($tlESL3D2) != 0) echo $playerName[$tlESL3D2]; ?>" readonly></td>
		</tr>
	</table>
	
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlESL4');"><?php echo $db_membre_gmo_langue[37]; ?></td>
		</tr>
		<tr>
			<td><label for="tlESL4CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlESL4CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL4CT) != 0) echo $tlESL4CT; ?>" data-assigned-id="L4C" class="lines" value="<?php if(strlen($tlESL4CT) != 0) echo $playerName[$tlESL4CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL4LW" class="linesPos"><?php echo $db_membre_gmo_langue[32]; ?></label></td>
			<td><input id="tlESL4LW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL4LW) != 0) echo $tlESL4LW; ?>" data-assigned-id="L4<?php echo $db_membre_gmo_langue[32]; ?>" class="lines" value="<?php if(strlen($tlESL4LW) != 0) echo $playerName[$tlESL4LW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL4RW" class="linesPos"><?php echo $db_membre_gmo_langue[33]; ?></label></td>
			<td><input id="tlESL4RW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL4RW) != 0) echo $tlESL4RW; ?>" data-assigned-id="L4<?php echo $db_membre_gmo_langue[33]; ?>" class="lines" value="<?php if(strlen($tlESL4RW) != 0) echo $playerName[$tlESL4RW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL4D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlESL4D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL4D1) != 0) echo $tlESL4D1; ?>" data-assigned-id="L4D1" class="lines" value="<?php if(strlen($tlESL4D1) != 0) echo $playerName[$tlESL4D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlESL4D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlESL4D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlESL4D2) != 0) echo $tlESL4D2; ?>" data-assigned-id="L4D2" class="lines" value="<?php if(strlen($tlESL4D2) != 0) echo $playerName[$tlESL4D2]; ?>" readonly></td>
		</tr>
	</table>
</div>

<div id="tlDivLinesPP" style="float:left; display:none;">
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlPPL1');"><?php echo $db_membre_gmo_langue[38]; ?></td>
		</tr>
		<tr>
			<td><label for="tlPPL1CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlPPL1CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL1CT) != 0) echo $tlPPL1CT; ?>" data-assigned-id="P1C" class="lines" value="<?php if(strlen($tlPPL1CT) != 0) echo $playerName[$tlPPL1CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL1LW" class="linesPos"><?php echo $db_membre_gmo_langue[32]; ?></label></td>
			<td><input id="tlPPL1LW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL1LW) != 0) echo $tlPPL1LW; ?>" data-assigned-id="P1<?php echo $db_membre_gmo_langue[32]; ?>" class="lines" value="<?php if(strlen($tlPPL1LW) != 0) echo $playerName[$tlPPL1LW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL1RW" class="linesPos"><?php echo $db_membre_gmo_langue[33]; ?></label></td>
			<td><input id="tlPPL1RW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL1RW) != 0) echo $tlPPL1RW; ?>" data-assigned-id="P1<?php echo $db_membre_gmo_langue[33]; ?>" class="lines" value="<?php if(strlen($tlPPL1RW) != 0) echo $playerName[$tlPPL1RW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL1D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPPL1D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL1D1) != 0) echo $tlPPL1D1; ?>" data-assigned-id="P1D1" class="lines" value="<?php if(strlen($tlPPL1D1) != 0) echo $playerName[$tlPPL1D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL1D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPPL1D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL1D2) != 0) echo $tlPPL1D2; ?>" data-assigned-id="P1D2" class="lines" value="<?php if(strlen($tlPPL1D2) != 0) echo $playerName[$tlPPL1D2]; ?>" readonly></td>
		</tr>
	</table>
	
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlPPL2');"><?php echo $db_membre_gmo_langue[41]; ?></td>
		</tr>
		<tr>
			<td><label for="tlPPL2CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlPPL2CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL2CT) != 0) echo $tlPPL2CT; ?>" data-assigned-id="P2C" class="lines" value="<?php if(strlen($tlPPL2CT) != 0) echo $playerName[$tlPPL2CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL2LW" class="linesPos"><?php echo $db_membre_gmo_langue[32]; ?></label></td>
			<td><input id="tlPPL2LW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL2LW) != 0) echo $tlPPL2LW; ?>" data-assigned-id="P2<?php echo $db_membre_gmo_langue[32]; ?>" class="lines" value="<?php if(strlen($tlPPL2LW) != 0) echo $playerName[$tlPPL2LW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL2RW" class="linesPos"><?php echo $db_membre_gmo_langue[33]; ?></label></td>
			<td><input id="tlPPL2RW" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL2RW) != 0) echo $tlPPL2RW; ?>" data-assigned-id="P2<?php echo $db_membre_gmo_langue[33]; ?>" class="lines" value="<?php if(strlen($tlPPL2RW) != 0) echo $playerName[$tlPPL2RW]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL2D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPPL2D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL2D1) != 0) echo $tlPPL2D1; ?>" data-assigned-id="P2D1" class="lines" value="<?php if(strlen($tlPPL2D1) != 0) echo $playerName[$tlPPL2D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL2D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPPL2D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL2D2) != 0) echo $tlPPL2D2; ?>" data-assigned-id="P2D2" class="lines" value="<?php if(strlen($tlPPL2D2) != 0) echo $playerName[$tlPPL2D2]; ?>" readonly></td>
		</tr>
	</table>
	
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlPPL3');"><?php echo $db_membre_gmo_langue[39]; ?></td>
		</tr>
		<tr>
			<td><label for="tlPPL3CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlPPL3CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL3CT) != 0) echo $tlPPL3CT; ?>" data-assigned-id="P3C" class="lines" value="<?php if(strlen($tlPPL3CT) != 0) echo $playerName[$tlPPL3CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL3WG" class="linesPos"><?php echo $db_membre_gmo_langue[40]; ?></label></td>
			<td><input id="tlPPL3WG" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL3WG) != 0) echo $tlPPL3WG; ?>" data-assigned-id="P3<?php echo $db_membre_gmo_langue[40]; ?>" class="lines" value="<?php if(strlen($tlPPL3WG) != 0) echo $playerName[$tlPPL3WG]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL3D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPPL3D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL3D1) != 0) echo $tlPPL3D1; ?>" data-assigned-id="P3D1" class="lines" value="<?php if(strlen($tlPPL3D1) != 0) echo $playerName[$tlPPL3D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL3D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPPL3D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL3D2) != 0) echo $tlPPL3D2; ?>" data-assigned-id="P3D2" class="lines" value="<?php if(strlen($tlPPL3D2) != 0) echo $playerName[$tlPPL3D2]; ?>" readonly></td>
		</tr>
	</table>
	
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlPPL4');"><?php echo $db_membre_gmo_langue[42]; ?></td>
		</tr>
		<tr>
			<td><label for="tlPPL4CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlPPL4CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL4CT) != 0) echo $tlPPL4CT; ?>" data-assigned-id="P4C" class="lines" value="<?php if(strlen($tlPPL4CT) != 0) echo $playerName[$tlPPL4CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL4WG" class="linesPos"><?php echo $db_membre_gmo_langue[40]; ?></label></td>
			<td><input id="tlPPL4WG" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL4WG) != 0) echo $tlPPL4WG; ?>" data-assigned-id="P4<?php echo $db_membre_gmo_langue[40]; ?>" class="lines" value="<?php if(strlen($tlPPL4WG) != 0) echo $playerName[$tlPPL4WG]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL4D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPPL4D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL4D1) != 0) echo $tlPPL4D1; ?>" data-assigned-id="P4D1" class="lines" value="<?php if(strlen($tlPPL4D1) != 0) echo $playerName[$tlPPL4D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPPL4D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPPL4D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPPL4D2) != 0) echo $tlPPL4D2; ?>" data-assigned-id="P4D2" class="lines" value="<?php if(strlen($tlPPL4D2) != 0) echo $playerName[$tlPPL4D2]; ?>" readonly></td>
		</tr>
	</table>
</div>


<div id="tlDivLinesPK" style="float:left; display:none;">
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlPKL1');"><?php echo $db_membre_gmo_langue[43]; ?></td>
		</tr>
		<tr>
			<td><label for="tlPKL1CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlPKL1CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL1CT) != 0) echo $tlPKL1CT; ?>" data-assigned-id="K1C" class="lines" value="<?php if(strlen($tlPKL1CT) != 0) echo $playerName[$tlPKL1CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPKL1WG" class="linesPos"><?php echo $db_membre_gmo_langue[40]; ?></label></td>
			<td><input id="tlPKL1WG" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL1WG) != 0) echo $tlPKL1WG; ?>" data-assigned-id="K1<?php echo $db_membre_gmo_langue[40]; ?>" class="lines" value="<?php if(strlen($tlPKL1WG) != 0) echo $playerName[$tlPKL1WG]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPKL1D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPKL1D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL1D1) != 0) echo $tlPKL1D1; ?>" data-assigned-id="K1D1" class="lines" value="<?php if(strlen($tlPKL1D1) != 0) echo $playerName[$tlPKL1D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPKL1D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPKL1D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL1D2) != 0) echo $tlPKL1D2; ?>" data-assigned-id="K1D2" class="lines" value="<?php if(strlen($tlPKL1D2) != 0) echo $playerName[$tlPKL1D2]; ?>" readonly></td>
		</tr>
	</table>
	
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlPKL2');"><?php echo $db_membre_gmo_langue[45]; ?></td>
		</tr>
		<tr>
			<td><label for="tlPKL2CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlPKL2CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL2CT) != 0) echo $tlPKL2CT; ?>" data-assigned-id="K2C" class="lines" value="<?php if(strlen($tlPKL2CT) != 0) echo $playerName[$tlPKL2CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPKL2WG" class="linesPos"><?php echo $db_membre_gmo_langue[40]; ?></label></td>
			<td><input id="tlPKL2WG" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL2WG) != 0) echo $tlPKL2WG; ?>" data-assigned-id="K2<?php echo $db_membre_gmo_langue[40]; ?>" class="lines" value="<?php if(strlen($tlPKL2WG) != 0) echo $playerName[$tlPKL2WG]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPKL2D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPKL2D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL2D1) != 0) echo $tlPKL2D1; ?>" data-assigned-id="K2D1" class="lines" value="<?php if(strlen($tlPKL2D1) != 0) echo $playerName[$tlPKL2D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPKL2D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPKL2D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL2D2) != 0) echo $tlPKL2D2; ?>" data-assigned-id="K2D2" class="lines" value="<?php if(strlen($tlPKL2D2) != 0) echo $playerName[$tlPKL2D2]; ?>" readonly></td>
		</tr>
	</table>
	
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlPKL3');"><?php echo $db_membre_gmo_langue[44]; ?></td>
		</tr>
		<tr>
			<td><label for="tlPKL3CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlPKL3CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL3CT) != 0) echo $tlPKL3CT; ?>" data-assigned-id="K3C" class="lines" value="<?php if(strlen($tlPKL3CT) != 0) echo $playerName[$tlPKL3CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPKL3D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPKL3D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL3D1) != 0) echo $tlPKL3D1; ?>" data-assigned-id="K3D1" class="lines" value="<?php if(strlen($tlPKL3D1) != 0) echo $playerName[$tlPKL3D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPKL3D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPKL3D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL3D2) != 0) echo $tlPKL3D2; ?>" data-assigned-id="K3D2" class="lines" value="<?php if(strlen($tlPKL3D2) != 0) echo $playerName[$tlPKL3D2]; ?>" readonly></td>
		</tr>
	</table>
	
	<table style="border-collapse: collapse; float:left;">
		<tr>
			<td style="width:20px;"></td>
			<td style="font-weight:bold; cursor:pointer;" onclick="javascript:tlLineAverage('tlPKL4');"><?php echo $db_membre_gmo_langue[46]; ?></td>
		</tr>
		<tr>
			<td><label for="tlPKL4CT" class="linesPos"><?php echo $db_membre_gmo_langue[31]; ?></label></td>
			<td><input id="tlPKL4CT" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL4CT) != 0) echo $tlPKL4CT; ?>" data-assigned-id="K4C" class="lines" value="<?php if(strlen($tlPKL4CT) != 0) echo $playerName[$tlPKL4CT]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPKL4D1" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPKL4D1" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL4D1) != 0) echo $tlPKL4D1; ?>" data-assigned-id="K4D1" class="lines" value="<?php if(strlen($tlPKL4D1) != 0) echo $playerName[$tlPKL4D1]; ?>" readonly></td>
		</tr>
		<tr>
			<td><label for="tlPKL4D2" class="linesPos"><?php echo $db_membre_gmo_langue[34]; ?></label></td>
			<td><input id="tlPKL4D2" onclick="javascript:tlInputClicked(this.id);" data-player-id="<?php if(strlen($tlPKL4D2) != 0) echo $tlPKL4D2; ?>" data-assigned-id="K4D2" class="lines" value="<?php if(strlen($tlPKL4D2) != 0) echo $playerName[$tlPKL4D2]; ?>" readonly></td>
		</tr>
	</table>
</div>

<div style="float:right;">
	<button id="tlImgLineEV" style="height: 25px; width: 25px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/even.png'); background-repeat:no-repeat; border-style:inset; border-width:2px; display:block;" onclick="javascript:tlShowLines(this.id);"></button>
	<button id="tlImgLinePP" style="height: 25px; width: 25px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/pp.png'); background-repeat:no-repeat; border-style:outset; border-width:2px; display:block;" onclick="javascript:tlShowLines(this.id);"></button>
	<button id="tlImgLinePK" style="height: 25px; width: 25px; background-image:url('<?php echo BASE_URL?>gmo/images/ligne/pk.png'); background-repeat:no-repeat; border-style:outset; border-width:2px; display:block;" onclick="javascript:tlShowLines(this.id);"></button>
</div>

<div style="float:right; margin-top:15px;">
	<button class="gmoActiveButton" id="tlImgAuto" style="background:url('<?php echo BASE_URL?>gmo/images/ligne/auto.png');" onclick="tlAutoLine();"></button>
	<button class="gmoActiveButton" id="tlImgSave" style="background:url('<?php echo BASE_URL?>gmo/images/ligne/saveline.png');" onclick="tlSave();"></button>
	<!--<button class="gmoActiveButton" id="tlImgRoster" style="background:url('<?php //echo BASE_URL?>gmo/images/ligne/teamroster.png');" onclick="window.location='<?php //echo BASE_URL?>MyCehl.php?membre=gmonline&lines=1#Lines';"></button>-->
	<button class="gmoActiveButton" id="tlImgReset" style="background:url('<?php echo BASE_URL?>gmo/images/ligne/reset.png');" onclick="javascript:tlButtonReset();"></button>

</div>

<div id="tlDivBottomSpacer" style="clear:both; width:100%;"></div>