<?php


class GameHolder implements \JsonSerializable
{
    private $homeTeam;
    private $awayTeam;
    
    private $awayShotsTotal;
    private $awayScore;
    private $awayShots = array();
    private $awayGoals = array();
    
    private $homeShotsTotal;
    private $homeScore;
    private $homeShots= array();
    private $homeGoals= array();
    
    private $scoringFirstPeriod = array();
    private $scoringSecondPeriod = array();
    private $scoringThirdPeriod = array();
    private $scoringOtPeriod = array();
    
    private $penaltySummary = array();
    
    private $awayStats = array();
    private $homeStats = array();
    
    private $goalieStats = array();
    
    private $threeStars = array();
    
    private $attendence;
    private $teamProfit;
    
    private $gameNotes = array();
    
    private $farmAwayTeam;
    private $farmAwayScore;
    
    private $farmHomeTeam;
    private $farmHomeScore;
    
    private $farmGoalies= array();
    private $farmScoringSummary = array();
    




    public function __construct(string $file) {

        $gamesSavesOutOf = 'saves out of';
        $gamesGoalShots = 'shots';
        $gamesW = 'W';
        $gamesL = 'L';
        $gamesT = 'T';
        $gamesin = 'en';
        
        $a = 0;
        $b = 0;
        $c = 1;
        $d = 0;
        $e = 0;
        $awayStatsProcessed = 0;

        if(file_exists($file)) {
            $tableau = file($file);
            while(list($cle,$val) = myEach($tableau)) {
                $val = utf8_encode($val);
                
                if(substr_count($val, ' at ') && $a == 0){
                    $pos = strpos($val, ' at ');
                    $pos_apres = strpos($val, '</H3>');
                    $pos_avant = strpos($val, '<H3>') + 4;
                    $long1 = $pos - $pos_avant;
                    $pos = $pos + 4;
                    $long2 = $pos_apres - $pos;
                    $equipe1 = substr($val, $pos_avant, $long1);
                    $equipe2 = substr($val, $pos, $long2);

                    $equipe1c = strtoupper($equipe1);
                    $equipe2c = strtoupper($equipe2);
                    
                    $this->awayTeam=$equipe1;
                    $this->homeTeam=$equipe2;
                    
                    $a++;
                }
                if( (isset($equipe1) && (substr_count($val, '<TR><TD>'.$equipe1)) || (isset($equipe1) && substr_count($val, '<TR><TD>'.$equipe2))) && $a >= 1 && $a < 5) {
                    $mod = prev($tableau);
                    //domicile = home
                    //visiteur = away
                    
                    //score by period
                    for($i=0;$i<4;$i++) {
                        $mod = next($tableau);
                        $pos_avant = strpos($mod, '>') + 1;
                        $pos_apres = strpos($mod, '</TD>');
                        $long = $pos_apres - $pos_avant;
                        if($a == 1)$visiteur1[$i] = substr($mod, $pos_avant, $long);
                        if($a == 2)$domicile1[$i] = substr($mod, $pos_avant, $long);
                        if($a == 3)$visiteur2[$i] = substr($mod, $pos_avant, $long);
                        if($a == 4)$domicile2[$i] = substr($mod, $pos_avant, $long);
                        
                        if($a == 1)$this->awayShots[$i] = substr($mod, $pos_avant, $long);
                        if($a == 2)$this->homeShots[$i] = substr($mod, $pos_avant, $long);
                        if($a == 3)$this->awayGoals[$i] = substr($mod, $pos_avant, $long);
                        if($a == 4)$this->homeGoals[$i] = substr($mod, $pos_avant, $long);
                    }
                    $mod = next($tableau);
                    $pos_avant = strpos($mod, '<B>') + 3;
                    $pos_apres = strpos($mod, '</B>');
                    $long = $pos_apres - $pos_avant;
                    //final score
                    if($a == 1)$visiteur1[4] = substr($mod, $pos_avant, $long);
                    if($a == 2)$domicile1[4] = substr($mod, $pos_avant, $long);
                    if($a == 3)$visiteur2[4] = substr($mod, $pos_avant, $long);
                    if($a == 4)$domicile2[4] = substr($mod, $pos_avant, $long);
                    
                    if($a == 1)$this->awayShotsTotal = substr($mod, $pos_avant, $long);
                    if($a == 2)$this->homeShotsTotal = substr($mod, $pos_avant, $long);
                    if($a == 3)$this->awayScore = substr($mod, $pos_avant, $long);
                    if($a == 4)$this->homeScore = substr($mod, $pos_avant, $long);
          
                    
                    $a++;
                }
                if($a == 5) {
                   
                    $a++;
                }
                if($a == 23 && substr_count($val, '------')) {
                    //divider
                    $a = 24;
                   
                }
                if($a == 22 || $a == 23) {
                    $a = 23;
                                       
                    //farm goalies
                    array_push($this->farmGoalies, trim($val)); //need to split these                   
                   
                }
                if($a == 21) {
                    $a = 22;
                   
                }
                if($a == 20 && substr_count($val, '------')) {
                    //divider
                    $a = 21;

                }
                if($a == 19 || $a == 20) {
                    $a = 20;
                    if(!substr_count($val, '(')) echo '<tr><td><br></td></tr>';
                    else {
                        //farm scoring summary
                        array_push($this->farmScoringSummary, trim($val));
                    }
                }
                if($a == 18) {
                    $a = 19;
                }
                if($a == 17) {
                    //farm home team/final score
                    $team_r2 = substr($val, 0, 12);
                    $team_r2p = substr($val, 14, 3);
                    
                    $this->farmHomeTeam = trim(substr($val, 0, 12));
                    $this->farmHomeScore = trim(substr($val, 14, 3));

                    $a = 18;
                }
                if($a == 16) {
                    //farm away team/final score
                    $team_r1 = substr($val, 0, 12);
                    $team_r1p = substr($val, 14, 3);
                    
                    $this->farmAwayTeam = trim(substr($val, 0, 12));
                    $this->farmAwayScore = trim(substr($val, 14, 3));

                    
                    $a = 17;
                }
                if($a == 15) {
                    $a = 16;
                }
                if($a == 14) {
          
                    $a = 15;
                }
                if($a == 13) {
                    str_replace('<BR>', '', $val);
                    $long = strlen($val);
            
                    //game notes
                    if($long > 5){
                    array_push($this->gameNotes, trim($val));
                    }
                    else {
       
                        $a = 14;
                    }
                }
                if(substr_count($val, 'Game Notes')) {
                    $a = 13;
                }
                if($a == 12) {
                    $pos = strpos($val, '<');
                    $long = $pos - 12;
                    $texte = substr($val, 12, $long);
//                     if(substr_count($val, 'Attendance')) $texte2 = $gamesAttendance;
//                     if(substr_count($val, 'Net Profit')) $texte2 = $gamesNetProfit;
       
                    if(substr_count($val, 'Attendance')) $this->attendence = trim($texte);
                    if(substr_count($val, 'Net Profit')) $this->teamProfit = trim($texte);
                    
                }
                if(substr_count($val, 'Financial')) {
                    $a = 12;
                    
                }
                if($a == 11 && substr_count($val, '</TD><TD><PRE>   </PRE></TD><TD>')) {
             
                    $a = 10;
                    
                    //away team stats complete. start home stats
                    $awayStatsProcessed++;
                    $b++;
                }
                if($a == 11) {
                    if(!substr_count($val, '                      ') && !substr_count($val, '-------')) {
                        if($c == 1) $c = 2;
                        else $c = 1;
                        
                        $count = strlen($val);
                        $i = 0;
                        while( $i < $count ) {
                            if( ctype_digit($val[$i]) ) {
                                $pos = $i;
                                break 1;
                            }
                            $i++;
                        }
                        $plusmoins = substr($val, $pos+9, 4);
                        $plusmoins = str_replace('Even', '0', $plusmoins);
                        
            
                        $statsArray = array();
                        
                        $statsArray['NAME'] = trim(substr($val, 0, $pos));
                        $statsArray['G'] = trim(substr($val, $pos, 2));
                        $statsArray['A'] = trim(substr($val, $pos+3, 2));
                        $statsArray['P'] = trim(substr($val, $pos+6, 2));
                        $statsArray['PLUSMINUS'] = $plusmoins;
                        $statsArray['PIM'] = trim(substr($val, $pos+14, 3));
                        $statsArray['S'] = trim(substr($val, $pos+18, 2));
                        $statsArray['HT'] = trim(substr($val, $pos+21, 3));
                        $statsArray['IT'] = trim(substr($val, $pos+24, 3));

                        if($awayStatsProcessed == 0){
                            //away
                            array_push($this->awayStats, $statsArray);
                        }else{
                            //home
                            array_push($this->homeStats, $statsArray);
                        }
                       
                                      }
                }
                if($a == 10 && substr_count($val, '<BR><BR><PRE>')) {
                    $pos = strpos($val, '<');
                    $team = substr($val, 0, $pos);
                   
                    $a = 11;
                }
                if(substr_count($val, 'Player Statistics')) {

                    $a = 10;
                }
                if($a == 9) {
                    //three stars
                    $numero = substr($val, 1, 1);
                    $pos = strpos($val, '(');
                    $long = $pos - 6;
                    $joueur = substr($val, 5, $long);
                    $equipe = substr($val, $pos + 1, 3);
       
                    $this->threeStars[''.$numero.''] = $joueur;

                }
                if(substr_count($val, 'Game Stars')) {
                    $a = 9;
                }
                if($a == 8) {
                    $val = str_replace('<BR>', '', $val);
                    $pos = strpos($val, '  ');
                    $team = substr($val, 0, $pos);
                    $pos = $pos + 2;
                    $long = strlen($val);
                    $long = $long - $pos;
                    $result = substr($val, $pos, $long);
                    $result = str_replace('for', $gamesin, $result);
       
                }
                if(substr_count($val, 'Power Play Conversions')) {

                    $a = 8;
                }
                if($a == 7) {
                    $pos = strpos($val, '(') - 1;
                    $joueur = substr($val, 0, $pos);
                    
                    $pos = $pos + 2;
                    $pos2 = strpos($val, ')');
                    $long = $pos2 - $pos;
                    $team = substr($val, $pos, $long);
                    
                    $pos2 = $pos2 + 3;
                    $pos = strpos($val, ' shots') + 6;
                    $long = $pos - $pos2;
                    $save = substr($val, $pos2, $long);
                    $save  = str_replace('saves out of', $gamesSavesOutOf, $save );
                    $save  = str_replace('shots', $gamesGoalShots, $save );
                    
                    if(!substr_count($val, 'shots<BR>')) {
                        $pos = $pos + 3;
                        $status = substr($val, $pos, 1);
                        $status = str_replace('W', $gamesW, $status);
                        $status = str_replace('L', $gamesL, $status);
                        $status = str_replace('T', $gamesT, $status);
                        $pos = $pos + 3;
                        $pos2 = strpos($val, '<BR>');
                        $long = $pos2 - $pos;
                        $total = substr($val, $pos, $long);
                    }
                    else {
                        $status = '';
                        $total = '';
                    }
  
                    $statsArray = array();

                    $statsArray['PLAYER'] = $joueur;
                    $statsArray['TEAM'] = $team;
                    //$statsArray['SAVES'] = $save;
                    $statsArray['SAVES'] = strtok($save,' ');
                    $statsArray['SA'] = strtok(substr($save, strpos($save, 'out of ') + 7),' ');;
                    
                    $statsArray['STATUS'] = $status;
                    $statsArray['RECORD'] = $total;

                    array_push($this->goalieStats, $statsArray);
                    
                    
                }
                if(substr_count($val, 'Goalie Statistics')) {
                    if(isset($punition)) {
                        
                        $f = $d;
                        for($d=0;$d<=$f;$d++) {
                            $aremplacer = array('<I>', '</I>', '<BR>', 'PENALTIES:');
                            $remplace = array('', '', '', '');
                            $tmpCpt = '';
                            if(isset($punition[$d])) {
                                $punition[$d] = str_replace($aremplacer, $remplace, $punition[$d]);
                                $tmpCpt = substr_count($punition[$d],"(") - substr_count($punition[$d],"(Served");
                    
                            }
                           // $tmpPunList = '';
                            for($i=0;$i<$tmpCpt;$i++) {
                                $pos = strpos($punition[$d], ',', strpos($punition[$d], ')'));
                                
                              
                                
                                if(!$pos){
                                    $tmpPunList[$i] = trim($punition[$d]);
                   
                                }
                                else {
                                    $tmpPunList[$i] = trim(substr($punition[$d], 0, $pos));
                                    $punition[$d] = substr($punition[$d], $pos+1);
                    
                                }
                                
                      
                            }

                              
                          if(isset($punition2[$d]) && $punition2[$d] == 1) {
                              $this->penaltySummary['1'] = $tmpPunList;
                          }
                          if(isset($punition2[$d]) && $punition2[$d] == 2) {
                              $this->penaltySummary['2'] = $tmpPunList;
                          }
                          if(isset($punition2[$d]) && $punition2[$d] == 3) {
                              $this->penaltySummary['3'] = $tmpPunList;
                          }
                          if(isset($punition2[$d]) && $punition2[$d] == 4) {
                              $this->penaltySummary['OT'] = $tmpPunList;
                          }
                              
                            
                
                            
                        }
                    
                    }
                 
                    $a = 7;
                }
                if($a == 6 && $e && (substr_count($val, $equipe1c) || substr_count($val, $equipe2c)) ) {
                    //SCORING BY PERIOD
                    
                    $long = strlen($val);
                    $pos = $long - 10;
                    $temps = substr($val, $pos-1, 6);
                    if(substr_count($temps, '<')) $temps = substr($temps, 0, 5);
                    $pos_avant = strpos($val, '.') + 1;
                    $pos_apres = strpos($val, ',');
                    $pos_apres2 = $pos_apres - $pos_avant;
                    $team = substr($val, $pos_avant, $pos_apres2);
                    $pos_apres = $pos_apres + 2;
                    //$pos = $pos - 2;
                    $pos = $pos - 3; //remove last comma
                    $pos = $pos - $pos_apres;
                    $score = substr($val, $pos_apres, $pos);
                    
               
                    $scoreArray = array();
                    
                    $scoreArray['TEAM'] = trim($team);
                    $scoreArray['TIME'] = trim($temps);
                    $scoreArray['SCORE'] = trim($score);
                    
                    if($e == 1){
                        array_push($this->scoringFirstPeriod, $scoreArray);
                    }
                    else if($e == 2){
                        array_push($this->scoringSecondPeriod, $scoreArray);
                    }
                    else if($e == 3){
                        array_push($this->scoringThirdPeriod, $scoreArray);
                    }
                    else{
                        //assume OT
                        array_push($this->scoringOtPeriod, $scoreArray);
                    }

                    
                }
                if($a == 6 && (substr_count($val, 'NO SCORING'))) {
                    
                }
                if($a == 6 && (substr_count($val, 'PENALTIES'))) {
                    $punition[$d] = $val;
                    $punition2[$d] = $e;
                    
                    //$this->penaltySummary[''.$e.''] = array(explode(",", $val));
                    //error_log($e);
                   // error_log($val);
  
                    $d++;
                }
                if($a == 6 && (substr_count($val, '<B>Period') || substr_count($val, '<B>Overtime'))) {
                    if(substr_count($val, 'Period 1')) {
                        $e++;
                        //echo '<div style="clear:both;"><br></div><table class="tableau"><tr class="tableau-top"><td colspan="3" style="text-align:left;'.$style1.'">'.$gamesGoalScorers.'</td></tr><tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$games1stPer.'</b></td></tr>';
                    }
                    if(substr_count($val, 'Period 2')) {
                        $e++;
                       // echo '<tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$games2ndPer.'</b></td></tr>';
                    }
                    if(substr_count($val, 'Period 3')) {
                        $e++;
                     //   echo '<tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$games3rdPer.'</b></td></tr>';
                    }
                    if(substr_count($val, 'Overtime')) {
                        $e++;
                        //echo '<tr style="'.$bg_1.'"><td colspan="3" style="'.$style1.'"><b>'.$gamesOTPer.'</b></td></tr>';
                    }
                }
                
               
            }
        }
        


    }
    
    
    
