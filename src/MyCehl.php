<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once 'config.php';
include 'lang.php';

$CurrentHTML = 'MyCehl.php';
$CurrentTitle = 'My CEHL';
$CurrentPage = 'MyCehl';
$SecurePage = true;

//error_reporting(E_ALL);
//ini_set("display_errors", "On");

// mb_internal_encoding('UTF-8');
// mb_http_output('UTF-8');
// mb_http_input('UTF-8');
// mb_language('uni');
// mb_regex_encoding('UTF-8');
// ob_start('mb_output_handler');

$version = '4.01';
//ini_set('arg_separator.output', '&amp;'); // MODE DANS LE URL


$skipNav = false;
include 'head.php';



//include GMO_ROOT.'config4.php';
include GMO_ROOT.'login/mysqli.php';


// Get Infos from database
// $sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
// $query = mysqli_query($con, $sql) or die(mysqli_error($con));
// if($query){
//     while($data = mysqli_fetch_array($query)) {
//         $SessionName = $data['VALUE'];
//     }
// }
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_langue' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $league_langue = $data['VALUE'];
    }
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'league_name' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $league_name = $data['VALUE'];
    }
}
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $TimeZone = $data['VALUE'];
    }
}

// Get Colors from database
$sql = "SELECT `NAME`, HEX(`COLOR`) AS COLOR FROM `".$db_table."_colors`";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $tmpName = $data['NAME'];
        $tmpColor = $data['COLOR'];
        $tmpArray = array($tmpName=>$tmpColor);
        if(isset($databaseColors)) $databaseColors = array_merge((array)$databaseColors, (array)$tmpArray);
        else $databaseColors = $databaseColors = $tmpArray;
    }
}

mysqli_close($con);

//init gmo
require_once GMO_ROOT.'membre/init.php';

date_default_timezone_set($TimeZone); //needs to be set or file_last_update may not be correct.
// $date_time = date("Y-m-d H:i:s"); // Global variable!

// $a = '';

//include 'head.php';
include 'nav.php';
//echo '<div class="header-content top-container"></div>';
?>


<div id="MyCEHL" class="container">

	<div class="row">
		<div class="col p-1">
			<div class="card">
				<?php include 'SectionHeader.php';?>

				<div class="card-body p-2">
					<?php 
					//$requiresLogin = true;
					
					   if ( !isAuthenticated() ) {
    					    // LIGUE NAME
    					    //no longer needed. done in main header.
//     					    include GMO_ROOT.'login/header.php';
//     					    include GMO_ROOT.'login/index.php';
//     					    $requiresLogin = false;
    					    
    					    error_log('HTTP/1.1 403 Forbidden', 0);
    					    http_response_code(403);
    					    //header('Location: ' . BASE_URL);
    					    exit();
					   }else{
					?>
					
				
					<div id="nav-mygm">
						<ul class="nav nav-tabs" id = "myCehlNav">
						
							<li class="nav-item"><a class="nav-link" href="#Team"
								data-toggle="tab">My Team</a></li>
	
							<li class="nav-item"><a class="nav-link" href="#Lines"
								data-toggle="tab">Line Editor</a></li>
								
							<li class="nav-item"><a class="nav-link" href="#Settings"
								data-toggle="tab">Settings</a></li>
								
							<?php 
							if(isAdmin()){
							    echo '<li class="nav-item"><a class="nav-link" href="#Admin"
								data-toggle="tab">Admin</a></li>';
							}
							?>
							
							
						</ul>
						<div class="tab-content">
							
							<div class="tab-pane" id="Team">
								<?php 
								
								include GMO_ROOT.'membre/myTeam.php';
								
                                ?>
							</div>
							
							
							<div class="tab-pane" id="Lines">
								<?php 
								
								if (isset($_SESSION['equipe']) && $_SESSION['equipe'] != 'ADMIN') {
								    // MEMBRE ZONE
								    $db_lang = '';
								    include GMO_ROOT.'login/mysqli.php';
								    $sql = "SELECT `LANGUE` FROM `".$db_table."` WHERE `INT`='".$teamID."'";
								    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
								    while($data = mysqli_fetch_array($query)) {
								        $db_lang = $data['LANGUE'];
								    }
								    if(isset($_GET['lang']) || isset($_POST['lang'])) {
								        $mode = ( isset($_GET['lang']) ) ? $_GET['lang'] : $_POST['lang'];
								        $mode = htmlspecialchars($mode);
								        
								        if($mode == 'fr' || $mode == 'en') {
								            if($db_lang == '') {
								                if($league_langue == "en") $db_lang = "fr";
								                if($league_langue == "fr") $db_lang = "en";
								            }
								            else {
								                $db_lang = $mode;
								            }
								            $sql = "UPDATE `".$db_table."` SET `LANGUE`='$db_lang' WHERE `INT`='".$teamID."'";
								            $query = mysqli_query($con, $sql) or die(mysqli_error($con));
								        }
								        mysqli_close($con);
								    }
								    if($db_lang) $league_langue = $db_lang;
								    
								    error_log("loading line editor", 0);
								    require GMO_ROOT.'membre/lang.php';
								    require GMO_ROOT.'membre/lineEditor.php';
								    
								    echo'<div class="pt-3 text-center">*NOTE: LINES MUST BE SAVED FOR ROSTER CHANGES TO TAKE EFFECT*</div>';
								}else{
								    echo '<h3>Error loading Page</h3>';
								}
								
                                ?>
							</div>
							
							<div class="tab-pane" id="Settings">
								<?php 
								
								include GMO_ROOT.'membre/settings.php';
								
                                ?>
							</div>
							
							<?php 
							if(isAdmin()){
							    echo '<div class="tab-pane" id="Admin">';
							    echo '<div class="table-responsive mt-2">';
							    
							    $db_lang = '';
							    include GMO_ROOT.'login/mysqli.php';
							    $sql = "SELECT `LANGUE` FROM `".$db_table."` WHERE `INT`='".$teamID."'";
							    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
							    while($data = mysqli_fetch_array($query)) {
							        $db_lang = $data['LANGUE'];
							    }
							    if($db_lang) $league_langue = $db_lang;
							    include GMO_ROOT.'admin/index.php';
							    
							    echo '</div>';
							    echo '</div>';
							}
							?>
					</div>

						</div>

					</div>
					
					<?php  }?>
					
				</div> <!-- end card body -->

			</div>
		</div>
	</div>
	
	<script>

	  $(document).ready(function() {
		  // add a hash to the URL when the user clicks on a tab
		  $('#MyCEHL a[data-toggle="tab"]').on('click', function(e) {
			var currentTab = $(this).attr('href');
		    history.pushState(null, null, currentTab);
		  });
		  // navigate to a tab when the history changes
		  window.addEventListener("popstate", function(e) {
		    var activeTab = $('[href="' + location.hash + '"]');
		    if (activeTab.length) {
		      activeTab.tab('show');
		    } else {
		      $('#MyCEHL .nav-tabs a:first').tab('show');
		    }
		  });

 		//inittab based on last location. (back button support)
		 if(location.hash){
			 var activeTab = $('[href="' + location.hash + '"]');
			 
			  if (activeTab.length) {
			      activeTab.tab('show');
			      console.log(activeTab);
			    } else {
			      //unable to resolve location.
			      $("#myCehlNav a:first").tab('show');
			    }
		 }else{
			 //if no location provider
			 $("#myCehlNav a:first").tab('show');
		 }


		});

	</script>

<!-- </div> -->



<?php include 'footer.php'; ?>