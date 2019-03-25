
<?php
$currentTeam = '';
//session_start();
if(isset($_SESSION["team"])) $currentTeam = $_SESSION["team"];
ob_start();
if(isset($_COOKIE['team'])) $currentTeam = $_COOKIE['team'];
ob_end_flush();

include_once 'config.php';
include_once 'lang.php';
include_once 'common.php';
include_once 'classes/ScheduleHolder.php';
include_once 'classes/ScheduleObj.php';


$playoffLink = '';
if(isPlayoffs($folder, $playoffMode)){
    $playoffLink = 'PLF';
}

if(!function_exists('search')) {
    function search($Fnm,$currentTeam) {
        $b = 0;
        $d = 0;
        $tableau = file($Fnm);
        while(list($cle,$val) = myEach($tableau)) {
            $val = utf8_encode($val);
            if(substr_count($val, 'A NAME='.$currentTeam)) {
                $b = 1;
            }
            if($b == 1 && $d == 1) {
                $reste = trim($val);
                $reste = trim(substr($reste, strpos($reste, ' ')));
                $reste = trim(substr($reste, strpos($reste, ' ')));
                if(substr($reste, 0, 1) == '*') {
                    $reste = trim(substr($reste, 1));
                }
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
                return $TSabbr = trim(substr($reste, strrpos($reste, ' ')));
            }
            if($b == 1 && substr_count($val, 'PCTG')) {
                $d = 1;
            }
        }
    }
}

?>

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<!--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/> -->

<!--   <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<!--     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
  

<style>


#scoringBanner .logo {
    float: left;
    vertical-align: middle;
/*     width: 40px; */
/*     height: 40px; */
    max-width: 25px;
    overflow:hidden;
/*     margin: 0 auto; */
    margin-left:-2px;
    display: block;
}

#scoringBanner .table th{
    vertical-align: middle;
    background-color: #dcdee0;
    border: 0;
    height: 20px;
    line-height: 10px;
    
}

#scoringBanner .table td{
   border: 1px solid #dcdee0;
   font-size: 15px;
   font-family: Arial,Helvetica,sans-serif;
   vertical-align: middle;
   background-color: #fff;
/*    line-height: 45px; */
   
}

#scoringBanner .dark-text{
   color: #323232;
}

#scoringBanner .team-acronym {
    color: #323232;
    font-size: 15px;
    font-weight: bold;
    padding-left: 10px;
    vertical-align: middle;
}

.slick-prev,
.slick-next{
background-color: inherit;
}

.slick-slide{ 
    width: 95px; 
}

.dayPlayed{ 
    height: 90px;
/*      line-height: 90px;  */
    width:50px; 
    color:black;
    background-color: #dcdee0; 
    margin-right:5px; 

 
 
}

.dayPlayed span {
 
 display: inline-block;
 width:100%;
 vertical-align: middle;
}


@media (max-width: 767px) {
    /*workaround because lineheight of table changes at this breakpoint*/
    .dayPlayed{	height: 100px;}
}

}

</style>

<div id ="scoringBanner" class="scoring-banner pt-3">
	<div class="button-container"></div>
    <div class="score-scroll" >
    

<?php
$playoff = isPlayoffs($folder, $playoffMode);
if($playoff == 1) $playoff = 'PLF';

$fileName = getLeagueFile($folder, $playoff, 'Schedule.html', 'Schedule');
$scheduleHolder = new ScheduleHolder($fileName, '');

