<?php
require_once 'config.php';
include 'lang.php';
require_once 'classes/TradeObj.php';

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

//READ TRADES CSV
$tradesArray = array();
$start_row = 2; //define start row
$i = 1; //define row count flag
$csvLocation = $folderLegacy."s".$seasonId."-trades.csv";

if(!file_exists($csvLocation)) {
    http_response_code(500);
    exit();
}

$file = fopen($csvLocation, "r");

if(empty($team)){
    while (($row = fgetcsv($file)) !== FALSE) {
        if($i >= $start_row) {            
            if($row[0] == "") continue;
            $trade = new TradeObj();
            $trade->setTeam1($row[0]);
            $trade->setTeam1Players($row[1]);
            $trade->setTeam1Prosepcts($row[2]);
            $trade->setTeam1Picks($row[3]);
            $trade->setTeam1Cash($row[4]);
            
            $trade->setTeam2($row[5]);
            $trade->setTeam2Players($row[6]);
            $trade->setTeam2Prosepcts($row[7]);
            $trade->setTeam2Picks($row[8]);
            $trade->setTeam2Cash($row[9]);
            
            $trade->setDate($row[10]);
            
            $tradesArray[$i-1] = $trade;
        }
        $i++;
    }
}else{
    while (($row = fgetcsv($file)) !== FALSE) {
        if($i >= $start_row) {
            if($row[0] == "") continue;
            if(trim($row[0]) == trim($team) || trim($row[5]) == trim($team)){
                $trade = new TradeObj();
                $trade->setTeam1($row[0]);
                $trade->setTeam1Players($row[1]);
                $trade->setTeam1Prosepcts($row[2]);
                $trade->setTeam1Picks($row[3]);
                $trade->setTeam1Cash($row[4]);
                
                $trade->setTeam2($row[5]);
                $trade->setTeam2Players($row[6]);
                $trade->setTeam2Prosepcts($row[7]);
                $trade->setTeam2Picks($row[8]);
                $trade->setTeam2Cash($row[9]);
                
                $trade->setDate($row[10]);
                
                $tradesArray[$i-1] = $trade;
            }
        }
        $i++;
    }
}


usort($tradesArray, function ($c1, $c2)
{
    
    //desc by date
    $returnValue = strtotime($c2->getDate()) - strtotime($c1->getDate());
    
    return $returnValue;
});


//echo '<pre>'; print_r($tradesArray); echo '</pre>';

//echo '{ "data": '.json_encode(array_values($tradesArray)).'}';
//http_response_code(200);


?>

<div class="row no-gutters">
	<div class="col">
		<div class="tableau-top">Transactions</div>
		<div class="table-responsive">
    		<table id = "contract-table" class="table table-sm table-striped table-hover table-rounded-bottom ">
    			<thead>
                    <tr>
                    	<th class="text-left">Team 1</th>
                    	<th class="text-left">Assets</th>
                    	<th class="text-left">Team 2</th>
                    	<th class="text-left">Assets</th>
                    </tr>
    			</thead>
    			<tbody>
    				<?php foreach($tradesArray as $trade) {
    				  
    				    ?>
    					<tr>
    						<td><?php echo $trade->getTeam1()?></td>
    						<td><?php echo $trade->concatTrade1()?></td>
    						<td><?php echo $trade->getTeam2()?></td>
    						<td><?php echo $trade->concatTrade2()?></td>
    					</tr>
    				<?php } ?>
    			</tbody>	
    		</table>
		</div>
	</div>

</div> <!-- end table -->




