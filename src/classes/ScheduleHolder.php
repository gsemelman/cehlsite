<?php

include_once 'common.php';
include_once 'lang.php';

class ScheduleHolder{
    
    private $schedule = array();
    private $tradeDeadline;
    private $lastDayPlayed;
    
    public function __construct(string $file) {
        if(!file_exists($file)) {
            throw new InvalidArgumentException('File does not exist');
        }
            
        $a = 0;
        $i = 0;
        $lastDay = 0;
        $lastGame = 0;
        $otGames = array();

        $pageHtml = file($file);
        while(list($cle,$val) = myEach($pageHtml)) { 
            if(substr_count($val, 'Day')){
              
                $reste = trim(substr($val, strpos($val, 'Day')));
                $lastDay = trim(substr($reste, strpos($reste, 'Day')+4, strpos($reste, '< ')-strpos($reste, 'Day')-4));
                $i++;
            }
            else if(substr_count($val, 'TRADE DEADLINE')){
              

                $this->setTradeDeadline($lastDay);

                $i++;
            }else if(substr_count($val, '(OT)')){
                $i--;
   
                array_push($otGames, $lastGame);

                $i++;
            }else{
                //game result
                
                $isPlayed = false;
                $gameNumber= 0;
                $gameDay = $lastDay;
                $team1 = '';
                $team1Score = 0;
                $team2 = '';
                $team2Score = 0;

                //game is not played
                if(substr_count($val, ' at ') && !substr_count($val, '<strike>')){
                    
                    $reste = trim(str_replace('<br>','', $val));
                    $reste = trim(str_replace('<BR>','', $reste));
                    $gameNumber = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $team1 = substr($reste, 0, strpos($reste, ' at '));
                    $reste = trim(substr($reste, strpos($reste, ' at ')+4));
                    $team2 = $reste;
                    
                    $i++;
                }
                //game is played
                else if(substr_count($val, 'A HREF=')){
                    if($a == 0) $a = $i;
  
                    $reste = trim(substr($val, strpos($val, '> ')+1));
                    $gameNumber = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $count = strlen($reste);
                    $z = 0;
                    while( $z < $count ) {
                        if( ctype_digit($reste[$z]) ) {
                            $pos3 = $z;
                            break 1;
                        }
                        $z++;
                    }
                    $team1 = substr($reste, 0, $pos3-1);
                    $reste = trim(substr($reste, $pos3));
                    $team1Score = substr($reste, 0, strpos($reste, ' '));
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                    $z = 0;
                    while( $z < $count ) {
                        if( ctype_digit($reste[$z]) ) {
                            $pos3 = $z;
                            break 1;
                        }
                        $z++;
                    }
                    $team2 = substr($reste, 0, $pos3-1);
                    $reste = trim(substr($reste, $pos3));
                    $team2Score = $reste;
                    
                    $isPlayed = true;
                    
                    
                    $i++;
                }else{ //neither (should probably reorder statements. This is for lines with nothing to parse)
                    $i++;
                    continue;
                }
                

                
                if($isPlayed){
                    $lastGame = $gameNumber;
                    $this->lastDayPlayed = $gameDay;
                }
 
                $scheduleDay = new ScheduleObj();
                $scheduleDay->setIsPlayed($isPlayed);
                $scheduleDay->setGameNumber($gameNumber);
                $scheduleDay->setGameDay($gameDay);
                $scheduleDay->setTeam1($team1);
                $scheduleDay->setTeam1Score($team1Score);
                $scheduleDay->setTeam2($team2);
                $scheduleDay->setTeam2Score($team2Score);
 
                array_push($this->schedule, $scheduleDay);
                
            }

    
            
        }
        
        //set ot games (needs to be done after initial iteration)
        foreach ($this->schedule as $scheduleDay) {

            if(in_array($scheduleDay->getGameNumber(), $otGames)){
                $scheduleDay->setIsOt(true);
            }
  
        }

    }
    
    public function getScheduleByDay($day){
        return getFilteredArray('gameDay', $day, $this->getSchedule());
    }
    
    public function getLastScheduleDay(){
        if($this->isSeasonStarted()){
            return getFilteredArray('gameDay', $day, $this->getSchedule());
        }
        
        return array();
    }
    
    public function getGameNumbersByDay($day){
        
        $filtered_array = array();
        foreach ($this->getSchedule() as $value) {
            
            if (isset($value->gameDay)) {
                if($day == $value->gameDay){
                    $filtered_array[] = $value->gameNumber;
                }
            }
            
        }
        
        return $filtered_array;

    }

    /**
     * @return multitype:
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @return mixed
     */
    public function getTradeDeadline()
    {
        return $this->tradeDeadline;
    }

    /**
     * @return
     */
    public function getLastDayPlayed()
    {
        return $this->lastDayPlayed;
    }

    /**
     * @return boolean
     */
    public function isSeasonStarted()
    {
        return $this->lastDayPlayed > 0;
    }

    /**
     * @param multitype: $schedule
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @param mixed $tradeDeadline
     */
    public function setTradeDeadline($tradeDeadline)
    {
        $this->tradeDeadline = $tradeDeadline;
    }

    /**
     * @param Ambigous <number, string> $lastDayPlayed
     */
    public function setLastDayPlayed($lastDayPlayed)
    {
        $this->lastDayPlayed = $lastDayPlayed;
    }

    
    
    
}

