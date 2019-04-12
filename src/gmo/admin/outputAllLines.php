<?php

require_once __DIR__ .'/../../config.php';
include FS_ROOT.'common.php';
include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
		$TimeZone = $data['VALUE'];
	}
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_folder_lines' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
	while($data = mysqli_fetch_array($query)) {
	    $file_folder_lines = GMO_ROOT.$data['VALUE'];
	}
}

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'file_last_update' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $file_lastUpdate = $data['VALUE'];
    }
}

function ascii2hex($ascii) {
    $hex = '';
    for ($i = 0; $i < strlen($ascii); $i++) {
        $byte = strtoupper(dechex(ord($ascii{$i})));
        $byte = str_repeat('0', 2 - strlen($byte)).$byte;
        $hex.=$byte." ";
    }
    return $hex;
}

session_name(SESSION_NAME);
session_start();

if(!isAuthenticated() || !isAdmin()){
   http_response_code(401);
   exit;
}

//$LNSPasswd = ascii2hex('          '); // Default No Password
$LNSPasswd = '20202020202020202020'; // Default No Password (10 blank spaces)

$teasData = array();

$teamsProcessed = 0;
$game1LinesSaved = 0;
$game2LinesSaved = 0;

$sql = "SELECT `EQUIPE`,`RANK`,TMS_LINEUP,LNS_FILE,LNS_DATE,LNS_FILE2,LNS_DATE2  FROM `$db_table` WHERE USER <> 'ADMIN'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $sqlLineup  = $data['TMS_LINEUP'];
        $sqlTeam = $data['EQUIPE'];
        $sqlRank = $data['RANK'];
        $teamLineFile = $data['LNS_FILE'];
        $teamLineDate = $data['LNS_DATE'];
        $teamLineFile2 = $data['LNS_FILE2'];
        $teamLineDate2 = $data['LNS_DATE2'];

        //default to team lineup
        //$game1Lines = '';
        //$game2Lines = '';
        
        //check for game1 lines being set
        if(!empty($teamLineFile) && !empty($teamLineDate)){
            $d1 = new DateTime($teamLineDate);
            $d2 = new DateTime($file_lastUpdate);

            //if updated since last updated use lines for game 1
            if($d1 > $d2) {
                $game1Lines = substr($teamLineFile, 22, 130); // Get the lineup only!
            }
        }
        if(!isset($game1Lines)){
            $game1Lines = $sqlLineup;
        }
        
        //check for game 2 lines being set
        if(!empty($teamLineFile2) && !empty($teamLineDate2)){
            $d1 = new DateTime($teamLineDate2);
            $d2 = new DateTime($file_lastUpdate);
            
            //if updated since last updated use lines for game 1
            if($d1 > $d2) {
                $game2Lines = substr($teamLineFile2, 22, 130); // Get the lineup only!
            }
        }
        if(!isset($game2Lines)){
            $game2Lines = $game1Lines;
        }

        array_push($teasData, array($sqlRank, $sqlTeam , $game1Lines, $game2Lines));
    }

}

foreach($teasData as $teamArray){
    
    
    $teamRank = $teamArray[0];
    $teamFHLSimName = $teamArray[1];

//    error_log('processing team: '.$teamFHLSimName.' teamRank: '.$teamRank);
    
    $LNSTMRank = dechex($teamRank);
    if(strlen($LNSTMRank) == 1) $LNSTMRank = "0".$LNSTMRank;
    
    
    $gamesToProcess = 2;
    //iterate for each game to output.
    for ($x = 1; $x <= $gamesToProcess; $x++) {
        
        $LNSGame = $x;
        if($LNSGame == 1){
            $LNSLineup  = $teamArray[2];
            $newfile = $file_folder_lines.$teamFHLSimName.".lns";
            $S_STAT = 'SAVE_STAT';
            $S_PROT = 'SAVE_PROT';
        }else{
            $LNSLineup  = $teamArray[3];
            $newfile = $file_folder_lines.'game'.$LNSGame.'/'.$teamFHLSimName.".lns";
            $S_STAT = 'SAVE_STAT2';
            $S_PROT = 'SAVE_PROT2';
        }
        
        // Player Stats & Player Protection
        $LNSStatPl = "";
        $LNSProtec = "";
        for($i=0;$i<50;$i++) {
            //$sql = "SELECT `SAVE_STAT`, `SAVE_PROT` FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' AND `RANK` = '$i'";
            $sql = "SELECT `$S_STAT` AS SAVE_STAT, `$S_PROT` AS SAVE_PROT FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' AND `RANK` = '$i'";
            $query = mysqli_query($con, $sql) or die(mysqli_error($con));
            if(mysqli_num_rows($query) != 0) {
                while($data = mysqli_fetch_array($query)) {
                    $tmpPlayerStat = dechex($data['SAVE_STAT']);
                    if(strlen($tmpPlayerStat) == 1) $LNSStatPl .= "0".$tmpPlayerStat;
                    else $LNSStatPl .= $tmpPlayerStat;
                    
                    if($data['SAVE_PROT'] == 1) $LNSProtec .= "FFFF";
                    else $LNSProtec .= "0000";
                }
            }
            else {
                $LNSStatPl .= "00";
                $LNSProtec .= "0000";
            }
        }
        


        if(is_readable($newfile) ) {
            error_log("File Already exists. Skipping outputting game file for game: ".$LNSGame.' Team: '.$teamFHLSimName);
            continue;
        }
        
        error_log("Outputting game".$LNSGame);
        
        // Creating LNS File
        $LNS_File = $LNSTMRank.$LNSPasswd.$LNSLineup.strtoupper($LNSStatPl).$LNSProtec;
        
        // Saving the LNS File to the server
        $output = pack('H*', $LNS_File);

        $file = fopen ($newfile, "w");
        fwrite($file, $output);
        fclose ($file);
        
        if($LNSGame == 1){
            $game1LinesSaved++;
        }else{
            $game2LinesSaved++;
        }
        
    } 
    
    $teamsProcessed++;

}

mysqli_close($con);

if($teamsProcessed == 0){
    echo '{"status":"FAILED", "teamsProcessed":'.$teamsProcessed.', "game1output":'.$game1LinesSaved.', "game2output":'.$game2LinesSaved.'}';
    header("Content-Type: application/json", true);
    http_response_code(500);
}


echo '{"status":"DONE", "teamsProcessed":'.$teamsProcessed.', "game1output":'.$game1LinesSaved.', "game2output":'.$game2LinesSaved.'}';
header("Content-Type: application/json", true);
http_response_code(200);
?>