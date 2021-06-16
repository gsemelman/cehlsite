<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

$playsNextSim = $playsGameOne || $playsGameTwo;

$game1Active = '';
$game2Active = '';


// if($linesGame == 1){
//     $game1Active = 'active';
// }

// if($linesGame == 2){
//     $game2Active = 'active';
// }

// if(!$playsGameOne){
//     $game1Active = 'disabled';
// }

// if(!$playsGameTwo){
//     $game2Active = 'disabled';
// }

// if(!$playsGameOne && $playsGameTwo){
//     $game1Active = 'disabled';
//     $game2Active = 'active';
// }else if(!$playsGameOne){
//     $game1Active = 'disabled';
// }else if(!$playsGameTwo){
//     $game2Active = 'disabled';
// }else{
//     //default game 1 active
//     $game1Active = 'active';
    
// }

if($playsNextSim){
    //check arguments for state first.
    if($linesGame == 1 && $playsGameOne){
        $game1Active = 'active';
    }else if($linesGame == 2 && $playsGameTwo){
        $game2Active = 'active';
    }else if ($playsGameTwo && !$playsGameOne){
        $game2Active = 'active';
    }else{
        $game1Active = 'active';
    } 
}

if(!$playsGameOne){
    $game1Active = 'disabled';
}
if(!$playsGameTwo){
    $game2Active = 'disabled';
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
<div class="card border-0">
<div class="card-header p-1">


    <ul class="nav nav-tabs justify-content-center" id="lineEditorTabs">
      <?php if($playsNextSim) {?>
    
          <li class="nav-item">
            <a class="nav-link <?php echo $game1Active?>" href="<?php echo BASE_URL.$game1url?>"><?php echo $game1Display;?></a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link <?php echo $game2Active?>" href="<?php echo BASE_URL.$game2url?>"><?php echo $game2Display;?></a>
          </li>
          
      <?php }else{?>
          <li class="nav-item">
          <a class="nav-link disabled" href="">No Game Scheduled</a>
          </li>
      <?php }?>

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
