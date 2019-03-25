<?php
$folder = $_POST['folder'];
chdir('../');
if($folder != '') chdir($folder);

$found = 0;
$dir = scandir(getcwd());
for($i=0;$i<count($dir);$i++) {
	if(!is_dir($dir[$i])) {
		$info = pathinfo($dir[$i]);
		if (isset($info["extension"]) && ($info["extension"] == "tms" || $info["extension"] == "ros")) {
			$found = 1;
			break 1;
		}
	}
}

if($found == 1) echo 'FOUND';
echo '|$|';
echo getcwd();

?>