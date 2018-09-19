<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Transactions';
$CurrentPage = 'Transactions';
include 'head.php';
?>

	<div class = "container">

		<div class="row">
			<div class="col iframe-container">
				<iframe src="<?php echo $folderLegacy ?>cehlTransact.html" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
		
	</div>

</body>

</html>