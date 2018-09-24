<?php

include 'config.php';
include 'lang.php';
$CurrentHTML = 'Rosters2';
$CurrentTitle = $rostersTitle;
$CurrentPage = 'Rosters2';
include 'head.php';

include_once 'common.php';
include_once 'classes/RosterObj.php';
include_once 'classes/RostersHolder.php';
include_once 'classes/PlayerVitalObj.php';
include_once 'classes/PlayerVitalsHolder.php';
include_once 'classes/PlayerFilter.php';

?>

<div class="container">
	<div class="card">
	<div class="card-header wow fadeIn">
		<h3><?php echo $CurrentTitle; ?></h3>
	</div>
	<div class="card-body">
	<div class="row">
		<div class="col">

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
                    
                    echo '<h5>'.$lastUpdated.'</h5>';
                    
                    echo'<div id="rosterTabs" class="container">';
                    echo'<ul class="nav nav-tabs nav-fill">
                        			<li class="nav-item">
                                        <a class="nav-link" href="#Pro" data-toggle="tab">Pro Roster</a>
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
                        echo '<table class="table table-sm">';
                        
                            echo '<tr class="tableau-top">
                			<th>#</th>
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

                			</tr>';
                            
                            if ($rosterType == 'Pro') {
                                $results = $rosters->getProRosters();
                            }else{
                                $results = $rosters->getFarmRosters();
                            }
                            
                            //create result rows
                            foreach ($results as $roster) {
                                
                                $vitalsMatch = array_filter($playerVitals->getVitals(), new PlayerFilter($roster->getNumber(),$roster->getName()));
                                $vitals = $vitalsMatch[0];

                                echo '<tr>';
                                echo '<td>'.$roster->getNumber().'</td>';
                                echo '<td class="text-left">'.$roster->getName().'</td>';
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
                                echo '<td>$'.$vitals->getSalary().'</td>';
                                echo '<td>'.$vitals->getContractLength().'</td>';
                                echo '<td>'.$vitals->getHeight().'</td>';
                                echo '<td>'.$vitals->getWeight().'</td>';
                                echo '</tr>';
                            }
                            
                        
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
           </div></div>     
		</div>
	</div>
</div>

</body>
</html>