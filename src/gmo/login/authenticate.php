<?php
include_once __DIR__ .'/../../config.php';
include_once FS_ROOT.'common.php';

// if(isAuthenticated()){
//     //already authenticated.. send back to referer
//     //header('Location: ' . $_SERVER['HTTP_REFERER']);
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(!isset($_POST['user']) || !isset($_POST['pass'])){
       // error_log('HTTP/1.1 403 Forbidden', 0);
        //header('Location: ' . BASE_URL);
        http_response_code(404);
        exit();
    }
    
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $rememberMe = $_POST['rememberMe'];
    
    
}else if(!empty($_COOKIE['rememberMe']) && !empty($_COOKIE['login'])){
    
    $user = $_COOKIE['login'];
    $pass = $_COOKIE['rememberMe'];
    
}

if(!isset($user)){
    error_log('HTTP/1.1 403 Forbidden', 0);
    http_response_code(403);
    //header('Location: ' . BASE_URL);
    exit();
}

include GMO_ROOT. 'config4.php';
include GMO_ROOT.'login/mysqli.php';

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $SessionName = $data['VALUE'];
    }
}
if(!isset($_SESSION)){
    session_name($SessionName);
    session_start();
}

// remove all session variables
session_unset();
// destroy the session
session_destroy();

$sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if($query){
    while($data = mysqli_fetch_array($query)) {
        $TimeZone = $data['VALUE'];
    }
}

//$user = strtoupper($_COOKIE['login']);
$user = mysqli_real_escape_string($con, $user);
$sql = "SELECT `INT`, `USER` , `PASS` , `EQUIPE` , `EQUIPESIM`, `ADMIN` FROM `$db_table` WHERE `USER` = '$user'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));

if($query){
    
    while($data = mysqli_fetch_array($query)) {
        
        if(!empty($_COOKIE['rememberMe']) || md5($pass) == $data['PASS']) {
            session_name($SessionName);
            session_start();

            $_SESSION['teamId'] = $data['INT'];
            $_SESSION['login'] = $user;
            $_SESSION['equipe'] = $data['EQUIPE'];
            $_SESSION['equipesim'] = $data['EQUIPESIM'];
            //$_SESSION['int'] = $data['INT'];
            if(1==$data['ADMIN']){
                // $_SESSION['admin'] = $data['ADMIN'];
                $_SESSION['isAdmin'] = true;
            }else{
                $_SESSION['isAdmin'] = false;
            }
            $_SESSION['authenticated'] = true;
            
            setcookie('login', $user, time() + (86400 * 30), "/");
            
            if(isset($rememberMe) && $rememberMe){
                setcookie('rememberMe', true, time() + (86400 * 30), "/");
            }
         
        }
    }
    
    
    
    if(isset($_SESSION['login'])){
        date_default_timezone_set($TimeZone);
        // For more information about timezone available : http://php.net/manual/en/timezones.php, copy paste your timezone in the box bellow!
        $date_time = date("Y-m-d H:i:s");
        $serv = $_SERVER["REMOTE_ADDR"];
        $user = mysqli_real_escape_string($con, $user);
        $sql = "UPDATE `$db_table` SET `LAST`='$date_time',`IP`='$serv' WHERE `USER`='$user'";
        $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    }else{
                
//         unset($_COOKIE['login']);
//         setcookie('login', '', time() - 3600, '/'); // empty value and old timestamp
//         unset($_COOKIE['rememberMe']);
//         setcookie('rememberMe', '', time() - 3600, '/'); // empty value and old timestamp

        error_log('HTTP/1.1 403 Forbidden', 0);
        //header('Location: ' . BASE_URL);
        //header('Location: ' . $_SERVER['HTTP_REFERER']);
        http_response_code(400);
        exit();
    }
}else{
    http_response_code(400);
}
mysqli_close($con);

unset($user, $pass, $rememberMe);

if(isset($_SERVER['HTTP_REFERER'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}else{
   // header('Location:' . BASE_URL);
}



?>