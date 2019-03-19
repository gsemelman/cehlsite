<?php 

include_once 'classes/TeamInfo.php';
$teamInfo = new TeamInfo($folder, $playoff, $currentTeam);

?>

<div class= "teamheader logo-gradient">
	<?php 
	 $teamCardLogoSrc = glob($folderTeamLogos.strtolower($currentTeam).'.*');
	?>
 	<div class="team-logo gloss logo-gradient">
        <?php 
            if(isset($teamCardLogoSrc[0])) {
                echo'<img src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
            }
        ?>
     </div>
     <div class="team-logo gloss logo-gradient team-logo-right">
        <?php 
            if(isset($teamCardLogoSrc[0])) {
                echo'<img src="'.$teamCardLogoSrc[0].'" alt="'.$currentTeam.'">';
            }
        ?>
     </div>

     <div class="header-container">

		<div class="gloss"></div>
		<div class="header">
			<h3 class="mb-0" ><?php echo $CurrentTitle ?></h3>
			<?php echo $currentTeam.' '.$teamInfo->getWins().'-'.$teamInfo->getLosses().'-'.$teamInfo->getTies() ?>
			<?php echo '('.$teamInfo->getPlaceString().' '.$teamInfo->getConferenceSafeString().')' ?>
			
		</div>
	</div>
</div>