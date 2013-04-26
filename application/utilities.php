<?php

// Resumes a session; initializes session variables if necessary
// Reports whether this is a submission
function resumeSession () 
{
	
	session_start();
	initSession('beg', array(''));
	initSession('end', array(''));
	initSession('job', array(''));
	initSession('name', '');
	initSession('address', '');
	initSession('number', '');
	initSession('position', '');
	initSession('error', '');
	initSession('errorA', '');
	initSession('error1', '');
	initSession('error2', '');
	initSession('error3', '');

	//used for resume views
	initSession('beg1', array(''));
	initSession('end1', array(''));
	initSession('job1', array(''));
	initSession('name1', '');
	initSession('address1', '');
	initSession('number1', '');
	initSession('position1', '');

	//user for ps6 authentication
	initSession('login', '');
	initSession('real', '');
	initSession('referer', '');


	initSession('resume', '');
	return isset($_REQUEST['save']);
}


// If $param is not a session variable, create it with $default as its value
function initSession ($param, $default)
{
	if (!isset($_SESSION[$param]))
	{
		$_SESSION[$param] = $default;
	}
}

// Echoes a session variable
function sticky ($param)
{
	echo $_SESSION[$param];
}

// validates the resume input 
function validate ($param)
{
	$param = trim($param);

	if(preg_match("/^[a-zA-Z]+$/", $param) === 0 || strlen($param) >= 20)
	{
		return false;
	}

	return true; 
}

// Return the value of the parameter $param if it exists.
// Otherwise, return $default.
function getParam ($param, $default)
{
	return (isset($_REQUEST[$param])) ? strip_tags($_REQUEST[$param]) : $default;
}

// Returns 'true' if this was a submission and $string is empty, returns 'false' otherwise.
function check ($string)
{
	global $isSubmission;
	return ($isSubmission && strlen($string) == 0) ? 'true' : 'false';
}

?>