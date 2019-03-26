<div class="row">
	<div class="col-12 col-md-6 col-lg-3 text-center mx-auto">
    	<form method="post" action="gmo/login/validation.php">
    		<div class="form-group">
        		<label for="usernameControl">Username:</label>	
        		<input class="form-control text-center"  type="text" name="user" id="usernameControl" required>	
    		</div>
    		
    		<div class="form-group">
                <label for="passControl">Password</label>
                <input class="form-control text-center" type="password" name="pass"  id="passControl" >
            </div>
            
<!--             <button type="submit" name="login" class="btn btn-primary">Submit</button> -->

            <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" name="remember" type="checkbox" id="rememberMe">
                  <label class="form-check-label" for="rememberMe">
                    Remember Me
                  </label>
                </div>
              </div>

			<input class="btn btn-primary" type="submit" value="<?php echo $db_login_langue[3]; ?>" name="login">
    		
    	</form>
	</div>
</div>
