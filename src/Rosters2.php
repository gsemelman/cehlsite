<?php

include 'config.php';
include 'lang.php';
$CurrentHTML = 'Rosters2';
$CurrentTitle = $rostersTitle;
$CurrentPage = 'Rosters2';
include 'head.php';

include_once 'common.php';
include_once 'classes/Rosters.php';
include_once 'classes/Roster.php';

?>

<h3>Rosters</h3>

<div class="container">
	<div class="row">
		<div class="col">

            <?php
            
            if (! isset($playoff))
                $playoff = '';
            
            $fileName = getLeagueFile($folder, $playoff, 'Rosters.html', 'Rosters');
            
            if (file_exists($fileName)) {
                //get rosters from file
                $rosters = new Rosters($fileName, 'Washington');

                $lastUpdated = $rosters->getLastUpdated();

                if (isset($lastUpdated)) {
                    
                    echo '<h5>'.$lastUpdated.'</h5>';
                    
                    echo'<div id="rosterTabs" class="container">';
                    echo'<ul class="nav nav-pills nav-fill">
                        			<li class="nav-item active">
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
                			<th>'.$rostersNumber.'</th>
              		       	<th>'.$rostersName.'</th>
                			<th>'.$rostersPosition.'</th>
                            <th>'.$rostersHD.'</th>
                            <th>Condition</th>
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
                			</tr>';
                            
                            if ($rosterType == 'Pro') {
                                $results = $rosters->getProRosters();
                            }else{
                                $results = $rosters->getFarmRosters();
                            }
                            
                            //create result rows
                            foreach ($results as $roster) {
                                
                                echo '<tr>';
                                echo '<td>'.$roster->getNumber().'</td>';
                                echo '<td>'.$roster->getName().'</td>';
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
                

            } else
                echo '<h3>' . $allFileNotFound . ' - ' . $fileName . '</h3>';
            
            ?>
                
		</div>
	</div>
</div>

</body>
</html>