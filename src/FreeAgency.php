<?php
$dataTablesRequired = 1; //require datatables import

include 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Free Agency';
$CurrentPage = 'FreeAgency';
include 'head.php';

//include_once 'cehlConfig.php';
?>

<style>

 #faTable { 
   display:none;  
 } 

</style>

	<div class = "container" style = "width: 100%; height: 100%;">
		<div id="freeAgency">
		</div>
	
	</div>

	<script>
		//$('#freeAgency').load('https://docs.google.com/document/d/e/2PACX-1vSHQoRNiVgG0m6Ou-V0k295b3m7PrbLbnqlcp8CKz1S1f5paRl4uu7Ps-9s8QFtpzmz4dFfsJp6ISW1/pub');

	 	$.ajax({
    	    type: "GET",
    	    contentType: "html",
    	    crossDomain:true,
    	    cache: false,
    	    url: 'https://docs.google.com/document/d/e/2PACX-1vSHQoRNiVgG0m6Ou-V0k295b3m7PrbLbnqlcp8CKz1S1f5paRl4uu7Ps-9s8QFtpzmz4dFfsJp6ISW1/pub',
    	    success: function(data){
    	    	$('#freeAgency').html(data);
    	    }
	    	
    	});
	</script>


</body>

</html>