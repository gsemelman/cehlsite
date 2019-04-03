
<?php 

//include GMO_ROOT.'config4.php';
require_once __DIR__ .'/../../config.php';
include GMO_ROOT.'login/mysqli.php';

if($league_langue == "fr") {
    $langPosition[0] = 'Changement de Position';
    $langPosition[1] = 'C';
    $langPosition[2] = 'AG';
    $langPosition[3] = 'AD';
    $langPosition[4] = 'D';
    $langPosition[5] = 'G';
    $langPosition[6] = 'DATE';
    $langPosition[7] = 'JOUEUR';
    $langPosition[8] = 'ÉQUIPE';
    $langPosition[9] = 'AVANT';
    $langPosition[10] = 'APRÈS';
    $langPosition[11] = 'SUPPRIMER';
    $langPosition[12] = 'POSITION';
    $langPosition[13] = 'TRIER PAR';
    $langPosition[14] = 'ÉQUIPE';
    $langPosition[100] = 'Menu Principal';
    $langPosition[101] = 'Page des échanges';
    $langPosition[102] = 'Page des signatures';
    $langPosition[103] = 'Page des changements de position';
    $langPosition[104] = 'Page des votes';
}

if($league_langue == "en") {
    $langPosition[0] = 'Position Change';
    $langPosition[1] = 'C';
    $langPosition[2] = 'LW';
    $langPosition[3] = 'RW';
    $langPosition[4] = 'D';
    $langPosition[5] = 'G';
    $langPosition[6] = 'DATE';
    $langPosition[7] = 'PLAYER';
    $langPosition[8] = 'TEAM';
    $langPosition[9] = 'BEFORE';
    $langPosition[10] = 'AFTER';
    $langPosition[11] = 'DELETE';
    $langPosition[12] = 'POSITION';
    $langPosition[13] = 'SORT BY';
    $langPosition[14] = 'TEAM';
    $langPosition[100] = 'Home';
    $langPosition[101] = 'Trade Page';
    $langPosition[102] = 'Signing Page';
    $langPosition[103] = 'Position Change Page';
    $langPosition[104] = 'Poll Page';
}

if(isset($teamID)){
    
    //query team rank
    $sql = "SELECT `RANK` FROM `$db_table` WHERE `INT` = '$teamID' LIMIT 1";
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    $useLNS = 0;
    if($query){
        while($data = mysqli_fetch_array($query)) {
            $teamRank = $data['RANK'];
        }
    }

    //ticket price query
    $sql = "SELECT EMAIL,TICKETS,TICKETS_REQ  FROM `".$db_table."`  WHERE `INT` = '$teamID' LIMIT 1";
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
   // $query = mysqli_query($con, $sql);
    if($query){
        while($data = mysqli_fetch_array($query)) {
            $TeamEmail = $data['EMAIL'];
            $TeamTicketPrice = $data['TICKETS'];
            $ReqTeamTicketPrice = $data['TICKETS_REQ'];
            
//             if(!$ReqTeamTicketPrice){
//                 $ReqTeamTicketPrice = 'N/A';
//             }
        }
    }else{
       
        //handle error
    }
    
    //position change query
    $sql = "SELECT `ID`, DATE(`DATE`) AS DATE, `NAME`, `POS_BF`, `POS_AF` FROM `".$db_table."_position` WHERE `TEAM` = '".$_SESSION['equipesim']."' ORDER BY `ID` DESC";
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if(mysqli_num_rows($query) != 0) {

        while($data = mysqli_fetch_array($query)) {
            $DB_TEAM_POS_ID[] = $data['ID'];
            $DB_TEAM_POS_DT[] = $data['DATE'];
            $DB_TEAM_POS_NM[] = $data['NAME'];
            if($data['POS_BF'] == '00') $DB_TEAM_POS_BF[] = $langPosition[1];
            if($data['POS_BF'] == '01') $DB_TEAM_POS_BF[] = $langPosition[2];
            if($data['POS_BF'] == '02') $DB_TEAM_POS_BF[] = $langPosition[3];
            if($data['POS_BF'] == '03') $DB_TEAM_POS_BF[] = $langPosition[4];
            if($data['POS_BF'] == '04') $DB_TEAM_POS_BF[] = $langPosition[5];
            if($data['POS_AF'] == '00') $DB_TEAM_POS_AF[] = $langPosition[1];
            if($data['POS_AF'] == '01') $DB_TEAM_POS_AF[] = $langPosition[2];
            if($data['POS_AF'] == '02') $DB_TEAM_POS_AF[] = $langPosition[3];
            if($data['POS_AF'] == '03') $DB_TEAM_POS_AF[] = $langPosition[4];
            if($data['POS_AF'] == '04') $DB_TEAM_POS_AF[] = $langPosition[5];
        }
    }
    
    //player query
    
    $gm_sortPlayer = 0;
    if($gm_sortPlayer == 0) $sql = "SELECT `NAME`,`POSI` FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' ORDER BY `NAME` ASC"; // Sort by First Name
    else $sql = "SELECT `NAME`,`POSI` FROM `".$db_table."_players` WHERE `TEAM` = '$teamRank' ORDER BY substring_index(TRIM(`NAME`), ' ', -1) ASC"; // Sort by Last Name
    
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if($query){
        while($data = mysqli_fetch_array($query)) {

            $playerName[] = $data['NAME'];
            $playerPosi[] = $data['POSI'];
            if($data['POSI'] == '00') $playerPosT[] = $langPosition[1];
            if($data['POSI'] == '01') $playerPosT[] = $langPosition[2];
            if($data['POSI'] == '02') $playerPosT[] = $langPosition[3];
            if($data['POSI'] == '03') $playerPosT[] = $langPosition[4];
            if($data['POSI'] == '04') $playerPosT[] = $langPosition[5];
        }
    }
    
    
    //player release query
    $sql = "SELECT id, playerName FROM `".$db_table."_player_release` WHERE teamId = '$teamID'";
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if($query){
        while($data = mysqli_fetch_array($query)) {
            $playerReleaseId[] = $data['id'];
            $playerReleaseName[] = $data['playerName'];
        }
    }

    mysqli_close($con);
}


