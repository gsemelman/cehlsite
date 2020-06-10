<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'config.php';
require_once 'lang.php';
include_once 'common.php';

$CurrentHTML = 'TeamRosters';
$CurrentTitle = $rostersTitle;
$CurrentPage = 'TeamRosters';
include 'head.php';


include_once 'classes/RosterObj.php';
include_once 'classes/RosterAvgObj.php';
include_once 'classes/RostersHolder.php';
include_once 'classes/PlayerVitalObj.php';
include_once 'classes/PlayerVitalsHolder.php';
include_once 'classes/ScoringHolder.php';
include_once 'classes/ScoringPlayerObj.php';
include_once 'classes/ScoringGoalieObj.php';
include_once 'classes/ScoringObj.php';

$playoffs='';
if(isPlayoffs(TRANSFER_DIR, LEAGUE_MODE)){
    $playoffs = 'PLF';
}


$teamScoringFileName = getLeagueFile(str_replace("#","27",CAREER_STATS_DIR), $playoffs, 'TeamScoring.html', 'TeamScoring');
$scoringHolder = new classes\ScoringHolder($teamScoringFileName, 'Columbus');

?>


<div class="container">
	<div class="row no-gutters">
		<div class="col">
			<div class="card">
			
			<?php 
			
			foreach ($scoringHolder->getSkaters() as $scoring) {
			    echo '<br>';
			    echo json_encode($scoring, JSON_PRETTY_PRINT);
			    echo '<br>';
			}
			
			echo '<br>';
			echo '-----------------------------------------';
			echo '<br>';
			
			foreach ($scoringHolder->getGoalies() as $goalie) {
			    echo '<br>';
			    echo json_encode($goalie, JSON_PRETTY_PRINT);
			    echo '<br>';
			    
			}
			
			?>
			
			</div>

		</div>
	</div>
	
<script>


</script>



</div>

<?php include 'footer.php'; ?>