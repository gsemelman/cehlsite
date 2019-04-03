<!DOCTYPE html>
<html lang="en">
<head>

  	<meta charset="UTF-8"/>
  	<meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86"/>
  	<title>Canadian Elite Hockey League</title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,600"/>
<!-- 	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/> -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/>
<!-- 	<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/sandstone/bootstrap.css"/> -->



    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css"/>
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/style-04022019-1.css"/>
	<link rel="stylesheet" href="<?php echo BASE_URL?>assets/css/media-queries.css"/>
     
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    
<!--     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
	 <!-- Other scripts -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL?>assets/js/scripts.js"></script>

	


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
        body {
          background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#cbccc8)) fixed;
          background-image: linear-gradient(to top, #ffffff, #fcfcff, #f9f9ff, #f5f7ff, #f1f4ff, #ecf1fc, #e7edf9, #e2eaf6, #dce4ef, #d5dee9, #cfd9e2, #c9d3dc);   
          }
          
       .navbar-nav ul{
        line-height:1.5;
       }
       
	</style>
	
	

	<?php include FS_ROOT.'style.php' ?>
</head>

<body>
	<!-- <div class="site-content">-- for use with footer -->
  
  <!-- Top menu -->
	<nav class="navbar navbar-dark fixed-top navbar-expand-lg navbar-no-bg">
		<div class="container">
			<a class="navbar-brand" href="<?php echo BASE_URL?>index.php">Navbar</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto scrollable text-center">
					<!--<li class="nav-item">
						<a class="nav-link scroll-link" href="#top-content">Top</a>
					</li>-->
					  <!--<li class="nav-item"><a class="nav-link" href="<?php echo $folderGmo ?>">GM&nbsp;Editor</a></li>  -->
					  <!--<li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL?>MyCehl.php">MyTeam</a></li>  -->
					  <?php 
    					  if(isAuthenticated()){
    					      echo '<li class="dropdown">
        						<a href="'.BASE_URL.'MyCehl.php" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My&nbspCEHL<span class="caret"></span></a>
        						<ul class="dropdown-menu" style="line-height:1.8">
        						  <li class="nav-item"><a class="nav-link-inner" href="'.BASE_URL.'MyCehl.php#Team">Team</a></li>
                                  <li class="nav-item"><a class="nav-link-inner" href="'.BASE_URL.'MyCehl.php#Lines">Line Editor</a></li>
    					          <li class="nav-item"><a class="nav-link-inner" href="'.BASE_URL.'MyCehl.php#Settings">Settings</a></li>';
    					          if(isAdmin()) echo '<li class="nav-item"><a class="nav-link-inner" href="'.BASE_URL.'MyCehl.php#Admin">Admin</a></li>';

                              echo '<li class="dropdown-divider"></li>
        						  <li class="nav-item"><a class="nav-link-inner" href="'.BASE_URL.'gmo/login/logout.php">Logout</a></li>
        						</ul>
        					  </li>';
    					  }else{
    					      echo '<li class="nav-item"><a class="nav-link" href="'.BASE_URL.'MyCehl.php">Login</a></li>';
    					  }
					  ?>

					  <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL?>Scores.php">Scores</a></li>
					  <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL?>Standings3.php">Standings</a></li>
					  <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL?>TeamRosters.php">Teams</a></li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Stats&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>TeamStats.php">Team Stats</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Individual.php">Individual</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Leaders.php">Leaders</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Leaders.php?s=1">Farm&nbsp;Leaders</a></li>
						  <li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>CareerLeaders.php">Career&nbsp;Leaders</a></li>
						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">League&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Coaches.php">Coaches</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Contracts.php">Contracts</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Standings.php?s=1">Farm&nbsp;Standings</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>FreeAgents.php">Free&nbsp;Agents</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>FreeAgency.php">Free&nbsp;Agent&nbsp;Offers</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Injury.php">Injuries</a></li>
<!-- 							<li class="nav-item"><a class="nav-link-inner" href="Schedule.php?only=0">Schedule</a></li> -->
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Schedule2.php">Schedule</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Transactions.php">Transactions</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Unassigned.php">Unassigned</a></li>

						</ul>
					  </li>
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Other&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<!--<li class="nav-item"><a class="nav-link-inner" href="https://goo.gl/forms/dcCNrDIqqEHAC6Bg1">Claim&nbsp;Request</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="https://goo.gl/forms/FW3iOZTmERdl06x23">Create&nbsp;Request</a></li>-->
							<li class="nav-item"><a class="nav-link-inner" target="_blank" href="https://docs.google.com/spreadsheets/d/e/2PACX-1vQNC0vO9e6s4zizPX3yYpongarBRr9sVdTQj1xxbzdTExEiEQwNmFidIWemXmmVimsYJjLKQOFnXrZZ/pubhtml#">Creation&nbsp;Requests</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>ProspectForm.php?type=claim">Claim&nbsp;Request</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>ProspectForm.php">Create&nbsp;Request</a></li>
							<li class="dropdown-divider"></li>
							<!--<li class="nav-item"><a class="nav-link-inner" href="https://docs.google.com/spreadsheets/d/1kgeW0jwgRH3NXLOJCjDxX1XIG7DKzAHTlP08jpNc1VU/edit?usp=sharing">Drafts</a></li>-->
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Drafts.php">Drafts</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>GMs.php">General&nbsp;Managers</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>SearchPlayers.php">Player Search</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>Rules.php">Rules</a></li>
							<li class="dropdown-divider"></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?>SalaryCop.php">Salary&nbsp;Cop</a></li>
							<li class="nav-item"><a class="nav-link-inner" href="<?php echo BASE_URL?><?php echo $folderLegacy ?>index.html">Old&nbsp;Site</a></li>
						</ul>
					  </li>
				</ul>
			</div>
			
		</div>
	</nav>
	
	<div class="site-content header-content top-container">

	
