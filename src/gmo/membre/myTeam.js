function alert(title, text, type) {

  var html = $('#alertPop');	
	
  if(html.length){
	  html.remove();
  }
      
  html = $("<div id=\"alertPop\" class='alert-fixed alert text-center hide fade in "
		   + type + "' role=\"alert\"><strong>" 
		   + title + "</strong> " 
		   + text + " </div>");

  $('body').append(html);
  setTimeout(function() {
	 html.addClass('show');
  },0);

  setTimeout(function() {
	  html.remove();
	  },2500);
  
}

jQuery(document).ready(function() {
	//handle submit position change from modal
	$('#submitPositionChange').on('click', function() {
	
		var playerName = $('#selectPlayer :selected').val();
		var playerPosBf = $("#selectPlayer option:selected").attr("data-pos");
		var playerPosAf = $('#positionSelection :selected').val();
	
		if(!playerName || 0 === playerName.length){
			$('#posChangeError').text("Please select a player");
		    return;
		}
		else if((!playerPosAf || 0 === playerPosAf.length)){
	    	$('#posChangeError').text("Please choose a position");
		    return;
	    }
	
		 $.ajax({
	    	  type: "POST",
	    	  url: endpointPositionSave,
	    	  data: {playerName: playerName, playerPosBf: playerPosBf, playerPosAf:playerPosAf}, 
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
	
				    if(xhr.status==401){
					   location.reload();
					   return;
				    }
	
	    	        $('#ticketError').text("Error submitting position");
	    	        return;
	    	       
	    	    }
	    	});
	
	});
	
	//show position in modal dialog
	//hide current position
	$('#selectPlayer').on('change', function() {
		 // alert( this.value );
		 $("#positionSelection option[value=\"04\"]").hide();
		  if(this.value){
			  var playerPosBf = $("#selectPlayer option:selected").attr("data-pos");
			  $("#positionSelection option[value=" + playerPosBf + "]").hide();
			  
			  $('#positionSelection').show();
		  }else{
			  $('#positionSelection').hide();
		  }
		});
	
	
	//cancel position change
	$(document).on("click","#tableTeamPosChange tbody tr td button.btn", function() { // any button
		  console.log($(this).val());
		 //cancelPositionChange($(this).val());
		  var playerID = $(this).val();
		  var currentRow = $(this).parent().parent();
	
		  document.body.style.cursor = "wait";
			
		  $.ajax({
	    	  type: "POST",
	    	  url: endpointPositionDelete,
	    	  data: {playerID: playerID}, 
	    	  success: function(data){
	    		document.body.style.cursor = "default";
	    	    //location.reload();
				
	
				var tbody = $("#tableTeamPosChange tbody");
	
				if (tbody.children().length > 1) {
					currentRow.hide(1000);
				    setTimeout(function() {
				    	currentRow.remove();
					  },500);
					
				}else{
					$("#tableTeamPosChange").hide(1000);
					currentRow.remove();
					//$("#tableTeamPosChange").hide();
				}
			
	    		alert('Success!', 'Position change cancelled', 'alert-primary');
	    		
	    	   
	    	  },
	    	    error : function(xhr, textStatus, errorThrown ) {
	    	    	document.body.style.cursor = "default";
	
				    if(xhr.status==401){
						   location.reload();
						   return;
					}
		    	    
	    	        if (textStatus == 'timeout') {
	    	            this.tryCount++;
	    	            if (this.tryCount <= this.retryLimit) {
	    	                //try again
	    	                $.ajax(this);
	    	                return;
	    	            }            
	    	            return;
	    	        }
	
	    	       // $('#ticketError').text("Error submitting position");
	    	       alert('Error!', 'Unable to cancel position change', 'alert-danger');
	    	       return;
	    	       
	    	    }
	    	});
		});
	
	
	//var originalTicketPrice = <?php echo $TeamTicketPrice; ?>
	
	//handle change ticket button press
	$("#btnTicketPrice").on("click", function(){
	
		if($(this).val() === "CAN"){
			submitTicketPriceChange(originalTicketPrice, "REQ");
	    }else{
	    	$('#ticketPriceModal').modal('show');
	    }
	
		  
	});
	
	//reset modal
	$("#ticketPriceModal").on("hidden.bs.modal", function(){
	    $("#ticketError").text("");
	    $("#newTicketPrice").val("");  
	
	    //hack for code below
	    history.replaceState(null, null, "#Team");
	
	});
	
	
	//below 4 queries are a hack to close to modal on back button press
	
	$("#positionChangeModal").on("hidden.bs.modal", function(){
	
	    history.replaceState(null, null, "#Team");
	
	});
	
	$(window).on('hashchange', function (event) {
	    if(window.location.hash != "#modal") {
	        $('#ticketPriceModal').modal('hide');
	        $('#positionChangeModal').modal('hide');
	    }
	});
	
	$("#ticketPriceModal").on("show.bs.modal", function(){
		 //history.pushState(null, null, "#modal");
		 history.pushState(null, null, "#modal");
	
	});
	
	$("#positionChangeModal").on("show.bs.modal", function(){
		 //history.pushState(null, null, "#modal");
		 history.pushState(null, null, "#modal");
	});
	
	
	//submit function. handles change and cancel
	function submitTicketPriceChange(newValue, newState){
	
	    $.ajax({
	    	  type: "POST",
	    	  url: endpointTicketPriceSave,
	    	  data: {newTicketPrice: newValue}, 
	    	  success: function(data){
	    	    if(newValue == originalTicketPrice){
	    	    	$('#requestedTicketPrice').hide(1000);
	    	    }else{
		    		$('#requestedTicketPriceValue').text(newValue);
		    	 	$('#requestedTicketPrice').show(1000);
	    	    }
	
	    	    if(newState === "CAN"){
	    	    	$("#btnTicketPrice").html("Cancel Request");
	    	    }else{
	    	    	$("#btnTicketPrice").html("Request Change");
	    	    }
		    	$("#btnTicketPrice").val(newState); //set new state
	
	    	    $('#ticketPriceModal').modal('hide');
	
	    	    if(newState === "CAN"){
	    	    	 alert('Success!', 'Ticket Price Request Successful!', 'alert-primary');
	    	    }else{
	    	    	 alert('Success!', 'Ticket Price Change Cancelled!', 'alert-primary');
		    	}
	    	   
	   
	    	  },
	    	    error : function(xhr, textStatus, errorThrown ) {
	
				    if(xhr.status==401){
					   location.reload();
					   return;
				    }
		    	    
	    	        if (textStatus == 'timeout') {
	    	            this.tryCount++;
	    	            if (this.tryCount <= this.retryLimit) {
	    	                //try again
	    	                $.ajax(this);
	    	                return;
	    	            }            
	    	            return;
	    	        }
	
		    	    $('#ticketPriceModal').modal('hide');
	
		    
		    	    alert('Error!', 'Error submitting ticket price', 'alert-danger');
	
	    	        //$('#ticketError').text("Error submitting ticket price");
	    	        return;
	    	       
	    	    }
	    	});
		
	}
	
	//ticket price change submit
	$('#btnSubmitTicketPrice').on('click', function() {
	
		var newValue = $('#newTicketPrice').val();
	
	    if((!newValue || 0 === newValue.length)){
	    	$('#ticketError').text("Ticket Price cannot be blank");
		    return;
	    }
	    else if(newValue < 25 || newValue > 200){
	    	$('#ticketError').text("Ticket price must be between 25 and 200");
		    return;
	    }else if(newValue == originalTicketPrice){
	    	$('#ticketError').text("Ticket price already set to " + originalTicketPrice);
		    return;
	    }
	
	    submitTicketPriceChange(newValue, "CAN");
	
	});
	
	//player release
	function submitPlayerRelease(playerName, type, row){

	    $.ajax({
	    	  type: "POST",
	    	  url: endpointPlayerRelease,
	    	  data: {playerName: playerName, type:type}, 
	    	  success: function(data){
	    		  if('ADD' === type){
	    			  location.reload(); 
	    		  }
	    		  if('CAN' === type){
    				var tbody = $("#tablePlayerRelease tbody");

    				if (tbody.children().length > 1) {
    					row.hide(1000);
    				    setTimeout(function() {
    				    	row.remove();
    					  },1000);
    					
    				}else{
    					$("#tablePlayerRelease").hide(1000);
    					row.remove();
    					
    					//$("#tableTeamPosChange").hide();
    				}
    				
   
    		  		alert('Success!', 'Player Release Cancelled', 'alert-primary');
	    		  }

	    	  },
	    	    error : function(xhr, textStatus, errorThrown ) {
	
				    if(xhr.status==401){
					   location.reload();
					   return;
				    }
		    	    
	    	        if (textStatus == 'timeout') {
	    	            this.tryCount++;
	    	            if (this.tryCount <= this.retryLimit) {
	    	                //try again
	    	                $.ajax(this);
	    	                return;
	    	            }            
	    	            return;
	    	        }
	
		    	    $('#playerReleaseModal').modal('hide');
	
		    
		    	    alert('Error!', 'Error submitting ticket price', 'alert-danger');
	
	    	        //$('#ticketError').text("Error submitting ticket price");
	    	        return;
	    	       
	    	    }
	    	});
		
	}
	
	$('#submitPlayerRelease').on('click', function() {
		var playerName = $('#selectPlayerRelease :selected').val();
		if(!playerName || 0 === playerName.length){
			$('#playerReleaseError').text("Please select a player");
		    return;
		}
		
		submitPlayerRelease(playerName, 'ADD');
	});
	
	$(document).on("click","#tablePlayerRelease tbody tr td button.btn", function() { // any button
	    var playerName = $(this).val();
		var currentRow = $(this).parent().parent();
		  
		submitPlayerRelease(playerName, 'CAN', currentRow);
 
	});
	

	
});