?>

<style>

.blink { background-color : orange; transition : all linear 600ms; }

.alert-fixed {
    top: 60px;     
    width: 75%;
    position: fixed;
    left: 50%;
    margin-left: -37.5%;
    z-index:9999; 
}

</style>


<div class = "container">
<div class="row">
<div class="col mt-2 px-0">
	<div class = "card">
	    <div class = "card-header text-center">
			My Team
		</div>
		
		<div id="myTeamCardBody" class = "card-body px-3">
		
    		<div class="my-3 p-2 bg-white rounded box-shadow border-bottom ">
                <h6 class="border-bottom border-gray pb-2 mb-0">General</h6>
                <div class="media text-muted pt-3">
                  	<span><strong>Team:</strong></span>
                    <span class="ml-1 align-middle"><?php echo $_SESSION['equipe']; ?></span>
                </div>
                <div class="media text-muted pt-3">
                 	<span><strong>Email:</strong></span>
                    <span class="ml-1 align-middle"><?php echo $TeamEmail; ?></span>
                </div>
<!--                 <div class="media text-muted pt-3"> -->
                 
<!--                 </div> -->
            </div>
           
            <div class="my-3 p-2 bg-white rounded box-shadow ">
                <h6 class="border-bottom border-gray pb-2 mb-0">Tickets</h6>
                <div class="pt-3">
                  <div style ="block-inline" class="media-body pb-3 mb-0 medium lh-125 border-bottom border-gray clearfix ">
           
                  <?php if(!isset($ReqTeamTicketPrice)){
                    $displayRequested = 'display:none;';
                    $ticketPriceState = "REQ";
                    $ticketPriceStateText = "Request Change";
                  }else{
                    $displayRequested='';
                    $ticketPriceState = "CAN";
                    $ticketPriceStateText = "Cancel Request";
                  }
                  ?>   