    /**
     * @return string
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * @return string
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * @return string
     */
    public function getAwayShotsTotal()
    {
        return $this->awayShotsTotal;
    }

    /**
     * @return string
     */
    public function getAwayScore()
    {
        return $this->awayScore;
    }

    /**
     * @return multitype:
     */
    public function getAwayShots()
    {
        return $this->awayShots;
    }

    /**
     * @return multitype:
     */
    public function getAwayGoals()
    {
        return $this->awayGoals;
    }

    /**
     * @return string
     */
    public function getHomeShotsTotal()
    {
        return $this->homeShotsTotal;
    }

    /**
     * @return string
     */
    public function getHomeScore()
    {
        return $this->homeScore;
    }

    /**
     * @return multitype:
     */
    public function getHomeShots()
    {
        return $this->homeShots;
    }

    /**
     * @return multitype:
     */
    public function getHomeGoals()
    {
        return $this->homeGoals;
    }

    /**
     * @return multitype:
     */
    public function getScoringFirstPeriod()
    {
        return $this->scoringFirstPeriod;
    }

    /**
     * @return multitype:
     */
    public function getScoringSecondPeriod()
    {
        return $this->scoringSecondPeriod;
    }

    /**
     * @return multitype:
     */
    public function getScoringThirdPeriod()
    {
        return $this->scoringThirdPeriod;
    }

