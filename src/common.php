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

function getLeagueFile2($rootFolder, $playoff, $fileName, $name, $exclude) {
    
    if (! isset($playoff))
        $playoff = '';
        
        $matches = glob($rootFolder . '*' . $playoff . $fileName);
        $folderLeagueURL = '';
        $matchesDate = array_map('filemtime', $matches);
        arsort($matchesDate);
        foreach ($matchesDate as $j => $val) {

            if(isset($exclude) && $exclude != '' && substr_count($matches[$j], $exclude)){
               continue; 
            }
            
            if ((! substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
                $folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/') + 1, strpos($matches[$j], $name) - strrpos($matches[$j], '/') - 1);
                break 1;
            }
        }
        return $rootFolder.$folderLeagueURL . $fileName;
}

function isPlayoffs($rootFolder, $playoffMode){

    if (!isset($playoffMode)){
        $playoffMode = 0;
    }
    
    if($playoffMode == 0){
        if(!empty(glob($rootFolder . '*PLFGMs.html'))){
            return true;
        }
    }else{
        if($playoffMode == 2){
            return true;
        }
    }
    
    return false;
}

function getFilteredArray($aFilterKey, $aFilterValue, $array) {
    $filtered_array = array();
    foreach ($array as $value) {
        
        if (isset($value->$aFilterKey)) {
            if($aFilterValue == $value->$aFilterKey){
                $filtered_array[] = $value;
            }
        }
        
    }
    
    return $filtered_array;
}


?>