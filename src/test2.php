
<html>
  <head>
  <title>My Now Amazing Webpage</title>

  </head>
  <body>
	<?php 
	
	$baseUrl = 'c:/cehlsite/';
	define("BASE_URL",realpath($baseUrl));

	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
	$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
	
	
	echo str_replace("\\",'/',$protocol.'://'.$_SERVER['HTTP_HOST'].substr(getcwd(),strlen($_SERVER['DOCUMENT_ROOT'])));
	?>
	
  </body>
</html>
