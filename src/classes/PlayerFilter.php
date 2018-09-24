<?php


class PlayerFilter {
    var $number;
    var $name;
    
    public function __construct(int $number, string $name) {
        $this->number = $number;
        $this->name = $name;
    }

    public function isMatch(PlayerVitalObj $vital) {
        //return $i < $this->num;
        //return $this->number == $vital->getNumber() && $this->name == $vital->getName();
        return true;
    }
    
    function __invoke($i) {
        return $this->isMatch($i);
    }
}