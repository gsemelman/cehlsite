<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
  <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
  <title>Canadian Elite Hockey League</title>
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">-->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/paper/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/docs.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/docs.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>-->
  
  
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
	<link rel="stylesheet" href="assets/css/animate.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/media-queries.css">
	
	<!-- Javascript -->
	<script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/jquery-migrate-3.0.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="assets/js/jquery.backstretch.min.js"></script>
	<script src="assets/js/wow.min.js"></script>
	<script src="assets/js/retina-1.1.0.min.js"></script>
	<script src="assets/js/waypoints.min.js"></script>
	<script src="assets/js/scripts.js"></script>

	<?php include 'style.php' ?>
</head>

<body>
  
  <!-- Top menu -->
	<nav class="navbar navbar-dark fixed-top navbar-expand-lg navbar-no-bg">
		<div class="container">
			<a class="navbar-brand" href="index.php">Navbar</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					<!--<li class="nav-item">
						<a class="nav-link scroll-link" href="#top-content">Top</a>
					</li>-->
					  <li class="nav-item"><a class="nav-link" href="<?php echo $folderGmo ?>">GM&nbsp;Editor</a></li>
					  <li class="nav-item"><a class="nav-link" href="TodayGamesTSN.php">Scores</a></li>
					  <li class="nav-item"><a class="nav-link" href="Standings.php">Standings</a></li>
					  <li class="nav-item"><a class="nav-link" href="LinkedRosters.php">Teams</a></li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Stats&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li class="nav-item"><a class="nav-link-inner" href="TeamStats.php">Team Stats</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="Individual.php">Individual</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="Leaders.php">Leaders</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="Leaders.php?s=1">Farm&nbsp;Leaders</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="CareerLeaders.php">Career&nbsp;Leaders</a></li>
						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">League&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="nav-item"><a class="nav-link-inner" href="Coaches.php">Coaches</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Contracts.php">Contracts</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Standings.php?s=1">Farm&nbsp;Standings</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="FreeAgents.php">Free&nbsp;Agents</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Injury.php">Injuries</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Schedule.php?only=0">Schedule</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Transactions.php">Transactions</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Unassigned.php">Unassigned</a></li>
							<div class="dropdown-divider"></div>

						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Other&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<!--<li class="nav-item"><a class="nav-link-inner" href="https://goo.gl/forms/dcCNrDIqqEHAC6Bg1">Claim&nbsp;Request</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="https://goo.gl/forms/FW3iOZTmERdl06x23">Create&nbsp;Request</a></li>-->
							<li class="nav-item"><a class="nav-link-inner" href="ProspectForm.php?type=claim">Claim&nbsp;Request</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="ProspectForm.php">Create&nbsp;Request</a></li>
							<div class="dropdown-divider"></div>
							<!--<li class="nav-item"><a class="nav-link-inner" href="https://docs.google.com/spreadsheets/d/1kgeW0jwgRH3NXLOJCjDxX1XIG7DKzAHTlP08jpNc1VU/edit?usp=sharing">Drafts</a></li>-->
							<li class="nav-item"><a class="nav-link-inner" href="Drafts.php">Drafts</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="GMs.php">General&nbsp;Managers</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="SearchPlayers.php">Player Search</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Rules.php">Rules</a></li>
							<div class="dropdown-divider"></div>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo $folderLegacy ?>index.html">Old&nbsp;Site</a></li>
						</ul>
					  </li>
				</ul>
			</div>
			
		</div>
	</nav>


