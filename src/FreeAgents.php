<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Free Agents';
$CurrentPage = 'FreeAgents';
include 'head.php';
?>

	<div class = "container" style = "width: 100%; height: 100%;">

		<div class="row">
			<div class="col-sm-12 col-md-8 offset-md-2 iframe-container">
				<iframe src="<?php echo $folder ?>cehlFreeAgents.html" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
		
	</div>

</body>

</html>