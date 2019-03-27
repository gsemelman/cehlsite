
<?php 

include FS_ROOT.'gmo/config4.php';
include FS_ROOT.'gmo/login/mysqli.php';

//only init if not already set

if(isset($teamID)){

    $sql = "SELECT TICKETS,TICKETS_REQ  FROM `".$db_table."`  WHERE `INT` = '$teamID' LIMIT 1";
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if($query){
        while($data = mysqli_fetch_array($query)) {
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
                  <img data-src="holder.js/32x32?theme=thumb&amp;bg=007bff&amp;fg=007bff&amp;size=1" alt="32x32" class="mr-2 rounded" style="width: 32px; height: 32px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_169c01fda0d%20text%20%7B%20fill%3A%23007bff%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_169c01fda0d%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23007bff%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2211.3828125%22%20y%3D%2216.9984375%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">@username</strong>
                    Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                  </p>
                </div>
                <div class="media text-muted pt-3">
                  <img data-src="holder.js/32x32?theme=thumb&amp;bg=e83e8c&amp;fg=e83e8c&amp;size=1" alt="32x32" class="mr-2 rounded" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_169c01fda12%20text%20%7B%20fill%3A%23e83e8c%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_169c01fda12%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23e83e8c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2211.3828125%22%20y%3D%2216.9984375%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="width: 32px; height: 32px;">
                  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">@username</strong>
                    Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                  </p>
                </div>
                <div class="media text-muted">
                  <img data-src="holder.js/32x32?theme=thumb&amp;bg=6f42c1&amp;fg=6f42c1&amp;size=1" alt="32x32" class="mr-2 rounded" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_169c01fda13%20text%20%7B%20fill%3A%236f42c1%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_169c01fda13%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%236f42c1%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2211.3828125%22%20y%3D%2216.9984375%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="width: 32px; height: 32px;">
                  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">@username</strong>
                    Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                  </p>
                </div>
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
	    else if(newValue < 25 || newValue > 999){
	    	alert("Ticket price must be between 25 and 999");
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