<!--                   <span class="float-right"><button id="btnTicketPrice" class="btn btn-outline-primary" data-toggle="modal" data-target="#ticketPriceModal" value="REQ">Request Change</button></span> -->
                  <span class="float-right"><button id="btnTicketPrice" class="btn btn-outline-primary" 
                  		data-toggle="modal" value="<?php echo $ticketPriceState;?>"><?php echo $ticketPriceStateText;?></button></span>
                
                  <div class="media text-muted">
                  	<span><strong>Ticket Price:</strong></span>
                    <span id="currentTicketPrice" class="ml-1 align-middle"><?php echo $TeamTicketPrice; ?></span>
                  </div>
     

                  <div id ="requestedTicketPrice" class="media text-muted pt-3" style="<?php echo $displayRequested;?> ">
                   	<span><strong>Requested Ticket Price:</strong></span>
                    <span id="requestedTicketPriceValue" class="ml-1 align-middle"><?php echo $ReqTeamTicketPrice; ?></span>
                  </div>
     
                   
                  </div>
                   
                </div>
                
            </div>
            
            <!-- position change -->
    		<div class="my-3 p-2 bg-white rounded box-shadow">
                <h6 class="border-bottom border-gray pb-2 mb-0">Position Change</h6>
                <div class="border-bottom border-gray">
                    <div class="pt-3 pb-2">
                      	 <span class="float-right" style="float:right;"><button id="btnRequestPosChange" class="btn btn-outline-primary" data-toggle="modal" data-target="#positionChangeModal" >Request Change</button></span>
                    </div>
    
                    <div class="pt-5">
                        <?php 
                                       
                        if(isset($DB_TEAM_POS_ID)){
                            $tableStyle = '';
                        }else{
                            $tableStyle = 'display:none';
                           // echo '<div class="text-center">No pending requests</div>';
                        }
                        
                        ?>
                     	<table id="tableTeamPosChange" class="table table-striped table-sm wow fadeIn" style ="<?php echo $tableStyle?>">
                          <thead>
                            <tr>
                           
                              <th class="text-left" style="width:40%">Player</th>
                              <th class="text-center" colspan="3" style="width:33%" >Position Change</th>
                              <th style="width:27%"></th>
                             
                            </tr>
                          </thead>
                          <tbody>
                           
                            <?php 
                            if(isset($DB_TEAM_POS_ID)){
                                for ($i = 0; $i < count($DB_TEAM_POS_ID); $i++) {
                                    echo '<tr  style="line-height:2.9">
                                
                                      <td>'.$DB_TEAM_POS_NM[$i].'</td>
                                      <td class="text-right" style="width:13%">'.$DB_TEAM_POS_BF[$i].'</td>
                                      <td class="text-center" style="width:10%"><i style="margin-left:2px; margin-right:4px; border: solid #'.$databaseColors['colorMainText'].'; border-width: 0 3px 3px 0; display: inline-block; padding: 3px; transform: rotate(-45deg); -webkit-transform: rotate(-45deg);"></i></td>
        				              <td class="text-left" style="width:13%">'.$DB_TEAM_POS_AF[$i].'</td>
                                      <td style="width:24%">
                                        <button value="'.$DB_TEAM_POS_ID[$i].'" class="btn btn-sm btn-primary btn-block"  >Cancel</button>  
                                      </td>
                                    </tr>';
                                }
                            }
                            ?>
                     
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="my-3 p-2 bg-white rounded box-shadow">
                <h6 class="border-bottom border-gray pb-2 mb-0">Release Player</h6>
                <div class="border-bottom border-gray">
                    <div class="pt-3 pb-2">
                      	 <span class="float-right" style="float:right;"><button id="btnRequestRelease" class="btn btn-outline-primary" data-toggle="modal" data-target="#playerReleaseModal" >Request Release</button></span>
                    </div>
    
                    <div class="pt-5">
                        <?php 
                                       
                        if(isset($playerReleaseId)){
                            $tableStyle = '';
                        }else{
                            $tableStyle = 'display:none';
                           // echo '<div class="text-center">No pending requests</div>';
                        }
                        
                        ?>
                     	<table id="tablePlayerRelease" class="table table-striped table-sm wow fadeIn" style ="<?php echo $tableStyle?>">
                          <thead>
                            <tr>
                           
                              <th class="text-left">Player</th>
                              <th></th>
                             
                            </tr>
                          </thead>
                          <tbody>
                           
                            <?php 
                            if(isset($playerReleaseId)){
                                for ($i = 0; $i < count($playerReleaseId); $i++) {
                                    echo '<tr  style="line-height:2.9">
                                      <td>'.$playerReleaseName[$i].'</td>

                                      <td style="width:24%">
                                        <button value="'.$playerReleaseName[$i].'" class="btn btn-sm btn-primary btn-block"  >Cancel</button>  
                                      </td>
                                    </tr>';
                                }
                            }
                            ?>
                     
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
      
      
    		
		</div>
	</div>
	
	<div class="modal fade" id="ticketPriceModal" tabindex="-1" role="dialog" aria-labelledby="ticketPriceModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ticketPriceModalLabel">Ticket Price Change</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
