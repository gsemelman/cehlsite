<?php

include_once 'common.php';

class RostersHolder{
    
    private $lastUpdated;
    private $proRosters = array();
    private $farmRosters = array();
    private $proAverages;
    private $farmAverages;

    public function __construct(string $file, string $searchTeam, bool $generateAvg = true) {
        
        if(!file_exists($file)) {
            throw new InvalidArgumentException('File does not exist');
        }
        
        if(!isset($searchTeam)){
            throw new InvalidArgumentException('Team must be set');
        }
        
        $contents = file($file);
 
        $a = 0;
        $b = 0;
        $d = 1;
        $i = 0;
        $z = 0;
        
        $curTeam = '';
        $number = 0;
        $name = '';
        $position= '';
        $hand= '';
        $condition= '';
        $injStatus= '';
        $it = 0;
        $sp = 0;
        $st = 0;
        $en = 0;
        $du = 0;
        $di = 0;
        $sk = 0;
        $pa = 0;
        $pc = 0;
        $df = 0;
        $sc = 0;
        $ex = 0;
        $ld = 0;
        $ov = 0;

        while(list($cle,$val) = myEach($contents)) {
            $val = utf8_encode($val);
            if(substr_count($val, '<P>(As of')){
                $pos = strpos($val, ')');
                $pos = $pos - 10;
                $val = substr($val, 10, $pos);
                $this->lastUpdated = $val;
            }
//             if(substr_count($val, 'AGE CT SALARY')){
//                 $stop = 1;
//                 break 1;
//             }
            if(substr_count($val, 'A NAME=') && $b) {
                $d = 0;
            }
            if(substr_count($val, 'A NAME='.$searchTeam) && $d) {
                $pos = strpos($val, '</A>');
                $pos = $pos - 23;
                $curTeam = substr($val, 23, $pos);
                $b = 1;
            }
            
            if(substr_count($val, '</PRE>') && $b && $d) {
                $a = 0;
            }
            //if($a == 1 && $b && $d && $z == 1) {
            if($a == 1 && $b && $d == 1  &&  $z > 0) {
                $reste = trim($val);
                $number = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $tmpPos = '';
                if(substr_count($reste, ' C ')) $tmpPos = ' C ';
                if(substr_count($reste, ' LW ')) $tmpPos = ' LW ';
                if(substr_count($reste, ' RW ')) $tmpPos = ' RW ';
                if(substr_count($reste, ' D ')) $tmpPos = ' D ';
                if(substr_count($reste, ' G ')) $tmpPos = ' G ';
                $name = trim(substr($reste, 0,  strpos($reste, $tmpPos)));
                $reste = trim(substr($reste, strpos($reste, $tmpPos)));
                $position = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $hand = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $condition = substr($reste, 0, strpos($reste, ' '));
                $reste = substr($reste, strpos($reste, ' '));
                $count = strlen($reste);
                $j = 3;
                while( $j < $count ) {
                    if( ctype_digit($reste[$j]) ) {
                        $pos = $j;
                        $j = 1000;
                    }
                    $j++;
                }
                $injStatus = trim(substr($reste, 0, $pos));
                $reste = trim(substr($reste, $pos));
                $it = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $sp = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $st = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $en = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $du = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $di = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $sk = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $pc = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $pa = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $df = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $sc = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $ex = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $ld = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $ov = substr($reste, strpos($reste, ' '));
                
                $roster = new RosterObj();
                $roster->setTeam($curTeam);
                $roster->setNumber($number);
                $roster->setName($name);
                $roster->setPosition($position);
                $roster->setHand($hand);
                $roster->setCondition($condition);
                $roster->setInjStatus($injStatus);
                $roster->setIt($it);
                $roster->setSp($sp);
                $roster->setSt($st);
                $roster->setEn($en);
                $roster->setDu($du);
                $roster->setDi($di);
                $roster->setSk($sk);
                $roster->setPa($pa);
                $roster->setPc($pc);
                $roster->setDf($df);
                $roster->setSc($sc);
                $roster->setEx($ex);
                $roster->setLd($ld);
                $roster->setOv($ov);

                if($z == 1){
                    array_push($this->proRosters, $roster);
                }else{
                    array_push($this->farmRosters, $roster);
                }
               
                $i++;
            }

            if(substr_count($val, '<PRE>') && $b && $d) {
                $a = 1;
                $z++;
                $i = 0;
            }
        }
        
        if($generateAvg){
            $this->proAverages = new RosterAvgObj($this->proRosters);
            $this->farmAverages = new RosterAvgObj($this->farmRosters);
        }
    }
    /**
     * @return string
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @return multitype:
     */
    public function getProRosters()
    {
        return $this->proRosters;
    }

    /**
     * @return multitype:
     */
    public function getFarmRosters()
    {
        return $this->farmRosters;
    }

    /**
     * @return mixed
     */
    public function getProAverages()
    {
        return $this->proAverages;
    }

    /**
     * @return mixed
     */
    public function getFarmAverages()
    {
        return $this->farmAverages;
    }


    

    

}