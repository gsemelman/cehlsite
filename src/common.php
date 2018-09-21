<?php
function myEach(&$arr) {
    $key = key($arr);
    $result = ($key === null) ? false : [$key, current($arr), 'key' => $key, 'value' => current($arr)];
    next($arr);
    return $result;
}

function getLeagueFile($rootFolder, $playoff, $fileName, $name) {
    
    if (! isset($playoff))
        $playoff = '';
    
    $matches = glob($rootFolder . '*' . $playoff . $fileName);
    $folderLeagueURL = '';
    $matchesDate = array_map('filemtime', $matches);
    arsort($matchesDate);
    foreach ($matchesDate as $j => $val) {
        if ((! substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
            $folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/') + 1, strpos($matches[$j], $name) - strrpos($matches[$j], '/') - 1);
            break 1;
        }
    }
    return $rootFolder.$folderLeagueURL . $fileName;
}

?>