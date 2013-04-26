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

if(isset($_REQUEST['delete']))
{
	$login = $_REQUEST['delete'];
	deleteUser($login); 
}

if(isset($_REQUEST['modify']))
{
	$login = $_REQUEST['modify'];
	modifyUser($login);
}


//print_r($_REQUEST);
//check if the user is authenticated
if(isset($_SESSION['authenticated']))
{

	$display = "<li><a href='archive.php'>Archive</a></li><li><a href='logout.php'>Logout</a></li>";

	//check if the user is an admin
	if(strcmp($_SESSION['authenticated'], 'admin') === 0)
	{
		$display = $display."<li class='active'><a href='admin.php'>Admin</a></li>";		 
	}
	else
	{
		//redirect to bad roles page 
		header("Location: /~matelau/cs4540/ps6/badRoles.php");
	}
}
else
{
	//user needs to login
	header("Location: /~matelau/cs4540/ps6/login.php");
}

//load the database into buttons 

$table = clientTable();

require('views/admin.php');
//used for debugging
//session_destroy();

?>