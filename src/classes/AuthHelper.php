<?php
include_once FS_ROOT.'classes/SessionDao.php';

class AuthHelper
{

    public static function redirect($url) {
        header("Location:" . $url);
        exit;
    }
    
    public static function redirectPage(){
        //when forwarded from other secure page.
        if(isset($_COOKIE['currentPage']) && $_COOKIE['currentPage'] && $_COOKIE['currentPage'] !== 'Login'){
            AuthHelper::redirect($_COOKIE['currentPage'].'.php');
        }else{
            AuthHelper::redirect('MyCehl.php');
        }
    }
    
    public static function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i ++) {
            $token .= $codeAlphabet[AuthHelper::cryptoRandSecure(0, $max)];
        }
        return $token;
    }
    
    public static function cryptoRandSecure($min, $max)
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
    
    public static function clearAuthCookie() {
        
        if (isset($_COOKIE["login"])) {
            unset($_COOKIE['login']);
            setcookie("login", "", time() - 36000, "/");
  
        }

        if (isset($_COOKIE["loginToken"])) {
            unset($_COOKIE['loginToken']);
            setcookie("loginToken", "", time() - 36000, "/");
        }
    }
    
    public static function clearSessionAttributes(){
        unset($_SESSION['login']);
        unset($_SESSION['equipe']);
        unset($_SESSION['equipesim']);
        unset($_SESSION['int']);
        unset($_SESSION['isAdmin']);
        
        $_SESSION['authenticated'] = false;
    }
    
    public static  function resetSession(){
        if(isset($_SESSION)){
            AuthHelper::clearAuthCookie();
            AuthHelper::clearSessionAttributes();
        }
        
    }
    
    public static function createAndSaveToken($teamId, SessionDao $sessionDao){
        
        $userToken = $sessionDao->getTokenByTeamId($teamId, 0);
        
        if($userToken && !empty($userToken[0]["id"])) {
            $sessionDao->markAsExpired($userToken[0]["id"]);
        }
        
        $random_selector = AuthHelper::getToken(32);
        $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
        $current_time = time();
        $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  // for 1 month
        $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
        
        $sessionDao->insertToken($teamId, $random_selector_hash, $expiry_date);
        
        return $random_selector_hash;
    }
    
}

