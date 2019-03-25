<?php
$step = 1;
if(isset($_GET['step']) || isset($_POST['step']) ){
	$step = htmlspecialchars(( isset($_GET['step']) ) ? $_GET['step'] : $_POST['step']);
}
$nextStep = $step + 1;

if(file_exists('config.php') && $step == 1) {
	unlink('config.php');
	echo 'config.php deleted!<br>';
}
if(file_exists('config2.php') && $step == 1) {
	unlink('config2.php');
	echo 'config2.php deleted!<br>';
}
if(is_dir('install') && $step == 1) {
	$dir = 'install';
	$files = array_diff(scandir($dir), array('.','..'));
	foreach ($files as $file) {
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
	} 
	rmdir($dir);
	echo 'install/ deleted!<br>';
}

echo '<div style="font-weight:bold; font-size:14px; width:100%; padding:5px; background-color:#bbbbbb; color:#ffff00">';
if($step == 1)	echo $db_admin_assist_langue[3].' <a href="?admin=first&step=2">'.$db_admin_assist_langue[5].'</a>';
if($step == 2)	echo $db_admin_assist_langue[0].' <a href="?admin=first&step=3">'.$db_admin_assist_langue[5].'</a>';
if($step == 3)	echo $db_admin_assist_langue[2].' <a href="?admin=first&step=4">'.$db_admin_assist_langue[5].'</a>';
if($step == 4)	echo $db_admin_assist_langue[6].' <a href="?admin=first&step=5">'.$db_admin_assist_langue[5].'</a>';
if($step == 5)	echo $db_admin_assist_langue[7].' <a href="?admin=first&step=6">'.$db_admin_assist_langue[5].'</a>';
if($step == 6)	echo $db_admin_assist_langue[8];
echo '</div>';

if($step == 1) include 'admin/password.php';
if($step == 2) include 'admin/param.php';
if($step == 3) include 'admin/upload.php';
if($step == 4) include 'admin/userpass.php';
if($step == 5) include 'admin/noms.php';
if($step == 6) {
	echo $league_name.'<br>';	
	include 'admin/accueil.php';
}
?>