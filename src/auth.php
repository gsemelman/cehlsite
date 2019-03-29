<?php
include_once 'lang.php';
include_once 'config.php';
include_once 'common.php';

//remember me basic.. need to make this better.
if(!isAuthenticated()){
    if(!empty($_COOKIE['login']) && !empty($_COOKIE['rememberMe'])){
        
        include GMO_ROOT.'config4.php';
        include GMO_ROOT.'login/mysqli.php';
        
        $sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'SessionName' LIMIT 1";
        $query = mysqli_query($con, $sql) or die(mysqli_error($con));
        if($query){
            while($data = mysqli_fetch_array($query)) {
                $SessionName = $data['VALUE'];
            }
        }
        $sql = "SELECT `VALUE` FROM `".$db_table."_parameters` WHERE `PARAM` = 'TimeZone' LIMIT 1";
        $query = mysqli_query($con, $sql) or die(mysqli_error($con));
        if($query){
            while($data = mysqli_fetch_array($query)) {
                $TimeZone = $data['VALUE'];
            }
        }
        
        $user = strtoupper($_COOKIE['login']);
        $user = mysqli_real_escape_string($con, $user);
        $sql = "SELECT `INT`, `USER` , `PASS` , `EQUIPE` , `EQUIPESIM`, `ADMIN` FROM `$db_table` WHERE `USER` = '$user'";
        $query = mysqli_query($con, $sql) or die(mysqli_error($con));
        if($query){
            while($data = mysqli_fetch_array($query)) {
                // session_name($SessionName);
                //session_start();
                $_SESSION['login'] = $user;
                $_SESSION['equipe'] = $data['EQUIPE'];
                $_SESSION['equipesim'] = $data['EQUIPESIM'];
                $_SESSION['int'] = $data['INT'];
                if(1==$data['ADMIN']){
                    // $_SESSION['admin'] = $data['ADMIN'];
                    $_SESSION['isAdmin'] = true;
                }else{
                    $_SESSION['isAdmin'] = false;
                }
                $_SESSION['authenticated'] = true;
                
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
                unset($_COOKIE['login']);
                setcookie('login', '', time() - 3600, '/'); // empty value and old timestamp
                unset($_COOKIE['rememberMe']);
                setcookie('rememberMe', '', time() - 3600, '/'); // empty value and old timestamp
            }
        }
        mysqli_close($con);
    }else{
        
    }
}
?>