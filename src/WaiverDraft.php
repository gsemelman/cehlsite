<?php
$dataTablesRequired = 1; //require datatables import

include 'config.php';
include 'lang.php';
$CurrentHTML = 'WaiverDraft.php';
$CurrentTitle = 'WaiverDraft';
$CurrentPage =  'WaiverDraft';
include 'head.php';

include_once 'common.php';


//READ WAIVER CSV
$waiverArray = array();
$start_row = 2; //define start row
$i = 1; //define row count flag
$csvLocation = $folderLegacy."waiverDraft.csv";
$file = fopen($csvLocation, "r");
while (($row = fgetcsv($file)) !== FALSE) {
    if($i >= $start_row) {
        $waiverArray[$i] = $row;
    }
    $i++;
}

function calcOv(&$arr){
    
    $ov = 0;
    

    
    if($arr[3] == 'C' ||$arr[3] == 'RW' || $arr[3] == 'LW' ) {
        $weighted_total =
        ($arr[4] * 5) +
        ($arr[5]* 5) +
        ($arr[6] * 7) +
        ($arr[7] * 3) +
        ($arr[8] * 1) +
        ($arr[9] * 1) +
        ($arr[10] * 6) +
        ($arr[11] * 10) +
        ($arr[12] * 8) +
        ($arr[13] * 7) +
        ($arr[14] * 13) +
        ($arr[15]* 1) +
        ($arr[16] * 1);
        $ov = 5 + ($weighted_total / 68);
        $ov = round($ov,0);
       
    }
    
    //defensive D
    if($arr[3] == "D" && (($arr[11] + $arr[14]) >= ($arr[13] + $arr[6]))) {
        $weighted_total =
        ($arr[4] * 4) +
        ($arr[5]* 8) +
        ($arr[6] * 4) +
        ($arr[7] * 3) +
        ($arr[8] * 1) +
        ($arr[9] * 1) +
        ($arr[10] * 8) +
        ($arr[11] * 11) +
        ($arr[12] * 6) +
        ($arr[13] * 6) +
        ($arr[14] * 11) +
        ($arr[15]* 1) +
        ($arr[16] * 1);
        $ov = 5 + ($weighted_total / 68);
        $ov = round($ov,0);
        
    }
    
    //offensive D
    if($arr[3] == "D" && $ov == 0) {
        $weighted_total =
        ($arr[4] * 8) +
        ($arr[5]* 5) +
        ($arr[6] * 10) +
        ($arr[7] * 3) +
        ($arr[8] * 1) +
        ($arr[9] * 1) +
        ($arr[10] * 6) +
        ($arr[11] * 8) +
        ($arr[12] * 6) +
        ($arr[13] * 13) +
        ($arr[14] * 5) +
        ($arr[15]* 1) +
        ($arr[16] * 1);
        $ov = 5 + ($weighted_total / 68);
        $ov = round($ov,0);
        
    }
    
    //G
    if($arr[3] == "G" && $ov == 0) {
        $weighted_total =
        ($arr[4] * 5) +
        ($arr[5]* 17) +
        ($arr[6] * 4) +
        ($arr[7] * 3) +
        ($arr[8] * 1) +
        ($arr[9] * 1) +
        ($arr[10] * 7) +
        ($arr[11] * 3) +
        ($arr[12] * 8) +
        ($arr[15]* 1) +
        ($arr[16] * 1);
        $ov = $weighted_total / 53;
        $ov = round($ov,0);
        
    }
    
    return $ov;

}
?>





<style>

 #faTable { 
   display:none;  
 } 

