<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = 'TeamFutures';
$CurrentTitle = $prospectsTitle;
$CurrentPage = 'TeamFutures';
include 'head.php';
include 'TeamHeader.php';
?>

<!--<h3 class = "text-center wow fadeIn"><?php echo $prospectsTitle.' - '.$currentTeam ?></h3>-->



<?php
$matches = glob($folder.'*'.$playoff.'Futures.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'Futures')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$Fnm = $folder.$folderLeagueURL.'Futures.html';

$a = 0;
$b = 0;
$c = 1;
$d = 1;
$yearCount = 0;
$lastUpdated = '';

$propects = array();
$picks = array();
if(file_exists($Fnm)) {
    $tableau = file($Fnm);
    while(list($cle,$val) = myEach($tableau)) {
        $val = utf8_encode($val);
        if(substr_count($val, '<P>(As of')){
            $pos = strpos($val, ')');
            $pos = $pos - 10;
            $val = substr($val, 10, $pos);
            $lastUpdated = $val;
            
        }
        if(substr_count($val, 'A NAME=') && $b) {
            $d = 0;
        }
        if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
            $pos = strpos($val, '</A>');
            $pos = $pos - 23;
            $equipe = trim(substr($val, 23, $pos));
            $b = 1;
        }
        if($a >= 2 && $a <= 7 && substr_count($val, '<B>') && $b && $d) {
            if($c == 1) $c = 2;
            else $c = 1;
            
            $yearCount++;
            if($yearCount <= $leagueFuturesDraftYears){
                $year = trim(substr($val, strpos($val, ':')+1, strpos($val, '</B>')-1-strpos($val, ':')-1));
                $draft = trim(substr($val, strpos($val, '</B>')+4, strpos($val, '<BR>')-strpos($val, '</B>')-4));
                
                array_push($picks, array($year, $draft));
                
                $pos = strpos($val, '<BR>');
                $pos = $pos - 19;
                // echo '<tr class="hover'.$c.'"><td>'.$year.'</td><td>'.$draft.'</td></tr>';
            }
            
            $a++;
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
                
//                 $scoringNameSearch = htmlspecialchars($tmp);
//                 $scoringNameLink = 'http://www.google.com/search?q='.$scoringNameSearch.'%20eliteprospects.com&btnI';
                
//                 // Choose between hockeyDB : 1 or EliteProspect : 2 | $leagueFuturesLink
//                 if($leagueFuturesLink == 1) $tmpLink = strtolower(str_replace(' ', '+', $tmp));
//                 //if($leagueFuturesLink == 2) $tmpLink = strtolower(str_replace(' ', '%20', $tmp));
//                 if($leagueFuturesLink == 1) $hockeyFutureLink = 'http://www.hockeydb.com/ihdb/stats/findplayer.php?full_name='.$tmpLink;
//                 //if($leagueFuturesLink == 2) $hockeyFutureLink = 'http://www.eliteprospects.com/playersearch2.php?player='.$tmpLink;
//                 if($leagueFuturesLink == 2) $hockeyFutureLink = $scoringNameLink;
                
                array_push($propects, $tmp);
                
                // echo '<tr class="hover'.$c.'"><td colspan="2"><a style="display:block; width:100%;" target="_blank" href="'.$hockeyFutureLink.'" >'.$tmp.'</a></td></tr>';
            }
            //echo '<tr class="tableau-top"><td colspan="2" style="text-align:center;">'.$prospectsDraft.'</td></tr>';
            $a = 2;
            $c = 1;
        }
        if(substr_count($val, '<H4>Prospects</H4>') && $b && $d) {
            // echo '<tr class="tableau-top"><td colspan="2" style="text-align:center;">'.$prospectsTitle.'</td></tr>';
            $a = 1;
        }
        
    }

}
?>

