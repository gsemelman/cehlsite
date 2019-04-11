<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Rules';
$CurrentPage = 'Rules';
include 'head.php';
?>

<!-- 	<div class = "container"> -->

<!-- 		<div class="row"> -->
<!-- 			<div class="col iframe-container"> -->
<!--  				<iframe src="<?php //echo $folderLegacy ?>cehlRules.html" frameborder="0" allowfullscreen></iframe>-->
<!-- 			</div> -->
<!-- 		</div> -->

<!-- 	</div> -->

<div class="container">
	<div class="row no-gutters">
		<div class="col">
			<div class="card">
					<?php include 'SectionHeader.php';?>
				<div class="card-body wow fadeIn">
					<div id="rulesTabs">
						<ul class="nav nav-tabs nav-fill">
							<li class="nav-item"><a class="nav-link active" href="#Basic"
								data-toggle="tab">Basic Rules</a></li>
							<li class="nav-item"><a class="nav-link" href="#Management"
								data-toggle="tab">Team Management</a></li>
							<li class="nav-item"><a class="nav-link" href="#Revenue"
								data-toggle="tab">Revenue</a></li>
							<li class="nav-item"><a class="nav-link" href="#FreeAgents"
								data-toggle="tab">Free Agents</a></li>
							<li class="nav-item"><a class="nav-link" href="#Contracts"
								data-toggle="tab">Contracts</a></li>
						</ul>
						
						<div class="tab-content">
							<div class="tab-pane" id="Basic">
							
								<p class="medium-paragraph">Overview</p>                                
								<p class="small-paragraph">i.)	You must be committed to this league. This means you should try to trade if you need to improve your teams status and/or give your lines at least once every 1 or 2 weeks. We also would like for you to openly participate. Send press releases through email, use the message board for open discussion, make your trade block known, or submit articles to the commissioner to be posted on the league site. Also, please feel free to tell the commissioner about your ideas to improve and develop the league.</p>  
                                
                                
                                <p class="medium-paragraph">Contact Information</p>
                                
                                
                                <p class="small-paragraph">i.)	Everyone should have MSN and e-mail the commissioner their e-mail address. GM's must e-mail the commissioner as soon as possible in order for a trade to be confirmed.
                                ii.) Each GM must send the commissioner their lines. These lines will include: 4 forward lines, 3 defense lines, a starting and backup goalie. No team may dress more than 20 players.
                                </p>
                                
                                <p class="medium-paragraph">Scheduling</p>
                                
                                <p class="small-paragraph">
                                i.)	The season runs on a 82 game schedule.
                                ii.) Playoff series are a best of 7 game format.
                                iii.) Playoff seeding will be done based on final point totals only. Division standings are not a factor.
                                iv.) Games are typically run twice a day every day during the regular season. They are typically run between 5pm and midnight EST.
                                </p>
                                
                                <p class="medium-paragraph">Player Attribute Information</p>
                                
                                <p class="small-paragraph2">
                                PO - Position - the position the player plays
                                HD - Handedness - Left or Right Handed shot
                                CD - Condition. Usually listed as OK. This means they are 100%
                                IJ - Injury Status
                                --> DD - day to day
                                --> 1W - approx. 1 week
                                --> 3W - 2-4 weeks
                                --> 1M - 4-6 weeks
                                --> 3M - 2-4 months
                                --> S# - Suspension followed by # of games
                                
                                
                                IT - Intensity
                                SP - Speed
                                ST - Strength
                                EN - Endurance
                                DU - Durability
                                DI - Discipline
                                SK - Skating
                                PA - Passing
                                PC - Stickhandling/Puck Control
                                DF - Defense
                                SC - Scoring
                                EX - Experience
                                LD – Leadership
                                </p>
                                                             
                                <p class="medium-paragraph">Player Rerates</p>
                                
                                <p class="small-paragraph">
                                i.)	CEHL Re-rates will occur twice each season: In the offseason, and again at mid-season. All re-rates will be conducted by the commissioner and his delegates. Their decisions are final and cannot be appealed. Players will be re-rated on their NHL performance only; CEHL performance will not factor into re-rates.
                                ii.) GMs will be allowed to request a maximum of 5 players at midseason rerates. If 5 positive rerates are requested then as many as 5 negative rerates may be applied if enough players are found applicable.
                                iii.) During offseason rerates any number of players per team may be rerated up or down as required.
                                </p>
							</div>
							<div class="tab-pane active" id="Management">
	
								<p class="medium-paragraph">Submitting Lines</p>

								<ul>
                                	<li>All lines will be submitted using the online GM Editor. 
                                	You are required to dress a minimum of 17 skaters and 2 goalies in your lineup for each game. (19 total)
                                	You must dress at least 3 centers, 3 left wingers, 3 right wingers,
                                	4 defencemen and 2 goalies to meet the minimum positional requirements of the FHL sim.
                                	</li>
                                </ul>
                                
                                <p class="medium-paragraph">Trades</p>
           
                                <ul class="list-group">
                                    <li class="list-group-item justify-content-between">Trades must be emailed to the commissioner by both teams. All trades submitted are final once they have been updated on the site. Please title all trade emails "TRADE Team A/Team B"</li>
                                    <li class="list-group-item">The trade deadline is at the 85% mark of the season.</li>
                                    <li class="list-group-item">You cannot trade a player who has zero years left on his contract and is an unrestricted free agent. RFAs may be traded as their rights still have a value. Any Group IV Free Agent signed during the free agency period CANNOT be traded until after the all-star break of the upcoming season.</li>
                                    <li class="list-group-item">Future considerations are not to be allowed in any trades.</li> 
                                    <li class="list-group-item">Any trade which is deemed to be unfair by GM can be appealed to the trade review panel within 48 hours of the trade being posted.</li> 
                                </ul>
                                
                                   ii.) 
                                iii.)   iv.) Future considerations are not to be allowed in any trades.
                                v.)	Any trade which is deemed to be unfair by GM can be appealed to the trade review panel within 48 hours of the trade being posted. The CEHL trade review panel consists of Ryan Williams, Shawn Lawrence and Kevin Lepointe
                                
                                
                                2C – Draft
                                
                                
                                i.)	Drafts are held once every two CEHL seasons. Draft positioning will be determined using the combined standings of both seasons. There is no lottery. There will be 7 draft rounds. You will be able to choose for the first 4 rounds, and the rest will be automatically completed. Also, the draft picks for rounds 5 through 8 can not be traded.
                                
                                
                                2D – Position Changes
                                
                                
                                i.)	If you want to change a player's listed position in the sim, you must ensure that the player is eligible to play that position. TSN.ca is used to determine eligibility.
                                ii.) Player position change requests based on the position listings at hockeydb.com or nhl.com will NO longer be accepted.
                                
                                
                                2E – Retirements
                                
                                
                                i.)	Players in the CEHL will retire when the player announces his retirement from the NHL.
                                ii.) Former NHLers playing in Europe may remain in the CEHL.
                                iii.) Should a player announce his retirement once the CEHL trading deadline has passed, the player will not retire from the CEHL until the end of the season.
                                
                                
                                2F – Waivers
                                
                                
                                i.)	Once a player has played 10 games in a regular season and is 24 or older, he can't be moved down to the farm team unless he clears waivers. Every team has the opportunity to claim a player when he is placed on waivers. Should more than one team make a claim on a waived player, the team who has the lowest winning percentage will be given priority. Intentionally stashing a player at the start of the season on your pro roster, and then demoting him to farm, and bypassing waivers is not allowed. This offence carries a minimum fine of $1,000,000. 
                                ii.) If you start the regular season with a player 24 and over on your farm roster who played more than 18 pro games the past season, that player must be entered in the waiver draft preceeding the start of the regular season.
                                
                                
                                2G – Player Creation
                                
                                
                                i.)	A prospect must be created if they have reached 100 NHL games played.
							</div>
							<div class="tab-pane" id="Revenue">
								<pre>
								</pre>
							</div>
							<div class="tab-pane" id="FreeAgents">
								<pre>
								</pre>
							</div>
							<div class="tab-pane" id="Contracts">
								BLah 5
							</div>
						</div>
					</div>
					


				</div>

			</div>
		</div>
	</div>
</div>

</body>

</html>