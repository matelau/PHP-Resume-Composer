<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">  
<title>Asaeli Matelau: PS3 - Employment History </title> 
<!-- I utilized Bootstrap for style -->
<meta name="description" content="Twitter Bootstrap navbar with responsive variation Example">
<link href="assets/bootstrap.css" rel="stylesheet">
<link href="assets/bootstrap-responsive.css" rel="stylesheet">

<!-- Add JQuery  -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/script.js"></script>
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
              <li ><a href="index.php">Contact Information</a></li>
              <!-- Default should be shown --> 
              <li><a href="position-sought.php">Position Sought</a></li>
              <!-- on click should show this page within the body content -->

              <li class="active"><a href="employment-history.php">Employment History</a></li>
              <?php echo $display ?>
              <!-- open in new window -->
              <li><a href="resume.php" target="Resume">View Resume</a></li>
         </div>
</div>
    <div class="span8"> 
      <!--Body content-->  
       <h3>Employment History</h3>
        <!--Check for Errors -->
       <?php sticky('error2') ?>
       <form class="form-horizontal" method="post" action="">
       <div class="eHistory">
        <!-- php loads stored values if any -->
        <?php echo $div ?>
       <!-- JavaScript does work here --> 
       </div>
       <div class="control-group">
         <div class="controls">
            <input class="btn btn-primary" type="submit" name="save" value="Save">
            <input class="btn-info" type="button" value="Add Another" id="add">
         </div>
        </div>
      </form>  
    </div>
    </div>  
  </div>  
</div>


</body>
</html>