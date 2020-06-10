<?php

require_once 'config.php';
include 'lang.php';
include 'common.php';

include_once 'classes/RosterObj.php';
include_once 'classes/RosterAvgObj.php';
include_once 'classes/RostersHolder.php';
include_once 'classes/UnassignedHolder.php';
include_once 'classes/TeamHolder.php';
include_once 'classes/ProspectObj.php';
include_once 'classes/ProspectHolder.php';
include_once 'classes/PlayerSearchWrapper.php';
include_once 'classes/PlayerVitalObj.php';
include_once 'classes/PlayerVitalsHolder.php';
include_once 'classes/ScoringHolder.php';

$playoffs='';
if(isPlayoffs(TRANSFER_DIR, LEAGUE_MODE)){
    $playoffs = 'PLF';
}

$gmFile = getLeagueFile(TRANSFER_DIR, $playoffs, 'GMs.html', 'GMs');
$rosterFile = getLeagueFile(TRANSFER_DIR, $playoffs, 'Rosters.html', 'Rosters');
$vitalsFileName = getLeagueFile(TRANSFER_DIR, $playoffs, 'PlayerVitals.html', 'PlayerVitals');
$teamScoringFileName = getLeagueFile(str_replace("#","27",CAREER_STATS_DIR), $playoffs, 'TeamScoring.html', 'TeamScoring');

if (!file_exists($rosterFile) || !file_exists($gmFile) || !file_exists($vitalsFileName)) {
    http_response_code(500);
    exit();
}

$teams = new TeamHolder($gmFile);
$allPlayers = array();

