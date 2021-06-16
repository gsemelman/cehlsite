<?php
include_once __DIR__ .'/../../config.php';
include_once FS_ROOT.'common.php';
include_once FS_ROOT.'classes/SessionDao.php';

class autenticate2
{
    
    function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i ++) {
            $token .= $codeAlphabet[cryptoRandSecure(0, $max)];
        }
        return $token;
    }
    
    function cryptoRandSecure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) {
            return $min; // not so random...
        }
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }
    
    function redirect($url) {
        header("Location:" . $url);
        exit;
    }
    
    function clearAuthCookie() {
        
        if (isset($_COOKIE["login"])) {
            setcookie("login", "");
        }
        if (isset($_COOKIE["rememberMe"])) {
            setcookie("rememberMe", "");
        }
        if (isset($_COOKIE["selectorHash"])) {
            setcookie("selectorHash", "");
        }
    }
    
    function clearSessionAttributes(){
        unset($_SESSION['login']);
        unset($_SESSION['equipe']);
        unset($_SESSION['equipesim']);
        unset($_SESSION['int']);
        unset($_SESSION['isAdmin']);
        
        $_SESSION['authenticated'] = false;
    }
    
    function createAndSaveToken($teamId){
        
        $sessionDao = new SessionDao();
        
        $userToken = $sessionDao->getTokenByTeamId($teamId, 0);
        
        error_log('--------------------'.$userToken[0]["id"]);
        if($userToken && !empty($userToken[0]["id"])) {
            $sessionDao->markAsExpired($userToken[0]["id"]);
        }
        
        $random_selector = getToken(32);
        $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
        $current_time = time();
        $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  // for 1 month
        $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
        
        $sessionDao->insertToken($teamId, $random_selector_hash, $expiry_date);
        
        return $random_selector_hash;
    }
    
    function authenticate($user, $pass, $rememberMe){
        
    }
    
    function _auth(){
        if(!empty($_COOKIE['selectorHash']) && !empty($_COOKIE['rememberMe']) && !empty($_COOKIE['login'])){
            
        }
    }
}



$preAuth = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(!isset($_POST['user']) || !isset($_POST['pass'])){
       // error_log('HTTP/1.1 403 Forbidden', 0);
        //header('Location: ' . BASE_URL);
        http_response_code(404);
        exit();
    }
    
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    if(isset($_POST['rememberMe'])){
        $rememberMe = $_POST['rememberMe'];
    }
 
}else if(!empty($_COOKIE['selectorHash']) && !empty($_COOKIE['rememberMe']) && !empty($_COOKIE['login'])){
    
    //$user = $_COOKIE['login'];
    //$pass = $_COOKIE['rememberMe'];
    $SessionDao = new SessionDao();
    
    $current_time = time();
    $current_date = date("Y-m-d H:i:s", $current_time);
    $isSelectorVerified = false;
    $isExpiryDateVerified = false;
    
    $userToken = $SessionDao->getTokenByUsername($_COOKIE['login'], 0);
    
    if($userToken){

        // Validate random selector cookie with database
        if (password_verify(urldecode($_COOKIE['selectorHash']), $userToken[0]["selector_hash"])) {
            $isSelectorVerified = true;
        }
        
        // check cookie expiration by date
        if($userToken[0]["expiry_date"] >= $current_date) {
            $isExpiryDateVerified = true;
        }
        
        $isSelectorVerified = true;
        $isExpiryDateVerified = true;

        if (!empty($userToken[0]["id"]) && $isSelectorVerified && $isExpiryDateVerified) {
            //authenticate
            $preAuth = true;
            $user = $_COOKIE['login'];

            //dont return let it query the db again to resync session attributes.
        } else {
            //mark old as expired.
            if(!empty($userToken[0]["id"])) {
                $SessionDao->markAsExpired($userToken[0]["id"]);
            }
            // clear cookies
            clearSessionAttributes();
            clearAuthCookie();
            return;
        }

    }else{
        // clear cookies
        clearAuthCookie();
        clearSessionAttributes();
        return;
    }

}else{
    // clear cookies
    clearAuthCookie();
    clearSessionAttributes();
    return;
}

if(!isset($user)){
    error_log('HTTP/1.1 403 Forbidden', 0);
    http_response_code(403);
    //header('Location: ' . BASE_URL);
    exit();
}

//include GMO_ROOT. 'config4.php';
include GMO_ROOT.'login/mysqli.php';


if(!isset($_SESSION)){
    session_name(SESSION_NAME);
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
        
        if($preAuth || md5($pass) == $data['PASS']) {
            session_name(SESSION_NAME);
            session_start();

            $_SESSION['teamId'] = $data['INT'];
            $_SESSION['login'] = $user;
            $_SESSION['equipe'] = $data['EQUIPE'];
            $_SESSION['equipesim'] = $data['EQUIPESIM'];
            //$_SESSION['int'] = $data['INT'];
            if(1==$data['ADMIN']){
                // $_SESSION['admin'] = $data['ADMIN'];
                $_SESSION['isAdmin'] = true;
            }
            
            $_SESSION['authenticated'] = true;
            
            setcookie('login', $user, time() + (86400 * 30), "/");
            
            if(isset($rememberMe) && $rememberMe){
                setcookie('rememberMe', true, time() + (86400 * 30), "/");
                $teamIdNumeric = $_SESSION['teamId'] + 0;
                echo $teamIdNumeric;
                error_log("SAVING HASH----------------------------------");
                $random_selector_hash = createAndSaveToken($teamIdNumeric);
                setcookie('selectorHash', $random_selector_hash, time() + (86400 * 30), "/");
                error_log("HASH SAVED----------------------------------");
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

        error_log('Access denied', 0);
        //header('Location: ' . BASE_URL);
        http_response_code(401);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        //http_response_code(400);
        exit();
    }
}else{
    http_response_code(400);
}
mysqli_close($con);

unset($user, $pass, $rememberMe);

// if(isset($_SERVER['HTTP_REFERER'])){
//     header('Location: ' . $_SERVER['HTTP_REFERER']);
// }else{
//    // header('Location:' . BASE_URL);
// }

if($preAuth) return;

if(isset($_COOKIE['CURRENT_PAGE']) && $_COOKIE['CURRENT_PAGE'] !== '' && $_COOKIE['CURRENT_PAGE'] !== 'Login'){
    header('Location:' . '../../'.$_COOKIE['CURRENT_PAGE'].'.php');
    //error_log('Forwarding to: '.'Location:' . '../../'.$_COOKIE['CURRENT_PAGE'].'.php');
}else{
    header('Location:' . '../../MyCehl.php');
   // error_log('Location:' . '../../MyCEHL'.'.php');
}



?>