<?php
include 'config.php';
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
            			<option value="<?php echo $folderLegacy ?>cehlContracts.htm">Current</option>
                        <option value="<?php echo $folderLegacy ?>season26contracts.htm">Season 26</option>
                        <option value="<?php echo $folderLegacy ?>season25contracts.htm">Season 25</option>
                        <option value="<?php echo $folderLegacy ?>season24contracts.htm">Season 24</option>
                        <option value="<?php echo $folderLegacy ?>season23contracts.htm">Season 23</option>
                        <option value="<?php echo $folderLegacy ?>season22contracts.htm">Season 22</option>
                        <option value="<?php echo $folderLegacy ?>season21contracts.htm">Season 21</option>
                        <option value="<?php echo $folderLegacy ?>season20contracts.htm">Season 20</option>
                        <option value="<?php echo $folderLegacy ?>season19contracts.htm">Season 19</option>
                        <option value="<?php echo $folderLegacy ?>season18contracts.htm">Season 18</option>
                        <option value="<?php echo $folderLegacy ?>season17contracts.htm">Season 17</option>
                        <option value="<?php echo $folderLegacy ?>season16contracts.htm">Season 16</option>
                        <option value="<?php echo $folderLegacy ?>season15contracts.htm">Season 15</option>
                        <option value="<?php echo $folderLegacy ?>season14contracts.htm">Season 14</option>
                        <option value="<?php echo $folderLegacy ?>season13contracts.htm">Season 13</option>
                        <option value="<?php echo $folderLegacy ?>season12contracts.htm">Season 12</option>
                        <option value="<?php echo $folderLegacy ?>season11contracts.htm">Season 11</option>
            
                        
                        </select>
            		
            		</div>
            		
    			
    			</div>
    			<div class="row">
    			
    				<div class="col"> 
            			<div class="loaderImage"><img src="assets/img/loader.gif"></div>
            			<div ALIGN=LEFT id = 'contracts'></div>
            		</div>
    			</div>
    
    		</div>
        </div>
    	
	</div>

		<script type="text/javascript">

		$('.loaderImage').show();
		
        $.ajax({
        url: "<?php echo $folderLegacy ?>cehlContracts.htm",
 		    cache: false,
 		    dataType: "html",
 		    success: function(data) {
 		        $("#contracts").html(data);
 		       $(".loaderImage").hide();
 		    },
    	 	error: function(XMLHttpRequest, textStatus, errorThrown) {
    	 		$('#contracts').html('<p>Error loading data</p>');
    	 		$(".loaderImage").hide();
    	 	}
 		});
		

        $('#contractsMenu').on('change', function() {

        	$("#contracts").hide();
        	$('.loaderImage').show();
        	
        	 $.ajax({
        		    url: this.value,
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

        });

         

         
 		</script>

<?php include 'footer.php'; ?>