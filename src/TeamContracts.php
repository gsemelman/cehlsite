<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = 'TeamContracts.php';
$CurrentTitle = 'Team Contracts';
$CurrentPage = 'TeamContracts';
include 'head.php';
include 'TeamHeader.php';
?>


<div class = "container">
	<div class="card">

    	<div class="card-header p-1">
    	
    		 <?php include 'TeamCardHeader.php'; ?>
    	
    	</div>
    	<div class="card-body wow fadeIn">
    		
    			<div class="row">
    				
<!--             		<div class="col-sm-3"> -->
<!--             			<select name="contractsMenu" class="form-control mb-3" id="contractsMenu"> -->
<!--             				<option value="27">Current</option> -->
<!--                         </select> -->
            		
<!--             		</div> -->
            		
            		<div class="col col-md-8 col-lg-6">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="contractsMenu">Season</label>
								</div>

								<select id="contractsMenu" class="col custom-select">
									<option selected value="27">Current</option> 
								</select>
							</div>
						</div>
            		
    			
    			</div>
    			<div class="row">
    			
    				<div class="col"> 
            			<div class="loaderImage"><img src="assets/img/loader.gif"></div>
            			<div id = "contracts"></div>
            		</div>
    			</div>
    
    		</div>
        </div>
</div>

<script type="text/javascript">

		var currentTeam = '<?php echo $currentTeam?>';

		$(document).ready(function() 
		    { 
				$('.loaderImage').show();
				//var seasonId = $("#contractsMenu option[value='" + seasonId + "']").value();
				var seasonId = $("#contractsMenu").find(':selected').val();
				load(seasonId);
		    } 
		); 


        $('#contractsMenu').on('change', function() {

        	$("#contracts").hide();
        	$('.loaderImage').show();

        	var seasonId = this.value;

        	//window.location.hash = seasonId;

        	load(seasonId);

        });

        function load(seasonId){
          	 $.ajax({
        	    url: './ContractsTemplate.php',
        	    data: {seasonId: seasonId, team: currentTeam},
      		    cache: false,
      		    dataType: "html",
      		    success: function(data) {
      		        $("#contracts").html(data);
      		        $(".loaderImage").hide();
      		    	$("#contracts").show();
      		    },
              	 error: function(XMLHttpRequest, textStatus, errorThrown) {
           	 		$('#contracts').html('<p>Error loading data</p>');
           	 		$(".loaderImage").hide();
           	 	}
      			});
        }


         
 		</script>




<?php include 'footer.php'; ?>