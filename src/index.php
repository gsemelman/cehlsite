<?php include 'config.php' ?>
<?php include 'lang.php' ?>
<?php include 'common.php' ?>
<?php include 'nav.php' ?>

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
						<div class="col-md-8 offset-md-2 text">
							<div class="wow fadeInLeftBig">
								<img src="assets\img\logo2.png" alt="Canadian Elite Hockey League" class="img-fluid">
							</div>
						</div>
					</div>
					
				</div>
			</div>
			
		</div>
		
		<!-- team logo roster links (img-rounded makes corner rounded) -->
		<div class="section-1-container section-container section-container-gray-bg">
			<div class="container">
				<div class="row">
	                <div class="col section-1 section-1-description wow fadeIn">
	                    <?php
							echo '<div class="row">';
								echo '<div class="col-xs-12">';
								sort($gmequipe); //sort
								for($i=0;$i<count($gmequipe);$i++) {

									$matches = glob($folderTeamLogos.strtolower($gmequipe[$i]).'.*');
									$teamImage = '';
									for($j=0;$j<count($matches);$j++) {
										$teamImage = $matches[$j];
										break 1;
									}
									//echo '<a href="LinkedRosters.php?'.$dropLinkPlf.$dropLinkFarm.$dropLinkOne.'team='.$gmequipe[$i].'">';
									echo '<a href="Rosters.php?team='.$gmequipe[$i].'">';
									echo '<img src="'.$teamImage.'" width=55 alt="'.$gmequipe[$i].'">';
									echo '</a>';

								}
								echo '</div>';
							echo '</div>';
						?>
	                </div>
	            </div>
			</div>
		<div>

		<div class="container-responsive section-2 mx-md-3 mx-lg-5">
			<div class="card-columns">

				<div class="card wow fadeIn">
					<div class="card-header wow fadeIn">
						<h3><?php
						if ($playoffs) {
                            echo 'Playoff Tree';
                        } else {
                            echo 'Overall Standings';
                        }
                
                        ?></h3>
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

				<div class="card wow fadeIn">
					<div class="card-header wow fadeIn">
						<h3>Latest Results</h3>
					</div>
					<div class="card-body">
						<?php include 'MiniTodayGames.php'; ?>
					</div>
				</div>

				<div class="card wow fadeIn">
					<div class="card-header wow fadeIn">
						<h3>Next Games</h3>
					</div>
					<div class="card-body">
						<?php include 'MiniNextGames.php'; ?>
					</div>
				</div>

				<div class="card wow fadeIn">
					<div class="card-header wow fadeIn">
						<h3>News</h3>
					</div>
					<div class="card-body">
						<?php include 'News.php'; ?>
					</div>
				</div>

				<div class="card wow fadeIn">
					<div class="card-header wow fadeIn">
						<h3>Waivers</h3>
					</div>
					<div class="card-body">
						<?php include 'MiniWaivers2.php'; ?>
					</div>
				</div>


				<div class="card wow fadeIn">
					<div class="card-header wow fadeIn">
						<h3>Leaders</h3>
					</div>
					<div class="card-body">
						<?php include 'MiniTop5.php'; ?>
					</div>
				</div>

			</div>
		</div>




		<!-- 
			<div class="section-2-container section-container">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="card section-2">
								<div class="card-header wow fadeIn">
									<h3>Overall Standings</h3>
								</div>
								<div class="card-body">
									<div class="col section-2-box wow fadeInLeft card-text">
									<?php
//                                     if (isPlayoffs($folder, $playoffMode)) {
//                                         include 'MiniStandingsTree.php';
//                                     } else {
//                                         include 'MiniStandings.php';
//                                     }
                            
                                    ?>
								</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="card section-2">
								<div class="card-header wow fadeIn">
									<h3>Latest Results</h3>
								</div>
								<div class="card-body">
									<div class="col section-2-box wow fadeInLeft card-text">
									<?php //include 'MiniTodayGames.php'; ?>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 col-md-6">
					<div class="section-2-container section-container">
						<div class="container">
							<div class="card section-2">
								<div class="card-header wow fadeIn">
									<h3>News</h3>
								</div>
								<div class="card-body">
									<div class="col section-2-box wow fadeInLeft card-text">
										<?php //include 'News.php'; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6">
					<div class="section-2-container section-container">
						<div class="container">
							<div class="card section-2">
								<div class="card-header wow fadeIn">
									<h3>Waivers</h3>
								</div>
								<div class="card-body">
									<div class="col section-2-box wow fadeInLeft card-text">
										<?php //include 'MiniWaivers2.php'; ?>
									</div>
								</div>
							</div>
							<div class="card section-2">
								<div class="card-header wow fadeIn">
									<h3>Next Games</h3>
								</div>
								<div class="card-body">
									<div class="col section-2-box wow fadeInLeft card-text">
										<?php //include 'MiniNextGames.php'; ?>
									</div>
								</div>
							</div>
							<div class="card section-2">
								<div class="card-header wow fadeIn">
									<h3>Leaders</h3>
								</div>
								<div class="card-body">
									<div class="col section-2-box wow fadeInLeft card-text">
										<?php// include 'MiniTop5.php'; ?>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div> -->
			


		</body>
</html>