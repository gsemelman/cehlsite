
<div class="container mt-3">

	<h5>Lines</h5>
	<div class="row">
		<div class="col">
              <div class="pt-3 pb-2">
                  	 <span class="float-left">
                  	 	<span>Output:</span>
                  	 	<button type="button" class="btn btn-outline-primary" onclick="outputAllLines()" >Output All Lines</button>
                  	 </span>
                  	 
               </div>
    	</div>
	</div>
</div>

<?php 
unset($playerReleaseId,$playerReleaseDate,$playerReleaseTeam,$playerReleaseName);
?>

<script type="text/javascript">
function outputAllLines() {

	   $("body").css("cursor", "progress");
		
	   $.ajax({
	    	  type: "GET",
	    	  url: "<?php echo BASE_URL?>gmo/admin/outputAllLines.php",
	    	  dataType: 'json',
	    	  success: function(data){
	    		  //$("body").css("cursor", "default");
	    		  //alert("Line Output Complete");
	    		  
	    		    //var d = JSON.parse(data);
					//alert(d.customer.first_name); // contains "John"
					
			      var processed = data.teamsProcessed;
			      var game1 = data.game1output;
			      var game2 = data.game2output;
	    		  
	    		  alert('Line Output Complete', '[Processed: ' + processed + ' Game 1: ' + game1 + ' Game 2: ' + game2 + ']', 'alert-primary', 5000);
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
	    	        $("body").css("cursor", "default");
	    	        alert('Error!', 'Unable to output lines', 'alert-danger', 5000);

	    	        return;
	    	       
	    	    }
	    	});
	
}
</script>
