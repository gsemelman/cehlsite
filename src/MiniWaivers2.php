<?php
//$currentTeam = '';
include 'class_lib.php';
include 'config.php';
include 'lang.php';
$CurrentHTML = 'MiniWaivers';
$CurrentTitle = 'Waivers';
$CurrentPage = 'MiniWaivers';

?>

<div class = "container">
<div class = "row">
<div class = "col">
<div class = "table-responsive">
<table class="table table-sm">

<?php
if(!isset($playoff)) $playoff = '';
if($playoff == 1) $playoff = 'PLF';
$matches = glob($folder.'*'.$playoff.'Waivers.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Waivers')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'Waivers.html';

if(file_exists($Fnm)) {
	$waivers = new Waivers($Fnm);
	$isnull = null !== $waivers->get_waivers();
	print "Is null? = $isnull";
	$records = $waivers->get_waivers();
	
/* 	foreach($records as $waiver){
		echo 'getting waiver' . ' ' . $waiver->player;
	} */
}
else echo '<h3>'.$allFileNotFound.' - '.$Fnm.'</h3>';

?>