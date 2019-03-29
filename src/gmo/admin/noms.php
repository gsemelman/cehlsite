<?php
extract($_POST,EXTR_OVERWRITE);

if(isset($nom_team)) {
	$i = 0;
	include GMO_ROOT.'login/mysqli.php';
	while(isset($_POST['new_int'.$i])) {
		$nom_full2 = mysqli_real_escape_string($con, $_POST['nom_full'.$i]);
		$new_int2 = $_POST['new_int'.$i];
		$sql = "UPDATE `".$db_table."` SET `EQUIPE`='$nom_full2' WHERE `INT` = '$new_int2'"; 
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		$i++;
	}
	mysqli_close($con);
	if($i!=0) $nameSaved = 1;
}

$i = 0;
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `EQUIPE`, `INT` FROM `".$db_table."` WHERE `EQUIPESIM` != '' ORDER BY `INT` ASC";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	$bd_equipe[$i] = $data['EQUIPE'];
	$bd_int[$i] = $data['INT'];
	$i++;
}
mysqli_close($con);

$link = 'admin=noms';
if(isset($step) && $step == 5) {
	$link = 'admin=first&step='.$step;
}
if(isset($nameSaved) && $nameSaved == 1) {
	$tmpNext = '';
	if(isset($step) && $step == 5) $tmpNext = ' - <a href="?admin=first&step='.$nextStep.'">'.$db_admin_assist_langue[1].'</a>';
	echo '<span style="display:block; font-weight:bold; color:green; padding-top:25px;">'.$db_admin_noms_langue[2].$tmpNext.'</span>';
}
?>

<form method="post" action="index.php?<?php echo $link; ?>">
<br><b><?php echo $db_admin_noms_langue[0]; ?></b><br><?php echo $db_admin_noms_langue[1]; ?><br>
<?php
for($i=0;$i<count($bd_equipe);$i++){
	echo '<br><input class="inputText" type="text" name="nom_full'.$i.'" size="50" value="'.$bd_equipe[$i].'"><input type="hidden" value="'.$bd_int[$i].'" name="new_int'.$i.'">';
}
?>
<br><br><input class="button" type="submit" value="<?php echo $db_admin_all_langue[1]; ?>" name="nom_team">
</form>