<div class = "container">

	<div class="card wow fadeIn">

    	<div class="card-header p-1">
    	
    		<div class= "teamheader logo-gradient">
    		 	<div class="team-logo gloss logo-gradient">
                    <a href="#">
                    <?php 
                        $teamCardLogoSrc = glob($folderTeamLogos.strtolower($currentTeam).'.*');
                        if(isset($teamCardLogoSrc[0])) {
                            echo'<img src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
                        }
                    ?>
            
                    </a>
                 </div>
                 <div class="team-logo gloss logo-gradient team-logo-right">
                    <a href="#">
                    <?php 
                        $teamCardLogoSrc = glob($folderTeamLogos.strtolower($currentTeam).'.*');
                        if(isset($teamCardLogoSrc[0])) {
                            echo'<img src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
                        }
                    ?>
            
                    </a>
                 </div>
                 
                 <div class="header-container">
    
        			<div class="gloss"></div>
        			<div class="header">
          				<h3 class="mb-0"><?php echo $CurrentTitle ?></h3>
        			</div>
    			</div>
    		</div>
    	
    	</div>
    	<div class="card-body">
    		<div class="row">
    			<div class = "col-sm-12 col-md-6">
    			
    				<h5 class="tableau-top titre" style = "padding-top:5px; padding-bottom:5px">Prospects</h5>
    				<table class="table table-sm table-striped">
    					<thead>
    						<tr class="tableau-top">
    							<td colspan=2 class="text-center">Name</td>
    						</tr>
    					</thead>
    					<tbody>
						
							<?php 
							$i = 0;
							foreach ($propects as $prospect) {

							    $scoringNameSearch = htmlspecialchars($prospect);
							    $scoringNameLink = 'http://www.google.com/search?q='.$scoringNameSearch.'%20eliteprospects.com&btnI';
							    
							    // Choose between hockeyDB : 1 or EliteProspect : 2 | $leagueFuturesLink
							    if($leagueFuturesLink == 1) $tmpLink = strtolower(str_replace(' ', '+', $tmp));
							    if($leagueFuturesLink == 1) $hockeyFutureLink = 'http://www.hockeydb.com/ihdb/stats/findplayer.php?full_name='.$prospect;
							    if($leagueFuturesLink == 2) $hockeyFutureLink = $scoringNameLink;
							    
							    if($i == 0){
							        echo '<tr>';
							        //echo '<td class="text-center">'.$prospect.'</td>';
							        echo '<td class="text-center"> <a style="display:block; width:100%;" href="'.$hockeyFutureLink.'" >'.$prospect.'</a></td>';
						
							        $i++;
							    }else{
							        //echo '<td class="text-center">'.$prospect.'</td>';
							        echo '<td class="text-center"> <a style="display:block; width:100%;" href="'.$hockeyFutureLink.'" >'.$prospect.'</a></td>';
							        
							        
							        echo '</tr>';
							        
							        $i = 0;
							    }
		
							}
							
							//in case tr was not closed because of uneven columns
							if($i > 0){
							    echo '<td></td></tr>';
							}
							
							?>

    					</tbody>			
    				</table>
    			
    			
    			</div>
    			
    			<div class = "col-sm-12 col-md-6">
    			
    				<h5 class="tableau-top titre" style = "padding-top:5px; padding-bottom:5px">picks</h5>
    				<table class="table table-sm table-striped" style="white-space:normal;">
    					<thead>
    						<tr class="tableau-top">
    							<td class="text-center">Year</td>
    							<td class="text-left">Picks</td>
    						</tr>
    					</thead>
    					<tbody>
						
							<?php 
							foreach ($picks as $pickyear) {
							    echo '<tr>';
							    echo '<td class="text-center">'.$pickyear[0].'</td>';
							    echo '<td class="text-left">'.$pickyear[1].'</td>';
							    echo '</tr>';
							}
							?>

    					</tbody>			
    				</table>
    			
    			
    			</div>
    		
    		</div>
    	</div>
    	
    	<?php 
        	if(isset($lastUpdated)){
        	    
        	    echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
        	}
    	    
    	?>

	</div>
</div>





<?php include 'footer.php'; ?>