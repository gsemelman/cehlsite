<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Contracts';
$CurrentPage = 'Contracts';
include 'head.php';

?>
	<div class = "container">
	
    	<div class = "card">
		    <?php include 'SectionHeader.php';?>
    		
    		<div class = "card-body">
    			<div class="row">
    				
            		<div class="col-sm-3">
            			 <select name="contractsMenu" class="form-control mb-3" id="contractsMenu">
            				<option value="27">Current</option>
                			<option data-legacy value="26">Season 26</option>
                            <option data-legacy value="25">Season 25</option>
                            <option data-legacy value="24">Season 24</option>
                            <option data-legacy value="23">Season 23</option>
                            <option data-legacy value="22">Season 22</option>
                            <option data-legacy value="21">Season 21</option>
                            <option data-legacy value="20">Season 20</option>
                            <option data-legacy value="19">Season 19</option>
                            <option data-legacy value="18">Season 18</option>
                            <option data-legacy value="17">Season 17</option>
                            <option data-legacy value="16">Season 16</option>
                            <option data-legacy value="15">Season 15</option>
                            <option data-legacy value="14">Season 14</option>
                            <option data-legacy value="13">Season 13</option>
                            <option data-legacy value="12">Season 12</option>
                            <option data-legacy value="11">Season 11</option>
   
                        </select>
            		
            		</div>
            		
    			
    			</div>
    			<div class="row">
    			
    				<div class="col"> 
            			<div class="loaderImage"><img class="mx-auto d-block" src="assets/img/loader.gif"></div>
            			<div ALIGN=LEFT id = 'contracts'></div>
            		</div>
    			</div>
    
    		</div>
        </div>
    	
	</div>

		<script type="text/javascript">

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

        	window.location.hash = seasonId;

        	//var attr = $(this).attr('data-legacy');
        	var attr = $("#contractsMenu").find(':selected').attr('data-legacy');
        	var isLegacy = false;

        	// For some browsers, `attr` is undefined; for others,
        	// `attr` is false.  Check for both.
        	if (typeof attr !== typeof undefined && attr !== false) {
        		isLegacy = true;
        	}

        	if(isLegacy){
            	var url = '<?php echo $folderLegacy ?>' + 'season' + seasonId + 'contracts.htm';
        		loadLegacy(url);
        	}else{
        		load(seasonId);
        	}



        });

        function load(seasonId){
          	 $.ajax({
        	    url: './ContractsTemplate.php',
        	    data: {seasonId: seasonId},
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

        function loadLegacy(url){
       	 $.ajax({
 		    url: url,
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


//         $(window).on('pageshow', function(){
            
//     		console.info(window.location.hash);
//             if(window.location.hash){

//                 var selection = window.location.hash;
//                 seasonId = selection.replace("#", "");
                
//                 var attr = $("#contractsMenu option[value='" + seasonId + "']").attr('data-legacy');
//                 var isLegacy = false;     
//                 if (typeof attr !== typeof undefined && attr !== false) {
//             		isLegacy = true;
//             	}

//              	if(isLegacy){
//             		var url = '<?php echo $folderLegacy ?>' + 'season' + seasonId + 'contracts.htm';
//             		loadLegacy(url);
//             	}else{
//             		load(seasonId);
//             	}
//             }
//         });

         
 		</script>

<?php include 'footer.php'; ?>