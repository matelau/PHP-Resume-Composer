<?php

require 'hidden/dbpassword.php';

// Opens and returns a DB connection
function openDBConnection () {
	global $dbpassword;
	$DBH = new PDO("mysql:host=atr.eng.utah.edu;dbname=ps6_matelau", 
			       'matelau_sw', $dbpassword);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $DBH;
}

//Stores a Resume
function registerResume($resumeName, $login) {
	try {

		//if the resume exists already, remove the old to update
		deleteResume($resumeName, $login);

		$DBH = openDBConnection();
		$DBH->beginTransaction();
		//insert the personal details
		$stmt = $DBH->prepare("insert into Resume_Info (Resume_Name, User_loginName, User_Number, User_Name, User_Address, User_Position ) 
		value (?,?,?,?,?,?)");
		$stmt->bindValue(1, $resumeName);
		$stmt->bindValue(2, $login);
		$stmt->bindValue(3, $_SESSION['number']);
		$stmt->bindValue(4, $_SESSION['name']);
		$stmt->bindValue(5, $_SESSION['address']);
		$stmt->bindValue(6, $_SESSION['position']);
		$stmt->execute();
		//update values
		$resumeid = $DBH->lastInsertId();
		
		$DBH->commit();

		//gets the count for employment history 
		$jobCount = count($_SESSION['beg']); 
  		//prepare loop to insert job history 
		for ($j =0; $j < $jobCount; $j++)
  		{
	  		$stmt = $DBH->prepare("insert into Resume_History (idResume_History, Start, End, Job_History)
				values (?, ?, ?, ?)");

			$stmt->bindValue(1, $resumeid);
			$stmt->bindValue(2, $_SESSION['beg'][$j]);
			$stmt->bindValue(3, $_SESSION['end'][$j]);
			$stmt->bindValue(4, $_SESSION['job'][$j]);
			$stmt->execute();
  		}
		

		$DBH->commit();
		return true;
	}
	catch (PDOException $e) {
		}
}

// Registers a new user
function registerNewUser ($name, $login, $password) {
	try {

		//check if loginName already exists
		if(!checkUserExists($login))
		{
			$DBH = openDBConnection();
			$DBH->beginTransaction();
			$stmt = $DBH->prepare("insert into User_Role(loginName, Real_Name, PW, User_Role) 
			value( ?, ?,?, 'user')");
			$stmt->bindValue(1, $login);
			$stmt->bindValue(2, $name);
			$hashedPassword = computeHash($password, makeSalt());
			$stmt->bindValue(3, $hashedPassword);
			
			$stmt->execute();

			$DBH->commit();
			return true;
		

		}
		else
		{
			return false; 
		}
		
	}
	catch (PDOException $e) {
		if ($e->getCode() == 23000) {
			return false;
		}
		//reportDBError($e);
	}
}

//checks to see if a user login already exists in the database
function checkUserExists($login)
{
	try
	{
		$DBH = openDBConnection();

		//check if loginName already exists
		$stmt = $DBH->prepare("select count(loginName) from User_Role where loginName=?");
		$stmt->bindValue(1,$login);
		$stmt->execute();

		$row = $stmt->fetch();
	
		//user exists
		if($row['count(loginName)'] > 0)
		{
			return true; 
		}

		else
		{
			return false; 
		}
	}
	catch (PDOException $e) {

	}
}

// deletes a resume from the database
function deleteResume($resumeName, $login) {
	try {

		$DBH = openDBConnection();
		$DBH->beginTransaction();

		$stmt = $DBH->prepare("delete from Resume_Info where Resume_Name=? and User_loginName=?");
		$stmt->bindValue(1, $resumeName);
		$stmt->bindValue(2, $login);
		$stmt->execute();
		$DBH->commit();
		
		return true;

	}
	catch (PDOException $e) {
	}
}

// deletes a user from the database
function deleteUser($login) {
	try {

		$DBH = openDBConnection();
		$DBH->beginTransaction();

		$stmt = $DBH->prepare("delete from User_Role where loginName=?");
		$stmt->bindValue(1, $login);
		$stmt->execute();
		$DBH->commit();
		
		return true;

	}
	catch (PDOException $e) {
	}
}

// if the user is an admin turns them into a user and the other way around for users
function modifyUser($login) {
	try {

		$DBH = openDBConnection();
		$DBH->beginTransaction();

		$stmt = $DBH->prepare("select User_Role from User_Role where loginName=?");
		$stmt->bindValue(1, $login);
		$stmt->execute();

		$val = $stmt->fetch(); 
		if(strcmp($val['User_Role'],'user') === 0 )
		{
			$stmt =$DBH->prepare("update User_Role SET User_Role='admin' WHERE loginName=?");
			$stmt->bindValue(1, $login);
			$stmt->execute();
			
		}
		else
		{
			$stmt =$DBH->prepare("update User_Role SET User_Role='user' WHERE loginName=?");
			$stmt->bindValue(1, $login);
			$stmt->execute();
		}

		$DBH->commit();
		
		return true;

	}
	catch (PDOException $e) {
	}
}

// Returns ID that goes with Resume name or Null if none exists
function getResumeID ($ResumeName, $login) {

	try {
		$DBH = openDBConnection();
		$stmt = $DBH->prepare("select ID from Resume_Info where Resume_Name=? and User_loginName=?");
		$stmt->bindValue(1, $ResumeName);
		$stmt->bindValue(2, $login);
		$stmt->execute();

	
		
		if ($row = $stmt->fetch()) {
			return $row['ID'];
		}
		else {
			return NULL;
		}
	}
	catch (PDOException $e) {
	}
}


// Loads Resume values from the database to $_SESSION variables 
function loadResume ($ResumeName, $login) {
	try
	 {
	 	$id = "";
		$DBH = openDBConnection();
		$stmt = $DBH->prepare("select User_Name, User_Number, User_Address, User_Position, ID from Resume_Info where Resume_Name=? and User_loginName=? ");
		$stmt->bindValue(1, $ResumeName);
		$stmt->bindValue(2, $login);
		
		$stmt->execute();
		//load personal values
		if ($row = $stmt->fetch()) 
		{
			$_SESSION['name'] = $row['User_Name'];
			$_SESSION['number'] = $row['User_Number'];
			$_SESSION['address'] = $row['User_Address'];
			$_SESSION['position'] = $row['User_Position'];
			$id = $row['ID'];
		}
		//load employment history 

		$stmt = $DBH->prepare("select Start, End, Job_History FROM Resume_History where idResume_History = ?");	
		$stmt->bindValue(1, $id);	
		$stmt->execute();

		$result = $stmt->fetchAll(); 
		//clear old values
		unset($_SESSION['beg']);
		unset($_SESSION['end']);
		unset($_SESSION['job']);

		$beg = array();
		$end = array();
		$job = array(); 

		//push new values
		foreach($result as $row)
		{
			array_push($beg, $row['Start']);
			array_push($end, $row['End']);
			array_push($job, $row['Job_History']);
		}

		//set values
		$_SESSION['beg'] = $beg;
		$_SESSION['end'] = $end;
		$_SESSION['job'] = $job;
	}
		
	catch (PDOException $e) {

	}
}

//loads all clients
function clientTable()
{
	$DBH = openDBConnection();
	$stmt = $DBH->prepare("select loginName, Real_Name, User_Role from User_Role");
	$stmt->execute();

	$result = $stmt-> fetchAll(); 
	$returnString =""; 
	$count = 0; 
	foreach ($result as $row) {
		$returnString = $returnString."<li>"."<b>Login Name:</b>".$row['loginName']."  <b>Real Name:</b>".$row['Real_Name']." <b>User Role:</b>".$row['User_Role']."<a href='?delete=".$row['loginName']." 'class='btn'>Delete</a><a href='?modify=".$row['loginName']." 'class='btn'>Modify</a></li>";
	}

	return $returnString; 

}
// Loads values into temporary Session variables for easy access 
function loadResumeView ($ResumeName, $userName) {
	try
	 {
	 	$id = "";
		$DBH = openDBConnection();
		$stmt = $DBH->prepare("select User_Name, User_Number, User_Address, User_Position, ID from Resume_Info where Resume_Name=? and User_loginName=?");
		$stmt->bindValue(1, $ResumeName);
		$stmt->bindValue(2, $userName);
		$stmt->execute();
		//load personal values
		if ($row = $stmt->fetch()) 
		{
			$_SESSION['name1'] = $row['User_Name'];
			$_SESSION['number1'] = $row['User_Number'];
			$_SESSION['address1'] = $row['User_Address'];
			$_SESSION['position1'] = $row['User_Position'];
			$id = $row['ID'];
		}
		else
		{
			header("Location: /~matelau/cs4540/ps5/error.php");
		}
			
		//load employment history 

		$stmt = $DBH->prepare("select Start, End, Job_History FROM Resume_History where idResume_History = ?");	
		$stmt->bindValue(1, $id);	
		$stmt->execute();

		$result = $stmt->fetchAll(); 

		unset($_SESSION['beg1']);
		unset($_SESSION['end1']);
		unset($_SESSION['job1']);

		$beg = array();
		$end = array();
		$job = array(); 

		foreach($result as $row)
		{
			 array_push($beg, $row['Start']);
			 array_push($end, $row['End']);
			 array_push($job, $row['Job_History']);
		}

		$_SESSION['beg1'] = $beg;
		$_SESSION['end1'] = $end;
		$_SESSION['job1'] = $job;
	}
		
	catch (PDOException $e) {

	}

}


?>