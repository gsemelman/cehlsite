<?php
$to = $_POST['email'];
$message = $_POST['userPass'];

$subject = "Online GM Editor - GMs Password";
$txt = $message;
$headers = "From: CEHL Info <no-reply@canadianelitehockeyleague.ca>" . "\r\n";

mail($to,$subject,$txt,$headers);

echo 'OK';

//header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?> 