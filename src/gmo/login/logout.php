<?php


require_once __DIR__ .'/../../config.php';
include_once FS_ROOT.'classes/AuthHelper.php';


if(!isset($_SESSION)){
    session_name(SESSION_NAME);
    session_start();
}

//remove session variables and clear session cookies
AuthHelper::resetSession();

// remove all session variables
//session_unset();

// destroy the session
session_destroy(); 
//$target = BASE_URL;
//header("Location: $target");
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>