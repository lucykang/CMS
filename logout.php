<?php ob_start();
$title = 'Log Out';
require_once('header.php');
//access to the current session
session_start();

//remove any variables from the session
session_unset();

//kill the session
session_destroy();

//redirect
header('location:login.php');

require_once('footer.php');
ob_flush();
?>