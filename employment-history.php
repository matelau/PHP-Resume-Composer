<?php 
//Resume composer Controller

// Get the utilities
require('application/utilities.php');

// Resume session
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



// If this was a submission
if ($isSubmission)
{ 
  // Get parameters
    $beg = getParam('beg', array());
    $end = getParam('end', array());
    $job = getParam('job', array());
    
    // Trim arrays to the same length and save to session
    $length = min(count($beg), count($end), count($job));
    $_SESSION['beg'] = array_slice($beg, 0, $length);
    $_SESSION['end'] = array_slice($end, 0, $length);
    $_SESSION['job'] = array_slice($job, 0, $length);  

  //validate that all values have been included
  if(in_array("", $beg) === true ||in_array("", $end)=== true || in_array("", $job)=== true )
  {
    $error2 = "<div class='alert alert-error'>All Active Fields Must be Completed</div>";
    $_SESSION['error2'] = $error2;  
  }
  else{
    $_SESSION['error2'] = "";
  }
}


//check for stored values 
if(empty($_SESSION['beg']) === false || empty($_SESSION['end']) === false || empty($_SESSION['job']) === false )
{
   $div ="";
   //number of elements stored within the session
  $jobCount = count($_SESSION['beg']); 

  //prepare output
  for ($j =0; $j < $jobCount; $j++)
  {
    $currentStart = $_SESSION['beg'][$j];
    $currentEnd = $_SESSION['end'][$j];
    $currentDescription = $_SESSION['job'][$j];

    $div .= "<div class='HistoryGroup' id='$j' ><label class='control-label' for='description'>Dates Employed</label>
    <a class='btn btn-danger pull-right remove' id='$j'>remove</a>
          <div class='control-group'>
           <div class='controls'>
            <input type='text' class='input-small' placeholder='Start Date' name='beg[]' value='$currentStart'>
            <input type='text' class='input-small' placeholder='End Date' name='end[]' value ='$currentEnd'>
            
            </div>
        </div>
      <label class='control-label' for='description'>Description</label>
      <div class='control-group'>
         <div class='controls'>
            <textarea placeholder='Job Description' rows='2' name='job[]'>$currentDescription</textarea>
          </div>
      </div>
      </div>";
  
  }
  
}

//Initial output
else
{
  $j = 0;
  $div = "<div class='HistoryGroup' id='$j'><label class='control-label' for='description'>Dates Employed</label>
    <a class='btn btn-danger pull-right remove' id='$j'>remove</a>
          <div class='control-group'>
           <div class='controls'>
            <input type='text' class='input-small' placeholder='Start Date' name='beg[]''>
            <input type='text' class='input-small' placeholder='End Date' name='end[]'>
            </div>
        </div>
      <label class='control-label' for='description'>Description</label>
      <div class='control-group'>
         <div class='controls'>
            <textarea placeholder='Job Description' rows='2' name='job[]'></textarea>
          </div>
      </div>
      </div>";
}
require("views/eHis.php");


?>