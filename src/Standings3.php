<?php
include 'config.php';
include 'lang.php';

$CurrentHTML = 'Standings';
$CurrentTitle = $standingTitle;
$CurrentPage = 'Standings';

include 'head.php';

if($currentPLF == 1){
    $playoffActive = 'active';
    $seasonActive = '';
}else{
    $playoffActive = '';
    $seasonActive = 'active';
}

?>

<div class="container wow fadeIn">

	<div class="card">
		<div class="card-header">
			<h3><?php echo $CurrentTitle; ?></h3>
		</div>
		<div class="card-body px-2 px-md-3">

			<div class ="col-sm-3" style="display: flex;">
			    <label for="seasonMenu" style="flex: 1;">Season:</label>
				<select style="flex: 1;" name="seasonMenu" class="form-control mb-3" id="seasonMenu">
					<option value="Current">Current</option>
					<option value=26>Season	26</option>
					<option value=25>Season	25</option>
				</select>
			</div>

			<div id="standingsTabs">
				<ul class="nav nav-tabs nav-fill">
					<li class="nav-item"><a class="nav-link <?php echo $seasonActive?>"
						href="#Season" data-toggle="tab">Regular Season</a>
					</li>
					
					<li class="nav-item"><a
						class="nav-link <?php echo $playoffActive?>" href="#Playoffs"
						data-toggle="tab">Playoff Tree</a>
					</li>
				</ul>

				<div class="tab-content">
    				<div class="tab-pane  <?php echo $seasonActive?>" id="Season">
    					<div id="SeasonInner" >
    						<?php include 'StandingsTemplate.php'; ?>
    					</div>
    				</div>
    
                	<div class="tab-pane <?php echo $playoffActive?>" id="Playoffs">
                		<div id="PlayoffsInner" >
    						<?php include 'StandingsTreeTemplate.php'; ?>
    					</div>
                	</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	//$('#Season').load('./StandingsTemplate.php');
	//$('#Playoffs').load('./StandingsTreeTemplate.php');

    $("#seasonMenu").on('change', function() {  
        var selection = $(this).val();

    	if(selection == 'Current'){
    		selection = '';
    	}

    	window.location.hash = selection;
    	
    	$.ajax({
    	    type: "GET",
    	    url: './StandingsTemplate.php',
    	    data: {seasonId: selection},
    	    success: function(data){
    	    	$('#SeasonInner').html(data);
    	    }
    	});

    	$.ajax({
    	    type: "GET",
    	    url: './StandingsTreeTemplate.php',
    	    data: {seasonId: selection},
    	    success: function(data){
    	    	$('#PlayoffsInner').html(data);
    	    }
    	});
        
    } );

    //this is a hack to support retaining state after back button press.
    //TODO: properly implement
    $(window).on('pageshow', function(){
       
		console.info(window.location.hash);
        if(window.location.hash){

            var selection = window.location.hash;
            selection = selection.replace("#", "");
            
        	$.ajax({
        	    type: "GET",
        	    url: './StandingsTemplate.php',
        	    data: {seasonId: selection},
        	    success: function(data){
        	    	$('#SeasonInner').html(data);
        	    },
              	 error: function(XMLHttpRequest, textStatus, errorThrown) {
           	 		$('#SeasonInner').html('<p>Error loading data</p>');
           	 	}
        	});

        	$.ajax({
        	    type: "GET",
        	    url: './StandingsTreeTemplate.php',
        	    data: {seasonId: selection},
        	    success: function(data){
        	    	$('#PlayoffsInner').html(data);
        	    },
               	 error: function(XMLHttpRequest, textStatus, errorThrown) {
          	 		$('#PlayoffsInner').html('<p>Error loading data</p>');
          	 	}
        	});

        	$("#seasonMenu").val(selection);
        }
    });

</script>


<?php include 'footer.php'; ?>
