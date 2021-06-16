  
  <?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

require_once 'config.php';
include 'lang.php';

$CurrentHTML = 'Login.php';
$CurrentTitle = 'Login';
$CurrentPage = '';
$SecurePage = false;

include 'head.php';

?>

<div class="container">
    <div class="row">
    	<div class="col-12 col-md-6 col-lg-4 text-center mx-auto">
    	    <div class="card">
    	    	<div class="card-header">Login</div>
    			<div class="card-body">
    				<form method="post" action="<?php echo BASE_URL?>gmo/login/authenticate.php">
                		<div class="form-group">
                    		<label for="usernameControl">Username:</label>	
                    		<input class="form-control text-center"  type="text" name="user" id="usernameControl" required>	
                		</div>
                		
                		<div class="form-group">
                            <label for="passControl">Password</label>
                            <input class="form-control text-center" type="password" name="pass"  id="passControl" >
                        </div>
            
              			<div class="form-group">
                            <div class="col-sm-12 custom-control custom-checkbox">
                             
                              <input id="rememberMe" name="rememberMe" type="checkbox" class="custom-control-input">
                               <label for="rememberMe" class="custom-control-label">Keep Me Logged-In</label>
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