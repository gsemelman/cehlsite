<?php
//set headers to NOT cache a page
//header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
//header("Pragma: no-cache"); //HTTP 1.0
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

include 'config.php';
include 'lang.php';

$CurrentHTML = 'TeamScoring';
$CurrentTitle = $scoringTitle;
$CurrentPage = 'TeamScoring';
include 'head.php';
include 'TeamHeader.php';
?>

<style>

.selection-content { 
    padding-bottom: 7px; 
    padding-top: 7px; 
    margin-bottom: 10px; 
    border-radius:5px; 
    text-align:center;
 
}


</style>


<div class="container">

	<div class="card">

		<div class="card-header p-1">
		
		 <?php include 'TeamCardHeader.php' ?>
			
		</div>
		<!--end card header -->
		<div class="card-body px-2 px-lg-4 pt-2 wow fadeIn">
			<div class="row selection-content justify-content-center">
				<div class="col col-md-8 col-lg-6">
					<div class="row">
						<div class="col">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="seasonMenu">Season</label>
								</div>

								<select class="col custom-select" id="seasonMenu">
									<option selected value="Current">Current</option>
									<option value=26>26</option>
									<option value=25>25</option>
									<option value=24>24</option>
									<option value=23>23</option>
									<option value=22>22</option>
									<option value=21>21</option>
									<option value=20>20</option>
									<option value=19>19</option>
									<option value=18>18</option>
									<option value=17>17</option>
									<option value=16>16</option>
									<option value=15>15</option>
									<option value=14>14</option>
									<option value=13>13</option>
									<option value=12>12</option>
									<option value=11>11</option>
									<option value=10>10</option>
									<option value=9>9</option>
									<option value=8>8</option>
									<option value=7>7</option>
									<option value=6>6</option>
									<option value=5>5</option>
									<option value=4>4</option>
									<option value=3>3</option>
									<option value=2>2</option>
									<option value=1>1</option>
								</select>
							</div>
						</div>


						<div class="col">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="typeMenu">Type</label>
								</div>
								<select class="custom-select" id="typeMenu">
									<option selected value=REG>Regular</option>
									<option value=PLF>Playoffs</option>
								</select>
							</div>
						</div>

					</div>
				</div>

			</div>
			
			<div id="scoringInner">
     
     		<?php include 'TeamScoringTemplate.php';?>
     
    		</div>

		</div>

		
	</div>
</div>


<script>


var currentTeam = '<?php echo $currentTeam?>';

$(window).on('pageshow', function(){

	if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
	    var seasonSelection = $('#seasonMenu').find(":selected").val();
	    var typeSelection = $('#typeMenu').find(":selected").val();
		handleSelection(seasonSelection, typeSelection);
	}
});


$("#seasonMenu").on('change', function() {  
    var selection = $(this).val();
    var typeSelection = $('#typeMenu').find(":selected").val();

	handleSelection(selection, typeSelection);
    
} );

$("#typeMenu").on('change', function() {  
    var selection = $(this).val();
    var seasonSelection = $('#seasonMenu').find(":selected").val();

	handleSelection(seasonSelection, selection);
    
} );

function handleSelection(season, type){

	var hash = generateHash(season, type);;
	
	if(season == 'Current'){
		season = '';
	}

	if(type == 'REG'){
		type = '';
	}

	$.ajax({
	    type: "GET",
	    url: './TeamScoringTemplate.php',
	    data: {seasonId: season, seasonType: type, team:currentTeam},
	    success: function(data){
	    	$('#scoringInner').html(data);

	    	window.location.hash = hash;
	    }
	});
}


function generateHash(season, type) {
	return season + '-' + type;
}

function parseHash(){
	
}


</script>

<?php include 'footer.php'; ?>