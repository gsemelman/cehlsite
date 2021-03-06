<?php

require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'PlayersVitalsTest';
$CurrentTitle = $playerVitalsTitle;
$CurrentPage = 'PlayersVitalsTest';
include 'head.php';

include_once 'common.php';
include_once 'classes/PlayerVitalsHolder.php';
include_once 'classes/PlayerVitalObj.php';

?>

<h3>Player Vitals</h3>

<div class="container">
	<div class="row">
		<div class="col">

            <?php
            
            if (! isset($playoff))
                $playoff = '';
            
            $fileName = getLeagueFile($folder, $playoff, 'PlayerVitals.html', 'PlayerVitals');
            
            if (file_exists($fileName)) {
                //get rosters from file
                $playerVitals = new PlayerVitalsHolder($fileName, 'Washington');

                $lastUpdated = $playerVitals->getLastUpdated();

                if (isset($lastUpdated)) {
                    
                    echo '<h5>'.$lastUpdated.'</h5>';
                    
                    
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-sm">';
                    
                    echo '<tr class="tableau-top">
                			<th>#</th>
                            <th>R</th>
              		       	<th>Name</th>
                			<th>PO</th>
                            <th>Age</th>
                            <th>HT</th>
                            <th>WT</th>
                            <th>Salary</th>
                            <th>Contract</th>
                			</tr>';
                    
                    $results = $playerVitals->getVitals();
                    
                    //create result rows
                    foreach ($results as $vitals) {
                        
                        echo '<tr>';
                        echo '<td>'.$vitals->getNumber().'</td>';
                        echo '<td>'.$vitals->getRookie().'</td>';
                        echo '<td>'.$vitals->getName().'</td>';
                        echo '<td>'.$vitals->getPosition().'</td>';
                        echo '<td>'.$vitals->getAge().'</td>';
                        echo '<td>'.$vitals->getHeight().'</td>';
                        echo '<td>'.$vitals->getWeight().'</td>';
                        echo '<td>$'.$vitals->getSalary().'</td>';
                        echo '<td>'.$vitals->getContractLength().'</td>';
                        echo '</tr>';
                    }
                    
                    echo '</table>'; //end table
                    echo '</div>'; //end resp table
                  
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