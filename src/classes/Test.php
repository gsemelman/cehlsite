<?php
// //line length = 31
// //pos1 = homeId
// //pos2 = home score
// //pos3 = away 1
// //pos4 = away score
// //pos7 = game number counter?
// //pos13 = ot
// $filename = 'c:/temp/cehl.scx';
// $handle = fopen ($filename, "r");
// $load_contents = '';

// while (!feof($handle)) {
//     $load_contents .= fread($handle, 8192);
// }
// fclose ($handle);
// $hex = bin2hex($load_contents);

// $teamArray = array();
// $game = 1;
// $day = 1;
// for($x=0;$x<strlen($hex);$x=$x+62) {
//     $sched1 = hexdec(substr($hex, $x, 2));
//     $sched2 = hexdec(substr($hex, $x+2, 2));
//     $sched3 = hexdec(substr($hex, $x+4, 2));
//     $sched4 = hexdec(substr($hex, $x+6, 2));
//     $sched5 = hexdec(substr($hex, $x+12, 2));
//     $sched6 = hexdec(substr($hex, $x+24, 2));
    
//     if (in_array($sched1, $teamArray) || in_array($sched3, $teamArray)) {
//         $day++;
//         $teamArray = array();
//     }else{
//         array_push($teamArray, $sched1);
//         array_push($teamArray, $sched3);
//     }
    
//     if($game > 233 && $game < 237) {
//         error_log('GAME '.$game.' HOME:'.$sched1.' SCORE '.$sched2.' AWAY:'.$sched3.' SCORE '.$sched4.' COUNTER '.$sched5.' OT '.$sched6.' DAY '.$day);
        
//         for($i=0;$i<=62;$i=$i+2) {
           
//             //error_log(hexdec(substr($hex, , 2)));
//             error_log(hexdec(substr($hex, $x+$i, 2)));
//         } 
//     }
//     //error_log('GAME '.$game.' HOME:'.$sched1.' SCORE '.$sched2.' AWAY:'.$sched3.' SCORE '.$sched4.' COUNTER '.$sched5.' OT '.$sched6.' DAY '.$day);
  
//     $game++;
//    // return;
    
//     if($game> 300) return;
// }
// $game = 1;
// for($x=0;$x<strlen($hex);$x=$x+2) {
//     if($x < 14260) continue;
//     error_log('GAME '.$game.' '.hexdec(substr($hex, $x, 2)));
    
//     $game++;
//     if($x > 1000) return;
// }


//pos4 = away score
//pos7 = game number counter?
//pos13 = ot
include 'ScheduleHolder2.php';
include_once '..\common.php';

$holder = new ScheduleHolder2('c:/temp/cehl.scx');

echo $holder->getLastDayPlayed();
echo $holder->isSeasonStarted();

echo '<pre>';
echo jsonPrettify(json_encode($holder));
echo '</pre>';



echo 'DONE';
?>