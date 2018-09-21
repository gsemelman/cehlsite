<?php

include_once 'common.php';
include_once 'lang.php';

class PlayerVitals {
    private $lastUpdated;
    private $vitals = array();
    private $avgAge = '';
    private $avgHeight = '';
    private $avgWeight = '';
    private $avgSalary = '';
    
    public function __construct(string $file, string $searchTeam) {
        if(!file_exists($file)) {
            throw new InvalidArgumentException('File does not exist');
        }
        
        if(!isset($searchTeam)){
            throw new InvalidArgumentException('Team must be set');
        }
        
        $number = 0;
        $name = '';
        $position = '';
        $age = 0;
        $height = 0;
        $weight = 0;
        $salary = 0;
        $contractLength = 0;
        
        $contents = file($file);
        
        $a = 0;
        $b = 0;
        $d = 1;
        $i = 0;
        
        while(list($cle,$val) = myEach($contents)) {
            $val = utf8_encode($val);
            if(substr_count($val, '<P>(As of')){
                $pos = strpos($val, ')');
                $pos = $pos - 10;
                $val = substr($val, 10, $pos);
                
                $this->lastUpdated = $val;
            }
            if(substr_count($val, 'A NAME=') && $b) {
                $d = 0;
            }
            if(substr_count($val, 'A NAME='.$searchTeam)) {
                $pos = strpos($val, '</A>');
                $pos = $pos - 23;
                $equipe = substr($val, 23, $pos);
                //echo '<tr class="titre"><td colspan="9" class="text-blanc bold-blanc">'.$equipe.'</td></tr>';
                $b++;
            }
            if($a == 3 && $b && $d) {
                $reste = trim(substr($val, strpos($val, '  '), strpos($val, '</PRE>')-strpos($val, '  ')));
                $this->avgAge = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $this->avgHeight = substr($reste, 0, strpos($reste, '  '));
                $this->avgHeight = str_replace('ft', '\'', $mgrandeur);
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $this->avgWeight = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $this->avgSalary = substr($reste, 0);
                $a++;
            }
            if(substr_count($val, '------------------') && $b && $d) {
                $a++;
            }
            if($a == 2 && $b && $d) {
                $number = substr($val, 0,  strpos($val, ' '));
                $reste = trim(substr($val, strpos($val, ' ')));
                if(substr_count($reste, '*', 0, 1)) {
                    $recrue[$i] = substr($reste, 0, 1);
                    $reste = trim(substr($reste, 1));
                }
                else $recrue[$i] = '';
                
                $name = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $position = substr($reste, 0, strpos($reste, '  '));
//                 $aremplacer = array('LW', 'RW');
//                 $remplace = array($joueursLW, $joueursRW);
//                 $position[$i] = str_replace($aremplacer, $remplace, $position[$i]);
//                 if(substr_count($position[$i], 'G')) $position2[$i] = 5;
//                 if(substr_count($position[$i], 'D')) $position2[$i] = 4;
//                 if(substr_count($position[$i], 'AG')) $position2[$i] = 2;
//                 if(substr_count($position[$i], 'AD')) $position2[$i] = 3;
//                 if(substr_count($position[$i], 'C')) $position2[$i] = 1;
                $reste = trim(substr($reste, strpos($reste, '  ')));
                
                $age = substr($reste, 0, strpos($reste, '  '));
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $height = substr($reste, 0, strpos($reste, '  '));
                $height = str_replace('ft', '\'', $height);
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $weight = substr($reste, 0, strpos($reste, 'lbs') + 3);
                $reste = trim(substr($reste, strpos($reste, 'lbs') + 3));
                $salaire[$i] = substr($reste, 0, strpos($reste, '  '));
                $salaire2[$i] = preg_replace('/\D/', '', $salaire[$i]);
                $reste = trim(substr($reste, strpos($reste, '  ')));
                $contractLength[$i] = substr($reste, 0);
                //$aremplacer = array('0 years', '1 year', 'years');
                //$remplace = array($joueurs0Year, $joueurs1Year, $joueursYears);
                //$contrat2[$i] = $contrat[$i];
                //$contractLength[$i] = str_replace($aremplacer, $remplace, $contractLength[$i]);
                
                $vitals = new PlayerVitalObj();
                $vitals->setNumber($number);
                $vitals->setName($name);
                $vitals->setPosition($position);
                $vitals->setAge($age);
                $vitals->setHeight($height);
                $vitals->setWeight($weight);
                $vitals->setSalary($salary);
                $vitals->setContractLength($contractLength);
                
                array_push($this->vitals, $vitals);
                
                $i++;
            }
            if($a == 1 && $b && $d) {
                $a++;
            }
            if(substr_count($val, '<PRE>') && $b && $d) {
                $a = 1;
            }
        }
        
    }
    
    
    /**
     * @return mixed
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @return multitype:
     */
    public function getVitals()
    {
        return $this->vitals;
    }

    /**
     * @param mixed $lastUpdated
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;
    }

    /**
     * @param multitype: $vitals
     */
    public function setVitals($vitals)
    {
        $this->vitals = $vitals;
    }
    /**
     * @return string
     */
    public function getAvgAge()
    {
        return $this->avgAge;
    }

    /**
     * @return string
     */
    public function getAvgHeight()
    {
        return $this->avgHeight;
    }

    /**
     * @return string
     */
    public function getAvgWeight()
    {
        return $this->avgWeight;
    }

    /**
     * @return string
     */
    public function getAvgSalary()
    {
        return $this->avgSalary;
    }

    /**
     * @param string $avgAge
     */
    public function setAvgAge($avgAge)
    {
        $this->avgAge = $avgAge;
    }

    /**
     * @param string $avgHeight
     */
    public function setAvgHeight($avgHeight)
    {
        $this->avgHeight = $avgHeight;
    }

    /**
     * @param string $avgWeight
     */
    public function setAvgWeight($avgWeight)
    {
        $this->avgWeight = $avgWeight;
    }

    /**
     * @param string $avgSalary
     */
    public function setAvgSalary($avgSalary)
    {
        $this->avgSalary = $avgSalary;
    }


    
    
    
}