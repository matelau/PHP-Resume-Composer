<?php

// Get the utilities
require('application/utilities.php');
//load the database functions
require('application/db.php');

//authentication functions
require('application/authentication.php');

redirectToHTTPS();
// Start/resume session
$isSubmission = resumeSession();

//the user must be authenticated to be on this page 
//check if the user is authenticated
if(isset($_SESSION['authenticated']))
{

	$display = "<li class='active'><a href='archive.php'>Archive</a></li><li><a href='logout.php'>Logout</a></li>";

	//check if the user is an admin
	if(strcmp($_SESSION['authenticated'], 'admin') === 0)
	{
		$display = $display."<li><a href='admin.php'>Admin</a></li>";		 
	}
}

//if the user is not logged in redirect to the login page
else
{
	header("Location: /~matelau/cs4540/ps6/login.php");
}

//Used to store the state of the latest transaction
$errorMsg = ""; 


// If this was a submission/save, save values to database
if ($isSubmission) 
{	
	//save the resume name to the session
	$_SESSION['resume'] = getParam('resume', '');

	//process resume
	if (isset($_REQUEST['save']))
	{	
		$resume = $_SESSION['resume'];
		//validate $resume name
		if(validate($resume))
		{
			//save the resume to the db
			registerResume($_SESSION['resume'] , $_SESSION['login']);
			$errorMsg = "<div class='alert alert-success'> <strong>Resume Saved!</strong></div>";
		}
		else
		{
			//The resume name was invalid
			$errorMsg = "<div class='alert alert-error'>The resume name may only contain the characters a-z (upper or lower case) and must be between 5-20 characters in length</div>";
		}
		
	}

}


// If this was a submission/delete, delete the resume from the database 
if(isset($_REQUEST['delete']))
{
	//save the resume name and login for processing
	$_SESSION['resume'] = getParam('resume', '');

	$resume = $_SESSION['resume'];
	$login = $_SESSION['login'];

		//validate the name
		if(validate($resume))
		{
			//check that the resume exists for this user
			if(getResumeID($resume, $login) === NULL)
			{
				$errorMsg = "<div class='alert alert-error'> <strong>Resume did not exist!</strong></div>";
			}
			else
			{	
				//delete the resume
				deleteResume($resume, $login);
				//the delete was successful
				$errorMsg = "<div class='alert alert-success'> <strong>Resume Deleted!</strong></div>";
			}

					
		}
		//The resume name was invalid
		else
		{
			$errorMsg = "<div class='alert alert-error'>The resume name may only contain the characters a-z (upper or lower case) and must be between 5-20 characters in length</div>";
		}
	
}

// If this was a submission/load get the values from the db and load them into the session
if(isset($_REQUEST['load']))
{
	
	//save the resume name
	$_SESSION['resume'] = getParam('resume', '');
	$login = $_SESSION['login'];
	$resume = $_SESSION['resume'];

		if(validate($resume))
		{
			//if the resume did not exist 
			if(getResumeID($_SESSION['resume'], $login) === NULL)
			{
				$errorMsg = "<div class='alert alert-error'> <strong>Resume did not exist!</strong></div>";
			}
			else
			{
				//load the values
				loadResume($_SESSION['resume'], $login);
				//the load was successful
				$errorMsg = "<div class='alert alert-success'> <strong>Resume loaded!</strong></div>";
			}		
		}
		//The resume name was invalid
		else
		{
			$errorMsg = "<div class='alert alert-error'>The resume name may only contain the characters a-z (upper or lower case) and must be between 5-20 characters in length</div>";
		}
	
}

// If this was a submission/view  show the stored values on a new resume page 
if(isset($_REQUEST['view']))
{
	
	//save the submission
	$_SESSION['resume'] = getParam('resume', '');
	$resume = $_SESSION['resume'];
	$login = $_SESSION['login'];

		if(validate($resume))
		{
			//if the resume did not exist 
			if(getResumeID($_SESSION['resume'], $login ) === NULL)
			{
				$errorMsg = "<div class='alert alert-error'> <strong>Resume did not exist!</strong></div>";
			}
			else
			{   
				//launch a new window
				header("Location: /~matelau/cs4540/ps6/resume.php?name=$resume&login=$login");
			}

					
		}
		//The resume name was invalid
		else
		{
			$errorMsg = "<div class='alert alert-error'>The resume name may only contain the characters a-z (upper or lower case) and must be between 5-20 characters in length</div>";
		}
	
}


// Output the HTML
require("views/archive.php");

//print_r($_SESSION);

?>
