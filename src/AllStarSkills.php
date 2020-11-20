<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'All-Star Skills Competition';
$CurrentPage = 'Skills';
include 'head.php';
?>

<div class="container wow fadeIn">

	<div class="card">
	
		<?php include 'SectionHeader.php';?>
		
		<div class="card-body px-2 px-md-3">

			<div class="col-sm-12 col-md-6 col-lg-4" style="display: flex;">

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="seasonMenuHeader">Season</span>
					</div>

					<select class="form-control" aria-label="Select Season"
						id="seasonMenu" aria-describedby="seasonMenuHeader">
						<option value="Current">Current</option>
					</select>
				</div>
			</div>


			<div class="card">
				<div id="standingsTabs" class="card-header px-2 px-lg-4 pb-1 pt-2">
					<ul class="nav nav-tabs nav-fill">
						<li class="nav-item"><a class="nav-link active" href="#Summary"
							data-toggle="tab">Summary</a></li>

						<li class="nav-item"><a class="nav-link" href="#PuckRelay"
							data-toggle="tab">Puck Control Relay</a></li>

						<li class="nav-item"><a class="nav-link" href="#FastestSkater"
							data-toggle="tab">Fastest Skater</a></li>

						<li class="nav-item"><a class="nav-link" href="#HardestShot"
							data-toggle="tab">Hardest Shot</a></li>

						<li class="nav-item"><a class="nav-link" href="#RapidFire"
							data-toggle="tab">Rapid Fire</a></li>

						<li class="nav-item"><a class="nav-link" href="#AccuracyShooting"
							data-toggle="tab">Accuracy Shooting</a></li>

						<li class="nav-item"><a class="nav-link" href="#BreakAwayRelay"
							data-toggle="tab">Breakaway Relay</a></li>
						
						<li class="nav-item"><a class="nav-link" href="#GoalieGoals"
							data-toggle="tab">Goalie Goals</a></li>
							
