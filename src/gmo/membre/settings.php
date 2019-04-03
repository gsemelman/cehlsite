<?php
extract($_POST,EXTR_OVERWRITE);

require_once __DIR__ .'/../../config.php';
include_once FS_ROOT.'common.php';
include_once GMO_ROOT.'membre/lang.php';

if(!isset($_SESSION)){
    session_name(SESSION_NAME);
    session_start();
}

if(!isAuthenticated()){
    http_response_code(401);
    exit;
}


$e = "";
$f = "#ae654c"; // Green : #4caf50 | Red : #ae654c

if (isset($_POST['changer']) && isset($_POST['actpass']) && isset($_POST['new1']) && isset($_POST['new2'])) {
	$correct2 = 0;
	$new1 = $_POST['new1'];
	$new2 = $_POST['new2'];
	if($new1 == $new2) {
		$actpass = $_POST['actpass'];
		include GMO_ROOT.'login/mysqli.php';
		$sql = "SELECT `PASS` FROM `".$db_table."` WHERE `INT` = '$teamID'";
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		while($data = mysqli_fetch_array($query)) {
			if(md5($actpass) == $data['PASS']) {
				$correct2 = 1;
			}
		}
		if($correct2) {
			$new1 = md5($new1);
			$sql = "UPDATE `".$db_table."` SET `PASS`='$new1' WHERE `INT`='$teamID'";
			$query = mysqli_query($con, $sql) or die(mysqli_error($con));
			$e = $db_membre_pass_langue[4];
			$f = "#4caf50";
		}
		else {
			$e = $db_membre_pass_langue[5];
		}
		mysqli_close($con);
	}
	else $e = $db_membre_pass_langue[6];
}

if(isset($_POST['notification']) ) {
	if(isset($_POST['checkboxNotification'])) {
		$checkboxNotification = 1;
		$e = $db_membre_pass_langue[9];
		$f = "#4caf50";
	}
	else {
		$checkboxNotification = 0;
		$e = $db_membre_pass_langue[8];
	}
	
	include GMO_ROOT.'login/mysqli.php';
	$sql = "UPDATE `".$db_table."` SET `NOTIFICATION`='$checkboxNotification' WHERE `INT`='$teamID'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
}

if(isset($_POST['language']) ) {
	$inputLanguage = $_POST['inputLanguage'];
	if($inputLanguage == "en") $text = $db_membre_pass_langue[12];
	if($inputLanguage == "fr") $text = $db_membre_pass_langue[11];
	$e = $db_membre_pass_langue[13]." (".$text.")";
	$f = "#4caf50";
	$league_langue = $inputLanguage;

	include GMO_ROOT.'login/mysqli.php';
	$sql = "UPDATE `".$db_table."` SET `LANGUE`='$inputLanguage' WHERE `INT`='$teamID'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);
}

if(isset($_POST['sortPlayer']) ) {
	$inputSortPlayer = $_POST['inputSortPlayer'];
	if($inputSortPlayer == "0") $text = $db_membre_pass_langue[17];
	if($inputSortPlayer == "1") $text = $db_membre_pass_langue[18];
	$e = $db_membre_pass_langue[19]." (".$text.")";
	$f = "#4caf50";
	$gm_sortPlayer = $inputSortPlayer;
	
	include GMO_ROOT.'login/mysqli.php';
	$sql = "UPDATE `".$db_table."` SET `SORT_PLAYER`='$inputSortPlayer' WHERE `INT`='$teamID'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	mysqli_close($con);

}

$languageEN = "";
$languageFR = "";
$sortPlayerFirst = "";
$sortPlayerLast = "";
include GMO_ROOT.'login/mysqli.php';
$sql = "SELECT `NOTIFICATION`, `LANGUE`, `EMAIL`, `SORT_PLAYER` FROM `".$db_table."` WHERE `INT` = '$teamID' LIMIT 1";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));
while($data = mysqli_fetch_array($query)) {
	if($data['NOTIFICATION'] == 1) $notification = " checked";
	else $notification = "";
	if($data['LANGUE'] == "en") $languageEN = " checked";
	if($data['LANGUE'] == "fr") $languageFR = " checked";
	$teamEmail = $data['EMAIL'];
	if($data['SORT_PLAYER'] == "0") $sortPlayerFirst = " checked";
	if($data['SORT_PLAYER'] == "1") $sortPlayerLast = " checked";
}
mysqli_close($con);

if($languageEN == "" & $languageFR == "") {
	if($league_langue == "fr") $languageFR = " checked";
	if($league_langue == "en") $languageEN = " checked";
}
if($sortPlayerFirst == "" & $sortPlayerLast == "") {
	if($gm_sortPlayer == "0") $sortPlayerFirst = " checked";
	if($gm_sortPlayer == "1") $sortPlayerLast = " checked";
}

