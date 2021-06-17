  
  <?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once 'config.php';
include 'lang.php';
include_once 'common.php';
include_once FS_ROOT.'classes/AuthHelper.php';
include_once FS_ROOT.'classes/SessionDao.php';


$CurrentHTML = 'Login.php';
$CurrentTitle = 'Login';
$CurrentPage = '';
$SecurePage = false;

$sessionDao = new SessionDao();

if(!isset($_SESSION)){
    session_name(SESSION_NAME);
    session_start();
}

if (isAuthenticated()) {
    //redirect('MyCehl.php');
    AuthHelper::redirectPage();
}

$username = '';

if (!empty($_POST["user"])) {

    $isAuthenticated = false;
    
    $username = $_POST["user"];
    $password = $_POST["pass"];

    $auth = $sessionDao->getAuthByUsername($username);
    //error_log(print_r($auth, TRUE));
    //if (password_verify($password, $auth[0]["PASS"])) {
    if (md5($password) == $auth[0]["PASS"]) {
        $isAuthenticated = true;
    }

    if ($isAuthenticated) {
        
        error_log("User is authenticated, setting up session");
        
        $_SESSION['teamId'] = $auth[0]['INT'];
        $_SESSION['login'] = $username;
        $_SESSION['equipe'] = $auth[0]['EQUIPE'];
        $_SESSION['equipesim'] = $auth[0]['EQUIPESIM'];

        if(1==$auth[0]['ADMIN']){
            $_SESSION['isAdmin'] = true;
        }
        
        $_SESSION['authenticated'] = true;
        
        setcookie('login', $username, time() + (86400 * 30), "/");
        
        if (!empty($_POST["rememberMe"]) && $_POST["rememberMe"]) {
            //setcookie('rememberMe', true, time() + (86400 * 30), "/");
            $teamIdNumeric = $_SESSION['teamId'] + 0;

            $random_token = AuthHelper::createAndSaveToken($teamIdNumeric, $sessionDao);
            setcookie('loginToken', $random_token, time() + (86400 * 30), "/");

        }
        
        //update login timestamps
        AuthHelper::updateLoginSession($_SESSION['teamId'], $sessionDao);

        AuthHelper::redirectPage();
    } else {
        //$message = "Invalid Login";
        $message = "The username or password you entered is incorrect.";
    }
}
//check keep logged in status

//if(!empty($_COOKIE['selectorHash']) && !empty($_COOKIE['rememberMe']) && !empty($_COOKIE['login'])){
if(!empty($_COOKIE['loginToken']) && !empty($_COOKIE['login'])){

    $loginToken = urldecode($_COOKIE['loginToken']);
    $current_time = time();
    $current_date = date("Y-m-d H:i:s", $current_time);
    $isSelectorVerified = false;
    $isExpiryDateVerified = false;
    $username = $_COOKIE['login'];
    $userToken='';
    
    $auth = $sessionDao->getAuthByUsername($username);
    if($auth && !empty($auth[0]["INT"])){
        $userToken = $sessionDao->getToken($loginToken, $auth[0]["INT"]);
    }
    
    if($userToken && !empty($userToken[0]["token"])){
        
        // Validate random selector cookie with database

        //if (password_verify(urldecode($_COOKIE['selectorHash']), $userToken[0]["selector_hash"])) {
        if (urldecode($_COOKIE['loginToken']) === $userToken[0]["token"]) {
            $isSelectorVerified = true;
        }
        
        // check cookie expiration by date
        if($userToken[0]["expiry_date"] >= $current_date) {
            $isExpiryDateVerified = true;
        }
        
        if (!empty($userToken[0]["id"]) && $isSelectorVerified && $isExpiryDateVerified) {
            $_SESSION['teamId'] = $auth[0]['INT'];
            $_SESSION['login'] = $username;
            $_SESSION['equipe'] = $auth[0]['EQUIPE'];
            $_SESSION['equipesim'] = $auth[0]['EQUIPESIM'];
            
            if(1==$auth[0]['ADMIN']){
                $_SESSION['isAdmin'] = true;
            }
            
            $_SESSION['authenticated'] = true;

            //update login timestamps
            AuthHelper::updateLoginSession($_SESSION['teamId'], $sessionDao);
            
            AuthHelper::redirectPage(); //redirect on successful login.
        } else {
            //mark old as expired.
            if(!empty($userToken[0]["id"])) {
                $sessionDao->markAsExpired($userToken[0]["id"]);
            }
    
        }
        
    }
     
    $message = "Login Expired. Please re-enter credentials";
}

//clear old session
ob_start();
AuthHelper::resetSession();  
ob_flush();

//must be after.
include 'head.php';

?>

<div class="container">
    <div class="row">
    	<div class="col-12 col-md-6 col-lg-5 text-center mx-auto">
    	    <div class="card">
    	    	<div class="card-header">Login</div>
    			<div class="card-body">

    				<form action="" method="post" id="frmLogin">
    				    			
                		<div class="form-group">
                    		<label for="usernameControl">Username:</label>	
                    		<input class="form-control text-center"  type="text" name="user" id="usernameControl" <?php echo 'value="'.$username.'"'?> required
                    		oninvalid="this.setCustomValidity('Please Enter valid username')"
							oninput="setCustomValidity('')">	
                		</div>
                		
                		<div class="form-group">
                            <label for="passControl">Password</label>
                            <input class="form-control text-center" type="password" name="pass"  id="passControl" required
                            oninvalid="this.setCustomValidity('Password is required')"
							oninput="setCustomValidity('')">
                        </div>
                        
                        <?php 
        				if(isset($message)){
        				    echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
    							}
    					?>
            
              			<div class="form-group">
                            <div class="col-sm-12 custom-control custom-checkbox">
                             
                              <input id="rememberMe" name="rememberMe" type="checkbox" class="custom-control-input">
                               <label for="rememberMe" class="custom-control-label">Keep me logged in</label>
                            </div>
                         </div>
            
            			<input class="btn btn-outline-primary" type="submit" value="Login" name="login">
                		
                	</form>
    			</div>
    		</div>
    		
    	</div>
    </div>
</div>

 
 <?php include 'footer.php'; ?>