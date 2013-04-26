<?php

// Get the utilities
require('application/utilities.php');
require('application/db.php');

// Start/resume session
resumeSession();

//A url of the form name=somename & login=somelogin should display the named resume that was saved by the named user
//no authentication is required
if(isset($_REQUEST['name']) === true && isset($_REQUEST['login']) )
{
	loadResumeView($_REQUEST['name'], $_REQUEST['login']);
	require("views/resume-view2.php");

	//clear temp variables
	unset($_SESSION['name1']);
 	unset($_SESSION['number1']);
 	unset($_SESSION['address1']);
 	unset($_SESSION['position1']);

 	unset($_SESSION['beg1']);
 	unset($_SESSION['end1']);
 	unset($_SESSION['job1']);
 	

}
else
{
	// Output the HTML
	require("views/resume-view.php");
}



?>
