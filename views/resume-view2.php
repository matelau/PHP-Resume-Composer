<!doctype html>
<!-- Uses temp session variables to show the user the stored resume --> 

<html>

<head>
<title><?php sticky('name1')?></title>
<link rel="stylesheet" type="text/css" href="application/style.css"/>
</head>

<body>

<h3><?php sticky('name1')?><br/>
    <?php sticky('address1')?><br/>
    <?php sticky('number1')?></h3>
    
<h4>Position Desired</h4>
<p><?php sticky('position1')?></p>

<h4>Employment History</h4>

<ul>
<?php 
for ($i = 0; $i < count($_SESSION['beg1']); $i++) 
{
	$beg = $_SESSION['beg1'][$i];
	$end = $_SESSION['end1'][$i];
	$job = $_SESSION['job1'][$i];
    echo "<li>$beg--$end.  $job</li>";
}
?>
</ul>
</body>
</html>