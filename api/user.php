<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    header('Content-Type: application/json');
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			// Get the requested user
			GETUser();
			break;
		case "POST":
			// Create a new user
			POSTUser();
			break;
        default:
            // Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
            break;
    }

	function GETUser() {
		$myuser = null;
		
		if (Session::IsAuth()) {
			// User is authenticated
			$myuser = Session::CurrentUser();
		}
		
		// Get the requested user id
		$username = urldecode($_REQUEST['username']);
		
		if ($username == null) {
			header("HTTP/1.0 404 Not Found - The user you requested was not found");
		}
		
		$user = User::FromName($username);
		if ($user == null) {
			header("HTTP/1.0 404 Not Found - The user you requested was not found");
		}
		
		// Get the userid for the specified username
		$userid = $user->userid;
		$myuserid = $myuser->userid;
		
		// If no user id was passed in, assume my user id
		if ($userid == null) {
			header("HTTP/1.0 404 Not Found - The user you requested was not found");
		}
		
		// Validate the user ID
		if (!CommonUtils\isValidId($userid)) {
			// User doesn't exist, return 404
			header("HTTP/1.0 404 Not Found - The user you requested was not found");
		} else {
			// Get the user
			if ($userid != $myuserid) {
				$u = User::FromDB($userid);
			} else {
				$u = $myuser;
			}
			
			// Check if this user actually exists
			if ($u == null) {
				// User doesn't exist, return 404
				header("HTTP/1.0 404  Not Found - The user you requested was not found");
			} else {
				// User exists, clean up the output and spit it out
				// Remove the passhash from the output
				unset($u->passhash);
				
				// Output the user
				echo $u->toJson();
			}
		}
	}

	function POSTUser() {
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$confirmpassword = $_REQUEST['confirmpassword'];

		if ($confirmpassword != $password) {
            header('HTTP/1.0 500 Passwords do not match');
            die();
		}
		
		if (strpos($username, "@")) {
            header('HTTP/1.0 500 Please do not use an email address as your user name');
            die();
		}

		// Create a new user
		User::NewUser($username, $password);

		// Sign this user in
		$u = Session::Login($_REQUEST['username'], $_REQUEST['password']);

		// Done
		echo $u->toJson();
	}
?>