?>
<div class="container">
<div class="col">
    <div class="row">

		<div class="my-1 p-2 bg-white rounded box-shadow border-bottom ">
            <h6 class="border-bottom border-gray mb-3"><?php echo $db_membre_pass_langue[0]; ?></h6>

     		<form method="post" action="">
 
              <div class="form-group row">
                <label for="currentPass" class="col-sm-5 col-form-label"><?php echo $db_membre_pass_langue[1]; ?></label>
                <div class="col-sm-7">
                  <input type="password" name="actpass" class="form-control text-center" id="currentPass" placeholder="********">
                </div>
              </div>
              <div class="form-group row">
                <label for="newPass" class="col-sm-5 col-form-label"><?php echo $db_membre_pass_langue[2]; ?></label>
                <div class="col-sm-7">
                  <input type="password" name="new1" class="form-control text-center" id="newPass" placeholder="********">
                </div>
              </div>
              <div class="form-group row">
                <label for="confirmPass" class="col-sm-5 col-form-label"><?php echo $db_membre_pass_langue[3]; ?></label>
                <div class="col-sm-7">
                  <input type="password" name="new2" class="form-control text-center" id="confirmPass" placeholder="********">
                </div>
              </div>
    
     
              <div class="form-group row">
                <div class="col-sm-10">
                  <input class="btn btn-outline-primary" type="submit" value="<?php echo $db_membre_all_langue[1]; ?>" name="changer">
                </div>
              </div>
            </form>

        </div>
        
       
    </div> <!-- end pass change row -->
    
    <div class="row">

		<div class="my-1 p-2 bg-white rounded box-shadow border-bottom ">
            <h6 class="border-bottom border-gray mb-3"><?php echo $db_membre_pass_langue[7]; ?></h6>

     		<form method="post" action="">
                
             <div class="form-group">
                <div class="col-sm-12 custom-control custom-checkbox">
                  <input id="checkboxNotification" name="checkboxNotification" type="checkbox" <?php echo $notification; ?> value="" class="custom-control-input">
                  <label class="custom-control-label" for="checkboxNotification"><?php echo $db_membre_pass_langue[15];?></label>
                </div>
             </div>
             
   
              <div class="form-group row">
                <div class="col-sm-10">
                  <input class="btn btn-outline-primary" type="submit" value="<?php echo $db_membre_all_langue[1]; ?>" name="notification">
                </div>
              </div>
            </form>
    

        </div>
        
       
    </div> <!-- end email notification row -->
    
    <!--  
    <div class="row">

		<div class="my-1 p-2 bg-white rounded box-shadow border-bottom ">
            <h6 class="border-bottom border-gray mb-3"><?php// echo $db_membre_pass_langue[10]; ?></h6>

     		<form method="post" action="">
     
     			<div class="form-group">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="languageFR" <?php //echo $languageFR; ?> name="inputLanguage" class="custom-control-input">
                      <label class="custom-control-label" for="languageFR"><?php //echo $db_membre_pass_langue[11]; ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="languageEN" <?php //echo $languageEN; ?> name="inputLanguage" class="custom-control-input">
                      <label class="custom-control-label" for="languageEN"><?php //echo $db_membre_pass_langue[12]; ?></label>
                    </div>
                 </div>
             
   
                <div class="form-group row">
                    <div class="col-sm-10">
                      <input class="btn btn-outline-primary" type="submit" value="<?php //echo $db_membre_all_langue[1]; ?>" name="language">
                    </div>
                </div>
            </form>
      

        </div>
        
       
    </div>--> <!-- end languae row -->
    
        
    <div class="row">

		<div class="my-1 p-2 bg-white rounded box-shadow border-bottom ">
            <h6 class="border-bottom border-gray mb-3"><?php echo $db_membre_pass_langue[16]; ?></h6>

     		<form method="post" action="">
          		<div class="form-group">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="inputSortPlayerFirst" value="0" <?php echo $sortPlayerFirst; ?> name="inputSortPlayer" class="custom-control-input">
                      <label class="custom-control-label" for="inputSortPlayerFirst"><?php echo $db_membre_pass_langue[17]; ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="inputSortPlayerLast" value="1" <?php echo $sortPlayerLast; ?> name="inputSortPlayer" class="custom-control-input">
                      <label class="custom-control-label" for="inputSortPlayerLast"><?php echo $db_membre_pass_langue[18]; ?></label>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10">
                      <input class="btn btn-outline-primary" type="submit" value="<?php echo $db_membre_all_langue[1]; ?>" name="sortPlayer">
                    </div>
                </div>
            </form>
      

        </div>
        
       
    </div> <!-- end sort row -->



</div><!-- end col -->
</div><!-- end container -->

<script type="text/javascript">
<!--

<?php if(isset($e) && $e != '') { ?>
document.addEventListener("DOMContentLoaded", popupAlert("<?php echo $e; ?>", "<?php echo $f; ?>"), false);
<?php } ?>

//-->
</script>
