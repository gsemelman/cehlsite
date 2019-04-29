<?php
require_once 'config.php';
include 'lang.php';
require_once 'classes/Contract.php';

if(isset($_GET['seasonId']) || isset($_POST['seasonId'])) {
    $seasonId = ( isset($_GET['seasonId']) ) ? $_GET['seasonId'] : $_POST['seasonId'];
    $seasonId = filter_var($seasonId, FILTER_VALIDATE_INT);
}

if(isset($_GET['team']) || isset($_POST['team'])) {
    $team = ( isset($_GET['team']) ) ? $_GET['team'] : $_POST['team'];
    //$team = filter_var($seasonId, FILTER_SANITIZE_STRING);
}

if(empty($seasonId)){
    http_response_code(400);
    exit();
}

//READ CONTRACTS CSV
$contractArray = array();
$start_row = 2; //define start row
$i = 1; //define row count flag
$csvLocation = $folderLegacy."s".$seasonId."-contracts.csv";

if(!file_exists($csvLocation)) {
    http_response_code(500);
    exit();
}

$file = fopen($csvLocation, "r");

if(empty($team)){
    while (($row = fgetcsv($file)) !== FALSE) {
        if($i >= $start_row) {            
            if($row[0] == "") continue;
            $contract = new Contract($row[0], $row[1],$row[2],$row[3],$row[4],$row[5], $row[6]);
            $contractArray[$i-1] = $contract;
        }
        $i++;
    }
}else{
    while (($row = fgetcsv($file)) !== FALSE) {
        if($i >= $start_row) {
            if($row[0] == "") continue;
            if(trim($row[0]) == trim($team)){
                $contract = new Contract($row[0], $row[1],$row[2],$row[3],$row[4],$row[5], $row[6]);
                $contractArray[$i-1] = $contract;
            }
        }
        $i++;
    }
}


// echo '<pre>'; print_r($contractArray); echo '</pre>';

// echo '{ "data": '.json_encode(array_values($contractArray)).'}';
// http_response_code(200);

usort($contractArray, function ($c1, $c2)
{
    
    //desc by date
    $returnValue = strtotime($c2->getDate()) - strtotime($c1->getDate());
    
    //asc by team
    if ($returnValue == 0) {
        $returnValue = $c1->getTeam() <=> $c2->getTeam();
    }
    
    //asc by name
    if ($returnValue == 0) {
        $returnValue = $c1->getName() <=> $c2->getName();
    }

    return $returnValue;
});

?>




<div class="card">
	<div id="standingsTabs" class="card-header px-2 px-lg-4 pb-1 pt-2">
		<ul class="nav nav-tabs nav-fill">
			<li class="nav-item"><a	class="nav-link active" href="#Signings" data-toggle="tab">Signings</a></li>
			<li class="nav-item"><a	class="nav-link" href="#Extensions"	data-toggle="tab">Extensions</a></li>
		</ul>
	</div>
	<div class="card-body tab-content m-0 p-0 pt-2">
		<div class="tab-pane active" id="Signings">
			<div id="SigningsInner">
				<div class="row no-gutters">
                	<div class="col">
                		<div class="tableau-top">Contract Signings</div>
                		<div class="table-responsive">
                    		<table id = "contract-table" class="table table-sm table-striped table-hover table-rounded-bottom ">
                    			<thead>
                                    <tr>
                                    	<?php if(empty($team)){ ?>
                                    	<th class="text-left">Team</th>
                                    	<?php } ?>
                                    	<th class="text-left">Player</th>
                                    	<th>Salary</th>
                                    	<th>Term</th>
                                    	<th>SB</th>
                                    	<th>AAV</th>
                                    	<th>Total</th>
                                    	<th>Date</th>
                                    </tr>
                    			</thead>
                    			<tbody>
                    				<?php foreach($contractArray as $contract) {
                    				    if($contract->getType() != "S") continue;
                    				    ?>
                    					<tr>
                    						<?php if(empty($team)){ ?>
                    						<td class="text-left"><?php echo $contract->getTeam()?></td>
                    						<?php } ?>
                    						<td class="text-left"><?php echo $contract->getName()?></td>
                    						<td><?php echo $contract->getSalaryDisplay()?></td>
                    						<td><?php echo $contract->getTermDisplay()?></td>
                    						<td><?php echo $contract->getBonusDisplay()?></td>
                    						<td><?php echo $contract->getAavDisplay()?></td>
                    						<td><?php echo $contract->getTotalDisplay()?></td>
                    						<td><?php echo $contract->getDate()?></td>
                    					</tr>
                    				<?php } ?>
                    			</tbody>	
                    		</table>
                		</div>
                	</div>
                
                </div> <!-- end table -->
			</div>
		</div>

		<div class="tab-pane" id="Extensions">
			<div id="ExtensionsInner">
				<div class="row no-gutters">
                	<div class="col">
                		<div class="tableau-top">Contract Extensions
                		<div><h6>*Applies next season</h6></div>
                		</div>
                		<div class="table-responsive">
                    		<table id = "extensions-table" class="table table-sm table-striped table-hover table-rounded-bottom ">
                    			<thead>
                                    <tr>
                                    	<?php if(empty($team)){ ?>
                                    	<th class="text-left">Team</th>
                                    	<?php } ?>
                                    	<th class="text-left">Player</th>
                                    	<th>Salary</th>
                                    	<th>Term</th>
                                    	<th>SB</th>
                                    	<th>AAV</th>
                                    	<th>Total</th>
                                    	<th>Date</th>
                                    </tr>
                    			</thead>
                    			<tbody>
                    				<?php foreach($contractArray as $contract) {
                    				    if($contract->getType() != "E") continue;
                    				    ?>
                    					<tr>
                    						<?php if(empty($team)){ ?>
                    						<td class="text-left"><?php echo $contract->getTeam()?></td>
                    						<?php } ?>
                    						<td class="text-left"><?php echo $contract->getName()?></td>
                    						<td><?php echo $contract->getSalaryDisplay()?></td>
                    						<td><?php echo $contract->getTermDisplay()?></td>
                    						<td><?php echo $contract->getBonusDisplay()?></td>
                    						<td><?php echo $contract->getAavDisplay()?></td>
                    						<td><?php echo $contract->getTotalDisplay()?></td>
                    						<td><?php echo $contract->getDate()?></td>
                    					</tr>
                    				<?php } ?>
                    			</tbody>	
                    		</table>
                		</div>
                	</div>
                
                </div> <!-- end table -->
			</div>
		</div>
	</div>

</div>



<script>

$("#contract-table").tablesorter({ 
    sortInitialOrder: 'asc'
}); 

$("#extensions-table").tablesorter({ 
    sortInitialOrder: 'asc'
}); 



</script>


