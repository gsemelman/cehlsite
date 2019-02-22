<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="UTF-8"/>
  	<meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86"/>
  	<title>Canadian Elite Hockey League</title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
<!--     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.bootstrap4.min.css"/> -->
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css"/>
	<link rel="stylesheet" href="assets/css/style2.css"/>
	<link rel="stylesheet" href="assets/css/media-queries.css"/>
     
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
<!--     <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
<!--     <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
<!--     <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script> -->
    
	 <!-- Other scripts -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
	<script type="text/javascript" src="assets/js/scripts.js"></script>
	

	<?php
	   //Only import datatables resources as required
    	if(isset($dataTablesRequired)){
    	    echo PHP_EOL;
    	    echo '<!-- Datatables scripts -->';
    	    echo '<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>';
    	    echo PHP_EOL;
    	    echo '<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.bootstrap4.min.css"/>';
    	    echo PHP_EOL;
    	    
    	    echo '<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>';
    	    echo PHP_EOL;
    	    echo '<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>';
    	    echo PHP_EOL;
    	    echo '<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>';
    	    
    	    echo PHP_EOL;
    	    echo '<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"/>';
    	    
    	    echo PHP_EOL;
    	    echo '<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>';
    	    echo PHP_EOL;
    	    echo '<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>';
    	    echo PHP_EOL;
    	    echo '<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>';
    	    echo PHP_EOL;
    	    echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>';
    	}
	?>
	
	
	
	
	
	
	<style>
	
 /*    @media (max-height: 640px) {

        .navbar-nav{
              max-height:350px;
              overflow-y:auto;
           }
        } */
        
	</style>
	
	

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
				<ul class="navbar-nav ml-auto scrollable">
					<!--<li class="nav-item">
						<a class="nav-link scroll-link" href="#top-content">Top</a>
					</li>-->
					  <li class="nav-item"><a class="nav-link" href="<?php echo $folderGmo ?>">GM&nbsp;Editor</a></li>
					  <li class="nav-item"><a class="nav-link" href="TodayGamesTSN.php">Scores</a></li>
					  <li class="nav-item"><a class="nav-link" href="Standings3.php">Standings</a></li>
					  <li class="nav-item"><a class="nav-link" href="Rosters.php">Teams</a></li>
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
							<li class="nav-item"><a class="nav-link-inner" href="FreeAgency.php">Free&nbsp;Agent&nbsp;Offers</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Injury.php">Injuries</a></li>
<!-- 							<li class="nav-item"><a class="nav-link-inner" href="Schedule.php?only=0">Schedule</a></li> -->
							<li class="nav-item"><a class="nav-link-inner" href="Schedule2.php">Schedule</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Transactions.php">Transactions</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Unassigned.php">Unassigned</a></li>

						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Other&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<!--<li class="nav-item"><a class="nav-link-inner" href="https://goo.gl/forms/dcCNrDIqqEHAC6Bg1">Claim&nbsp;Request</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="https://goo.gl/forms/FW3iOZTmERdl06x23">Create&nbsp;Request</a></li>-->
							<li class="nav-item"><a class="nav-link-inner" target="_blank" href="https://docs.google.com/spreadsheets/d/e/2PACX-1vQNC0vO9e6s4zizPX3yYpongarBRr9sVdTQj1xxbzdTExEiEQwNmFidIWemXmmVimsYJjLKQOFnXrZZ/pubhtml#">Creation&nbsp;Requests</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="ProspectForm.php?type=claim">Claim&nbsp;Request</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="ProspectForm.php">Create&nbsp;Request</a></li>
							<li class="dropdown-divider"></li>
							<!--<li class="nav-item"><a class="nav-link-inner" href="https://docs.google.com/spreadsheets/d/1kgeW0jwgRH3NXLOJCjDxX1XIG7DKzAHTlP08jpNc1VU/edit?usp=sharing">Drafts</a></li>-->
							<li class="nav-item"><a class="nav-link-inner" href="Drafts.php">Drafts</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="GMs.php">General&nbsp;Managers</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="SearchPlayers.php">Player Search</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="Rules.php">Rules</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="SalaryCop.php">Salary&nbsp;Cop</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo $folderLegacy ?>index.html">Old&nbsp;Site</a></li>
						</ul>
					  </li>
				</ul>
			</div>
			
		</div>
	</nav>


