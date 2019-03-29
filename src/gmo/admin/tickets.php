
<?php


include GMO_ROOT.'login/mysqli.php';

$TICKET_TEAM_INT = array();

//workaround due to conflict to other position page
//if(isset($data)){
    $sql = "SELECT `INT`, EQUIPE, TICKETS, TICKETS_REQ FROM `".$db_table."` WHERE TICKETS_REQ IS NOT NULL ORDER BY `EQUIPE` DESC";

    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if(mysqli_num_rows($query) != 0) {
        $x = 0;
        while($data = mysqli_fetch_array($query)) {
            $TICKET_TEAM_INT[$x] = $data['INT'];
            $TICKET_TEAM[$x] = $data['EQUIPE'];
            $TICKET_PRICE[$x] = $data['TICKETS'];
            $TICKET_PRICE_REQ[$x] = $data['TICKETS_REQ'];
            $x++;
        }

    }
    
    mysqli_close($con);
    
    
    
   // echo '<pre>'; print_r($TICKET_TEAM); echo '</pre>';
//}
?>
<div class="container mt-3">

	<h5>Ticket Change Requests</h5>
	<div class="row">
		<div class="col">
            <table class="table text-center">
              <thead>
                <tr>
                  <th scope="col">Team</th>
                  <th scope="col">Current</th>
                  <th scope="col">Requested</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
               
                <?php 
                if($TICKET_TEAM_INT){
                    for ($i = 0; $i < count($TICKET_TEAM_INT); $i++) {
                        echo '<tr>
                          <td>'.$TICKET_TEAM[$i].'</td>
                          <td>'.$TICKET_PRICE[$i].'</td>
                           <td>'.$TICKET_PRICE_REQ[$i].'</td>
                          <td><input onclick="javascript:deleteChange('.$TICKET_TEAM_INT[$i].');" class="button" type="button" value="'.$db_admin_position[11].'"></td>
                        </tr>';
                    }
                }
         
                ?>
         
              </tbody>
            </table>
    	</div>
	</div>
</div>

<script type="text/javascript">
function deleteChange(teamId) {
	   $.ajax({
	    	  type: "POST",
	    	  url: "<?php echo BASE_URL?>gmo/admin/tickets_delete.php",
	    	  data: {teamId: teamId}, // serializes the form's elements.
	    	 // dataType: 'json',
	    	  success: function(data){
	
	    	    location.reload();
	    	   
	    	  },
	    	    error : function(xhr, textStatus, errorThrown ) {
	    	        if (textStatus == 'timeout') {
	    	            this.tryCount++;
	    	            if (this.tryCount <= this.retryLimit) {
	    	                //try again
	    	                $.ajax(this);
	    	                return;
	    	            }            
	    	            return;
	    	        }
//	    	        if (xhr.status == 500) {
//	    	        	 alert("Error Requesting ticket price change");
//	    	        } else {
//	    	            //handle error
//	    	        }
	    	        alert("Error Deleting ticket price request");

	    	        return;
	    	       
	    	    }
	    	});
}
</script>
