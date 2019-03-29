<?php

$i = 0;

include GMO_ROOT.'login/mysqli.php';

//include 'gmo/login/mysqli.php';
$sql = "SELECT `EQUIPESIM`, `IP` FROM `".$db_table."` WHERE `EQUIPESIM` != '' ORDER BY `IP` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$bd_equipesim[$i] = $data['EQUIPESIM'];
	$bd_ip[$i] = $data['IP'];
	$i++;
}
mysqli_close($con);

echo '<br><b>'.$db_admin_triche_langue[0].'</b><br>'.$db_admin_triche_langue[1].'<br>';
echo '<table class="table" style="margin-top:25px;"><tr class="tr"><td>'.$db_admin_triche_langue[2].'</td><td>IP</td></tr>';

$colorRow = 2;
for($i=0;$i<count($bd_equipesim);$i++){
	if($colorRow == 1) $colorRow = 2;
	else $colorRow = 1;
	echo '<tr class="tr_content'.$colorRow.'"><td>'.$bd_equipesim[$i].'</td><td>'.$bd_ip[$i].'</td></tr>';
}
echo '</table>';
?>