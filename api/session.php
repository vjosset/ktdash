<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

Utils::SetApiHeaders();
header("Access-Control-Allow-Methods: OPTIONS, GET, POST, DELETE");

switch ($_SERVER['REQUEST_METHOD']) {
	case "GET":
		// Get the current session
		GETSession();
		break;
	case "POST":
		// Log the user in
		$username = getIfSet($_REQUEST['username']);
		$password = getIfSet($_REQUEST['password']);

		if (strlen($username) > 50 || strlen($password) > 50) {
			sleep(3);
			header('HTTP/1.0 400 Invalid Input');
			die();
		}

		$u = Session::Login($username, $password);
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
	case "OPTIONS":
		echo "";
		break;
	default:
		// Invalid verb
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function GETSession()
{
	$myuser = null;
	if (Session::IsAuth()) {
		// User is authenticated, get their user record
		$myuser = Session::CurrentUser();
		echo $myuser->toJson();
	} else {
		// User is not authenticated
		header('HTTP/1.0 401 Not logged in');
		die();
	}
}
