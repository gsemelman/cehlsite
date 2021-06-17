<?php
extract($_POST,EXTR_OVERWRITE);

if(isset($changer)) {
    include GMO_ROOT.'login/mysqli.php';
	$sql = "UPDATE ".$db_table." SET `SEND`='0' WHERE `EQUIPESIM` != ''";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
	$message = 1;
}

if(isset($message)) echo '<br><b>'.$db_admin_actif_langue[1].'</b><br>';
echo '<br><b>'.$db_admin_actif_langue[0].'</b><br>';

// LISTE DES ÉQUIPES ET # DENVOIE DE LIGNE
$i = 0;
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `EQUIPESIM`, `SEND` FROM ".$db_table." WHERE `EQUIPESIM`!='' ORDER BY `EQUIPESIM` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
		$bd_team_list[$i] = $data['EQUIPESIM'];
		$bd_team_send[$i] = $data['SEND'];
		if(!$bd_team_send[$i]) $bd_team_send[$i] = '0';
		$i++;
}
mysqli_close($con);

$date = date("Y-m-d H:i:s");
$date_av = date('Y-m-d H:i:s', strtotime('-10 minute'));
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `EQUIPESIM` FROM ".$db_table." WHERE `LAST` BETWEEN '$date_av' AND '$date' AND `EQUIPESIM`!='' ORDER BY `INT` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$i = 0;
	while($data['EQUIPESIM']!=$bd_team_list[$i]){
		$i++;
	}
	$bd_lasts_ten[$i] = 'X';
}
mysqli_close($con);

$date_av = date('Y-m-d H:i:s', strtotime('-1 hour'));

include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `EQUIPESIM`, `EQUIPE` FROM ".$db_table." WHERE `LAST` BETWEEN '$date_av' AND '$date' AND `EQUIPESIM`!='' ORDER BY `INT` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$i = 0;
	while($data['EQUIPESIM']!=$bd_team_list[$i]){
		$i++;
	}
	$bd_lasts_hour[$i] = 'X';
}
mysqli_close($con);


$date_av = date('Y-m-d H:i:s', strtotime('-1 day'));
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `EQUIPESIM`, `EQUIPE` FROM ".$db_table." WHERE `LAST` BETWEEN '$date_av' AND '$date' AND `EQUIPESIM`!='' ORDER BY `INT` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$i = 0;
	while($data['EQUIPESIM']!=$bd_team_list[$i]){
		$i++;
	}
	$bd_lasts_day[$i] = 'X';
}
mysqli_close($con);


$date_av = date('Y-m-d H:i:s', strtotime('-2 days'));
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `EQUIPESIM`, `EQUIPE` FROM ".$db_table." WHERE `LAST` BETWEEN '$date_av' AND '$date' AND `EQUIPESIM`!='' ORDER BY `INT` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$i = 0;
	while($data['EQUIPESIM']!=$bd_team_list[$i]){
		$i++;
	}
	$bd_lasts_2day[$i] = 'X';
}
mysqli_close($con);

$date_av = date('Y-m-d H:i:s', strtotime('-1 week'));
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `EQUIPESIM`, `EQUIPE` FROM ".$db_table." WHERE `LAST` BETWEEN '$date_av' AND '$date' AND `EQUIPESIM`!='' ORDER BY `INT` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$i = 0;
	while($data['EQUIPESIM']!=$bd_team_list[$i]){
		$i++;
	}
	$bd_lasts_week[$i] = 'X';
}
mysqli_close($con);

$date_av = date('Y-m-d H:i:s', strtotime('-2 week'));
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `EQUIPESIM`, `EQUIPE` FROM ".$db_table." WHERE `LAST` BETWEEN '$date_av' AND '$date' AND `EQUIPESIM`!='' ORDER BY `INT` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$i = 0;
	while($data['EQUIPESIM']!=$bd_team_list[$i]){
		$i++;
	}
	$bd_lasts_2week[$i] = 'X';
}
mysqli_close($con);

$date_av = date('Y-m-d H:i:s', strtotime('-1 month'));
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `EQUIPESIM`, `EQUIPE` FROM ".$db_table." WHERE `LAST` BETWEEN '$date_av' AND '$date' AND `EQUIPESIM`!='' ORDER BY `INT` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$i = 0;
	while($data['EQUIPESIM']!=$bd_team_list[$i]){
		$i++;
	}
	$bd_lasts_month[$i] = 'X';
}
mysqli_close($con);


// TABLEAU
echo '<br>'.$db_admin_actif_langue[2].'<br>'.$db_admin_actif_langue[3];

echo '<table class="table"><tr class="tr">
<td>'.$db_admin_actif_langue[4].'</td>
<td style="width:50px;">'.$db_admin_actif_langue[5].'</td>
<td>'.$db_admin_actif_langue[6].'</td>
<td>'.$db_admin_actif_langue[7].'</td>
<td>'.$db_admin_actif_langue[8].'</td>
<td>'.$db_admin_actif_langue[9].'</td>
<td>'.$db_admin_actif_langue[10].'</td>
<td>'.$db_admin_actif_langue[11].'</td>
<td>'.$db_admin_actif_langue[12].'</td></tr>';
$colorRow = 2;
for($i=0; $i<count($bd_team_list);$i++){
	if($colorRow == 1) $colorRow = 2;
	else $colorRow = 1;
	echo '<tr class="tr_content'.$colorRow.'">';
	if(isset($bd_team_list[$i])) echo '<td>'.$bd_team_list[$i].'</td>';
	else echo '<td></td>';
	if(isset($bd_team_send[$i])) echo '<td>'.$bd_team_send[$i].'</td>';
	else echo '<td></td>';
	if(isset($bd_lasts_ten[$i])) echo '<td>'.$bd_lasts_ten[$i].'</td>';
	else echo '<td></td>';
	if(isset($bd_lasts_hour[$i])) echo '<td>'.$bd_lasts_hour[$i].'</td>';
	else echo '<td></td>';
	if(isset($bd_lasts_day[$i])) echo '<td>'.$bd_lasts_day[$i].'</td>';
	else echo '<td></td>';
	if(isset($bd_lasts_2day[$i])) echo '<td>'.$bd_lasts_2day[$i].'</td>';
	else echo '<td></td>';
	if(isset($bd_lasts_week[$i])) echo '<td>'.$bd_lasts_week[$i].'</td>';
	else echo '<td></td>';
	if(isset($bd_lasts_2week[$i])) echo '<td>'.$bd_lasts_2week[$i].'</td>';
	else echo '<td></td>';
	if(isset($bd_lasts_month[$i])) echo '<td>'.$bd_lasts_month[$i].'</td>';
	else echo '<td></td>';
	echo '</tr>';
}
echo '<tr class="tr">
<td>'.$db_admin_actif_langue[4].'</td>
<td>'.$db_admin_actif_langue[5].'</td>
<td>'.$db_admin_actif_langue[6].'</td>
<td>'.$db_admin_actif_langue[7].'</td>
<td>'.$db_admin_actif_langue[8].'</td>
<td>'.$db_admin_actif_langue[9].'</td>
<td>'.$db_admin_actif_langue[10].'</td>
<td>'.$db_admin_actif_langue[11].'</td>
<td>'.$db_admin_actif_langue[12].'</td></tr>';
echo '</table>';
//echo '<form method="post" action="index.php?admin=actif">';
echo '<form method="post" action="MyCehl.php?admin=actif#Admin">';
echo '<br>'.$db_admin_actif_langue[14];
echo '<br><input style="width:150px;" class="button" type="submit" value="'.$db_admin_actif_langue[13].'" name="changer"></form>';
?>