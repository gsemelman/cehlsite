<style>

.highlight-team {
	-webkit-filter: sepia(1);
	filter: sepia(1);
border-bottom:1px solid blue;
}

.active {
    font-weight: 1000;
	font-size: large;
}

.team-header-content { 
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#cedce7+9,596a72+100 */
    background: rgb(206,220,231); /* Old browsers */
    background: -moz-linear-gradient(top, rgba(206,220,231,1) 9%, rgba(89,106,114,1) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, rgba(206,220,231,1) 9%,rgba(89,106,114,1) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, rgba(206,220,231,1) 9%,rgba(89,106,114,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cedce7', endColorstr='#596a72',GradientType=0 ); /* IE6-9 */

    border-radius: 5px;   
    margin-bottom:10px;
}

.team-nav {
   a { color: rgba(225, 239, 255, 1.0); ; border-bottom: 1px ; text-decoration: none; transition: all .3; }
   a:hover, a:focus { 
    color: #856dc0; border: 0; text-decoration: none;   -webkit-filter: grayscale(100%);
    -moz-filter: grayscale(100%);
    filter: grayscale(100%);
   }
}

.team-nav a { color: rgba(225, 239, 255, 1.0); border-bottom: 1px ; text-decoration: none; transition: all .3; }

.panel-profile-img { 
	max-width: 75px; 
	margin-top: -10px; 
	margin-bottom: -10px; 
	margin-left: -20px; 
/*  	border: 1px solid #fff;   */
/* 	background-color: #708090;  */
/* 	border-radius: 100%;   */
}

</style>

<div class="container team-header-content">

<?php

//$CurrentTitle .= ' - '.$currentTeam;
    
//team logo links
echo '<div class="row">';
    echo '<div id="logo-header" class="col ">';
    
    sort($gmequipe); //sort
    for($i=0;$i<count($gmequipe);$i++) {
        $matches = glob($folderTeamLogos.strtolower($gmequipe[$i]).'.*');
        $teamImage = '';
        for($j=0;$j<count($matches);$j++) {
            $teamImage = $matches[$j];
            break 1;
        }
        //echo '<a id="'.$gmequipe[$i].'" href="'.$CurrentPage.'.php?'.$dropLinkPlf.$dropLinkFarm.$dropLinkOne.'team='.$gmequipe[$i].'">';
        echo '<a id="'.$gmequipe[$i].'" href="'.$CurrentPage.'.php?'.$plfLink.$dropLinkFarm.$dropLinkOne.'team='.$gmequipe[$i].'">';
        
        echo '<img src="'.$teamImage.'" width=55>';
        
        echo '</a>';
    }
    echo '</div>';
echo '</div>';



//team nav
echo '<div class="row justify-content-center team-nav">'; 
echo '<nav id ="header-nav" class="nav justify-content-center ">';
    echo'<a class="nav-item nav-link" href="TeamScoring.php'.$plfLink.'">'.$allScoring.'</a>';
    echo'<a class="nav-item nav-link" href="TeamFinance.php'.$plfLink.'">'.$allFinances.'</a>';
    echo'<a class="nav-item nav-link" href="TeamRosters.php'.$plfLink.'">'.$allRosters.'</a>';
    echo'<a class="nav-item nav-link" href="TeamLines.php'.$plfLink.'">'.$allLines.'</a>';
    echo'<a class="nav-item nav-link" href="TeamFutures.php'.$plfLink.'">'.$allProspects.'</a>';
    //echo'<a class="nav-item nav-link" href="Futures2.php">'.$allProspects.'</a>';
    //echo'<a class="nav-item nav-link" target="_blank" href="https://docs.google.com/spreadsheets/d/e/2PACX-1vQNC0vO9e6s4zizPX3yYpongarBRr9sVdTQj1xxbzdTExEiEQwNmFidIWemXmmVimsYJjLKQOFnXrZZ/pubhtml?widget=true&amp;headers=false">'.$allProspects.'</a>';
    //echo'<a class="nav-item nav-link" href="fiche.php'.$plfLink.'">'.$allTeamCard.'</a>';
    echo'<a class="nav-item nav-link" href="TeamOverview.php'.$plfLink.'">'.$allTeamCard.'</a>';
    echo'<a class="nav-item nav-link" href="TeamSchedule.php'.$plfLink.'">'.$schedTitle.'</a>';
echo '</nav>';
echo '</div>';

?>


<script>

function getPageName() {

    var index = window.location.href.lastIndexOf("/") + 1,
        filenameWithExtension = window.location.href.substr(index),
        filename = filenameWithExtension.split('?')[0]; 

	return filename;
}

$(document).ready(function() {

	$('a', $('#header-nav')).each(function () {

		var href = $(this).attr('href');
		if(typeof href !== "undefined"){
			if(href.startsWith(getPageName())){
				$(this).addClass('active');
			}
		}

	});

});

</script>

</div>
