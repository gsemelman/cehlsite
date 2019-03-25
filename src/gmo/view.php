<!DOCTYPE html>
<html>
<head>
<title>GMO - VIEW</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="author" content="Éric Leclerc">
</head>
<body>


<?php
if(file_exists('gmo/config4.php')) {
	include 'gmo/config4.php';
}
else {
	echo '<a href="install/">Please install the Online GM Editor! - Installer le GM Editor en ligne S.V.P.</a>';
	exit();
}

include 'login/mysqli.php';
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$SessionName = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_langue' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_langue = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_name' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_name = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$file_folder = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder_lines' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$file_folder_lines = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_cap' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_cap = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_capType' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_capType = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_GameInProPayroll' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_GameInProPayroll = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_players' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_players = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_MaxPlayers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_MaxPlayers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_FarmMaxOV' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_FarmMaxOV = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_AgeExemptFarmMaxOV' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_AgeExemptFarmMaxOV = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_FarmMaxAge' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_FarmMaxAge = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_GameInProWaivers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_GameInProWaivers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_AgeExemptWaivers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_AgeExemptWaivers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_OVSkatersWaivers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_OVSkatersWaivers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_OVGoaliesWaivers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_OVGoaliesWaivers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_SalaryWaivers' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_SalaryWaivers = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_gmeditor' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_gmeditor = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_last_update' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$file_last_update = $data['VALUE'];
	}
}

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_editorPassword' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_editorPassword = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_capInjured' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_capInjured = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$TimeZone = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_TradeToolStatus' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_TradeToolStatus = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_TradeToolDraft' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_TradeToolDraft = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_TradeToolDraftRounds' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_TradeToolDraftRounds = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_TradeToolDisplay' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_TradeToolDisplay = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_TradeToolOtherMandatory' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_TradeToolOtherMandatory = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_UFAToolStatus' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_UFAToolStatus = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_position' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$league_position = $data['VALUE'];
	}
}

mysqli_close($con);
?>

<table style="border:1px solid #000000; padding:5px; font-family:Arial;">
<tr>
<td>VERSION</td>
<td>VERSION</td>
<td></td>
<td>4.01</td>
</tr>

<tr>
<td>NOM DE SESSION</td>
<td>SESSION NAME</td>
<td></td>
<td><?php echo $SessionName; ?></td>
</tr>

<tr>
<td>Serveur Base de donnée</td>
<td>Database Server</td>
<td></td>
<td><?php echo $db_server; ?></td>
</tr>
<tr>
<td>Nom Base de donnée</td>
<td>Database Name</td>
<td></td>
<td><?php echo $db_name; ?></td>
</tr>
<tr>
<td>Table Base de donnée</td>
<td>Database Table</td>
<td></td>
<td><?php echo $db_table; ?></td>
</tr>
<tr>
<td>Utilisateur Base de donnée</td>
<td>Database Username</td>
<td></td>
<td><?php echo $db_username; ?></td>
</tr>

<tr>
<td>Dossier fichiers ligue</td>
<td>League files directory</td>
<td></td>
<td><?php echo $file_folder; ?></td>
</tr>
<tr>
<td>Dossier fichiers lignes</td>
<td>Lines files directory</td>
<td></td>
<td><?php echo $file_folder_lines; ?></td>
</tr>
<tr>
<td>Nom de la ligue</td>
<td>League Name</td>
<td></td>
<td><?php echo $league_name; ?></td>
</tr>
<tr>
<td>Langue de la ligue</td>
<td>League Language</td>
<td></td>
<td><?php echo $league_langue; ?></td>
</tr>
<tr>
<td>Envoie de fichiers ligne</td>
<td>Send line Files</td>
<td>Avec / With : 1 | Sans / Wihtout : 0</td>
<td><?php echo $league_gmeditor; ?></td>
</tr>
<tr>
<td>Champ Mot de Passe</td>
<td>Password Field</td>
<td>Avec / With : 1 | Sans / Wihtout : 0</td>
<td><?php echo $league_editorPassword; ?></td>
</tr>

