<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">  
<title>Asaeli Matelau: PS5 - Archive </title> 
<!-- I utilized Bootstrap for style -->
<meta name="description" content="Twitter Bootstrap navbar with responsive variation Example">
<link href="assets/bootstrap.css" rel="stylesheet">
<link href="assets/bootstrap-responsive.css" rel="stylesheet"> 
<!-- use some JQuery to modify the view button so that when it is clicked it sets target to new destination --> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script>
$(function () {
  //register event handlers
  $('input[name=view]').click(
    function () {$('form').attr('target', )};

  });

</script> 
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
              <li ><a href="position-sought.php">Position Sought</a></li>
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
        <h3>Archive Resume</h3>
        <!--Check for Errors -->
        
        <div class="control-group">
          <label class="control-label" for="inputName">Resume Name</label>
          <div class="controls">
            <!-- The Pattern below should only allow upper and lower a-z chars and require there to be 5-20 chars but upper lim is not functioning -->
            <input type ="text" class="input-medium" placeholder="Resume Name" name="resume" pattern="[a-z\A-Z]*.{5,20}" value="<?php sticky('resume') ?>" ?>
            <br/>
            <input class="btn btn-primary" type="submit" name="save" value="Store">
            <input class="btn btn-primary" type="submit" name="load" value="Load" >
            <input class="btn btn-primary" type="submit" value="Delete" name="delete">
            <input class="btn btn-primary" type="submit" name='view' value="View" >
            <?php echo $errorMsg ?>
          </div>
          </div>
          </div>
        </div>
      </form>  
    </div>  
  </div>  
</div>


</body>
</html>