<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">  
<title>Asaeli Matelau: PS6 - Resume Composer </title> 
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
              <li><a href="index.php">Contact Information</a></li>
              <!-- Default should be shown --> 
              <li><a href="position-sought.php">Position Sought</a></li>
              <!-- on click should show this page within the body content -->
              <li><a href="employment-history.php">Employment History</a></li>
              <?php echo $display ?>
              <!-- on click open in new window -->
              <li><a href="resume.php" target="Resume">View Resume</a></li>
         </div>
</div>
    <div class="span8"> 
      <!--Body content-->  
     <form class="form-horizontal" method="post" action="" target="">
      <?php echo $table ?>
    </form>
    </div>
    </div>  
  </div>  
</div>  
</body>
</html>