<tr>
<td>Plafond Salarial</td>
<td>Salary Cap</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_cap; ?></td>
</tr>
<tr>
<td>Type Plafond Salarial</td>
<td>Salary Cap Type</td>
<td>PRO Only : 0 / Pro + Farm Payroll : 1</td>
<td><?php echo $league_capType; ?></td>
</tr>
<tr>
<td>Calcul Joueurs Blessés</td>
<td>Injured Player Calculated</td>
<td>Off : 0 / On : 1</td>
<td><?php echo $league_capInjured; ?></td>
</tr>
<tr>
<td>Con. 2 sens après</td>
<td>2-way Con After</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_GameInProPayroll; ?></td>
</tr>
<tr>
<td>Joueurs obligatoires dans l'alignement</td>
<td>Mandatory players in lineup</td>
<td>Off : 0 / On : 1</td>
<td><?php echo $league_players; ?></td>
</tr>
<tr>
<td>Joueurs pro maximum</td>
<td>Max pro player</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_MaxPlayers; ?></td>
</tr>

<tr>
<td>OV Club-école Max</td>
<td>Farm OV Max</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_FarmMaxOV; ?></td>
</tr>
<tr>
<td>OV Club-école Max, Age Exemption</td>
<td>Age Exempt, Farm OV Max</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_AgeExemptFarmMaxOV; ?></td>
</tr>
<tr>
<td>Age Club-école Max</td>
<td>Farm Age Max</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_FarmMaxAge; ?></td>
</tr>

<tr>
<td>Waivers - Partie Jouée</td>
<td>Waivers - Game Played</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_GameInProWaivers; ?></td>
</tr>
<tr>
<td>Waivers - Age minimum</td>
<td>Waivers - Minimum Age</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_AgeExemptWaivers; ?></td>
</tr>
<tr>
<td>Waivers - OV avant minimum</td>
<td>Waivers - Minimum Skaters OV</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_OVSkatersWaivers; ?></td>
</tr>
<tr>
<td>Waivers - OV gardien minimum</td>
<td>Waivers - Minimum Goalie OV</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_OVGoaliesWaivers; ?></td>
</tr>
<tr>
<td>Waivers - Salary minimum</td>
<td>Waivers - Minimum Salary</td>
<td>Aucune limit / No restrition : 0</td>
<td><?php echo $league_SalaryWaivers; ?></td>
</tr>

<tr>
<td>Fuseau Horaire</td>
<td>TimeZone</td>
<td></td>
<td><?php echo $TimeZone; ?></td>
</tr>

<tr>
<td>Zone Échange</td>
<td>Trade Area</td>
<td>0: Off / 1: History / 2: On</td>
<td><?php echo $league_TradeToolStatus; ?></td>
</tr>
<tr>
<td>Choix #</td>
<td>Draft #</td>
<td></td>
<td><?php echo $league_TradeToolDraft; ?></td>
</tr>
<tr>
<td>Ronde max</td>
<td>Max Round</td>
<td></td>
<td><?php echo $league_TradeToolDraftRounds; ?></td>
</tr>
<tr>
<td>Échange en attente</td>
<td>Pending Trade</td>
<td>0: Displayed / 1: Hidden</td>
<td><?php echo $league_TradeToolDisplay; ?></td>
</tr>
<tr>
<td>Champ Autre</td>
<td>Other Field</td>
<td>0: Optionnal / 1: Mandatory</td>
<td><?php echo $league_TradeToolOtherMandatory; ?></td>
</tr>

<tr>
<td>Agents Libres</td>
<td>Free Agents</td>
<td>0: Off / 1:History / 2: On</td>
<td><?php echo $league_UFAToolStatus; ?></td>
</tr>

<tr>
<td>Chamgement de Position</td>
<td>Position Change</td>
<td>0: Off / 1: On</td>
<td><?php echo $league_position; ?></td>
</tr>


<tr>
<td>Mise à jour .ROS</td>
<td>.ROS Upgrade</td>
<td>Date et heure / Datetime</td>
<td><?php echo $file_last_update; ?></td>
</tr>
</table>
<?php echo '<br>PHP Version: '.phpversion(); ?>
</body>
</html>