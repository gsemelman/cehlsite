<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Prospect Forms';
$CurrentPage = 'ProspectForm';
include 'head.php';
?>

<?php

if(isset($_GET['type'])) {
	$formType = $_GET['type'];
	$formType = htmlspecialchars($formType);
	if($formType == 'claim') {
		$formLink = 'https://goo.gl/forms/dcCNrDIqqEHAC6Bg1'; //claim
	}else{
		$formLink = 'https://goo.gl/forms/FW3iOZTmERdl06x23'; //create
	}	
}else{
	$formLink = 'https://goo.gl/forms/FW3iOZTmERdl06x23'; //create
}
?>

	<div class = "container-responsive">
		<div class="row">
			<div class="col iframe-container">
				<iframe src="<?php echo $formLink ?>" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
		
	</div>

<?php include 'footer.php'; ?>