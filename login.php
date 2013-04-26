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



// Use HTTPS
redirectToHTTPS();

// Start/resume session
$isSubmission = resumeSession();

//check if the user is authenticated
if(isset($_SESSION['authenticated']))
{

	$display = "<li><a href='archive.php'>Archive</a></li><li><a href='logout.php'>Logout</a></li>";

	//check if the user is an admin
	if(strcmp($_SESSION['authenticated'], 'admin') === 0)
	{
		$display = $display."<li><a href='admin.php'>Admin</a></li>";		 
	}
}
else
{
	$display = "<li class='active'><a href='login.php'>Login</a></li><li><a href='register.php'>Register</a></li>";
}

//save what page the user came from incase redirect is needed 
if(!isset($_REQUEST['cancel']) && !isset($_REQUEST['submit']))
{
	//if the value is undefined send to the index
	if($_SERVER['HTTP_REFERER'] === NULL )
	{
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


// If this was a submission, save parameters to session - process login
if(isset($_REQUEST['submit']))
{	
	$_SESSION['login'] = getParam('login', '');
       
	//validate that all values have been included
	if(empty($$_REQUEST['login']) === true || empty($_REQUEST['pw']) === true )
	{
		$errorMessage = "<div class='alert alert-error'>Login and password are required</div>";
		$_SESSION['error'] = $errorMessage;
	}

	$login = trim($_REQUEST['login']);
	$password = trim($_REQUEST['pw']);

	if(verifyLogin($login, $password))
	{
		header("Location:".$_SESSION['referer']); 
	}
	
		
}

//this was something else  - reset error message
else
{
		$errorMessage = "";
		$_SESSION['error'] = $errorMessage;
}





require('views/login.php');
//used for debugging
//session_destroy();

?>