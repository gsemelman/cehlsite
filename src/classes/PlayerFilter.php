<?php


class PlayerFilter {
    private $roster;
    
    public function __construct(RosterObj $roster) {
        $this->roster = $roster;
    }

    public function isMatch(PlayerVitalObj $vital) {
        //return $i < $this->num;
        //var_dump($vital);
        //var_dump($this->roster);
        //var_dump($this->vital);
              
        return $this->roster->getNumber() == $vital->getNumber() && $this->roster->getName() == $vital->getName();
       // return true;
    }
    
    function __invoke($i) {
        return $this->isMatch($i);
    }
}