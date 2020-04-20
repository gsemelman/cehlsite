<?php
include_once 'classes/TeamHolder.php';

class TeamAbbrHolder {
    var $teamAbbrArray = array();

    public function __construct(string $gmFile, string $teamScoringFile) {
       
       //init TeamHolder;
       $teamHolder = new TeamHolder($gmFile);
       
       foreach ($teamHolder->get_teams() as $team) {
           $this->teamAbbrArray[$team] = search($teamScoringFile,$team);
       }

          
    }
    
    public function getAbbr(string $teamName) : string{
        return $this->teamAbbrArray[$teamName];
    }
    

    
}


