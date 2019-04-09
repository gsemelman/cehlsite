<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'config.php';
include 'lang.php';
$CurrentHTML = 'TeamRosters';
$CurrentTitle = $rostersTitle;
$CurrentPage = 'TeamRosters';
include 'head.php';
include 'TeamHeader.php';

include_once 'common.php';
include_once 'classes/RosterObj.php';
include_once 'classes/RosterAvgObj.php';
include_once 'classes/RostersHolder.php';
include_once 'classes/PlayerVitalObj.php';
include_once 'classes/PlayerVitalsHolder.php';

?>

<style>

</style>

<div class="container">
	<div class="row no-gutters">
	<div class="col"> 
	<div class="card">
	<div class="card-header p-1">
		<?php include 'TeamCardHeader.php'?>
	</div>
    	<div class="card-body px-2 px-lg-4 wow fadeIn">
    
                    <?php

                    $fileName = getLeagueFile($folder, $playoff, 'Rosters.html', 'Rosters');
                    $vitalsFileName = getLeagueFile($folder, $playoff, 'PlayerVitals.html', 'PlayerVitals');
                    $lastUpdated = '';
                    
                    if (file_exists($fileName) && file_exists($vitalsFileName)) {
                        //get rosters from file
                        $rosters = new RostersHolder($fileName, $currentTeam);
                        $playerVitals = new PlayerVitalsHolder($vitalsFileName, $currentTeam);
                        
        
                        $lastUpdated = $rosters->getLastUpdated();
        
                        if (isset($lastUpdated)) {
                            
                            //echo '<h5>'.$lastUpdated.'</h5>';
                            //echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
                            
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

                                $tableId = 'Roster' . $rosterType;
                                $active = ($rosterType == 'Pro' ? ' active' : '');

                                echo'<div class="tab-pane'.$active.'" id="'.$rosterType.'">';
             
                                //create table header
                                echo '<div class="table-responsive">';
                                echo '<table id="'.$tableId.'" class="table table-sm table-striped table-hover fixed-column text-center">';
                                
                                    echo '<thead>
                                        <tr>
                                            <th class="text-left">'.$rostersName.'</th>
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
                                            <th class="text-right">Salary</th>
                                            <th>CT</th>
                                            <th>HT</th>
                                            <th>WT</th>
                            			</tr>    
                                    </thead>';
                                    
                                    if ($rosterType == 'Pro') {
                                        $results = $rosters->getProRosters();
                                        $rosterAvgs = $rosters->getProAverages();
                                    }else{
                                        $results = $rosters->getFarmRosters();
                                        $rosterAvgs = $rosters->getFarmAverages();
                                    }
                                    
                                    echo '<tbody style="font-weight:normal">';
                                    //create result rows
                                    foreach ($results as $roster) {
                                        
                                        $vitals = $playerVitals->findVital($roster->getNumber(), $roster->getName());
                                        //var_dump($vitals);
                                        
                                        $scoringNameSearch = htmlspecialchars($roster->getName());
                                        $scoringNameLink = 'http://www.google.com/search?q='.$scoringNameSearch.'%nhl.com&btnI';

                                        echo '<tr>';
                                            echo '<td class="text-left"><a href="'.$scoringNameLink.'">'.$roster->getName().'</a></td>';
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
                                            echo '<td style="font-weight:bold; font-size: 13px;">'.$roster->getOv().'</td>';
                                            echo '<td>'.$vitals->getAge().'</td>';
                                            echo '<td class="text-right">$'.number_format($vitals->getSalary()).'</td>';
                                            echo '<td class="text-center">'.$vitals->getContractLength().'</td>';
                                            echo '<td>'.$vitals->getHeight().'</td>';
                                            echo '<td>'.$vitals->getWeight().'</td>';
                                        echo '</tr>';             
                                    }
                                    echo '</tbody>';
                                    
                                    //display averages in table footer
                                    echo ' <tfoot>
                                        <tr class="tableau-top">
                              		       	<td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>'.$rosterAvgs->getAvgIt().'</td>
                                            <td>'.$rosterAvgs->getAvgSp().'</td>
                                            <td>'.$rosterAvgs->getAvgSt().'</td>
                                            <td>'.$rosterAvgs->getAvgEn().'</td>
                                            <td>'.$rosterAvgs->getAvgDu().'</td>
                                            <td>'.$rosterAvgs->getAvgDi().'</td>
                                            <td>'.$rosterAvgs->getAvgSk().'</td>
                                            <td>'.$rosterAvgs->getAvgPa().'</td>
                                            <td>'.$rosterAvgs->getAvgPc().'</td>
                                            <td>'.$rosterAvgs->getAvgDf().'</td>
                                            <td>'.$rosterAvgs->getAvgSc().'</td>
                                            <td>'.$rosterAvgs->getAvgEx().'</td>
                                            <td>'.$rosterAvgs->getAvgLd().'</td>
                                            <td>'.$rosterAvgs->getAvgOv().'</td>
                                            <td>'.$playerVitals->getAvgAge().'</td>
                                            <td class="text-right">$'.$playerVitals->getAvgSalary().'</td>
                                            <td></td>
                                            <td>'.$playerVitals->getAvgHeight().'</td>
                                            <td>'.$playerVitals->getAvgWeight().'</td>
                                                
                            			</tr>
                                    </tfoot>'; 
 
                                echo '</table>'; //end table
                                echo '</div>'; //end resp table
                                echo '</div>'; //end tab pane
                            }
                            echo '</div>'; //end tab-content
                            
                            echo '<h6 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h6>';
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
 
</div>
<script>

// window.onload = function () {
// 	makeTableSortable('RosterPro');
// 	makeTableSortable('RosterFarm');
// 	};

$(document).ready(function() 
    { 
        $("#RosterPro").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 
        $("#RosterFarm").tablesorter({ 
            sortInitialOrder: 'desc'
    	}); 
    } 
); 



</script>

<?php include 'footer.php'; ?>