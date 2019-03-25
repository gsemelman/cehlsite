<?php
$con = mysqli_connect($db_server,$db_username,$db_password);
if (!mysqli_connect_errno()) {
	mysqli_select_db($con,$db_name);
	mysqli_set_charset($con,"utf8");
}
else echo "Failed to connect to MySQL: " . mysqli_connect_error();
?>