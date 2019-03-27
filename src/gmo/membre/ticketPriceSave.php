<?php
error_reporting(E_ALL);
ini_set("display_errors", "Off");

include '../../config.php';
include FS_ROOT.'gmo/config4.php';


include FS_ROOT.'gmo/login/mysqli.php';
$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $SessionName = $data['VALUE'];
    }
}
mysqli_close($con);

session_name($SessionName);
session_start();

if(!isset($_SESSION['int'])){
    error_log('Caught exception: Unknown team', 0);
    header( 'HTTP/1.1 500 Server error' );
    die('Caught exception: Unknown team');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (isset($_POST['newTicketPrice'])){
        $newTicketPrice = $_POST['newTicketPrice'];

        if($newTicketPrice < 25 || $newTicketPrice > 999){
            error_log('Ticket price out of range', 0);
            
             header( 'HTTP/1.1 400' );
        }
        
        
        include FS_ROOT.'gmo/login/mysqli.php';
        $newTicketPrice = mysqli_real_escape_string($con, $newTicketPrice);
      
        $teamID = $_SESSION['int'];
        
        $sql = "UPDATE `$db_table` SET `TICKETS_REQ`='$newTicketPrice' WHERE `INT`='$teamID'";
        //$query = mysqli_query($con, $sql) or die(mysqli_error($con));
        $query = mysqli_query($con, $sql);
        
//         if (!$query)
//         {
//             error_log('Caught exception: '.mysqli_error($con), 0);
            
//             header( 'HTTP/1.1 500 Server error' );
            
//             $arr = array(
//                 'error'=>$error
//             );
//             echo json_encode($arr);
            
//             mysqli_close($con);
//             exit();
            
//             // die(mysqli_error($con));
//         }
        
//         error_log("NEW TICKET PRICE OMG OMG OMG OMG", 0);
        
        mysqli_close($con);

    }
}else{
    error_log('POST REQUIRED', 0);
    header( 'HTTP/1.1 500 Server error.' );
    die('Caught exception: Requires POST');
}

// if(isset($error)){
//     $arr = array(
//         'error'=>$error
//     );
//     echo json_encode($arr);
    
// }



?>