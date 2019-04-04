<div class="row">
	<div class="col-12 col-md-6 col-lg-3 text-center mx-auto">
<!--     	<form method="post" action="gmo/login/validation.php"> -->
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
                  <label class="custom-control-label" for="rememberMe">Remember Me</label>
                </div>
             </div>

			<input class="btn btn-outline-primary" type="submit" value="<?php echo $db_login_langue[3]; ?>" name="login">
    		
    	</form>
	</div>
</div>
