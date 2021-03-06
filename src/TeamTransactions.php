<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'TeamTransactions.php';
$CurrentTitle = 'Transactions';
$CurrentPage = 'TeamTransactions';
include 'head.php';
include 'TeamHeader.php';
?>

<style>

#loaderImage {
    background: url("assets/img/loader.gif") no-repeat scroll center center #FFF;

    height: 100%;
    width: 100%;
}
</style>



<div class = "container">
	<div class="card">
    	<div class="card-header p-1">
    	
    		 <?php include 'TeamCardHeader.php'; ?>
    	
    	</div>
    	<div class="card-body">
    			<div class="row mb-2">
            		
            		<div class="col col-md-8 col-lg-6">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="contractsMenu">Season</label>
								</div>

								<select id="contractsMenu" class="col custom-select">
									<option selected value="30">Current</option> 
									<option value="29">Season 29</option> 
									<option value="28">Season 28</option> 
									<option value="27">Season 27</option> 
								</select>
							</div>
						</div>
            		
    			
    			</div>
    			
    			<div class="row">
    				
    				<div class="col"> 
             			<div id="loaderImage"><img class="mx-auto d-block" src="assets/img/loader.gif"></div>
<!--                         <div id="loaderImage" class="loaderImage">test</div> -->
    			
    		
            			<div id = "contracts"></div>
            		</div>
    			</div>
    
    		</div>
        </div>
</div>

<script type="text/javascript">

//         $(window).load(function(){
//             $('#loaderImage').fadeOut(1000);
            
//         });


		var currentTeam = '<?php echo $currentTeam?>';

		$(document).ready(function() 
		    { 
				$('#loaderImage').show();
				//var seasonId = $("#contractsMenu option[value='" + seasonId + "']").value();
				var seasonId = $("#contractsMenu").find(':selected').val();
				load(seasonId);
		    } 
		); 


        $('#contractsMenu').on('change', function() {

        	$("#contracts").hide();
        	$('#loaderImage').show();

        	var seasonId = this.value;

        	//window.location.hash = seasonId;

        	load(seasonId);

        });

        function load(seasonId){
            
          	 $.ajax({
        	    url: './TeamTransactionsTemplate.php',
        	    data: {seasonId: seasonId, team: currentTeam},
      		    cache: false,
      		    dataType: "html",
      		    success: function(data) {
      		        $("#contracts").html(data);
      		        $("#loaderImage").hide();
      		    	$("#contracts").show();
      		    },
              	 error: function(XMLHttpRequest, textStatus, errorThrown) {
           	 		$('#contracts').html('<p>Error loading data</p>');
           	 		$("#loaderImage").hide();
           	 	}
      			});
        }


         
 		</script>




<?php include 'footer.php'; ?>