if($scheduleHolder->isSeasonStarted()){

    if($scheduleHolder->getLastDayPlayed() > 1){

        echo '<div class="dayPlayed text-center">';
            echo '<div style ="padding-top:50%">';
                echo '<span><strong>Day</strong></span>';
                echo '<span><strong>'.($scheduleHolder->getLastDayPlayed() -1 ).'</strong></span>';
            echo '</div>';
        echo '</div>';
        
        foreach ($scheduleHolder->getScheduleByDay($scheduleHolder->getLastDayPlayed()-1) as $games) {
            $matches = glob($folderTeamLogos.strtolower($games->team1).'.*');
            $todayImage1 = '';
            for($j=0;$j<count($matches);$j++) {
                $todayImage1 = $matches[$j];
                break 1;
            }
            $matches = glob($folderTeamLogos.strtolower($games->team2).'.*');
            $todayImage2 = '';
            for($j=0;$j<count($matches);$j++) {
                $todayImage2 = $matches[$j];
                break 1;
            }
            
            $FnmAbbr = getLeagueFile($folder, $playoff, 'TeamScoring.html', 'TeamScoring');
            
            if(file_exists($FnmAbbr)) {
                $team1Abbr = search($FnmAbbr,$games->team1);
                $team2Abbr = search($FnmAbbr,$games->team2);
            }
            else echo $allFileNotFound.' - '.$FnmAbbr;
            
            echo '<div>';
            echo '<a href="games.php?num='.$games->getGameNumber().$playoffLink.'">';
            echo '<table class = "table table-sm mb-0" style="width:90px" >';
            echo '<tbody>';
            echo '<tr class="d-flex" style = "text-transform: uppercase;">'; //header
            echo '<th class="col-9 p-1">Final</th>';
            echo '<th class="col-3 p-1"></th>';
            echo '</tr>';
            
            echo '<tr class="d-flex">'; //header
            echo '<td class="col-9 p-1">
                <div><img class="logo" src="'.$todayImage1.'" alt="'.$games->team1.'"</img></div>
                <div class = "team-acronym">'.$team1Abbr.'</div>
             </td>';
            
            echo '<td class = "col-3 p-1 dark-text text-center"><strong>'.$games->team1Score.'</strong></td>';
            echo '</tr>';
            
            echo '<tr class="d-flex">'; //header
            echo '<td class="col-9 p-1">
                <div><img class="logo" src="'.$todayImage2.'" alt="'.$games->team2.'"</img></div>
                <div class = "team-acronym">'.$team2Abbr.'</div>
             </td>';
            echo '<td class = "col-3 p-1 dark-text text-center"><strong>'.$games->team2Score.'</strong></td>';
            echo '</tr>';
            
            echo '</tbody>';
            echo '</table>'; //end score-main table
            echo '</a>';
            echo '</div>';
   
        }
    }
    
    echo '<div class="dayPlayed text-center">';
        echo '<div style ="padding-top:50%">';
            echo '<span><strong>Day</strong></span>';
            echo '<span><strong>'.($scheduleHolder->getLastDayPlayed() ).'</strong></span>';
        echo '</div>';
    echo '</div>';
    
    foreach ($scheduleHolder->getLastScheduleDay() as $games) {
        $matches = glob($folderTeamLogos.strtolower($games->team1).'.*');
        $todayImage1 = '';
        for($j=0;$j<count($matches);$j++) {
            $todayImage1 = $matches[$j];
            break 1;
        }
        $matches = glob($folderTeamLogos.strtolower($games->team2).'.*');
        $todayImage2 = '';
        for($j=0;$j<count($matches);$j++) {
            $todayImage2 = $matches[$j];
            break 1;
        }
        
        $FnmAbbr = getLeagueFile($folder, $playoff, 'TeamScoring.html', 'TeamScoring');
        
        if(file_exists($FnmAbbr)) {
            $team1Abbr = search($FnmAbbr,$games->team1);
            $team2Abbr = search($FnmAbbr,$games->team2);
        }
        else echo $allFileNotFound.' - '.$FnmAbbr;
        
       
        echo '<div>';
        echo '<a href="games.php?num='.$games->getGameNumber().$playoffLink.'">';
        echo '<table class = "table table-sm " style="width:90px" >';
        echo '<tbody>';
        echo '<tr class="d-flex" style = "text-transform: uppercase;">'; //header
        echo '<th class="col-9 p-1">Final</th>';
        echo '<th class="col-3 p-1"></th>';
        echo '</tr>';
        
        echo '<tr class="d-flex">'; //header
        echo '<td class="col-9 p-1">
                <div><img class="logo" src="'.$todayImage1.'" alt="'.$games->team1.'"</img></div>
                <div class = "team-acronym">'.$team1Abbr.'</div>
             </td>';
        
        echo '<td class = "col-3 p-1 dark-text text-center"><strong>'.$games->team1Score.'</strong></td>';
        echo '</tr>';
        
        echo '<tr class="d-flex">'; //header
        echo '<td class="col-9 p-1">
                <div><img class="logo" src="'.$todayImage2.'" alt="'.$games->team2.'"</img></div>
                <div class = "team-acronym">'.$team2Abbr.'</div>
             </td>';
        echo '<td class = "col-3 p-1 dark-text text-center"><strong>'.$games->team2Score.'</strong></td>';
        echo '</tr>';
        
        echo '</tbody>';
        echo '</table>'; //end score-main table
        echo '</a>';
        echo '</div>';
       
    }
}
?>
    
    
  	
    </div>

</div>

<script>

$('.score-scroll').slick({
	  dots: true,
	  infinite: false,
	  speed: 300,
	  variableWidth: true,
	  slidesToShow: 9,
	  slidesToScroll: 9,
	  mobileFirst: true,
	  responsive: [
	  	{
	      breakpoint: 1024,
	      settings: {
	        slidesToShow: 12,
	        slidesToScroll:12,
	        infinite: false,
	        dots: true
	      }
	    },
	    {
	      breakpoint: 900,
	      settings: {
	        slidesToShow: 5,
	        slidesToScroll: 5,
	        infinite: false,
	        dots: true
	      }
	    },
	    {
	      breakpoint: 700,
	      settings: {
	        slidesToShow: 4,
	        slidesToScroll: 4,
	        touchThreshold:10
	      }
	    },
	    {
	      breakpoint: 550,
	      settings: {
	        slidesToShow: 4,
	        slidesToScroll: 4,
	        touchThreshold:10
	      }
	    },
	    {
	      breakpoint: 440,
	      settings: {
	        slidesToShow: 4,
	        slidesToScroll: 4,
	        touchThreshold:10
	      }
	    },
	    {
	      breakpoint: 350,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 3,
	        touchThreshold:10
	      }
	    }
	  ]
	});


</script>








