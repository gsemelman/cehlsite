<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Rules';
$CurrentPage = 'Rules';
include 'head.php';
?>

	<div class = "container">
		<div class="col">
			<div ALIGN=LEFT id = 'rules'></div>
		</div>
		

	</div>
	
	

	 <script type="text/javascript">
	 $.ajax({
		    url: "<?php echo $folderLegacy ?>cehlRules.html",
		    cache: false,
		    dataType: "html",
		    success: function(data) {
		        $("#rules").html(data);
		    }
		});
	 </script>

</body>

</html>