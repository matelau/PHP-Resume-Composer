<?php 
//Resume composer Controller


// Get the utilities
require('application/utilities.php');

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
  $display = "<li><a href='login.php'>Login</a></li><li><a href='register.php'>Register</a></li>";
}


// If this was a submission, save parameters to session
if ($isSubmission) 
{ 
  $_SESSION['position'] = getParam('position', '');

  //validate submission
  if(empty($_SESSION['position']) === true)
  {
    $errorMessage = "<div class='alert alert-error'>You must include a description</div>";
    $_SESSION['error1'] = $errorMessage;

  }
  else
  {
    $errorMessage = "";
    $_SESSION['error1'] = $errorMessage;
  }
}

// Output the HTML
require("views/position.php");

?>