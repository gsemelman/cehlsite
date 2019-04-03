<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$id = $_POST['id'];
$ntc = $_POST['ntc'];

require_once __DIR__ .'/../../config.php';
include '../login/mysqli.php';

$sql = "UPDATE `".$db_table."_ufalist` SET `NTC`='$ntc' WHERE `INT`='$id';";
$query = mysqli_query($con, $sql);

mysqli_close($con);

echo 'done';
?>