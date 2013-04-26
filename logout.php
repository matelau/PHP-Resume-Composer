<?php 
//Resume composer Controller
//Written by Asaeli Matelau for cs4540

//start the session
// Get the utilities
require('application/utilities.php');

//database functions
require('application/db.php');

//authentication functions
require('application/authentication.php');



// Start/resume session
$isSubmission = resumeSession();

//get the referer

//if the value is undefined send to the index
if($_SERVER['HTTP_REFERER'] === NULL )
{
	$_SESSION['referer'] = "/~matelau/cs4540/ps6/index.php";
}
else
{
	$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
}

//logout
unset($_SESSION['real']);
unset($_SESSION['login']);
unset($_SESSION['authenticated']);

//send back to the page the user came from 
header("Location:".$_SESSION['referer']);

session_destroy();


?>