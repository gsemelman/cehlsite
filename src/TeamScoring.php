<?php
include 'config.php';
include 'lang.php';

$CurrentHTML = 'TeamScoring';
$CurrentTitle = $scoringTitle;
$CurrentPage = 'TeamScoring';
include 'head.php';
include 'TeamHeader.php';
?>



<div class="container">

<?php

echo '<div class="card">';
echo '<div class="card-header wow fadeIn" style="padding-bottom: 0px; padding-top: 2px;">';
echo'<div class = "row d-flex align-items-center justify-content-center">';

$teamCardLogoSrc = glob($folderTeamLogos.strtolower($currentTeam).'.*');
if(isset($teamCardLogoSrc[0])) {
    echo'<img class="float-left card-img-top" src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
}
echo'<h3>'.$CurrentTitle.'</h3>';
echo'</div>';
echo' </div>';
echo '<div class="card-body">';

//echo '<h5 class = "text-center wow fadeIn">'.$allLastUpdate.' '.$val.'</h5>';

echo '<div class ="col-sm-12 col-lg-8" style="display: flex;">
			<label for="seasonMenu" style="flex: 1;">Season:</label>
			<select style="flex: 1;" name="seasonMenu" class="form-control mb-3" id="seasonMenu">
			<option value="Current">Current</option>
			<option value=26>Season	26</option>
			<option value=25>Season	25</option>
            <option value=24>Season	24</option>
            <option value=23>Season	23</option>
            <option value=22>Season	22</option>
            <option value=21>Season	21</option>
            <option value=20>Season	20</option>
            <option value=19>Season	19</option>
            <option value=18>Season	18</option>
            <option value=17>Season	17</option>
            <option value=16>Season	16</option>
            <option value=15>Season	15</option>
            <option value=14>Season	14</option>
            <option value=13>Season	13</option>
            <option value=12>Season	12</option>
            <option value=11>Season	11</option>
            <option value=10>Season	10</option>
            <option value=9>Season 9</option>
            <option value=8>Season 8</option>
            <option value=7>Season 7</option>
            <option value=6>Season 6</option>
            <option value=5>Season 5</option>
            <option value=4>Season 4</option>
            <option value=3>Season 3</option>
            <option value=2>Season 2</option>
            <option value=1>Season 1</option>

			</select>
			<label for="typeMenu" style="flex: 1;">Game Type:</label>
			<select style="flex: 1;" name="typeMenu" class="form-control mb-3" id="typeMenu">
			<option value=REG>Regular Season</option>
			<option value=PLF>Playoffs</option>
			</select>
			</div>';

echo '<div id = "scoringInner">';

include 'TeamScoringTemplate.php';

echo '</div></div></div></div>';

?>

<script>

var currentTeam = '<?php echo $currentTeam?>';

$("#seasonMenu").on('change', function() {  
    var selection = $(this).val();

	if(selection == 'Current'){
		selection = '';
	}

    var typeSelection = $('#typeMenu').find(":selected").val();

	if(typeSelection == 'REG'){
		typeSelection = '';
	}

	$.ajax({
	    type: "GET",
	    url: './TeamScoringTemplate.php',
	    data: {seasonId: selection, seasonType: typeSelection, team:currentTeam},
	    success: function(data){
	    	$('#scoringInner').html(data);
	    }
	});
    
} );

$("#typeMenu").on('change', function() {  
    var selection = $(this).val();

    var seasonSelection = $('#seasonMenu').find(":selected").val();

	if(seasonSelection == 'Current'){
		seasonSelection = '';
	}

	if(selection == 'REG'){
		selection = '';
	}

	$.ajax({
	    type: "GET",
	    url: './TeamScoringTemplate.php',
	    data: {seasonId: seasonSelection, seasonType: selection, team:currentTeam},
	    success: function(data){
	    	$('#scoringInner').html(data);
	    }
	});
    
} );



</script>

<?php include 'footer.php'; ?>