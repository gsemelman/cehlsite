<?php
include_once 'lang.php';
include_once 'config.php';
include_once 'common.php';
include GMO_ROOT.'config4.php';

// if($page_secured && !isAuthenticated() && $CurrentPage != 'MyTeam'){
//     header('Location: ' . BASE_URL . 'MyCehl.php');
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    authenticate();
}else{
    //remember me basic.. need to make this better.
    if(!isAuthenticated() && !empty($_COOKIE['login']) && !empty($_COOKIE['rememberMe'])){
        authenticate();
    }
}

function authenticate(){
    include GMO_ROOT.'login/mysqli.php';
    
    $sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
    $query = mysqli_query($con, $sql) or die(mysqli_error($con));
    if($query){
        while($data = mysqli_fetch_array($query)) {
            $SessionName = $data['VALUE'];
        }
    }
    
    session_name($SessionName);
    session_start();
    // remove all session variables
    session_unset();
    
    // destroy the session
    session_destroy(); 
    
    $rememberMe = false;
    
    if(isset($_COOKIE['login']) &&  isset($_COOKIE['rememberMe']) && $_COOKIE['rememberMe']){
        $user = $_COOKIE['login'];
        $rememberMe = true;
    }else{
        
        if(isset($_POST['user'])){
            $user = $_POST['user'];
        }
        
        if(isset($_POST['pass'])){
            $pass = $_POST['pass'];
        }
        
        if(!isset($_POST['user']) || !isset($_POST['pass'])){
            error_log('HTTP/1.1 403 Forbidden', 0);
            header( 'HTTP/1.1 403 Forbidden' );
            die('HTTP/1.1 403 Forbidden');
        }    
    }
    

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

            if($rememberMe || md5($pass) == $data['PASS']) {
                // session_name($SessionName);
                //session_start();
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
            } 
        }
        
        if(isset($_SESSION['login'])){
            date_default_timezone_set($TimeZone);
            // For more information about timezone available : http://php.net/manual/en/timezones.php, copy paste your timezone in the box bellow!
            $date_time = date("Y-m-d H:i:s");
            $serv = $_SERVER["REMOTE_ADDR"];
            //$user = mysqli_real_escape_string($con, $user);
            $sql = "UPDATE `$db_table` SET `LAST`='$date_time',`IP`='$serv' WHERE `USER`='$user'";
            $query = mysqli_query($con, $sql) or die(mysqli_error($con));
        }else{
            unset($_COOKIE['login']);
            setcookie('login', '', time() - 3600, '/'); // empty value and old timestamp
            unset($_COOKIE['rememberMe']);
            setcookie('rememberMe', '', time() - 3600, '/'); // empty value and old timestamp
        }
    }
    mysqli_close($con);
}
?>