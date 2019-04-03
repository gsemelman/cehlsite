<?php
error_reporting(E_ALL);
ini_set("display_errors", "Off");

require_once __DIR__ .'/../../config.php';
include FS_ROOT.'common.php';
//include GMO_ROOT.'config4.php';

session_name(SESSION_NAME);
session_start();

//must be logged in with admin privaleges
if(!isAuthenticated()){
    http_response_code(401);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (isset($_POST['newTicketPrice'])){
        $newTicketPrice = $_POST['newTicketPrice'];

        if($newTicketPrice < 25 || $newTicketPrice > 200){
            error_log('Ticket price out of range', 0);
            
            header( 'HTTP/1.1 400' );
            exit();
        }
        
        
        include GMO_ROOT.'login/mysqli.php';
        $newTicketPrice = mysqli_real_escape_string($con, $newTicketPrice);
      
        $teamID = $_SESSION['teamId'];
        
        $sql = "UPDATE `$db_table` SET `TICKETS_REQ`= 
             CASE
             WHEN '$newTicketPrice' = TICKETS THEN NULL
             ELSE '$newTicketPrice' 
             END
        WHERE `INT`='$teamID'";
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
