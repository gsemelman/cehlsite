<?php
if( !empty($_POST) )
{
    error_reporting(E_ALL);
    ini_set("display_errors", "On");
}


require_once __DIR__ .'/../../config.php';
include_once GMO_ROOT.'membre/lang.php';
include GMO_ROOT.'login/mysqli.php';


$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $file_folder = GMO_ROOT.$data['VALUE'];
    }
}

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_last_update' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $file_lastUpdate = $data['VALUE'];
    }
}

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $TimeZone = $data['VALUE'];
    }
}
date_default_timezone_set($TimeZone);

error_log('league files last update: '.$file_lastUpdate,0);

mysqli_close($con);

// Find the .ros and .tms
$matches = glob($file_folder.'*.ros');
if(isset($matches) && count($matches)) {
    $matchesDate = array_map('filemtime', $matches);
    arsort($matchesDate);
    foreach ($matchesDate as $j => $val) {
        break 1;
    }
    if(substr_count($matches[$j],"/")) $file_ros = substr($matches[$j],strrpos($matches[$j],"/")+1);
    else $file_ros = $matches[$j];
}
$matches = glob($file_folder.'*.tms');
if(isset($matches) && count($matches)) {
    $matchesDate = array_map('filemtime', $matches);
    arsort($matchesDate);
    foreach ($matchesDate as $j => $val) {
        break 1;
    }
    if(substr_count($matches[$j],"/")) $file_tms = substr($matches[$j],strrpos($matches[$j],"/")+1);
    else $file_tms = $matches[$j];
}

// Update the .ros if new
if(isset($file_ros) && isset($file_tms)) {
    $file_date = date ("Y-m-d H:i:s", filemtime($file_folder.$file_ros));
    
    error_log("checking for new new files!!!!!",0);
    
    $d1 = new DateTime($file_date);
    $d2 = new DateTime($file_lastUpdate);
    
    error_log("old file date:". $d1->format('Y-m-d H:i:s'). ' new file date:' .$d2->format('Y-m-d H:i:s'),0);
    error_log($d1 > $d2);
    
    if($d1 > $d2) {
        error_log("loading new files!!!!!",0);
        include GMO_ROOT.'editor/file_to_sql.php';
        $txtFileUpdated =  $db_membre_File_Update[1].'<br><br>';
        error_log("new files loaded!!!!!",0);
    }
}
else {
    $error = '<br>'.$db_membre_File_Update[0].'<br>';
    die($error);
}


?>