    /**
     * @return multitype:
     */
    public function getScoringOtPeriod()
    {
        return $this->scoringOtPeriod;
    }

    /**
     * @return multitype:
     */
    public function getPenaltySummary()
    {
        return $this->penaltySummary;
    }

    /**
     * @return multitype:
     */
    public function getAwayStats()
    {
        return $this->awayStats;
    }

    /**
     * @return multitype:
     */
    public function getHomeStats()
    {
        return $this->homeStats;
    }

    /**
     * @return multitype:
     */
    public function getGoalieStats()
    {
        return $this->goalieStats;
    }

    /**
     * @return multitype:
     */
    public function getThreeStars()
    {
        return $this->threeStars;
    }

    /**
     * @return string
     */
    public function getAttendence()
    {
        return $this->attendence;
    }

    /**
     * @return string
     */
    public function getTeamProfit()
    {
        return $this->teamProfit;
    }

    /**
     * @return multitype:
     */
    public function getGameNotes()
    {
        return $this->gameNotes;
    }

    /**
     * @return string
     */
    public function getFarmAwayTeam()
    {
        return $this->farmAwayTeam;
    }

    /**
     * @return string
     */
    public function getFarmAwayScore()
    {
        return $this->farmAwayScore;
    }

    /**
     * @return string
     */
    public function getFarmHomeTeam()
    {
        return $this->farmHomeTeam;
    }

    /**
     * @return string
     */
    public function getFarmHomeScore()
    {
        return $this->farmHomeScore;
    }

    /**
     * @return multitype:
     */
    public function getFarmGoalies()
    {
        return $this->farmGoalies;
    }

    /**
     * @return multitype:
     */
    public function getFarmScoringSummary()
    {
        return $this->farmScoringSummary;
    }
    
    public function isOvertime(){
        return !empty($this->scoringOtPeriod);
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

?>