function get_games_played($csName, $fileName){
    $Fnm = $fileName;
    $i = 0;
    $b = 0;
    $e = 0;
    $f = 0;
    $type = 0;
    $tmpFound = 0;
    if(file_exists($Fnm)) {
        $tableau = file($Fnm);
        while(list($cle,$val) = myEach($tableau)) {
            $val = utf8_encode($val);
            if(substr_count($val, 'A NAME=')) {
                $reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
                //if($lastTeam == '') $lastTeam = trim(substr($reste, strpos($reste, '>')+1));
                $b = 1;
            }
            if($b && substr_count($val, '------------')) {
                $e = 0;
                if($f == 1) {
                    $b = 0;
                    $f = 0;
                    if($tmpFound != 0) break 1;
                }
            }
            if($tmpFound == 1 && !substr_count($val, '                         ')) $tmpFound = 2;
            if($b && $e && $type != 2 && (substr_count($val, $csName) || ($tmpFound == 1 && substr_count($val, '                         '))) && !substr_count(substr($val, 0, 1), 'G')) {
                $tmpFound = 1;
                $type = 1;
                $reste = trim($val);
                if(substr_count($val, '                         ')) {
                    $statsPosition[$i] = '';
                    $statsNumber[$i] = '';
                    $statsRookie[$i] = '';
                    //$statsName[$i] = '';
                    $bold[$i] = '';
                }
                else {
                    $statsPosition[$i] = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $statsNumber[$i] = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    if(substr($reste, 0, 1) == '*') {
                        $statsRookie[$i] = substr($reste, 0, 1);
                        $reste = trim(substr($reste, 1));
                    }
                    else $statsRookie[$i] = '';
                    //$reste = trim(substr($reste, strpos($reste, '  ')));
                    $tmpFwdHT2 = 0;
                }
                $statsPS[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsGS[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsPCTG[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsS[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsHT[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsGT[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsGW[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsSHG[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsPPG[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsPIM[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsDiff[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsP[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsA[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsG[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                
                return substr($reste, strrpos($reste, ' '));
                
                $statsGP[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
                if(!substr_count($val, '                         ')) {
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    /*
                     $statsName[$i] = $reste;
                     if(substr_count($statsName[$i], 'xtrastats.html')) {
                     $statsName[$i] = trim(substr($statsName[$i], strpos($statsName[$i], '"')+1, strpos($statsName[$i], '>')-1-strpos($statsName[$i], '"')-1));
                     }
                     */
                }
                $tmpVal = $tableau[$cle+1];
                if(substr_count($tmpVal, '                         ') || (!substr_count($val, '                         ') && !substr_count($tmpVal, '                         '))) {
                    $tmpFwdHT2 += $statsHT[$i];
                }
                else $statsHT[$i] = $tmpFwdHT2;
                //$statsSeason[$i] = $workSeason;
                $i++;
            }
            if($b && $f && $type != 1 && (substr_count($val, $csName) || ($tmpFound == 1 && substr_count($val, '                         ')))) {
                $tmpFound = 1;
                $type = 2;
                $reste = trim($val);
                if(substr_count($val, '                         ')) {
                    $statsPosition[$i] = '';
                    $statsNumber[$i] = '';
                    $statsRookie[$i] = '';
                    //$statsName[$i] = '';
                }
                else {
                    $statsPosition[$i] = 'G';
                    $statsNumber[$i] = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    if(substr($reste, 0, 1) == '*') {
                        $statsRookie[$i] = substr($reste, 0, 1);
                        $reste = trim(substr($reste, 1));
                    }
                    else $statsRookie[$i] = '';
                }
                $statsAS[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsPIM[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsPCT[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsSA[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsGA[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsSO[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsT[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsL[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsW[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsAVG[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsMin[$i] = substr($reste, strrpos($reste, ' '));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsGP[$i] = substr($reste, strrpos($reste, ' '));
                
                return $statsGP[$i];
                
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $statsTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
                if(!substr_count($val, '                         ')) {
                    $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                    /*
                     $statsName[$i] = $reste;
                     if(substr_count($statsName, 'xtrastats.html')) {
                     $statsName[$i] = trim(substr($statsName[$i], strpos($statsName[$i], '"')+1, strpos($statsName[$i], '>')-1-strpos($statsName[$i], '"')-1));
                     }
                     */
                }
                //$statsSeason[$i] = $workSeason;
                $i++;
            }
            if($b && substr_count($val, 'PCTG') ) {
                $e = 1;
            }
            if($b && substr_count($val, 'AVG') ) {
                $f = 1;
            }
        }
    }
   // else echo $allFileNotFound.' - '.$Fnm;
    
    return 0;
};

    


//add roster players for each team
foreach($teams->get_teams() as $team){
    $rosterHolder = new RostersHolder($rosterFile, $team, false);
    $playerVitals = new PlayerVitalsHolder($vitalsFileName, $team);

    foreach($rosterHolder->getFarmRosters() as $roster){
        $wrapper = new PlayerSearchWrapper();
        
        $playerVital = $playerVitals->findVital($roster->getNumber(), $roster->getName());
        
        //filter players under 24 and no contract
        if($playerVital->getAge() < 24 || $playerVital-> getContractLength() == 0) {
            continue;
        }
        
        if(get_games_played($roster->getName(), $teamScoringFileName) < 20) continue;
      //  error_log($roster->getName().''.get_games_played($roster->getName(), $teamScoringFileName), 0);
        
        $wrapper->setType('Farm');
        $wrapper->setTeam($roster->getTeam());
        $wrapper->setNumber($roster->getNumber());
        $wrapper->setName($roster->getName());
        $wrapper->setPosition($roster->getPosition());
        $wrapper->setHand($roster->getHand());
        $wrapper->setCondition($roster->getCondition());
        $wrapper->setInjStatus($roster->getInjStatus());
        $wrapper->setIt($roster->getIt());
        $wrapper->setSp($roster->getSp());
        $wrapper->setSt($roster->getSt());
        $wrapper->setEn($roster->getEn());
        $wrapper->setDu($roster->getDu());
        $wrapper->setDi($roster->getDi());
        $wrapper->setSk($roster->getSk());
        $wrapper->setPa($roster->getPa());
        $wrapper->setPc($roster->getPc());
        $wrapper->setDf($roster->getDf());
        $wrapper->setSc($roster->getSc());
        $wrapper->setEx($roster->getEx());
        $wrapper->setLd($roster->getLd());
        $wrapper->setOv($roster->getOv());
        $wrapper->setAge($playerVital->getAge());
        //$wrapper->setSalary($playerVital->getSalary());
        $wrapper->setContract($playerVital->getContractLength());
        $wrapper->setSalary('$'.number_format($playerVital->getSalary()));
        
        
        array_push($allPlayers, $wrapper);
    }

}



//return data
echo '{ "data": '.json_encode($allPlayers).'}';
http_response_code(200);



?>