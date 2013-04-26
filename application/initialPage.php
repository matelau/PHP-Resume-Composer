<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">  
<title>Asaeli Matelau: PS3 - Resume Composer </title> 
<!-- I utilized Bootstrap for style -->
<meta name="description" content="Twitter Bootstrap navbar with responsive variation Example">
<link href="assets/bootstrap.css" rel="stylesheet">
<link href="assets/bootstrap-responsive.css" rel="stylesheet"> 
</head>
<body>
<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <a class="brand" href="index.php">Resume Composer</a>
    </div>
  </div>
</div>
<div class="container-fluid">  
  <div class="row-fluid">  
    <div class="span2"> 
         <!--Sidebar content-->  
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Build a Resume</li>
              <li class="active"><a href="#">Contact Information</a></li>
              <!-- Default should be shown --> 
              <li><a href="position-sought.php">Position Sought</a></li>
              <!-- on click should show this page within the body content -->
              <li><a href="employment-history.php">Employment History</a></li>
              <!-- on click open in new window -->
              <li><a href="resume.php" target="Resume">View Resume</a></li>
         </div>
</div>
    <div class="span8"> 
      <!--Body content-->  
      <form class="form-horizontal" method="post" action="">
        <h3>Contact Info</h3>
        <!--Check for Errors -->
        <?php if(isset($session['error']) === true) {echo $session['error'];} ?>
        <div class="control-group">
          <label class="control-label" for="inputName">Name</label>
          <div class="controls">
            <input type ="text" class="input-medium" placeholder="Name" name="name" id="name" <?php if(isset($session['name']) === true) {echo 'value="', strip_tags($session['name']), '"';} ?>>
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="inputNumber">Number</label>
          <div class="controls">
            <input type ="text" class="input-medium" placeholder="Number" name="number" id="number" <?php if(isset($session['number']) === true) {echo 'value="', strip_tags($session['number']), '"';} ?>>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="inputAddress">Address</label>
          <div class="controls">
            <input type ="text" class="input-medium" placeholder="Address" name="address" id="address" <?php if(isset($session['address']) === true) {echo 'value="', strip_tags($session['address']), '"';} ?>>
          </div>
        </div>

          <div class="control-group">
          <div class="controls">
            <input class="btn btn-primary" type="submit" value="Save Info">
          </div>
        </div>
      </form>  
    </div>
    </div>  
  </div>  
</div>  
</body>
</html>