<?php

include 'config.php';
include 'lang.php';
include 'common.php';

include_once 'classes/RosterObj.php';
include_once 'classes/RosterAvgObj.php';
include_once 'classes/RostersHolder.php';
include_once 'classes/UnassignedHolder.php';
include_once 'classes/TeamHolder.php';


$gmFile = getLeagueFile($folder, '', 'GMs.html', 'GMs');
$rosterFile = getLeagueFile($folder, '', 'Rosters.html', 'Rosters');
$unassignedFile = getLeagueFile($folder, '', 'Unassigned.html', 'Unassigned');

if (!file_exists($rosterFile) || !file_exists($gmFile)) {
    http_response_code(400);
    exit();
}

$allPlayers = array();

$teams = new TeamHolder($gmFile);

foreach($teams->get_teams() as $team){
    $rosterHolder = new RostersHolder($rosterFile, $team, false);
    
    $allPlayers = array_merge($allPlayers, $rosterHolder->getProRosters(), $rosterHolder->getFarmRosters());
}

$unassignedHolder = new UnassignedHolder($unassignedFile);

$allPlayers = array_merge($allPlayers,$unassignedHolder->getUnassigned());


$a = 0;
$b = 0;
$c = 1;
$d = 1;
$propects = array();
$futuresFile = getLeagueFile($folder, '', 'Futures.html', 'Futures');
if(file_exists($futuresFile)) {
    $tableau = file($futuresFile);
    while(list($cle,$val) = myEach($tableau)) {
        $val = utf8_encode($val);

        if(substr_count($val, 'A NAME=')) {
            $d = 1;
            $b = 1;
            
            $pos = strpos($val, '</A>');
            $pos = $pos - 23;
            $team = trim(substr($val, 23, $pos));
      
        }

//         if($a >= 2 && $a <= 7 && substr_count($val, '<B>') && $b && $d) {
//             if($c == 1) $c = 2;
//             else $c = 1;
            
//             $a++;
//         }
        if($a == 1 && $b && $d) {
            $pos = strpos($val, '<');
            $tmpProspect = substr($val, 0, $pos).',';
            $tmpCount = substr_count($tmpProspect, ',');
            for($i=0;$i<$tmpCount;$i++) {
                if($c == 1) $c = 2;
                else $c = 1;
                $tmp = trim(substr($tmpProspect, 0, strpos($tmpProspect, ',')));
                $tmpProspect = substr($tmpProspect, strpos($tmpProspect, ',')+1);
                
                
                $roster = new RosterObj();
                $roster->setTeam('Prospect');
                $roster->setNumber('N/A');
                $roster->setName($tmp);
                $roster->setPosition('N/A');
                $roster->setHand('N/A');
                $roster->setCondition('N/A');
                $roster->setInjStatus('N/A');
                $roster->setIt('N/A');
                $roster->setSp('N/A');
                $roster->setSt('N/A');
                $roster->setEn('N/A');
                $roster->setDu('N/A');
                $roster->setDi('N/A');
                $roster->setSk('N/A');
                $roster->setPa('N/A');
                $roster->setPc('N/A');
                $roster->setDf('N/A');
                $roster->setSc('N/A');
                $roster->setEx('N/A');
                $roster->setLd('N/A');
                $roster->setOv('N/A');
                
                array_push($propects, $roster);
              
            }
            
            $a = 2;
            $c = 1;
        }
        if(substr_count($val, '<H4>Prospects</H4>') && $b && $d) {
            $a = 1;
        }
        
    }
    
}

$allPlayers = array_merge($allPlayers,$propects);
//$allPlayers =$propects;

//return data
echo '{ "data": '.json_encode($allPlayers).'}';
http_response_code(200);



?>