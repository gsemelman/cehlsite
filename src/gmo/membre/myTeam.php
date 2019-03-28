
<?php 

include FS_ROOT.'gmo/config4.php';
include FS_ROOT.'gmo/login/mysqli.php';

//only init if not already set

if(isset($teamID)){

    $sql = "SELECT EMAIL,TICKETS,TICKETS_REQ  FROM `".$db_table."`  WHERE `INT` = '$teamID' LIMIT 1";
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if($query){
        while($data = mysqli_fetch_array($query)) {
            $TeamEmail = $data['EMAIL'];
            $TeamTicketPrice = $data['TICKETS'];
            $ReqTeamTicketPrice = $data['TICKETS_REQ'];
        }
    }

    mysqli_close($con);
}


?>

<div class = "container">

	<div class = "card">
	    <div class = "card-header text-center">
			My Team
		</div>
		
		<div class = "card-body">
		
    		<div class="my-3 p-2 bg-white rounded box-shadow">
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
           
            <div class="my-3 p-2 bg-white rounded box-shadow">
                <h6 class="border-bottom border-gray pb-2 mb-0">Tickets</h6>
                <div class="pt-3">
                  <div class="media-body pb-3 mb-0 medium lh-125 border-bottom border-gray  clearfix">
                  <span class="float-right"><button class="btn btn-outline-primary" data-toggle="modal" data-target="#ticketPriceModal" >Request Change</button></span>
                    
                    
                  <div>
                  	<span><strong>Ticket Price:</strong></span>
                    <span id="currentTicketPrice" class="ml-1 align-middle"><?php echo $TeamTicketPrice; ?></span>
                  </div>
                  
                
                  <?php if(!isset($ReqTeamTicketPrice)){
                    $displayRequested = 'display:none;';
                  }else{
                    $displayRequested='';
                  }
                  ?>   
                  <div id="ReqTickPriceValue" style="<?php echo $displayRequested;?>">
                   	<span><strong>Requested Ticket Price:</strong></span>
                    <span id="requestedTicketPrice" class="ml-1 align-middle"><?php echo $ReqTeamTicketPrice; ?></span>
                  </div>
     
                   
                  </div>
                   
                </div>
                
            </div>
      
    		
		</div>
	</div>
	
	<div class="modal fade" id="ticketPriceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ticket Price Change</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="ticketPriceForm" method="post" action="gmo/membre/ticketPriceSave.php">
          <div class="modal-body">
          	<label for="newTicketPrice">New Ticket Price:</label>
          	<input type="text" name="newTicketPrice" class="form-control" id="newTicketPrice" placeholder="<?php echo $TeamTicketPrice; ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="submitTicketPrice" type="button" class="btn btn-primary">Save changes</button>
          </div>
           </form>
        </div>
      </div>
    </div>

	
	<script type="text/javascript">

	$("#ticketPriceForm").submit(function(e) {

	    e.preventDefault(); // avoid to execute the actual submit of the form.

	    var form = $(this);
	    var url = form.attr('action');
	    var newValue = e.currentTarget[0].value;

	    if((!newValue || 0 === newValue.length)){
	    	alert("Ticket price must be set");
		    return;
	    }
	    else if(newValue < 25 || newValue > 200){
	    	alert("Ticket price must be between 25 and 200");
		    return;
	    }

	    $.ajax({
	    	  type: "POST",
	    	  url: url,
	    	  data: form.serialize(), // serializes the form's elements.
	    	 // dataType: 'json',
	    	  success: function(data){
	    	    //console.log(data.error); // overflow
	    	    $('#requestedTicketPrice').text(newValue);
	    	    $('#ReqTickPriceValue').show();
	    	    $('#ticketPriceModal').modal('hide');
	    	    //location.reload();
	    	   
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
// 	    	        if (xhr.status == 500) {
// 	    	        	 alert("Error Requesting ticket price change");
// 	    	        } else {
// 	    	            //handle error
// 	    	        }
	    	        alert("Error Requesting ticket price change");

	    	       
	    	    }
	    	});


	});


	</script>
	
	

</div>
