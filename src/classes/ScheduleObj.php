<?php

class ScheduleObj{
    
    var $isPlayed = false;
    var $gameNumber;
    var $gameDay;
    var $team1;
    var $team1Score;
    var $team2;
    var $team2Score;
    var $isOt;
    
    
    /**
     * @return boolean
     */
    public function getIsPlayed()
    {
        return $this->isPlayed;
    }

    /**
     * @param boolean $isPlayed
     */
    public function setIsPlayed($isPlayed)
    {
        $this->isPlayed = $isPlayed;
    }

    /**
     * @return mixed
     */
    public function getGameNumber()
    {
        return $this->gameNumber;
    }

    /**
     * @return mixed
     */
    public function getGameDay()
    {
        return $this->gameDay;
    }

    /**
     * @return mixed
     */
    public function getTeam1()
    {
        return $this->team1;
    }

    /**
     * @return mixed
     */
    public function getTeam1Score()
    {
        return $this->team1Score;
    }

    /**
     * @return mixed
     */
    public function getTeam2()
    {
        return $this->team2;
    }

    /**
     * @return mixed
     */
    public function getTeam2Score()
    {
        return $this->team2Score;
    }

    /**
     * @return mixed
     */
    public function getIsOt()
    {
        return $this->isOt;
    }

    /**
     * @param mixed $gameNumber
     */
    public function setGameNumber($gameNumber)
    {
        $this->gameNumber = $gameNumber;
    }

    /**
     * @param mixed $gameDay
     */
    public function setGameDay($gameDay)
    {
        $this->gameDay = $gameDay;
    }

    /**
     * @param mixed $team1
     */
    public function setTeam1($team1)
    {
        $this->team1 = $team1;
    }

    /**
     * @param mixed $team1Score
     */
    public function setTeam1Score($team1Score)
    {
        $this->team1Score = $team1Score;
    }

    /**
     * @param mixed $team2
     */
    public function setTeam2($team2)
    {
        $this->team2 = $team2;
    }

    /**
     * @param mixed $team2Score
     */
    public function setTeam2Score($team2Score)
    {
        $this->team2Score = $team2Score;
    }

    /**
     * @param mixed $isOt
     */
    public function setIsOt($isOt)
    {
        $this->isOt = $isOt;
    }
    
    
    
}

