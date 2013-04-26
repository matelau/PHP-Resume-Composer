<!doctype html>

<html>

<head>
<title><?php sticky('name')?></title>
<link rel="stylesheet" type="text/css" href="application/style.css"/>
</head>

<body>

<h3><?php sticky('name')?><br/>
    <?php sticky('address')?><br/>
    <?php sticky('number')?></h3>
    
<h4>Position Desired</h4>
<p><?php sticky('position')?></p>

<h4>Employment History</h4>

<ul>
<?php 
for ($i = 0; $i < count($_SESSION['beg']); $i++) 
{
	$beg = $_SESSION['beg'][$i];
	$end = $_SESSION['end'][$i];
	$job = $_SESSION['job'][$i];
    echo "<li>$beg--$end.  $job</li>";
}
?>
</ul>
</body>
</html>