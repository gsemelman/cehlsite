<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$id = $_POST['id'];

require_once __DIR__ .'/../../config.php';
include '../login/mysqli.php';

$id = mysqli_real_escape_string($con, $id);

$sql = "DELETE FROM `".$db_table."_trade` WHERE `INT` = '$id';";
$query = mysqli_query($con, $sql);

mysqli_close($con);

echo 'done';
?>