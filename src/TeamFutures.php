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

<div class = "container">

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



echo '<div class="card wow fadeIn">';
echo '<div class="card-header p-1">';

$teamCardLogoSrc = glob($folderTeamLogos.strtolower($currentTeam).'.*');

echo '<div class= "teamheader logo-gradient">
            				<div class="team-logo gloss logo-gradient">
            				<a href="#">
            	                <img src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">
    
                            </a>
                         </div>
                         <div class="team-logo gloss logo-gradient team-logo-right">
                            <a href="#">
            	                <img src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">
                            </a>
                         </div>
            	                    
                         <div class="header-container">
            	                    
                			<div class="gloss"></div>
                			<div class="header">
                  				<h3 class="mb-0">'.$CurrentTitle.'</h3>
                			</div>
            			</div>
            		</div>';

echo' </div>';
echo '<div class="card-body">';

//echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$val.'</h5>';

//echo '<div class = "container">';
echo '<div class = "col-sm-12 col-md-8 offset-md-2">';
echo '<table class="table table-sm" style="white-space:normal;">';

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
			    
			    $pos = strpos($val, '<BR>');
			    $pos = $pos - 19;
			    echo '<tr class="hover'.$c.'"><td>'.$year.'</td><td>'.$draft.'</td></tr>';
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
				
				$scoringNameSearch = htmlspecialchars($tmp);
				$scoringNameLink = 'http://www.google.com/search?q='.$scoringNameSearch.'%20eliteprospects.com&btnI';
				
				// Choose between hockeyDB : 1 or EliteProspect : 2 | $leagueFuturesLink
				if($leagueFuturesLink == 1) $tmpLink = strtolower(str_replace(' ', '+', $tmp));
				//if($leagueFuturesLink == 2) $tmpLink = strtolower(str_replace(' ', '%20', $tmp));
				if($leagueFuturesLink == 1) $hockeyFutureLink = 'http://www.hockeydb.com/ihdb/stats/findplayer.php?full_name='.$tmpLink;
				//if($leagueFuturesLink == 2) $hockeyFutureLink = 'http://www.eliteprospects.com/playersearch2.php?player='.$tmpLink;
				if($leagueFuturesLink == 2) $hockeyFutureLink = $scoringNameLink;
				
				echo '<tr class="hover'.$c.'"><td colspan="2"><a style="display:block; width:100%;" target="_blank" href="'.$hockeyFutureLink.'" >'.$tmp.'</a></td></tr>';
			}
			echo '<tr class="tableau-top"><td colspan="2" style="text-align:center;">'.$prospectsDraft.'</td></tr>';
			$a = 2;
			$c = 1;
		}
		if(substr_count($val, '<H4>Prospects</H4>') && $b && $d) {
			echo '<tr class="tableau-top"><td colspan="2" style="text-align:center;">'.$prospectsTitle.'</td></tr>';
			$a = 1;
		}
		
	}
}
else{
    echo '<tr><td>'.$allFileNotFound.' - '.$Fnm.'</td></tr>';
}

echo '</table>';

echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
?>
</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>