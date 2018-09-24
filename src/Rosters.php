<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'config.php';
include 'lang.php';
$CurrentHTML = 'Rosters';
$CurrentTitle = $rostersTitle;
$CurrentPage = 'Rosters';
include 'head.php';

include_once 'common.php';
include_once 'classes/RosterObj.php';
include_once 'classes/RostersHolder.php';
include_once 'classes/PlayerVitalObj.php';
include_once 'classes/PlayerVitalsHolder.php';
include_once 'classes/PlayerFilter.php';

?>

<div class="container">
	<div class="row no-gutters">
	<div class="col"> 
	<div class="card">
	<div class="card-header wow fadeIn">
		
		<div class = "row d-flex align-items-center justify-content-center">
		<?php 
    		$teamCardLogoSrc = glob($folderTeamLogos.strtolower($currentTeam).'.*');
    		if(isset($teamCardLogoSrc[0])) {
    		    echo'<img class="float-left card-img-top" src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
    		}
		?>
		<h3><?php echo $CurrentTitle; ?></h3>
		</div>
	</div>
    	<div class="card-body wow fadeIn">
        	<!-- <div class="row no-gutters">
        		<div class="col">-->
        
                    <?php
                    
                    if (! isset($playoff))
                        $playoff = '';
                    
                    $fileName = getLeagueFile($folder, $playoff, 'Rosters.html', 'Rosters');
                    $vitalsFileName = getLeagueFile($folder, $playoff, 'PlayerVitals.html', 'PlayerVitals');
                    
                    if (file_exists($fileName) && file_exists($vitalsFileName)) {
                        //get rosters from file
                        $rosters = new RostersHolder($fileName, 'Washington');
                        $playerVitals = new PlayerVitalsHolder($vitalsFileName, 'Washington');
                        
        
                        $lastUpdated = $rosters->getLastUpdated();
        
                        if (isset($lastUpdated)) {
                            
                            //echo '<h5>'.$lastUpdated.'</h5>';
                            echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
                            
                            echo'<div id="rosterTabs">';
                            echo'<ul class="nav nav-tabs nav-fill">
                                			<li class="nav-item">
                                                <a class="nav-link active" href="#Pro" data-toggle="tab">Pro Roster</a>
                                			</li>
                                			<li class="nav-item">
                                                <a class="nav-link" href="#Farm" data-toggle="tab">Farm Roster</a>
                                			</li>
                                </ul>';
                            
                            echo '<div class="tab-content">';
                            
                            $typeArray = array('Pro','Farm');
                            
                            foreach ($typeArray as $rosterType) {
        
                                //echo '<h5>'.$rosterType.'</h5>';
                                
                                if ($rosterType == 'Pro') {
                                    echo'<div class="tab-pane active" id="Pro">';
                                }else{
                                    echo'<div class="tab-pane" id="Farm">';
                                }
                                                 
                                //create table header
                                echo '<div class="table-responsive">';
                                echo '<table class="table table-sm table-striped">';
                                
                                    echo '<thead>
                                        <tr class="tableau-top">
                                			<!--<th>#</th>-->
                              		       	<th>'.$rostersName.'</th>
                                			<th>PO</th>
                                            <th>'.$rostersHD.'</th>
                                            <th>CD</th>
                                            <th>'.$rostersIJ.'</th>
                                            <th>'.$rostersIT.'</th>
                                            <th>'.$rostersSP.'</th>
                                            <th>'.$rostersST.'</th>
                                            <th>'.$rostersEN.'</th>
                                            <th>'.$rostersDU.'</th>
                                            <th>'.$rostersDI.'</th>
                                            <th>'.$rostersSK.'</th>
                                            <th>'.$rostersPA.'</th>
                                            <th>'.$rostersPC.'</th>
                                            <th>'.$rostersDF.'</th>
                                            <th>'.$rostersOF.'</th>
                                            <th>'.$rostersEX.'</th>
                                            <th>'.$rostersLD.'</th>
                                            <th>'.$rostersOV.'</th>
                                            <th>Age</th>
                                            <th>Salary</th>
                                            <th>CT</th>
                                            <th>HT</th>
                                            <th>WT</th>
                            			</tr>    
                                    </thead>';
                                    
                                    if ($rosterType == 'Pro') {
                                        $results = $rosters->getProRosters();
                                    }else{
                                        $results = $rosters->getFarmRosters();
                                    }
                                    
            
                                    //create result rows
                                    foreach ($results as $roster) {
                                        
                                        //$vitalsMatch = array_reduce($playerVitals->getVitals(), new PlayerFilter($roster));
                                        //var_dump($vitalsMatch);
                                        $vitals = $playerVitals->findVital($roster->getNumber(), $roster->getName());
        
                                        echo '<tr>';
                                        //echo '<td>'.$roster->getNumber().'</td>';
                                        echo '<td class="text-left"><a href="CareerStatsPlayer.php?csName='.urlencode($roster->getName()).'">'.$roster->getName().'</a></td>';
                                        echo '<td>'.$roster->getPosition().'</td>';
                                        echo '<td>'.$roster->getHand().'</td>';
                                        echo '<td>'.$roster->getCondition().'</td>';
                                        echo '<td>'.$roster->getInjStatus().'</td>';
                                        echo '<td>'.$roster->getIt().'</td>';
                                        echo '<td>'.$roster->getSp().'</td>';
                                        echo '<td>'.$roster->getSt().'</td>';
                                        echo '<td>'.$roster->getEn().'</td>';
                                        echo '<td>'.$roster->getDu().'</td>';
                                        echo '<td>'.$roster->getDi().'</td>';
                                        echo '<td>'.$roster->getSk().'</td>';
                                        echo '<td>'.$roster->getPa().'</td>';
                                        echo '<td>'.$roster->getPc().'</td>';
                                        echo '<td>'.$roster->getDf().'</td>';
                                        echo '<td>'.$roster->getSc().'</td>';
                                        echo '<td>'.$roster->getEx().'</td>';
                                        echo '<td>'.$roster->getLd().'</td>';
                                        echo '<td>'.$roster->getOv().'</td>';
                                        echo '<td>'.$vitals->getAge().'</td>';
                                        echo '<td>'.$vitals->getSalary().'</td>';
                                        echo '<td>'.$vitals->getContractLength().'</td>';
                                        echo '<td>'.$vitals->getHeight().'</td>';
                                        echo '<td>'.$vitals->getWeight().'</td>';
                                        echo '</tr>';
                                       
                                    }
                                    
                                    
                                    //calculate averages 
                                    $avgIt = 0;
                                    $avgSp  = 0;
                                    $avgSt = 0;
                                    $avgEn = 0;
                                    $avgDu = 0;
                                    $avgDi = 0;
                                    $avgSk = 0;
                                    $avgPa = 0;
                                    $avgPc = 0;
                                    $avgDf  = 0;
                                    $avgSc  = 0;
                                    $avgEx  = 0;
                                    $avgLd  = 0;
                                    $avgOv  = 0;                            
                                    $goalieCount=0;
                                    
                                    
                                    //calculate averages
                                    foreach ($results as $roster) {
                                        $avgIt += $roster->getIt();
                                        $avgSp += $roster->getSp();
                                        $avgSt += $roster->getSt();
                                        $avgEn += $roster->getEn();
                                        $avgDu += $roster->getDu();
                                        $avgDi += $roster->getDi();
                                        $avgSk += $roster->getSk();
                                        $avgPa += $roster->getPa();
                                        $avgPc += $roster->getPc();
                                        if($roster->getPosition() != 'G') {
                                            $avgDf += $roster->getDf();
                                            $avgSc += $roster->getSc();
                                        }
                                        else $goalieCount++;
                                        $avgEx += $roster->getEx();
                                        $avgLd += $roster->getLd();
                                        $avgOv += $roster->getOv();
          
                                        //$avgContract += floatval($contrat[$i]);
        
                                    }
                                    
                                    $resultsSize = count($results);
                                    //$avgContract = round($avgContract / $resultsSize);
                                    $avgIt = round($avgIt / $resultsSize);
                                    $avgSp = round($avgSp / $resultsSize);
                                    $avgSt = round($avgSt / $resultsSize);
                                    $avgEn = round($avgEn / $resultsSize);
                                    $avgDu = round($avgDu / $resultsSize);
                                    $avgDi = round($avgDi / $resultsSize);
                                    $avgSk = round($avgSk / $resultsSize);
                                    $avgPa = round($avgPa / $resultsSize);
                                    $avgPc = round($avgPc / $resultsSize);
                                    $avgDf = round($avgDf / ($resultsSize-$goalieCount));
                                    $avgSc = round($avgSc / ($resultsSize-$goalieCount));
                                    $avgEx = round($avgEx / $resultsSize);
                                    $avgLd = round($avgLd / $resultsSize);
                                    $avgOv = round($avgOv / $resultsSize);
                                    
                                    //display averages in table footer
                                    echo ' <tfoot>
                                        <tr class="tableau-top">
                              		       	<th colspan="5"></th>
                                            <th>'.$avgIt.'</th>
                                            <th>'.$avgSp.'</th>
                                            <th>'.$avgSt.'</th>
                                            <th>'.$avgEn.'</th>
                                            <th>'.$avgDu.'</th>
                                            <th>'.$avgDi.'</th>
                                            <th>'.$avgSk.'</th>
                                            <th>'.$avgPa.'</th>
                                            <th>'.$avgPc.'</th>
                                            <th>'.$avgDf.'</th>
                                            <th>'.$avgSc.'</th>
                                            <th>'.$avgEx.'</th>
                                            <th>'.$avgLd.'</th>
                                            <th>'.$avgOv.'</th>
                                            <th>'.$playerVitals->getAvgAge().'</th>
                                            <th>'.$playerVitals->getAvgSalary().'</th>
                                            <th></th>
                                            <th>'.$playerVitals->getAvgHeight().'</th>   
                                            <th>'.$playerVitals->getAvgWeight().'</th>
                                                                         
                            			</tr>
                                    </tfoot>';
                                    
                                
                                echo '</table>'; //end table
                                echo '</div>'; //end resp table
                                echo '</div>'; //end tab pane
                            }
                            echo '</div>'; //end tab-content
                        }else{
                            //parsing error
                            echo '<h3>ERROR PARSING ROSTERS</h3>';
                        }
                        
        
                    } else{
                        if(!file_exists($fileName)){
                            echo '<h3>' . $allFileNotFound . ' - ' . $fileName . '</h3>';
                        }
                        
                        if(!file_exists($vitalsFileName)){
                            echo '<h3>' . $allFileNotFound . ' - ' . $vitalsFileName . '</h3>'; 
                        }
                    }
                    
                    ?>
                    
        		</div> 
            </div>   
		</div>
	</div>
</div>

</body>
</html>