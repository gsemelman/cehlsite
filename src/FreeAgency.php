<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Free Agency';
$CurrentPage = 'FreeAgency';
include 'head.php';

//include_once 'cehlConfig.php';
?>

	<div class = "container">
		<div class="loaderImage"><img src="assets/img/loader.gif"></div>
		<div id="freeAgency">
		</div>
	
	</div>

	<script>

		$('.loaderImage').show();
		
	 	$.ajax({
    	    type: "GET",
    	    contentType: "html",
    	    crossDomain:true,
    	    cache: false,
    	    url: 'https://docs.google.com/document/d/e/2PACX-1vSHQoRNiVgG0m6Ou-V0k295b3m7PrbLbnqlcp8CKz1S1f5paRl4uu7Ps-9s8QFtpzmz4dFfsJp6ISW1/pub',
    	    success: function(data){
    	    	$('#freeAgency').html(data);
    	    	$(".loaderImage").hide();
    	    },
    	 	error: function(XMLHttpRequest, textStatus, errorThrown) {
    	 		$('#freeAgency').html('<p>Error loading data</p>');
    	 		$(".loaderImage").hide();
    	 	}

    	});

	</script>
	
	

<?php include 'footer.php'; ?>
