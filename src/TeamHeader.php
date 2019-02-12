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

</style>

<div class="container header-content">

<?php

$CurrentTitle .= ' - '.$currentTeam;
    
//team logo links
echo '<div class="row">';
    echo '<div id="logo-header" class="col logo-header logo-header-description">';
    
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
echo '<nav id ="header-nav" class="nav nav-justified-center justify-content-center">';
    echo'<a class="nav-item nav-link" href="TeamScoring.php'.$plfLink.'">'.$allScoring.'</a>';
    echo'<a class="nav-item nav-link" href="Finance.php'.$plfLink.'">'.$allFinances.'</a>';
    echo'<a class="nav-item nav-link" href="Rosters.php'.$plfLink.'">'.$allRosters.'</a>';
    echo'<a class="nav-item nav-link" href="Lines.php'.$plfLink.'">'.$allLines.'</a>';
    echo'<a class="nav-item nav-link" href="Futures.php'.$plfLink.'">'.$allProspects.'</a>';
    //echo'<a class="nav-item nav-link" href="Futures2.php">'.$allProspects.'</a>';
    //echo'<a class="nav-item nav-link" target="_blank" href="https://docs.google.com/spreadsheets/d/e/2PACX-1vQNC0vO9e6s4zizPX3yYpongarBRr9sVdTQj1xxbzdTExEiEQwNmFidIWemXmmVimsYJjLKQOFnXrZZ/pubhtml?widget=true&amp;headers=false">'.$allProspects.'</a>';
    //echo'<a class="nav-item nav-link" href="fiche.php'.$plfLink.'">'.$allTeamCard.'</a>';
    echo'<a class="nav-item nav-link" href="TeamOverview.php'.$plfLink.'">'.$allTeamCard.'</a>';
    echo'<a class="nav-item nav-link" href="TeamSchedule.php'.$plfLink.'">'.$schedTitle.'</a>';
echo '</nav>';


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