</style>

	<div class = "container-fluid" style = "width: 100%; height: 100%;">
		
    	<div class = "card">
    		<div class = "card-header">
    			<h3><?php echo $CurrentTitle; ?></h3>
    		</div>
    		<div class = "card-body p-2">
    			<div class="container">
        			<div class = "row justify-content-center" style="padding-top:10px;"> 
    
                		<div class="col-*-*">
                    		<label style="padding-right:10px;" class="text-center" for="positionInputField">Position: </label> 
                    	</div>
                    	<div class="col-*-*">
                    		<select
                			name="positionInputField" class="form-control mb-3"
                			id="positionInputField">
                			<option value="">All Players</option>
                			<option value="Skaters">All Skaters</option>
                			<option value="Forwards">All Forwards</option>
                			<option value="C">Center</option>
                			<option value="RW">Right Wing</option>
                			<option value="LW">Left Wing</option>
                			<option value="D">Defense</option>
                			<option value="G">Goalie</option>
                			</select>
                    	</div>
                
                		
                	</div>
                
                	<div class = "row"> 
                	<?php
                	
                	$i=0;
                	foreach ($waiverArray as $value){
                	    
                	    $unassignedPL[$i] = $value[1];
                	    $unassignedPO[$i] = $value[2];
                	    $unassignedAG[$i] = $value[3];
                	    $unassignedIT[$i] = $value[4];
                	    $unassignedSP[$i] = $value[5];
                	    $unassignedST[$i] = $value[6];
                	    $unassignedEN[$i] = $value[7];
                	    $unassignedDU[$i] = $value[8];
                	    $unassignedDI[$i] = $value[9];
                	    $unassignedSK[$i] = $value[10];
                	    $unassignedPA[$i] = $value[11];
                	    $unassignedPC[$i] = $value[12];
                	    $unassignedDF[$i] = $value[13];
                	    $unassignedSC[$i] = $value[14];
                	    $unassignedEX[$i] = $value[15];
                	    $unassignedLD[$i] = $value[16];
                	    $unassignedSAL[$i] = $value[17];
                	    $unassignedCT[$i] = $value[18];
                	    $unassignedOV[$i]  = calcOv($value);
                	    
                	    $i++;
                	}
                
                    
                		    if(isset($unassignedPL)) {
                		        
                		        
                		        echo '<div class="table-responsive">';
                		        //echo '<table id="freeAgents" class="table table-sm table-striped fixed-column-striped">';
                		        echo '<table id="faTable" class="table table-sm table-striped nowrap" style="width:100%">';
                		          echo '<thead>
                                            <tr>
                                                <th>'.$rostersName.'</th>
                                                <th>Age</th>
                                    			<th>PO</th>
                                                <th>Salary</th>
                                                <th>Contract</th>
                
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
                                     
                                			</tr>
                                        </thead>';
                		        echo '<tbody style="font-weight:normal">';
                		        
                		        for ($x = 0; $x < $i; $x++) {
                		            echo '<tr>';
                		            
                		            $scoringNameSearch = htmlspecialchars($unassignedPL[$x]);
                		            $scoringNameLink = 'http://www.google.com/search?q='.$scoringNameSearch.'%nhl.com&btnI';
                		            
                		            // 		            echo '<td class="text-left">'.$unassignedPL[$x].'</td>';
                		            echo '<td class="text-left"><a href="'.$scoringNameLink.'">'.$unassignedPL[$x].'</a></td>';
                		            echo '<td>'.$unassignedAG[$x].'</td>';
                		            echo '<td>'.$unassignedPO[$x].'</td>';
                		            echo '<td>'.$unassignedSAL[$x].'</td>';
                		            echo '<td>'.$unassignedCT[$x].'</td>';
                		            echo '<td>'.$unassignedIT[$x].'</td>';
                		            echo '<td>'.$unassignedSP[$x].'</td>';
                		            echo '<td>'.$unassignedST[$x].'</td>';
                		            echo '<td>'.$unassignedEN[$x].'</td>';
                		            echo '<td>'.$unassignedDU[$x].'</td>';
                		            echo '<td>'.$unassignedDI[$x].'</td>';
                		            echo '<td>'.$unassignedSK[$x].'</td>';
                		            echo '<td>'.$unassignedPA[$x].'</td>';
                		            echo '<td>'.$unassignedPC[$x].'</td>';
                		            echo '<td>'.$unassignedDF[$x].'</td>';
                		            echo '<td>'.$unassignedSC[$x].'</td>';
                		            echo '<td>'.$unassignedEX[$x].'</td>';
                		            echo '<td>'.$unassignedLD[$x].'</td>';
                		            echo '<td>'.$unassignedOV[$x].'</td>';

                		            echo '</tr>';        
                		        } 
                		        echo '</tbody>';
                		        echo '</table>';
                		        echo '</div>';
                		        
                		    }else {
                		        echo $langUnassignedPlayersNotFound;
                		    }
                
                		?>
                	</div>
            	</div>
    		</div>
    	</div>
	

	
	</div>

	<script>

// 	window.onload = function () {
// 		makeTableSortable('freeAgents');
// 	};


	var table = $('#faTable').DataTable({
		dom: 'lftBip',
		scrollY:        true,
        scrollX:        true,
        scrollCollapse: true,
        order: [[ 18, "desc" ]],
        fixedColumns:   {
            leftColumns: 1,
            rightColumns: 1
        },
        paging:         true,
        pagingType: "simple_numbers",
        lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
        language: {
            "lengthMenu": "Display _MENU_ records"
        },   
        search: {
            "regex": true
          },    
        initComplete: function () {
        	$("#faTable").show(); 
        },
        
        buttons: [
        	'copyHtml5',
            {
                extend: 'excelHtml5',
                title: 'FreeAgencyExport'
            },
            {
                extend: 'csvHtml5',
                title: 'FreeAgencyExport'
            }
        ]
        
	});


    $("#positionInputField").on('change', function() {  
        var pos = $(this).val();
        if(pos == 'Skaters'){
        	table.column(2).search('^(?=.*?(C|RW|LW|D)).*?', true, false).draw();
        }else if(pos == 'Forwards'){
        	table.column(2).search('^(?=.*?(C|RW|LW)).*?', true, false).draw();
        }else{
        	table.column(2).search(pos).draw() ; 
        }    
        
    } );



	</script>

<?php include 'footer.php'; ?>