<?php $version = '1.01'; ?>
<!DOCTYPE html>
<html>
<head>
<?php include 'config.php' ?>
<?php include 'lang.php' ?>
<title><?php echo $homeTitle; ?></title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="author" content="Éric Leclerc">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=yes">

<?php include 'style.php' ?>

</head>
<body>

<div style="float:left; width:150px; border: solid 1px <?php echo $couleur_contour; ?>;">
	<table class="tableau">
		<tr class="tableau-top"><td><?php echo $homeUtilityPage; ?></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="CareerStats.php"><?php echo $careerStatsTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="SearchPlayers.php"><?php echo $searchPlayerTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="ComparePlayers.php"><?php echo $compareTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="fiche.php"><?php echo $teamCardTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="CareerLeaders.php"><?php echo $langCareerLeadersTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="CareerLeaders.php?one=1"><?php echo $langCareerTeamLeadersTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="CareerStandings.php"><?php echo $careerStandingsTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Unassigned.php"><?php echo $langUnassignedPlayers; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="ChatBox.php"><?php echo $langChatBoxTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="SalaryCopDaily.php"><?php echo $langSalaryCopDailyTitle; ?></a></td></tr>
	</table>
	<div class="titre"><span class="bold-blanc"><?php echo $homeTitle.' - '.$homeSeason; ?></span></div>
	<table class="tableau">
		<tr class="tableau-top"><td><?php echo $homeSeason; ?></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Schedule.php"><?php echo $schedTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Standings.php"><?php echo $standingTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="OverallStandings.php"><?php echo $standingOVTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="TodayGames.php"><?php echo $todayTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="TodayGamesTSN.php"><?php echo $todayTitle.' (TSN)'; ?></a></td></tr>
		<tr class="tableau-top"><td><?php echo $homeTeam; ?></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="GMs.php"><?php echo $GMsTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Coaches.php"><?php echo $CoachesTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Finance.php"><?php echo $financeTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Futures.php"><?php echo $prospectsTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Injury.php"><?php echo $injuryTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Lines.php"><?php echo $linesTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="PlayerVitals.php"><?php echo $joueursTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Rosters.php"><?php echo $rostersTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="TeamScoring.php"><?php echo $scoringTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="LinkedRosters.php"><?php echo $linkedTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="SalaryCop.php"><?php echo $salaryCopTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Transact.php"><?php echo $transactTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Waivers.php"><?php echo $waiversTitle; ?></a></td></tr>
		<tr class="tableau-top"><td><?php echo $homeStats; ?></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Leaders.php"><?php echo $leaderTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Individual.php"><?php echo $individualTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="TeamStats.php"><?php echo $teamStatsTitle; ?></a></td></tr>
		<tr class="tableau-top"><td><?php echo $homeFarm; ?></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Leaders.php?s=1"><?php echo $leaderTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Standings.php?s=1"><?php echo $standingTitle; ?></a></td></tr>
	</table>
	<div class="titre"><span class="bold-blanc"><?php echo $homeTitle.' - '.$homePlayoff; ?></span></div>
	<table class="tableau">
		<tr class="tableau-top"><td><?php echo $homePlayoff; ?></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Schedule.php?plf=1"><?php echo $schedTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Standings.php?plf=1"><?php echo $standingTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="OverallStandings.php?plf=1"><?php echo $standingOVTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="StandingsTree.php"><?php echo $StandingsTreeTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="TodayGames.php?plf=1"><?php echo $todayTitle; ?></a></td></tr>
		<tr class="tableau-top"><td><?php echo $homeTeam; ?></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="GMs.php?plf=1"><?php echo $GMsTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Coaches.php?plf=1"><?php echo $CoachesTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Finance.php?plf=1"><?php echo $financeTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Futures.php?plf=1"><?php echo $prospectsTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Injury.php?plf=1"><?php echo $injuryTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Lines.php?plf=1"><?php echo $linesTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="PlayerVitals.php?plf=1"><?php echo $joueursTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Rosters.php?plf=1"><?php echo $rostersTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="TeamScoring.php?plf=1"><?php echo $scoringTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="LinkedRosters.php?plf=1"><?php echo $linkedTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="SalaryCop.php?plf=1"><?php echo $salaryCopTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Transact.php?plf=1"><?php echo $transactTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Waivers.php?plf=1"><?php echo $waiversTitle; ?></a></td></tr>
		<tr class="tableau-top"><td><?php echo $homeStats; ?></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="Leaders.php?plf=1"><?php echo $leaderTitle; ?></a></td></tr>
		<tr class="hover1"><td><a class="lien-noir" style="display:block; width:100%;" href="Individual.php?plf=1"><?php echo $individualTitle; ?></a></td></tr>
		<tr class="hover2"><td><a class="lien-noir" style="display:block; width:100%;" href="TeamStats.php?plf=1"><?php echo $teamStatsTitle; ?></a></td></tr>
	</table>
</div>

<div style="float:left; margin-left:20px;">
	<?php
		/* $code = '<?php include \'addonFolder/MiniChatBox.php\'; ?>';
		highlight_string($code); */
	?>
	
	<br>
	<?php /* include 'MiniChatBox.php'; */ ?>
	<br>
	<?php
	# Season
	/* 	$code = '<?php include \'addonFolder/MiniTransact.php\'; ?>';
		highlight_string($code); */
	?>
	<br>
	<?php /* include 'MiniTransact.php'; */ ?>
	<br>
	<?php
	/* 	$code = '<?php include \'addonFolder/MiniTop5.php\'; ?>';
		highlight_string($code); */
	?>
	<br>
	<?php include 'MiniTop5.php'; ?>
	<br>
	<div style="max-width:555px; width:555px;">
	<?php
/* 		$code = '<?php include \'addonFolder/MiniTodayGames.php\'; ?>';
		highlight_string($code); */
	?>
	</div>
	<br>
	<?php include 'MiniTodayGames.php'; ?>
	<br>
	<?php
/* 		$code = '<?php include \'addonFolder/MiniWaivers.php\'; ?>';
		highlight_string($code); */
	?>
	<br>
	<?php include 'MiniWaivers.php'; ?>
	<br>

	<?php
	# Playoff
	$code = '<?php $playoff = 1; include \'addonFolder/MiniTransact.php\'; ?>';
	highlight_string($code);
	echo '<br>';
	$playoff = 1;
	include 'MiniTransact.php';
		
	echo '<br>';
	
	$code = '<?php $playoff = 1; include \'addonFolder/MiniTop5.php\'; ?>';
	highlight_string($code);
	echo '<br>';
	$playoff = 1;
	include 'MiniTop5.php';
		
	echo '<br>';
	echo '<div style="max-width:555px; width:555px;">';
	$code = '<?php $playoff = 1; include \'addonFolder/MiniTodayGames.php\'; ?>';
	highlight_string($code);
	echo '<br>';
	$playoff = 1;
	include 'MiniTodayGames.php';
	echo '</div>';
	echo '<br>';
	
	$code = '<?php $playoff = 1; include \'addonFolder/MiniWaivers.php\'; ?>';
	highlight_string($code);
	echo '<br>';
	$playoff = 1;
	include 'MiniWaivers.php';
	?>
	
	
</div>

</body>
</html>