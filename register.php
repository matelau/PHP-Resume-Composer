<?php 
//Resume composer Controller
//Written by Asaeli Matelau for cs4540

//start the session
// Get the utilities
require('application/utilities.php');

//authentication functions
require('application/authentication.php');

//database functions
require('application/db.php');

// Use HTTPS
redirectToHTTPS();

// Start/resume session
$isSubmission = resumeSession();

//check if the user is authenticated
if(isset($_SESSION['authenticated']))
{

	$display = "<li><a href='archive.php'>Archive</a></li> <li><a href='logout.php'>Logout</a></li>";

	//check if the user is an admin
	if(strcmp($_SESSION['authenticated'], 'admin') === 0)
	{
		$display = $display."<li><a href='admin.php'>Admin</a></li>";		 
	}
}
else
{
	$display = "<li><a href='login.php'>Login</a></li><li class='active'><a href='register.php'>Register</a></li>";
}


//save what page the user came from - ignore submission updates
if(!isset($_REQUEST['cancel']) && !isset($_REQUEST['save']))
{
	//if the value is undefined
	if($_SERVER['HTTP_REFERER'] === NULL )
	{
		//refer to the index
		$_SESSION['referer'] = "/~matelau/cs4540/ps6/index.php";
	}
	else
	{
		$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
	}

}

//if user clicks cancel redirect
if(isset($_REQUEST['cancel']))
{

	header("Location:".$_SESSION['referer']);
	unset($_SESSION['referer']);
	exit();
 }

// If this was a submission, save parameters to session
if ($isSubmission) 
{	
	
    $_SESSION['login'] = getParam('login', '');
    $_SESSION['real'] = getParam('real', '');

	//validate that all values have been included
	if(empty($_REQUEST['real']) === true || empty($_REQUEST['login']) === true || empty($_REQUEST['pw']) === true || empty($_REQUEST['pw1']) === true )
	{
		$errorMessage = "<div class='alert alert-error'>Login name, Real name, and password are required</div>";
		$_SESSION['errorA'] = $errorMessage;
	}
	//insure passwords are identical
	else if(strcmp($_REQUEST['pw'], $_REQUEST['pw1']) != 0)
	{
		$errorMessage = "<div class='alert alert-error'>Passwords do not match</div>";
		$_SESSION['errorA'] = $errorMessage;

	}

	//form has been validated now process registration
	else
	{

		$errorMessage = "";
		$_SESSION['errorA'] = $errorMessage;

		//sanitize input
		$name = strip_tags(trim($_REQUEST['real']));
		$login = strip_tags(trim($_REQUEST['login']));
		$pw = strip_tags(trim($_REQUEST['pw']));

		//register user
		$return = registerNewUser($name , $login , $pw );
		

		//successful register
		if($return)
		{
			//route to the page of origin -login page
			$_SESSION['error'] = 'Please Login Now';
			header("Location:".$_SESSION['referer']);
			///cs4540/ps6/login.php

			unset($_SESSION['referer']);
			exit();

		}

		// unsuccessful register - login exists - display error
		else
		{
			$errorMessage = "<div class='alert alert-error'>Login name already exists</div>";
			$_SESSION['errorA'] = $errorMessage;
		}
		

	}

	
}



require('views/register.php');
//used for debugging
//session_destroy();

?>