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

.table.fixed-column-striped, .table.fixed-column {
	border-collapse: collapse;
	width: 100%;
}

.table.fixed-column td, th, .table.fixed-column-striped td, th {
	/*border: 1px solid #dddddd;*/
	text-align: left;
	padding: 3px;
}

.table.fixed-column-striped th:first-child, td:first-child, .table.fixed-column th:first-child,
	td:first-child {
	position: sticky;
	left: 0px;
}

.table.fixed-column-striped tr:nth-child(even) td:first-child {
	background-color: rgba(176, 214, 255, 1.0);
}

.table.fixed-column-striped tr:nth-child(odd) td:first-child {
	background-color: rgba(225, 239, 255, 1.0);
}

.table tfoot th, .table thead th {
	background-color: rgba(23, 145, 202, 1.0);
}

.table.fixed-column-striped th a, .table.fixed-column th a {
	color: #ffffff;
}

.table-striped>tbody>tr:nth-child(even) {
	background-color: rgba(176, 214, 255, 1.0);
}

.table-striped>tbody>tr:nth-child(odd) {
	background-color: rgba(225, 239, 255, 1.0);
}
</style>

<div class="container">
	<div class="row no-gutters">
	<div class="col"> 
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

<!-- 		<div class = "row"> -->
<!--         	<div class = "col-2"> -->
        	    <?php 
//                 $teamCardLogoSrc = glob($folderTeamLogos.strtolower($currentTeam).'.*');
//                 if(isset($teamCardLogoSrc[0])) {
//                     echo'<img class="float-left panel-profile-img" src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
//                 }
//                 ?>
<!--         	</div> -->
<!--         	<div class = "col-8 d-flex align-items-center justify-content-center"> -->
  <!--          	<h3><?php //echo $CurrentTitle; ?></h3>-->
<!--         	</div> -->
        
<!--            <div class = "col-2"></div> -->

<!--     	</div> -->
		
	</div>
    	<div class="card-body px-2 px-lg-4">
    
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
                                echo '<table id="'.$tableId.'" class="table table-sm table-striped fixed-column-striped">';
                                
                                    echo '<thead>
                                        <tr class="tableau-top">
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
                              		       	<th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>'.$rosterAvgs->getAvgIt().'</th>
                                            <th>'.$rosterAvgs->getAvgSp().'</th>
                                            <th>'.$rosterAvgs->getAvgSt().'</th>
                                            <th>'.$rosterAvgs->getAvgEn().'</th>
                                            <th>'.$rosterAvgs->getAvgDu().'</th>
                                            <th>'.$rosterAvgs->getAvgDi().'</th>
                                            <th>'.$rosterAvgs->getAvgSk().'</th>
                                            <th>'.$rosterAvgs->getAvgPa().'</th>
                                            <th>'.$rosterAvgs->getAvgPc().'</th>
                                            <th>'.$rosterAvgs->getAvgDf().'</th>
                                            <th>'.$rosterAvgs->getAvgSc().'</th>
                                            <th>'.$rosterAvgs->getAvgEx().'</th>
                                            <th>'.$rosterAvgs->getAvgLd().'</th>
                                            <th>'.$rosterAvgs->getAvgOv().'</th>
                                            <th>'.$playerVitals->getAvgAge().'</th>
                                            <th class="text-right">$'.$playerVitals->getAvgSalary().'</th>
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
                            
                            echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$lastUpdated.'</h5>';
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

window.onload = function () {
	makeTableSortable('RosterPro');
	makeTableSortable('RosterFarm');
	};

</script>

<?php include 'footer.php'; ?>