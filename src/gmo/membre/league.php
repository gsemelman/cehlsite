<?php
function moneyFormat($money,$lang) {
	if($lang == "fr") $money2 = number_format($money, 0, ',', ' ')." $";
	if($lang == "en") $money2 = "$".number_format($money, 0, '.', ',');
	return $money2;
}

$txt_league_players = $db_membre_League[3];
if($league_players == 1) $txt_league_players = $db_membre_League[4];

$txt_league_MaxPlayers = $db_membre_League[3];
if($league_MaxPlayers != 0) $txt_league_MaxPlayers = $league_MaxPlayers;

$txt_league_cap = $db_membre_League[3];
if($league_cap != 0) $txt_league_cap = moneyFormat($league_cap, $league_langue);

$txt_league_capType = $league_capType;

$txt_league_GameInProPayroll = $db_membre_League[3];
if($league_GameInProPayroll != 0) $txt_league_GameInProPayroll = $league_GameInProPayroll;

$txt_league_FarmMaxOV = $db_membre_League[3];
if($league_FarmMaxOV != 0) $txt_league_FarmMaxOV = $league_FarmMaxOV;

$txt_league_AgeExemptFarmMaxOV = $db_membre_League[3];
if($league_AgeExemptFarmMaxOV != 0) $txt_league_AgeExemptFarmMaxOV = $league_AgeExemptFarmMaxOV;

$txt_league_FarmMaxAge = $db_membre_League[3];
if($league_FarmMaxAge != 0) $txt_league_FarmMaxAge = $league_FarmMaxAge;

$txt_league_GameInProWaivers = $db_membre_League[3];
if($league_GameInProWaivers != 0) $txt_league_GameInProWaivers = $league_GameInProWaivers;

$txt_league_AgeExemptWaivers = $db_membre_League[3];
if($league_AgeExemptWaivers != 0) $txt_league_AgeExemptWaivers = $league_AgeExemptWaivers;

$txt_league_OVSkatersWaivers = $db_membre_League[3];
if($league_OVSkatersWaivers != 0) $txt_league_OVSkatersWaivers = $league_OVSkatersWaivers;

$txt_league_OVGoaliesWaivers = $db_membre_League[3];
if($league_OVGoaliesWaivers != 0) $txt_league_OVGoaliesWaivers = $league_OVGoaliesWaivers;

$txt_league_SalaryWaivers = $db_membre_League[3];
if($league_SalaryWaivers != 0) $txt_league_SalaryWaivers = moneyFormat($league_SalaryWaivers, $league_langue);

?>
<div style="font-weight:bold; margin-bottom:20px;"><?php echo $db_membre_League[0]; ?></div>
<div style="font-weight:bold;"><?php echo $db_membre_League[1]; ?></div>
<hr>
<table class="tableSpace">
<tr class="tr_content1">
	<td><?php echo $db_membre_League[2]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_players; ?></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_membre_League[5]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_MaxPlayers; ?></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_membre_League[6]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_cap; ?></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_membre_League[7]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_capType; ?></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_membre_League[8]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_GameInProPayroll; ?></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_membre_League[9]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_FarmMaxOV; ?></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_membre_League[10]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_AgeExemptFarmMaxOV; ?></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_membre_League[11]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_FarmMaxAge; ?></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_membre_League[12]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_GameInProWaivers; ?></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_membre_League[13]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_AgeExemptWaivers; ?></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_membre_League[14]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_OVSkatersWaivers; ?></td>
</tr>
<tr class="tr_content2">
	<td><?php echo $db_membre_League[15]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_OVGoaliesWaivers; ?></td>
</tr>
<tr class="tr_content1">
	<td><?php echo $db_membre_League[16]; ?></td>
	<td style="text-align:center;"><?php echo $txt_league_SalaryWaivers; ?></td>
</tr>
</table>