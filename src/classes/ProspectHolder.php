<?php

class ProspectHolder {
    private $prospects = array();
    
    //ProspectObj
    
    public function __construct(string $file, string $team = '' ) {
        
        if(file_exists($file)) {
            $a = 0;
            $b = 0;
            $c = 1;
            $d = 1;
            $tableau = file($file);
            while(list($cle,$val) = myEach($tableau)) {
                $val = utf8_encode($val);
                
                if(substr_count($val, 'A NAME=')) {
                    $d = 1;
                    $b = 1;
                    
                    $pos = strpos($val, '</A>');
                    $pos = $pos - 23;
                    $currentTeam = trim(substr($val, 23, $pos));
                    
                }
                
                if($a == 1 && $b && $d) {
                    $pos = strpos($val, '<');
                    $tmpProspect = substr($val, 0, $pos).',';
                    $tmpCount = substr_count($tmpProspect, ',');
                    for($i=0;$i<$tmpCount;$i++) {
                        if($c == 1) $c = 2;
                        else $c = 1;
                        $tmp = trim(substr($tmpProspect, 0, strpos($tmpProspect, ',')));
                        $tmpProspect = substr($tmpProspect, strpos($tmpProspect, ',')+1);
                        
                        
                        $prospect = new ProspectObj();
                        $prospect->setTeam($currentTeam);
                        $prospect->setName($tmp);

                        array_push($this->prospects, $prospect);
                        
                    }
                    
                    $a = 2;
                    $c = 1;
                }
                if(substr_count($val, '<H4>Prospects</H4>') && $b && $d) {
                    $a = 1;
                }
                
            }
            
        }
        
    }
    /**
     * @return multitype:
     */
    public function getProspects()
    {
        return $this->prospects;
    }

    
}