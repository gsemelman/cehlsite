<?php
include 'login/mysqli.php';

// Get Colors from database
$sql = "SELECT `NAME`, HEX(`COLOR`) AS COLOR FROM `".$db_table."_colors`";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$tmpName = $data['NAME'];
		$tmpColor = $data['COLOR'];
		echo 'var '.$tmpName.' = "#'.$tmpColor.'";<br>';
	}
}

mysqli_close($con);

?>