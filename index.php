<?php 
//Resume composer Controller
//Written by Asaeli Matelau for cs4540

//start the session
// Get the utilities
require('application/utilities.php');



// Start/resume session
$isSubmission = resumeSession();

//debug
//$_SESSION['authenticated']= "user"; 

// If this was a submission, save parameters to session
if ($isSubmission) 
{	
	$_SESSION['name'] = getParam('name', '');
    $_SESSION['number'] = getParam('number', '');
    $_SESSION['address'] = getParam('address', '');

	    //validate that all values have been included
	if(empty($_SESSION['name']) === true || empty($_SESSION['number']) === true || empty($_SESSION['address']) === true )
	{
		$errorMessage = "<div class='alert alert-error'>Name, Number, and Address are required</div>";
		$_SESSION['error'] = $errorMessage;
	}

	
}
else{
		$errorMessage = "";
		$_SESSION['error'] = $errorMessage;
	}


//$_SESSION['authenticated']='admin';

// Output the HTML
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
	$display = "<li><a href='login.php'>Login</a></li><li><a href='register.php'>Register</a></li>";
}

require('views/contact.php');
//used for debugging
//session_destroy();

?>