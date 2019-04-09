﻿
<?php
include_once 'config.php';
include_once 'lang.php';
include_once 'common.php';

$seasonId = '';
if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    //$sort = ( isset($_GET['sort']) ) ? $_GET['sort'] : $_POST['sort'];
    //$sort = htmlspecialchars($sort);
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
}

if(trim($seasonId) == false){
    $Fnm = getLeagueFile2($folder, '', 'Standings.html', 'Standings', 'Farm'); // exclude farm
}else{
    $seasonFolder = str_replace("#",$seasonId,$folderCarrerStats);
    $Fnm = getLeagueFile2($seasonFolder, '', 'Standings.html', 'Standings', 'Farm'); // exclude farm
}


$tableCol = 15;
$c = 1;
$d = 0;
$e = 0;

$confProcessed = 0;
$divProcessed = 0;

$lastUpdated = '';


if (file_exists($Fnm)) {
    $tableau = file($Fnm);
    while (list ($cle, $val) = myEach($tableau)) {
        $val = utf8_encode($val);
        if (substr_count($val, '<P>(As of')) {
            $pos = strpos($val, ')');
            $pos = $pos - 10;
            //$val2 = substr($val, 10, $pos);
            $lastUpdated= substr($val, 10, $pos);

            echo '<div class="col-sm-12 col-lg-8 offset-lg-2 px-0">';
            
            echo '<div class="accordion" id="accordionExample">';

          
        }
        else if (substr_count($val, '<H3>By Conference</H3>')) {
  
            //start conference
            echo '<div class="card">';
            echo '<div class="card-header p-1" id="headingOne">
                 
                    <button class="btn btn-link btn-block p-0" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <div class= "section-header logo-gradient">
                        <div class="header-container">
                        
                        <div class="gloss"></div>
                        <span class="header">By Conference</span>
                        
                        </div>
                    </button>
       
                  </div>';
            echo '<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">';
            echo '<div class="card-body p-1">';
           
            //echo '<div class = "tableau-top"><h3>Conference Standings</h3></div>';
        }
        else if (substr_count($val, '<H3>By Division</H3>')) {

            //end of last conference
            echo '</tbody>';
            echo '</table>';
            echo '</div>'; //end table-responsive;
            echo '</div>'; //end card body
            echo '</div>'; //end card collapse;
            echo '</div>'; //end card
            
            echo '<div class="card">';
            echo '<div class="card-header p-1" id="divHeader">
                
                    <button class="btn btn-link btn-block collapsed p-0" type="button" data-toggle="collapse" data-target="#divCollapse" aria-expanded="true" aria-controls="divCollapse">
                        <div class= "section-header logo-gradient">
                            <div class="header-container">
                                <div class="gloss"></div>
                                <span class="header">By Division</span>
                    	    </div>
                    	</div>';
            echo '  </button>
                
                  </div>';
            echo '<div id="divCollapse" class="collapse" aria-labelledby="divHeader" data-parent="#accordionExample">';
            echo '<div class="card-body p-1">';
 
            //echo '<div class = "tableau-top"><h3>Division Standings</h3></div>';

        }
        else if (substr_count($val, 'Conference</H3>') && ! substr_count($val, '<H3>By Conference</H3>')) {
            $pos = strpos($val, 'Conference</H3>');
            $pos2 = strpos($val, '<H3>');
            $val2 = substr($val, $pos2 + 4, $pos - $pos2 - 5);


            
            if($confProcessed > 0){
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            }
            
            echo '<div class = "tableau-top"><h5 class="m-0">' . $val2 . ' ' . $standingConference . '</h5></div>';
            echo '<div class="table-responsive">';
            echo '<table class="table table-sm table-striped">';
           
     
            $d = 1;
            $b = 0;
            $final = 0;

            $confProcessed++;
        }
        else if  (substr_count($val, 'Division</H3>') && ! substr_count($val, '<H3>By Division</H3>')) {
            $pos = strpos($val, 'Division</H3>');
            $pos2 = strpos($val, '<H3>');
            $val2 = substr($val, $pos2 + 4, $pos - $pos2 - 5);            
            //echo '<tr><td colspan="' . $tableCol . '"><br></td></tr><tr class="titre"><td colspan="' . $tableCol . '"><h5 class="tableau-top"  style = "padding-top:5px; padding-bottom:5px">' . $val2 . ' ' . $standingDivision . '</h5></td></tr>';
            
            if($divProcessed > 0){
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            }
            
            echo '<div class = "tableau-top"><h5 class="m-0">' . $val2 . ' ' . $standingDivision . '</h5></div>';
            echo '<div class="table-responsive">';
            echo '<table class="table table-sm table-striped">';
            
            
            $d = 1;
            $b = 0;
            
            $divProcessed++;
        }
        if ($d == 1 && substr_count($val, '</H3>')) {
            $c = 1;
        }
        if (substr_count($val, 'STK') && (substr_count($val, 'OL') || substr_count($val, 'OTL'))) {
            $e = 1;
        }
        if (substr_count($val, 'HREF=')) {
            if ($d == 1) {
                echo '<thead>';
                echo '<tr class="tableau-top">';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td class="text-left">' . $standingTeam . '</td>';
                echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingGP . '<span>' . $standingGPFull . '</span></a></td>';
                echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingW . '<span>' . $standingWFull . '</span></a></td>';
                echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingL . '<span>' . $standingLFull . '</span></a></td>';
                echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingE . '<span>' . $standingEFull . '</span></a></td>';
                if ($e == 1){

                    echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingOT . '<span>' . $standingOTFull . '</span></a></td>';
                    echo '<td style="text-align:right;"><a href="javascript:return;" class="info"><b>' . $standingPTS . '</b><span>' . $standingPTSFull . '</span></a></td>';
                    echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingGF . '<span>' . $standingGFFull . '</span></a></td>';
                    echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingGA . '<span>' . $standingGAFull . '</span></a></td>';
                    echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingDiff . '<span>' . $standingDiffFull . '</span></a></td>';
                    echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingPCT . '<span>' . $standingPCTFull . '</span></a></td>';
                    echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingL10 . '<span>' . $standingL10Full . '</span></a></td>';
                    echo '<td style="text-align:right;"><a href="javascript:return;" class="info">' . $standingSTRK . '<span>' . $standingSTRKFull . '</span></a></td>';
                    echo '</tr>';
                }
                echo '</thead>';
                echo '<tbody>';

            }
            $reste = trim($val);
            if (substr_count($reste, 'WIDTH')) {
                echo '<tr><td colspan="' . $tableCol . '" style="height:2px; background-color:' . $couleur_contour . ';"></td></tr>';
                $reste = substr($reste, strpos($reste, '<A '));
            }
            $serie = '';
            
            $serie = substr($reste, 0, strpos($reste, '<'));
            $reste = trim(substr($reste, strpos($reste, '>') + 1));
            $equipe = substr($reste, 0, strpos($reste, '</A>'));
            $reste = trim(substr($reste, strpos($reste, '</A>') + 4));
            
            $pj = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsW = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsL = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsT = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            if ($e == 1) {
                $standingsOL = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
            }
            $standingsPts = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsGF = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsGA = substr($reste, 0, strpos($reste, ' '));
            $reste = trim(substr($reste, strpos($reste, ' ')));
            $standingsDiff = $standingsGF - $standingsGA;
            if ($standingsDiff > 0)
                $standingsDiff = '+' . $standingsDiff;
                
                $standingsPCT = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                for ($z = 0; $z < 9; $z ++) {
                    $reste = trim(substr($reste, strpos($reste, ' ')));
                }
                $standingsL10 = substr($reste, 0, strpos($reste, ' '));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $standingsSTK = $reste;
                
                if ($serie != '') {
                    if ($serie == 'z')
                        $serie = '<a href="javascript:return;" class="info" style="color:#000000">' . $standingZ . '<span>' . $standingZFull . '</span></a>';
                        if ($serie == 'y')
                            $serie = '<a href="javascript:return;" class="info" style="color:#000000">' . $standingY . '<span>' . $standingYFull . '</span></a>';
                            if ($serie == 'x')
                                $serie = '<a href="javascript:return;" class="info" style="color:#000000">' . $standingX . '<span>' . $standingXFull . '</span></a>';
                                if ($d == 3)
                                    $final = 1;
                                    if ($d == 8)
                                        $b = 1;
                }

                if ($b && $d > 8 && $final)
                    $serie = '<a href="javascript:return;" class="info" style="color:#000000">' . $standingN . '<span>' . $standingNFull . '</span></a>';
                    if ($c == 1)
                        $c = 2;
                        else
                            $c = 1;
                         
                            echo '<tr class="hover' . $c . '">';
                            echo '<td>' . $d . '</td>';
                            echo '<td>' . $serie . '</td>';
                            //echo '<td>' . $equipe . '</td>';
                            echo '<td><a class="text-left" style="display:block; width:100%;" href="TeamRosters.php?team=' . $equipe . '">' . $equipe . '</a></td>';
                            
                            echo '<td style="text-align:right;">' . $pj . '</td>';
                            echo '<td style="text-align:right;">' . $standingsW . '</td>';
                            echo '<td style="text-align:right;">' . $standingsL . '</td>';
                            echo '<td style="text-align:right;">' . $standingsT . '</td>';
             
                            if ($e == 1){

                                echo '<td style="text-align:right;">' . $standingsOL . '</td>';
                                echo '<td style="text-align:right;"><b>' . $standingsPts . '</b></td>';
                                echo '<td style="text-align:right;">' . $standingsGF . '</td>';
                                echo '<td style="text-align:right;">' . $standingsGA . '</td>';
                                echo '<td style="text-align:right;">' . $standingsDiff . '</td>';
                                echo '<td style="text-align:right;">' . $standingsPCT . '</td>';
                            }
                            echo '<td style="text-align:right;">' . $standingsL10 . '</td>';
                            echo '<td style="text-align:right;">' . $standingsSTK . '</td>';
                            echo '</tr>';
                            
                            $d ++;
                              
                
        }
    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>'; //end last div table responsive
    echo '</div>'; //end card body
    echo '</div>'; //end card collapse;
    echo '</div>'; //end card
    echo '</div>'; //end accordian
    echo '</div>'; //end col
    
    echo '<h6 class = "text-center">' . $allLastUpdate . ' ' . $lastUpdated . '</h56>';
    
    
    
} else {
    //echo  $allFileNotFound . ' - ' . $Fnm ;
    echo '<h6>No season data found</h6>';
}



?>

<script>

$('.collapse').on('shown.bs.collapse', function(e) {
    var $card = $(this).closest('.card');
    $('html,body').animate({
        scrollTop: $card.offset().top - 55
    }, 500);
});
</script>
