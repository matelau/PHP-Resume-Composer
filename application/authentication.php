<?php

// Changes the session ID
function changeSessionID () {
	$server = $_SERVER['SERVER_NAME'];
	$secure = usingHTTPS();
	setcookie("PHPSESSID", "", time()-3600, "/");
	session_set_cookie_params(0, "/", $server, $secure, true);
	session_regenerate_id(true);
}

// Reports if https is in use
function usingHTTPS () {
	return isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != "off");
}


// Redirects to HTTPS
function redirectToHTTPS()
{
	if(!usingHTTPS())
	{
		$redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header("Location:$redirect");
		exit();
	}
}

//if the users password matches - set proper session variables and change sessionID
function verifyLogin ($login , $pw) 
{
	try {
			$DBH = openDBConnection();
			$DBH->beginTransaction();
			
			// Get the information about the user.  This includes the
			// hashed password, which will be prefixed with the salt.
			$stmt = $DBH->prepare("select Real_Name, User_Role, PW from User_Role where loginName = ?");
			$stmt->bindValue(1, $login);
			$stmt->execute();

			// Was this a real user?
			if ($row = $stmt->fetch())
			 {				
				// Validate the password
				$hashedPassword = $row['PW'];

				//the password was correct 
				if (computeHash($pw, $hashedPassword) === $hashedPassword)
				{
					$_SESSION['real'] = htmlspecialchars($row['Real_Name']);
					$_SESSION['login'] = $login;			
					$_SESSION['authenticated'] = $row['User_Role'];

					return true; 
				}
				else
				{
					$message = "<div class='alert alert-error'>Username or password was wrong</div>";
					$_SESSION['error'] = $message; 
					return false; 
					
				}
			}
			else {
				$message = "<div class='alert alert-error'>Username or password was wrong</div>";
				$_SESSION['error'] = $message; 

				return false; 
				
			}
		}
		catch (PDOException $exception) 
		{
			return false; 
		}
		
		// We're logged in, so change session ID.  If the session ID was
		// stolen before we switched to HTTPS, it will do no good now.
		changeSessionID();


}

// Generates random salt for blowfish
function makeSalt () {
	$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
	return '$2a$12$' . $salt;
}

// Compute a hash using blowfish using the salt. 
function computeHash ($password, $salt) {
	return crypt($password, $salt);
}

?>