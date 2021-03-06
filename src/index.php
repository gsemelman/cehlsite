<?php 
require_once 'config.php';
include 'lang.php';
include 'common.php';

$CurrentHTML = 'index.php';
$CurrentTitle = 'Home';
$CurrentPage = 'Home';

include 'head.php';

?>

<style>
.team-header-content {
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#cedce7+9,596a72+100 */
	background: rgb(206, 220, 231); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(206, 220, 231, 1) 9%,
		rgba(89, 106, 114, 1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top, rgba(206, 220, 231, 1) 9%,
		rgba(89, 106, 114, 1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom, rgba(206, 220, 231, 1) 9%,
		rgba(89, 106, 114, 1) 100%);
	/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cedce7',
		endColorstr='#596a72', GradientType=0); /* IE6-9 */
	border-radius: 5px;
	margin-bottom: 10px;
}

/* .card-header { */
/* 	background: linear-gradient(rgb(0, 55, 112) 2%, rgb(0, 55, 112) 20%, rgb(27, 98, 162) 100%); */

/* 	color: white; */
/* } */

</style>

<?php
// CRÉATION DE LA LISTE DES ÉQUIPES
$playoff = ''; //default for now (need to perperly handle this)
$matches = glob($folder.'*'.$playoff.'GMs.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	if((!substr_count($matches[$j], 'PLF') && $playoff == '') || (substr_count($matches[$j], 'PLF') && $playoff == 'PLF')) {
		$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
		break 1;
	}
}
$FnmGMs = $folder.$folderLeagueURL.'GMs.html';
$i = 0;
if(file_exists($FnmGMs)) {
	$tableau = file($FnmGMs);
	/* while(list($cle,$val) = each($tableau)) { */
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'HREF') && !substr_count($val, '<BR>')) {
			$gmequipe[$i] = trim(substr($val, 0, 10));
			//if($currentTeam == '' && $i == 0) $currentTeam = $gmequipe[$i];
			$i++;
		}
	}
}
else echo $allFileNotFound.' - '.$FnmGMs;

$playoffs = isPlayoffs($folder, $playoffMode);
?>

		<div class="top-content">
			<div class="inner-bg">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-8 offset-md-2 text ">
							<div class="wow fadeInLeftBig ">
								<img src="assets/img/logo2.png" alt="Canadian Elite Hockey League" class="img-fluid"/>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
        <div class="section-container">
			<div class="container">
				<div class="row">
	                <div class="col section-1 section-1-description team-header-content">
	                    <?php
							echo '<div class="row">';
								echo '<div class="col text-center">';
								sort($gmequipe); //sort
								for($i=0;$i<count($gmequipe);$i++) {

								    $matches = glob(FS_ROOT.LOGO_DIR.strtolower($gmequipe[$i]).'.*');
	
									$teamImage = '';
									for($j=0;$j<count($matches);$j++) {
										$teamImage = $matches[$j];
										$teamImage = LOGO_DIR.basename($teamImage);
										break 1;
									}

									echo '<a href="TeamRosters.php?team='.urlencode($gmequipe[$i]).'">';
									echo '<img src="'.$teamImage.'" width=55 alt="'.$gmequipe[$i].' ">';
									echo '</a>';

								}
								echo '</div>';
							echo '</div>';
						?>
	                </div>
	            </div>
			</div>
		</div>
		
		<div class="container rounded wow fadeIn" style ="background:#444; padding-left:30px; padding-right:30px ">
			<?php include 'ScoreCarousel.php'; ?>
		</div>
		
		<div class="container-responsive mx-md-3 mx-lg-5">
			<div class="card-columns">

				<div class="card wow fadeIn">
					<div class="card-header">
						<h4 class="m-0"><?php
						if ($playoffs) {
                            echo 'Playoff Tree';
                        } else {
                            echo 'Overall Standings';
                        }
                
                        ?></h4>
           
					</div>
					<div class="card-body">
						<?php
						if ($playoffs) {
                            include 'MiniStandingsTree.php';
                        } else {
                            include 'MiniStandings.php';
                        }
                
                        ?>
					</div>
				</div>

<!-- 				<div class="card wow fadeIn"> -->
<!-- 					<div class="card-header wow fadeIn"> -->
<!-- 						<h4 class="m-0">Latest Results</h4> -->
<!-- 					</div> -->
<!-- 					<div class="card-body"> -->

<!-- 					</div> -->
<!-- 				</div> -->

				<div class="card wow fadeIn">
					<div class="card-header">
						<h4 class="m-0">Next Games</h4>
					</div>
					<div class="card-body">
						<?php include 'MiniNextGames.php'; ?>
					</div>
				</div>

				<div class="card wow fadeIn">
					<div class="card-header">
						<h4 class="m-0">News</h4>
					</div>
					<div class="card-body">
						<?php include 'News.php'; ?>
					</div>
				</div>

				<div class="card wow fadeIn">
					<div class="card-header">
						<h4 class="m-0">Waivers</h4>
					</div>
					<div class="card-body">
						<?php include 'MiniWaivers.php'; ?>
					</div>
				</div>


				<div class="card wow fadeIn">
					<div class="card-header">
						<h4 class="m-0">Leaders</h4>
					</div>
					<div class="card-body">
						<?php include 'MiniTop5.php'; ?>
					</div>
				</div>

			</div>
		</div>

<?php include 'footer.php'; ?>