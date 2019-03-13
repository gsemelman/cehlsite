<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Transactions';
$CurrentPage = 'Transactions';
include 'head.php';
?>

	<div class = "container">
	
		<div class = "card">
		    <div class = "card-header">
    			<h3>CEHL Transactions</h3>
    		</div>
    		
    		<div class = "card-body">
        		<div class="col-sm-3">
        			 <select name="tradesMenu" class="form-control mb-3" id="tradesMenu">
        			<option value="<?php echo $folderLegacy ?>cehlTransact.html">Current</option>
                    <option value="<?php echo $folderLegacy ?>season26trades.html">Season 26</option>
                    <option value="<?php echo $folderLegacy ?>season25trades.html">Season 25</option>
                    <option value="<?php echo $folderLegacy ?>season24trades.html">Season 24</option>
                    <option value="<?php echo $folderLegacy ?>season23trades.html">Season 23</option>
                    <option value="<?php echo $folderLegacy ?>season22trades.html">Season 22</option>
                    <option value="<?php echo $folderLegacy ?>season21trades.html">Season 21</option>
                    <option value="<?php echo $folderLegacy ?>season20trades.html">Season 20</option>
                    <option value="<?php echo $folderLegacy ?>season19trades.html">Season 19</option>
                    <option value="<?php echo $folderLegacy ?>season18trades.html">Season 18</option>
                    <option value="<?php echo $folderLegacy ?>season17trades.html">Season 17</option>
                    <option value="<?php echo $folderLegacy ?>season16trades.html">Season 16</option>
                    <option value="<?php echo $folderLegacy ?>season15trades.html">Season 15</option>
                    <option value="<?php echo $folderLegacy ?>season14trades.html">Season 14</option>
                    <option value="<?php echo $folderLegacy ?>season13trades.html">Season 13</option>
                    <option value="<?php echo $folderLegacy ?>season12trades.html">Season 12</option>
                    <option value="<?php echo $folderLegacy ?>season11trades.html">Season 11</option>
                    <option value="<?php echo $folderLegacy ?>season10trades.html">Season 10</option>
                    <option value="<?php echo $folderLegacy ?>season9trades.html">Season 9</option>
                    <option value="<?php echo $folderLegacy ?>season8trades.html">Season 8</option>
                    <option value="<?php echo $folderLegacy ?>season7trades.html">Season 7</option>
                    <option value="<?php echo $folderLegacy ?>season6trades.html">Season 6</option>
                    <option value="<?php echo $folderLegacy ?>season5trades.html">Season 5</option>
                    <option value="<?php echo $folderLegacy ?>season4trades.html">Season 4</option>
        <!--             <option value="<?php echo $folderLegacy ?>season3trades.html">Season 3</option> -->
        <!--             <option value="<?php echo $folderLegacy ?>season2trades.html">Season 2</option> -->
        <!--             <option value="<?php echo $folderLegacy ?>season1trades.html">Season 1</option> -->
                    </select>
        		
        		</div>
        		
        		<div class="col"> 
        				<div class="loaderImage"><img src="assets/img/loader.gif"></div>
        				<div ALIGN=LEFT id = 'trades'></div>
        		</div>
			</div>
		</div>

	<script type="text/javascript">

		$('.loaderImage').show();
		$('#trades').load('<?php echo $folderLegacy ?>cehlTransact.html');
		$('.loaderImage').hide();

        $('#tradesMenu').on('change', function() {

    		$("#trades").hide();
        	$('.loaderImage').show();
        	
       		$.ajax({
        		    url: this.value,
        		    cache: false,
        		    dataType: "html",
        		    success: function(data) {
        		        $("#trades").html(data);
        		        $(".loaderImage").hide();
        		    	$("#trades").show();
        		    },
                	 error: function(XMLHttpRequest, textStatus, errorThrown) {
             	 		$('#trades').html('<p>Error loading data</p>');
             	 		$(".loaderImage").hide();
             	 	}
        		});

        });

        </script>

</div>

<?php include 'footer.php'; ?>