<!-- 						<li class="nav-item"><a class="nav-link" href="#Playoffs" -->
<!-- 							data-toggle="tab">Goaltender Competition</a></li> -->
					</ul>
				</div>
				<div class="card-body tab-content pt-2">
					<div class="tab-pane active" id="Summary">
						<div class = "row">
							<div class="col mt-2">
								<h3>Summary</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-4 offset-md-4 mt-2">
								<table class="table table-sm table-striped table-rounded">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Final Score</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>9</td>
										</tr>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>3</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-4 offset-md-2 mt-2">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Puck Control Relay</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Eastern Conference wins the Puck Control Relay</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Connor McDavid unsurprisingly takes the Individual Puck Control Relay.</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-12 col-md-4 mt-2">
								<table class="table table-sm table-striped table-rounded">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Fastest Skater</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>2</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Eastern Conference wins the Team Event</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Winner Individual Event: Erik Karlsson</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
		
						<div class="row">
							<div class="col-sm-12 col-md-4 offset-md-2 mt-2">
								<table class="table table-sm table-striped table-rounded">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Hardest Shot</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Eastern Conference wins the Hardest Shot Event</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Dougie Hamilton recorded the hardest shot with 105.1 MPH</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-12 col-md-4 mt-2">
								<table class="table table-sm table-striped table-rounded">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Rapid Fire</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Eastern Conference wins the Rapid Fire event</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
			
						<div class="row">
							<div class="col-sm-12 col-md-4 offset-md-2 mt-2">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Accuracy Shooting</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>2</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Eastern Conference wins the Accuracy Shooting Team Event</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Kevin Labanc hits the target four times with only 4 shots.</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-12 col-md-4 mt-2">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Breakaway Relay</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Western Conference wins the Breakaway Relay Event</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					
						<div class="row">
							<div class="col-sm-12 col-md-4 offset-md-2 mt-2">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Goalie Goals</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Eastern Conference wins the Goalie Goals Event.</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Frederik Andersen scored the most goals (2)</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-12 col-md-4 mt-2">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Goaltender Competition</h5></th></tr>
										<tr><th colspan="2" >(Combined saves from Rapid Fire and Breakaway Relay Event)</th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td colspan="2" class="text-left">Frederik Andersen and Henrik Lundqvist have the most saves with 16</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>		
						
						<div class="row">
							<div class="col-sm-12 col-md-6 offset-md-3 mt-2">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="3" ><h5 class="m-0">Prizes</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Puck Control Relay</td>
											<td class="text-left">Connor McDavid</td>
											<td>500K each</td>
										</tr>
										<tr>	
											<td class="text-left">Fastest Skater</td>
											<td class="text-left">Erik Karlsson</td>
											<td>500K</td>
										</tr>
										<tr>	
											<td class="text-left">Hardest Shot</td>
											<td class="text-left">Dougie Hamilton</td>
											<td>500K</td>
										</tr>
										<tr>	
											<td class="text-left">Accuracy Shooting</td>
											<td class="text-left">Kevin Labanc</td>
											<td>500K</td>
										</tr>
										<tr>	
											<td class="text-left">Breakaway Relay</td>
											<td class="text-left">Matthew Tkachuk scores the winning goal </td>
											<td>500K</td>
										</tr>

										<tr>	
											<td class="text-left">Goalie Goals</td>
											<td class="text-left">Frederik Andersen</td>
											<td>500k</td>
										</tr>
										<tr>	
											<td class="text-left">Goaltender Competition</td>
											<td class="text-left">Frederik Andersen and Henrik Lundqvist</td>
											<td>250K each</td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						
					</div>

					<div class="tab-pane" id="PuckRelay">
						<div class = "row">
							<div class="col mt-2">
								<h3>Puck Control Relay</h3>
							</div>
						</div>
						<div class = "row">
							
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Rules</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Race One involves three players per squad participating in a relay. The second player participating must be defenseman.</td>
										</tr>
										<tr>	
											<td class="text-left">Race Two is a one-on-one match race involving a player from each squad.</td>
										</tr>
										<tr>	
											<td class="text-left">One goal is awarded to the winning squad of each race. In the event of a tie, each squad will receive one goal.</td>
										</tr>
										
									</tbody>
								</table>
								
							</div>
						
						</div>
						
						<div class="row mt-2">
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Western Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>John Tavares</td>
										</tr>
										<tr>
											<td>Torey Krug</td>
										</tr>
										<tr>
											<td>John Klingberg</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Eastern Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Artemi Panarin</td>
										</tr>
										<tr>
											<td>Erik Karlsson</td>
										</tr>
										<tr>
											<td>Kristopher Letang</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class = "row">
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Team Event</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">	John Tavares for the Western Conference and Artemi Panarin for the Eastern</td>
										</tr>
										<tr>	
											<td class="text-left">Conference hit the ice and start skating....</td>
										</tr>
										<tr>	
											<td class="text-left">Artemi Panarin crosses the line with a 2ft lead.</td>
										</tr>
										<tr>	
											<td class="text-left">The next skaters are Torey Krug for the Western Conference
									and Erik Karlsson for the Eastern Conference.</td>
										</tr>
										<tr>	
											<td class="text-left">Erik Karlsson crosses the line with a 10ft lead. BOOM!</td>
										</tr>
										<tr>	
											<td class="text-left">The next skaters are 	John Klingberg for the Western Conference
									and Kristopher Letang for the Eastern Conference.</td>
										</tr>
										<tr>	
											<td class="text-left">Kristopher Letang crosses the line with a 3ft lead.</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference wins!</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
						
						
						<div class="row mt-2">
		
							<div class="col-sm-12 col-md-6 offset-md-3">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Team Result</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						
						<div class="row mt-2">
							<div class="col">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2"><h5 class="m-0">Invidivual</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Western Conference</td>
											<td>Connor McDavid</td>
										</tr>
										<tr>
											<td>Eastern Conference</td>
											<td>Auston Matthews</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						
						<div class = "row">
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Individual Event</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Connor McDavid for the Western Conference and Auston Matthews for the Eastern</td>
										</tr>
										<tr>	
											<td class="text-left">Players hit the ice and start skating....</td>
										</tr>
										<tr>	
											<td class="text-left"> Connor McDavid crosses the line with a 5ft lead. The west WIN!</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
						
						<div class="row mt-2">
		
							<div class="col-sm-12 col-md-6 offset-md-3">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Individual Result</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td colspan ="2" class="text-left">Steven Stamkos and Auston Matthews tie</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

					</div>
					
					<div class="tab-pane" id="FastestSkater">
						<div class = "row">
							<div class="col mt-2">
								<h3>Fastest Skater</h3>
							</div>
						</div>
						<div class = "row">
							
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Rules</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Three players per sqaud.</td>
										</tr>
										<tr>	
											<td class="text-left">One goal is awarded to the squad with the best average time.</td>
										</tr>
										<tr>	
											<td class="text-left">One goal is awarded to the squad of the player with the best time.</td>
										</tr>
										
									</tbody>
								</table>
								
							</div>
						
						</div>
						
						<div class="row mt-2">
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Western Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Connor McDavid</td>
										</tr>
										<tr>
											<td>Alexander Radulov</td>
										</tr>
										<tr>
											<td>Michael Grabner</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Eastern Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Erik Karlsson</td>
										</tr>
										<tr>
											<td>Mathew Barzal</td>
										</tr>
										<tr>
											<td>Nicklas Backstrom</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class = "row  mt-2">
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Event</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Erik Karlsson: 13.689</td>
										</tr>
										<tr>	
											<td class="text-left">Mathew Barzal: 14.059</td>
										</tr>
										<tr>	
											<td class="text-left">Nicklas Backstrom: 13.883</td>
										</tr>
										<tr>	
											<td class="text-left">Connor McDavid: 13.726</td>
										</tr>
										<tr>	
											<td class="text-left">Alexander Radulov: 14.124</td>
										</tr>
										<tr>	
											<td class="text-left">Michael Grabner: 14.328</td>
										</tr>
									</tbody>
								</table>
								
							</div>
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Overview</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Average Time Eastern Conference: 13.877</td>
										</tr>
										<tr>	
											<td class="text-left">Average Time Western Conference: 14.059</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference wins the Team Event</td>
										</tr>
										<tr>	
											<td class="text-left">Winner Individual Event: Erik Karlsson - Eastern Conference Time: 13.689</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
						

						<div class="row mt-2">
		
							<div class="col-sm-12 col-md-6 offset-md-3">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Result</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>2</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="tab-pane" id="HardestShot">
						<div class = "row">
							<div class="col mt-2">
								<h3>Hardest Shot</h3>
							</div>
						</div>
						<div class = "row">
							
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Rules</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Four players per squad. Each player has two attempts.</td>
										</tr>
										<tr>	
											<td class="text-left">The highest recorded shot (in mph) of the two attempts will be scored.</td>
										</tr>
										<tr>	
											<td class="text-left">The squad with the best average score in mph, determined by using each participant''s highest recorded shot, will receive one goal.</td>
										</tr>
										<tr>	
											<td class="text-left">The player with the highest recorded shot in mph will be deemed the individual winner and his squad will receive one goal.</td>
										</tr>
										
									</tbody>
								</table>
								
							</div>
						
						</div>
						
						<div class="row mt-2">
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Western Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Dougie Hamilton</td>
										</tr>
										<tr>
											<td>Brent Burns</td>
										</tr>
										<tr>
											<td>Yohann Auvitu</td>
										</tr>
										<tr>
											<td>Jamie Benn</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Eastern Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Mark Giordano</td>
										</tr>
										<tr>
											<td>Kristopher Letang</td>
										</tr>
										<tr>
											<td>Darnell Nurse</td>
										</tr>
										<tr>
											<td>Auston Matthews</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class = "row  mt-2">
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Event</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Mark Giordano First shot: 100.7 Second Shot: 99.3</td>
										</tr>
										<tr>	
											<td class="text-left">Dougie Hamilton First shot: 96.2 Second Shot: 105.1</td>
										</tr>
										<tr>	
											<td class="text-left">Kristopher Letang First shot: 96.0 Second Shot: 102.0</td>
										</tr>
										<tr>	
											<td class="text-left">Brent Burns First shot: 104.2 Second Shot: 104.4</td>
										</tr>
										<tr>	
											<td class="text-left">Darnell Nurse First shot: 96.0 Second Shot: 98.0</td>
										</tr>
										<tr>	
											<td class="text-left">Yohann Auvitu First shot: 87.9 Second Shot: 90.9</td>
										</tr>
										<tr>	
											<td class="text-left">Auston Matthews First shot: 103.2 Second Shot: 95.3</td>
										</tr>
										<tr>	
											<td class="text-left">Jamie Benn First shot: 94.5 Second Shot: 97.5</td>
										</tr>
									</tbody>
								</table>
								
							</div>
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Overview</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference average score in mph: 99.5</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference average score in mph: 100.9</td>
										</tr>
										<tr>	
											<td class="text-left">Dougie Hamilton recorded the hardest shot with 105.1</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
						

						<div class="row mt-2">
		
							<div class="col-sm-12 col-md-6 offset-md-3">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Result</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>1</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="tab-pane" id="PuckRelay">
						<div class = "row">
							<div class="col mt-2">
								<h3>Puck Control Relay</h3>
							</div>
						</div>
						<div class = "row">
							
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Rules</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Race One involves three players per squad participating in a relay. The second player participating must be defenseman.</td>
										</tr>
										<tr>	
											<td class="text-left">Race Two is a one-on-one match race involving a player from each squad.</td>
										</tr>
										<tr>	
											<td class="text-left">One goal is awarded to the winning squad of each race. In the event of a tie, each squad will receive one goal.</td>
										</tr>
										
									</tbody>
								</table>
								
							</div>
						
						</div>
						
						<div class="row mt-2">
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Western Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>John Tavares</td>
										</tr>
										<tr>
											<td>Torey Krug</td>
										</tr>
										<tr>
											<td>John Klingberg</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Eastern Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Artemi Panarin</td>
										</tr>
										<tr>
											<td>Erik Karlsson</td>
										</tr>
										<tr>
											<td>Kristopher Letang</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class = "row">
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Event</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Artemi Panarin for the Eastern Conference and John Tavares for the Western </td>
										</tr>
										<tr>	
											<td class="text-left">Conference hit the ice and start skating....</td>
										</tr>
										<tr>	
											<td class="text-left">Artemi Panarin crosses the line with a 2ft lead.</td>
										</tr>
										<tr>	
											<td class="text-left">The next skaters are Torey Krug for the Western Conference
									and  Erik Karlsson for the Eastern Conference.</td>
										</tr>
										<tr>	
											<td class="text-left"> Erik Karlsson crosses the line with a 10ft lead.</td>
										</tr>
										<tr>	
											<td class="text-left">The next skaters are John Klingberg for the Western Conference
									and Kristopher Letang for the Eastern Conference.</td>
										</tr>
										<tr>	
											<td class="text-left">Kristopher Letang crosses the line with a 3ft lead.</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
						

						<div class="row mt-2">
		
							<div class="col-sm-12 col-md-6 offset-md-3">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Result</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="tab-pane" id="FastestSkater">
						<div class = "row">
							<div class="col mt-2">
								<h3>Fastest Skater</h3>
							</div>
						</div>
						<div class = "row">
							
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Rules</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Three players per sqaud.</td>
										</tr>
										<tr>	
											<td class="text-left">One goal is awarded to the squad with the best average time.</td>
										</tr>
										<tr>	
											<td class="text-left">One goal is awarded to the squad of the player with the best time.</td>
										</tr>
										
									</tbody>
								</table>
								
							</div>
						
						</div>
						
						<div class="row mt-2">
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Western Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Connor McDavid</td>
										</tr>
										<tr>
											<td>Alexander Radulov</td>
										</tr>
										<tr>
											<td>Michael Grabner</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Eastern Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Erik Karlsson</td>
										</tr>
										<tr>
											<td>Mathew Barzal</td>
										</tr>
										<tr>
											<td>Nicklas Backstrom</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class = "row  mt-2">
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Event</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Phil Kessel: 13.846</td>
										</tr>
										<tr>	
											<td class="text-left">Carl Hagelin: 13.606</td>
										</tr>
										<tr>	
											<td class="text-left">Tobias Rieder: 14.143</td>
										</tr>
										<tr>	
											<td class="text-left">Jon Marchessault: 14.170</td>
										</tr>
										<tr>	
											<td class="text-left">Nikita Kucherov: 14.106</td>
										</tr>
										<tr>	
											<td class="text-left">Matt Duchene: 14.124</td>
										</tr>
									</tbody>
								</table>
								
							</div>
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Overview</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Average Time Western Conference: 13.865</td>
										</tr>
										<tr>	
											<td class="text-left">Average Time Eastern Conference: 14.133</td>
										</tr>
										<tr>	
											<td class="text-left">Western Conference wins the Team Event</td>
										</tr>
										<tr>	
											<td class="text-left">Winner Individual Event: Carl Hagelin - Western Conference Time: 13.606</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
						

						<div class="row mt-2">
		
							<div class="col-sm-12 col-md-6 offset-md-3">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Result</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>2</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="tab-pane" id="AccuracyShooting">
						<div class = "row">
							<div class="col mt-2">
								<h3>Accuracy Shooting</h3>
							</div>
						</div>
						<div class = "row">
							
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Rules</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Four players per squad.</td>
										</tr>
										<tr>	
											<td class="text-left">One goal to squad with most targets hit in fewest shots.</td>
										</tr>
										<tr>	
											<td class="text-left">One goal to individual winner's squad.</td>
										</tr>
										<tr>	
											<td class="text-left">In the event of a tie, each squad will receive one goal.</td>
										</tr>
										
									</tbody>
								</table>
								
							</div>
						
						</div>

						<div class="row mt-2">
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Western Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Victor Hedman</td>
										</tr>
										<tr>
											<td>Alexander Ovechkin</td>
										</tr>
										<tr>
											<td>Sidney Crosby</td>
										</tr>
										<tr>
											<td>Vladislav Namestnikov</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Eastern Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Nikita Kucherov</td>
										</tr>
										<tr>
											<td>Alex Pietrangelo</td>
										</tr>
										<tr>
											<td>Anze Kopitar</td>
										</tr>
										<tr>
											<td>Jon Marchessault</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class = "row  mt-2">
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Event</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left"><strong>Western Conference</strong></td>
										</tr>
										<tr>	
											<td class="text-left">Victor Hedman  4 hits, 5 shots</td>
										</tr>
										<tr>	
											<td class="text-left">Alexander Ovechkin  4 hits, 4 shots</td>
										</tr>
										<tr>	
											<td class="text-left">Sidney Crosby  4 hits, 5 shots</td>
										</tr>
										<tr>	
											<td class="text-left">Vladislav Namestnikov  4 hits, 5 shots</td>
										</tr>
										<tr>	
											<td class="text-left"><strong>Eastern Conference</strong></td>
										</tr>
										<tr>	
											<td class="text-left">Nikita Kucherov  4 hits, 5 shots</td>
										</tr>
										<tr>	
											<td class="text-left">Alex Pietrangelo  4 hits, 12 shots</td>
										</tr>
										<tr>	
											<td class="text-left">Anze Kopitar  4 hits, 12 shots</td>
										</tr>
										<tr>	
											<td class="text-left">Jon Marchessault  4 hits, 6 shots</td>
										</tr>
									</tbody>
								</table>
								
							</div>
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Best Shooter</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Alexander Ovechkin 4 shots</td>
										</tr>
										<tr>	
											<td class="text-left">Western Conference wins</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
						

						<div class="row mt-2">
		
							<div class="col-sm-12 col-md-6 offset-md-3">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Result</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>2</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="tab-pane" id="BreakAwayRelay">
						<div class = "row">
							<div class="col mt-2">
								<h3>BreakAway Relay</h3>
							</div>
						</div>
						<div class = "row">
							
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Rules</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">18 Skater and 3 goaltenders per squad.</td>
										</tr>
										<tr>	
											<td class="text-left">Skaters are sepereated into three groups of six players per squad.</td>
										</tr>
										<tr>	
											<td class="text-left">All goals for are counted towards the total score for each conference.</td>
										</tr>
										<tr>	
											<td class="text-left">Player(s) on the winning team with the most goals wins the event.</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						
						</div>

						<div class="row mt-2">
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Western Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr class="tableau-top"><td>Group 1</td></tr>
										<tr>
											<td>Carl Hagelin</td>
										</tr>
										<tr>
											<td>Connor McDavid</td>
										</tr>
										<tr>
											<td>John Tavares</td>
										</tr>
										<tr>
											<td>Kyle Okposo</td>
										</tr>
										<tr>
											<td>Erik Karlsson</td>
										</tr>
										<tr>
											<td>Zach Bogosian</td>
										</tr>
										<tr class="tableau-top"><td>Group 2</td></tr>
										<tr>
											<td>Logan Couture</td>
										</tr>
										<tr>
											<td>Tobias Rieder</td>
										</tr>
										<tr>
											<td>Sidney Crosby</td>
										</tr>
										<tr>
											<td>Phil Kessel</td>
										</tr>
										<tr>
											<td>Victor Hedman</td>
										</tr>
										<tr>
											<td>Torey Krug</td>
										</tr>
										<tr class="tableau-top"><td>Group 3</td></tr>
										<tr>
											<td>Jamie Benn</td>
										</tr>
										<tr>
											<td>Steven Stamkos</td>
										</tr>
										<tr>
											<td>Alexander Ovechkin</td>
										</tr>
										<tr>
											<td>Vladislav Namestnikov</td>
										</tr>
										<tr>
											<td>Brent Burns</td>
										</tr>
										<tr>
											<td>P.K. Subban</td>
										</tr>
										<tr class="tableau-top"><td>Goalies</td></tr>
										<tr>
											<td>Braden Holtby</td>
										</tr>
										<tr>
											<td>Jonathan Quick</td>
										</tr>
										<tr>
											<td>Connor Hellebuyck</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Eastern Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr class="tableau-top"><td>Group 1</td></tr>
										<tr>
											<td>David Krejci</td>
										</tr>
										<tr>
											<td>Joshua Bailey</td>
										</tr>
										<tr>
											<td>Nicklas Backstrom</td>
										</tr>
										<tr>
											<td>Jakub Voracek</td>
										</tr>
										<tr>
											<td>John Carlson</td>
										</tr>
										<tr>
											<td>Adam Larsson</td>
										</tr>
										<tr class="tableau-top"><td>Group 2</td></tr>
										<tr>
											<td>Auston Matthews</td>
										</tr>
										<tr>
											<td>Evgeni Malkin</td>
										</tr>
										<tr>
											<td>Anze Kopitar</td>
										</tr>
										<tr>
											<td>Brayden Point</td>
										</tr>
										<tr>
											<td>Brayden Point</td>
										</tr>
										<tr>
											<td>Jacob Trouba</td>
										</tr>
										<tr class="tableau-top"><td>Group 3</td></tr>
										<tr>
											<td>Matt Duchene</td>
										</tr>
										<tr>
											<td>Joe Thornton</td>
										</tr>
										<tr>
											<td>Nikita Kucherov</td>
										</tr>
										<tr>
											<td>Jon Marchessault</td>
										</tr>
										<tr>
											<td>Alex Pietrangelo</td>
										</tr>
										<tr>
											<td>Jeff Petry</td>
										</tr>
										<tr class="tableau-top"><td>Goalies</td></tr>
										<tr>
											<td>Andrei Vasilevskiy</td>
										</tr>
										<tr>
											<td>Matt Murray</td>
										</tr>
										<tr>
											<td>Tuukka Rask</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class = "row  mt-2">
							<div class="col">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2"><h5 class="m-0">Event</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left"><strong>Western Conference</strong></td>
											<td class="text-left"><strong>Eastern Conference</strong></td>
										</tr>
										<tr class="tableau-top"><td colspan="3">Group 1</td></tr>
										<tr>	
											<td class="text-left">Carl Hagelin misses</td>
											<td class="text-left">David Krejci misses</td>
										</tr>
										<tr>	
											<td class="text-left">Connor McDavid misses</td>
											<td class="text-left">Joshua Bailey misses</td>
										</tr>
										<tr>	
											<td class="text-left">John Tavares misses</td>
											<td class="text-left">Nicklas Backstrom misses</td>
										</tr>
										<tr>	
											<td class="text-left">Kyle Okposo misses</td>
											<td class="text-left">Jakub Voracek scores</td>
										</tr>
										<tr>	
											<td class="text-left">Erik Karlsson misses</td>
											<td class="text-left">John Carlson misses</td>
										</tr>
										<tr>	
											<td class="text-left">Zach Bogosian misses</td>
											<td class="text-left">Adam Larsson misses</td>
										</tr>
										<tr class="tableau-top"><td colspan="3">Group 2</td></tr>
										<tr>	
											<td class="text-left">Logan Couture misses</td>
											<td class="text-left">Auston Matthews misses</td>
										</tr>
										<tr>	
											<td class="text-left">Tobias Rieder scores</td>
											<td class="text-left">Evgeni Malkin misses</td>
										</tr>
										<tr>	
											<td class="text-left">Sidney Crosby misses</td>
											<td class="text-left">Anze Kopitar misses</td>
										</tr>
										<tr>	
											<td class="text-left">Phil Kessel misses</td>
											<td class="text-left">Brayden Point misses</td>
										</tr>
										<tr>	
											<td class="text-left">Victor Hedman misses</td>
											<td class="text-left">T.J. Brodie misses</td>
										</tr>
										<tr>	
											<td class="text-left">Torey Krug misses</td>
											<td class="text-left">Jacob Trouba misses</td>
										</tr>
										<tr class="tableau-top"><td colspan="3">Group 3</td></tr>
										<tr>	
											<td class="text-left">Jamie Benn misses</td>
											<td class="text-left">Matt Duchene scores</td>
										</tr>
										<tr>	
											<td class="text-left">Steven Stamkos misses</td>
											<td class="text-left">Joe Thornton misses</td>
										</tr>
										<tr>	
											<td class="text-left">Alexander Ovechkin misses</td>
											<td class="text-left">Nikita Kucherov misses</td>
										</tr>
										<tr>	
											<td class="text-left">Vladislav Namestnikov misses</td>
											<td class="text-left">Jon Marchessault misses</td>
										</tr>
										<tr>	
											<td class="text-left">Brent Burns misses</td>
											<td class="text-left">Alex Pietrangelo misses</td>
										</tr>
										<tr>	
											<td class="text-left">P.K. Subban misses</td>
											<td class="text-left">Jeff Petry misses</td>
										</tr>
									</tbody>
								</table>
							</div>
							
						
						</div>
						

						<div class="row mt-2">
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Overview</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Braden Holtby: 6 saves</td>
										</tr>
										<tr>	
											<td class="text-left">Jonathan Quick: 5 saves</td>
										</tr>
										<tr>	
											<td class="text-left">Connor Hellebuyck: 6 savess</td>
										</tr>
										<tr>	
											<td class="text-left">Andrei Vasilevskiy: 5 saves</td>
										</tr>
										<tr>	
											<td class="text-left">Matt Murray: 6 saves</td>
										</tr>
										<tr>	
											<td class="text-left">Tuukka Rask: 5 saves</td>
										</tr>
										<tr>	
											<td class="text-left">Matt Duchene and Jakub Voracek have the most goals for the winning team (1)</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference: 2 goals</td>
										</tr>
										<tr>	
											<td class="text-left">Western Conference: 1 goal</td>
										</tr>
									    <tr>	
											<td class="text-left">Eastern Conference wins!</td>
										</tr>
									</tbody>
								</table>
								
							</div>
							<div class="col">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Result</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="tab-pane" id="GoalieGoals">
						<div class = "row">
							<div class="col mt-2">
								<h3>Goalie Goals</h3>
							</div>
						</div>
						<div class = "row">
							
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Rules</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Three goalies per squad.</td>
										</tr>
										<tr>	
											<td class="text-left">The squad with the most emptynet goals win.</td>
										</tr>
										<tr>	
											<td class="text-left">In the event of a tie, each squad will receive one goal.</td>
										</tr>
										
									</tbody>
								</table>
								
							</div>
						
						</div>

						<div class="row mt-2">
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Western Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Braden Holtby</td>
										</tr>
										<tr>
											<td>Jonathan Quick</td>
										</tr>
										<tr>
											<td>Connor Hellebuyck</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Eastern Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Andrei Vasilevskiy</td>
										</tr>
										<tr>
											<td>Matt Murray</td>
										</tr>
										<tr>
											<td>Tuukka Rask</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class = "row  mt-2">
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Event</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left"><strong>Western Conference</strong></td>
										</tr>
										<tr>	
											<td class="text-left">Braden Holtby misses</td>
										</tr>
										<tr>	
											<td class="text-left">Jonathan Quick misses</td>
										</tr>
										<tr>	
											<td class="text-left">Connor Hellebuyck scores</td>
										</tr>
										<tr>	
											<td class="text-left">Braden Holtby misses</td>
										</tr>
										<tr>	
											<td class="text-left">Jonathan Quick misses</td>
										</tr>
										<tr>	
											<td class="text-left">Connor Hellebuyck scores</td>
										</tr>
										<tr>	
											<td class="text-left"><strong>Eastern Conference</strong></td>
										</tr>
										<tr>	
											<td class="text-left">Andrei Vasilevskiy misses</td>
										</tr>
										<tr>	
											<td class="text-left">Matt Murray scores</td>
										</tr>
										<tr>	
											<td class="text-left">Tuukka Rask scores</td>
										</tr>
										<tr>	
											<td class="text-left">Andrei Vasilevskiy scores</td>
										</tr>
										<tr>	
											<td class="text-left">Matt Murray misses</td>
										</tr>
										<tr>	
											<td class="text-left">Tuukka Rask scores</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Overview</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference: 2 goals</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference: 4 goals</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference wins!</td>
										</tr>
										<tr>	
											<td class="text-left">Tuukka Rask and Connor Hellebuyck have the most goals with 2 each</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
						

						<div class="row mt-2">
		
							<div class="col-sm-12 col-md-6 offset-md-3">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Result</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					
					<div class="tab-pane" id="RapidFire">
						<div class = "row">
							<div class="col mt-2">
								<h3>Rapid Fire</h3>
							</div>
						</div>
						<div class = "row">
							
							<div class="col mt-2">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th ><h5 class="m-0">Rules</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Each goaltender will face two shooters, one at a time.</td>
										</tr>
										<tr>	
											<td class="text-left">Six players, three golatenders per team.</td>
										</tr>
										<tr>	
											<td class="text-left">Shooters will take five shots.</td>
										</tr>
										<tr>	
											<td class="text-left">One goal to squad whose goaltenders make the most saves.</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						
						</div>

						<div class="row mt-2">
							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Western Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Connor McDavid</td>
										</tr>
										<tr>
											<td>Jamie Benn</td>
										</tr>
										<tr>
											<td>John Tavares</td>
										</tr>
										<tr>
											<td>Matthew Tkachuk</td>
										</tr>
										<tr>
											<td>Torey Krug</td>
										</tr>
										<tr>
											<td>John Klingberg</td>
										</tr>
										<tr class="tableau-top"><td>Goalies</td></tr>
										<tr>
											<td>Jordan Binnington</td>
										</tr>
										<tr>
											<td>Connor Hellebuyck</td>
										</tr>
										<tr>
											<td>Semyon Varlamov</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="col-sm-6">
								<table class="table table-sm table-striped table-rounded text-center" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Eastern Conference</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Auston Matthews</td>
										</tr>
										<tr>
											<td>Artemi Panarin</td>
										</tr>
										<tr>
											<td>Mark Stone</td>
										</tr>
										<tr>
											<td>Brock Boeser</td>
										</tr>
										<tr>
											<td>Mark Giordano</td>
										</tr>
										<tr>
											<td>Erik Karlsson</td>
										</tr>
										
										<tr class="tableau-top"><td>Goalies</td></tr>
										<tr>
											<td>Frederik Andersen</td>
										</tr>
										<tr>
											<td>Sergei Bobrovsky</td>
										</tr>
										<tr>
											<td>Henrik Lundqvist</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class = "row  mt-2">
							<div class="col">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="4"><h5 class="m-0">Event</h5></th></tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left" colspan="2"><strong>Western Conference</strong></td>
											<td class="text-left" colspan="2"><strong>Eastern Conference</strong></td>
										</tr>

										<tr class="tableau-top">
											<td colspan="4">Round 1</td>
										</tr>
										<tr class="tableau-top">
											<td colspan="2"><strong>Goalie: Connor Hellebuyck</strong></td>
											<td colspan="2"><strong>Goalie: Jordan Binnington</strong></td>
										</tr>
										<tr>
											<td class="text-left">Sidney Crosby misses</td>
											<td class="text-left">1 shots 0 goals</td>
											<td class="text-left">Nikita Kucherov misses</td>
											<td class="text-left">1 shots 0 goals</td>
										</tr>
										<tr>
											<td class="text-left">Logan Couture misses</td>
											<td class="text-left">2 shots 0 goals</td>
											<td class="text-left">Auston Matthews misses</td>
											<td class="text-left">2 shots 0 goals</td>
										</tr>
										<tr>
											<td class="text-left">Logan Couture misses</td>
											<td class="text-left">3 shots 0 goals</td>
											<td class="text-left">Nikita Kucherov misses</td>
											<td class="text-left">3 shots 0 goals</td>

										</tr>
										<tr>
											<td class="text-left">Logan Couture misses</td>
											<td class="text-left">4 shots 0 goals</td>
											<td class="text-left">Auston Matthews misses</td>
											<td class="text-left">4 shots 0 goals</td>
										</tr>
										<tr>
											<td class="text-left">Sidney Crosby misses</td>
											<td class="text-left">5 shots 0 goals</td>
											<td class="text-left">Nikita Kucherov scores</td>
											<td class="text-left">5 shots 1 goals</td>
										</tr>
										<tr>
											<td class="text-left">Logan Couture misses</td>
											<td class="text-left">6 shots 0 goals</td>
												<td class="text-left">Auston Matthews misses</td>
											<td class="text-left">6 shots 1 goals</td>
										</tr>
										<tr>
											<td class="text-left">Sidney Crosby misses</td>
											<td class="text-left">7 shots 0 goals</td>
											<td class="text-left">Nikita Kucherov misses</td>
											<td class="text-left">7 shots 1 goals</td>

										</tr>
										<tr>
											<td class="text-left">Logan Couture misses</td>
											<td class="text-left">8 shots 0 goals</td>
											<td class="text-left">Auston Matthews scores</td>
											<td class="text-left">8 shots 2 goals</td>
										</tr>
										<tr>
											<td class="text-left">Sidney Crosby scores</td>
											<td class="text-left">9 shots 1 goals</td>
											<td class="text-left">Nikita Kucherov misses</td>
											<td class="text-left">9 shots 2 goals</td>

										</tr>
										<tr>
											<td class="text-left">Logan Couture misses</td>
											<td class="text-left">10 shots 1 goals</td>
											<td class="text-left">Auston Matthews scores</td>
											<td class="text-left">10 shots 3 goals</td>
										</tr>

										<tr class="tableau-top">
											<td colspan="4">Round 2</td>
										</tr>
										<tr class="tableau-top">
											<td colspan="2"><strong>Goalie: Matt Murray</strong></td>
											<td colspan="2"><strong>Goalie: Jonathan Quick</strong></td>
										</tr>
										<tr>
											<td class="text-left">Connor McDavid misses</td>
											<td class="text-left">11 shots 1 goals</td>
											<td class="text-left">Brayden Point misses</td>
											<td class="text-left">11 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">John Tavares misses</td>
											<td class="text-left">12 shots 1 goals</td>
											<td class="text-left">Nicklas Backstrom misses</td>
											<td class="text-left">12 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">Connor McDavid misses</td>
											<td class="text-left">13 shots 1 goals</td>
											<td class="text-left">Brayden Point misses</td>
											<td class="text-left">13 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">John Tavares misses</td>
											<td class="text-left">14 shots 1 goals</td>
											<td class="text-left">Nicklas Backstrom misses</td>
											<td class="text-left">14 shots 3 goals</td>
										</tr>
															<tr>
											<td class="text-left">Connor McDavid misses</td>
											<td class="text-left">15 shots 1 goals</td>
											<td class="text-left">Brayden Point misses</td>
											<td class="text-left">15 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">John Tavares misses</td>
											<td class="text-left">16 shots 1 goals</td>
											<td class="text-left">Nicklas Backstrom misses</td>
											<td class="text-left">16 shots 3 goals</td>
										</tr>
															<tr>
											<td class="text-left">Connor McDavid misses</td>
											<td class="text-left">17 shots 1 goals</td>
											<td class="text-left">Brayden Point misses</td>
											<td class="text-left">17 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">John Tavares misses</td>
											<td class="text-left">18 shots 1 goals</td>
											<td class="text-left">Nicklas Backstrom misses</td>
											<td class="text-left">18 shots 3 goals</td>
										</tr>
															<tr>
											<td class="text-left">Connor McDavid misses</td>
											<td class="text-left">19 shots 1 goals</td>
											<td class="text-left">Brayden Point misses</td>
											<td class="text-left">19 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">John Tavares misses</td>
											<td class="text-left">20 shots 1 goals</td>
											<td class="text-left">Nicklas Backstrom misses</td>
											<td class="text-left">20 shots 3 goals</td>
										</tr>

										<tr class="tableau-top">
											<td colspan="4">Round 3</td>
										</tr>
										<tr class="tableau-top">
											<td colspan="2"><strong>Goalie: Tuukka Rask</strong></td>
											<td colspan="2"><strong>Goalie: Connor Hellebuyck</strong></td>
										</tr>
										<tr>
											<td class="text-left">Kyle Okposo misses</td>
											<td class="text-left">21 shots 1 goals</td>
											<td class="text-left">Jon Marchessault misses</td>
											<td class="text-left">21 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">Vladislav Namestnikov misses</td>
											<td class="text-left">22 shots 1 goals</td>
											<td class="text-left">Joshua Bailey misses</td>
											<td class="text-left">22 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">Kyle Okposo scores</td>
											<td class="text-left">23 shots 2 goals</td>
											<td class="text-left">Jon Marchessault misses</td>
											<td class="text-left">23 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">Vladislav Namestnikov misses</td>
											<td class="text-left">24 shots 2 goals</td>
											<td class="text-left">Joshua Bailey misses</td>
											<td class="text-left">24 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">Kyle Okposo misses</td>
											<td class="text-left">25 shots 2 goals</td>
											<td class="text-left">Jon Marchessault misses</td>
											<td class="text-left">25 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">Vladislav Namestnikov misses</td>
											<td class="text-left">26 shots 2 goals</td>
											<td class="text-left">Joshua Bailey misses</td>
											<td class="text-left">26 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">Kyle Okposo misses</td>
											<td class="text-left">27 shots 2 goals</td>
											<td class="text-left">Jon Marchessault misses</td>
											<td class="text-left">27 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">Vladislav Namestnikov misses</td>
											<td class="text-left">28 shots 2 goals</td>
											<td class="text-left">Joshua Bailey misses</td>
											<td class="text-left">28 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">Kyle Okposo misses</td>
											<td class="text-left">29 shots 2 goals</td>
											<td class="text-left">Jon Marchessault misses</td>
											<td class="text-left">29 shots 3 goals</td>
										</tr>
										<tr>
											<td class="text-left">Vladislav Namestnikov misses</td>
											<td class="text-left">30 shots 2 goals</td>
											<td class="text-left">Joshua Bailey misses</td>
											<td class="text-left">30 shots 3 goals</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col">

								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th><h5 class="m-0">Overview</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Braden Holtby: 7 saves</td>
										</tr>
										<tr>	
											<td class="text-left">Jonathan Quick: 10 saves</td>
										</tr>
										<tr>	
											<td class="text-left">Connor Hellebuyck: 10 saves</td>
										</tr>
										<tr>	
											<td class="text-left">Andrei Vasilevskiy: 9 saves</td>
										</tr>
										<tr>	
											<td class="text-left">Matt Murray: 10 saves</td>
										</tr>
										<tr>	
											<td class="text-left">Tuukka Rask: 9 saves</td>
										</tr>
									    <tr>	
											<td class="text-left">Eastern Conference wins!</td>
										</tr>
									</tbody>
								</table>
								
							</div>
							<div class="col">
								<table class="table table-sm table-striped table-rounded" style ="white-space: normal;">
									<thead>
										<tr><th colspan="2" ><h5 class="m-0">Result</h5></th></tr>
									</thead>
									<tbody>
										<tr>	
											<td class="text-left">Western Conference</td>
											<td>0</td>
										</tr>
										<tr>	
											<td class="text-left">Eastern Conference</td>
											<td>1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
				</div> <!-- end tab content -->

			</div>
		</div>
	</div>
</div>


<?php include 'footer.php'; ?>