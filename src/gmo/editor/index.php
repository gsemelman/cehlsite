<?php
// error_reporting(E_ALL);
// ini_set("display_errors", "On");

//if($modeGMO == 1) include GMO_ROOT.'editor/teamRoster.php';
//if($modeGMO == 2) include GMO_ROOT.'editor/teamLines.php';

// include_once FS_ROOT.'classes/ScheduleHolder.php';
// include_once FS_ROOT.'/classes/ScheduleObj.php';

// $scheduleFile = getLeagueFile($folder, $playoff, 'Schedule.html', 'Schedule');
// $scheduleHolder = new ScheduleHolder($scheduleFile, '');

// if($scheduleHolder->isSeasonStarted()){
//     $nextDay = $scheduleHolder->getLastDayPlayed() + 1;
//     $nextDay2 = $scheduleHolder->getLastDayPlayed() + 2;
// }else {
//     $nextDay = 1;
//     $nextDay2 = 2;
// }

// $enableNext = TRUE;

// foreach($scheduleHolder->getScheduleByDay($nextDay2) as $schedule){
//     if($schedule->getTeam1() == $teamID || $schedule->getTeam1() == $teamID) $enableNext = true;
// }

// $game1Active = '';
// $game2Active = '';

// if($linesGame == 1){
//     $game1Active = 'active';
// }

// if($linesGame == 2){
//     $game2Active = 'active';
// }

// if($modeGMO == 1){
//     $game1url = 'MyCehl.php?lines=1&game=1#Lines';
//     $game2url = 'MyCehl.php?lines=1&game=2#Lines';
// }
// if($modeGMO == 2){
//     $game1url = 'MyCehl.php?lines=2&game=1#Lines';
//     $game2url = 'MyCehl.php?lines=2&game=2#Lines';
// }

include_once FS_ROOT.'classes/ScheduleHolder2.php';
error_log($file_folder.'cehl.scx');
$scheduleHolder2 = new ScheduleHolder2($file_folder.'cehl.scx');
$playsGameOne = $scheduleHolder2->playsInDays($_SESSION['teamId'] -1 , 1);
$playsGameTwo = $scheduleHolder2->playsInDays($_SESSION['teamId'] -1 , 2);


$lastDayPlayed = $scheduleHolder2->getLastDayPlayed();

$nextDay = $lastDayPlayed + 1;
$nextDay2 = $lastDayPlayed + 2;

$game1Active = '';
$game2Active = '';

$enableNext=false;

if($playsGameOne){
 
}

if($playsGameOne && $playsGameTwo){
    $enableNext=true;
}

if($linesGame == 1){
    $game1Active = 'active';
}

if($linesGame == 2){
    $game2Active = 'active';
}

if($modeGMO == 1){
    $game1url = 'MyCehl.php?lines=1&game=1#Lines';
    $game2url = 'MyCehl.php?lines=1&game=2#Lines';
}
if($modeGMO == 2){
    $game1url = 'MyCehl.php?lines=2&game=1#Lines';
    $game2url = 'MyCehl.php?lines=2&game=2#Lines';
}

?>

<div class="container p-0">
<div class="card">
<div class="card-header p-1">
    <ul class="nav nav-pills justify-content-center">
      <li class="nav-item">
        <a class="nav-link <?php echo $game1Active?>" href="<?php echo BASE_URL.$game1url?>">Day <?php echo $nextDay;?></a>
      </li>
      
      <?php if($enableNext) {?>
      <li class="nav-item">
        <a class="nav-link <?php echo $game2Active?>" href="<?php echo BASE_URL.$game2url?>">Day <?php echo $nextDay2;?></a>
      </li>
      <?php }?>
<!--        <li class="nav-item"> -->
<!--       		<button type="button" id="btnAddGame" class="btn btn-outline-primary btn-sm" >ADD</button> -->
<!--       </li> -->
    </ul>
</div>
<div class="card-body p-0">

<?php 
if($modeGMO == 1) include GMO_ROOT.'editor/teamRoster.php';
if($modeGMO == 2) include GMO_ROOT.'editor/teamLines.php';
?>

</div><!-- end card-body -->
</div><!-- end card -->
</div><!-- end container -->

<script type="text/javascript">
<!--

<?php if($modeGMO == 1) { ?>
document.addEventListener("DOMContentLoaded", trDivCreateLists(), false);
<?php } ?>

<?php if($modeGMO == 2) { ?>
document.addEventListener("DOMContentLoaded", tlDivCreateLists(), false);
<?php } ?>

//-->
</script>