<!--           <form id="ticketPriceForm" method="post" action="gmo/membre/ticketPriceSave.php"> -->
          <div class="modal-body">
          	<label for="newTicketPrice">New Ticket Price:</label>
          	<input type="number" name="newTicketPrice" class="form-control" id="newTicketPrice" placeholder="<?php //echo $TeamTicketPrice; ?>">
          	<span id="ticketError" style="color:red;"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="btnSubmitTicketPrice" class="btn btn-primary">Submit</button>
          </div>
<!--            </form> -->
        </div>
      </div>
    </div>
    
	<div class="modal fade" id="positionChangeModal" tabindex="-1" role="dialog" aria-labelledby="positionChangeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="positionChangeModalLabel">Position Change Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
<!--           <form id="ticketPriceForm" method="post" action="gmo/membre/ticketPriceSave.php"> -->
              <div class="modal-body">
              <span id="posChangeError" style="color:red;"></span>
               <select id="selectPlayer" class = "form-control btn-outline-primary" style="width:20em; text-align:center;"">
                    <option value="">Choose Player</option>
                    <?php
                    for($i=0;$i<count($playerName);$i++) {
                        if($playerPosi[$i] == '04') continue; //skip goalies
                    	?>
                    	<option  data-pos="<?php echo $playerPosi[$i]; ?>" value="<?php echo $playerName[$i]; ?>"><?php echo $playerName[$i].' - '.$playerPosT[$i]; ?></option>
                    	<?php
                    }
                    ?>
                </select>
                
                
                <select id="positionSelection" class = "form-control btn-outline-primary mt-2" style="display:none; width:20em; text-align:center;" >
                    <option value="">Choose Position</option>
                    <option value="00"><?php echo $langPosition[1]; ?></option>
                    <option value="01"><?php echo $langPosition[2]; ?></option>
                    <option value="02"><?php echo $langPosition[3]; ?></option>
                    <option value="03"><?php echo $langPosition[4]; ?></option>
                    <option value="04"><?php echo $langPosition[5]; ?></option>
                </select>
      
              	
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="submitPositionChange" type="button" class="btn btn-primary">Submit</button>
              </div>
<!--            </form> -->
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="playerReleaseModal" tabindex="-1" role="dialog" aria-labelledby="playerReleaseModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="playerReleaseModal">Player Release Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
<!--           <form id="ticketPriceForm" method="post" action="gmo/membre/ticketPriceSave.php"> -->
              <div class="modal-body">
              <span id="playerReleaseError" style="color:red;"></span>
               <select id="selectPlayerRelease" class = "form-control btn-outline-primary" style="width:20em; text-align:center;"">
                    <option value="">Choose Player</option>
                    <?php
                    for($i=0;$i<count($playerName);$i++) {
                    	?>
                    	<option value="<?php echo $playerName[$i]; ?>"><?php echo $playerName[$i]; ?></option>
                    	<?php
                    }
                    ?>
                </select>
   
              	
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="submitPlayerRelease" type="button" class="btn btn-primary">Submit</button>
              </div>
<!--            </form> -->
        </div>
      </div>
    </div>
    

	<script type="text/javascript">
	var originalTicketPrice = "<?php echo $TeamTicketPrice; ?>";
	var endpointTicketPriceSave = "<?php echo BASE_URL?>gmo/membre/ticketPriceSave.php";
	var endpointPositionDelete = "<?php echo BASE_URL?>gmo/membre/position_delete.php";
	var endpointPositionSave = "<?php echo BASE_URL?>gmo/membre/position_save.php";
	var endpointPlayerRelease = "<?php echo BASE_URL?>gmo/membre/player_release_save.php";
	
	</script>
	<script type="text/javascript" src="<?php echo BASE_URL?>gmo/membre/myTeam.js"></script>
	
</div>
</div>
</div>
<?php 

unset($langPosition, $data, $query, $playerName, $playerPosi, $playerPosT, $playerReleaseId, $playerReleaseName);

?>