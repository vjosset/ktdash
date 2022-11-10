<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    header('Content-Type: application/json');
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			// Get the current session
			GETSession();
			break;
		case "POST":
			// Log the user in
			$u = Session::Login($_REQUEST['username'], $_REQUEST['password']);
			if ($u == null) {
				// Could not log in
				// Wait a little bit to thwart brute-force login attempts
				sleep(3);
				header('HTTP/1.0 401 Invalid user name or password');
				die();
			} else {
				// Logged in - Return the current user
				GETSession();
			}
			break;
		case "DELETE":
			// Log the user out
			Session::Logout();
			echo "{ \"success\": \"OK\" }";
			break;
        default:
            // Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

	function GETSession() {
		$myuser = null;
		if (Session::IsAuth()) {
			// User is authenticated, get their feed
			$myuser = Session::CurrentUser();
			//$myuser->loadRosters();
			echo $myuser->toJson();
		} else {
			// User is not authenticated
            header('HTTP/1.0 401 Not logged in');
            die();
		}
	}
?>
