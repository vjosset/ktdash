<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

Utils::SetApiHeaders();
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");

switch ($_SERVER['REQUEST_METHOD']) {
	case "POST":
		// Update user's password
		POSTUserPassword();
		break;
	default:
		// Invalid verb
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		break;
}

function POSTUserPassword()
{
	// Check that the user is currently logged in
	if (!Session::IsAuth()) {
		// Not logged in - Return error				
		header('HTTP/1.0 401 Unauthorized - You are not logged in"');
		die();
	}

	global $dbcon;
	
	// Get the current user
	$u = Session::CurrentUser();
	$password = getIfSet($_REQUEST['password'], '');

	if (strlen($password) > 50 || strlen($password) < 4) {
		header('HTTP/1.0 400 Invalid Password');
		die();
	}

	$u->passhash = password_hash($password, PASSWORD_DEFAULT);

	$sql = "UPDATE User SET passhash = ? WHERE userid = ?;";
	$paramtypes = "ss";
	$params = array();
	$params[] =& $paramtypes;
	$params[] =& $u->passhash;
	$params[] =& $u->userid;

	$cmd = $dbcon->prepare($sql);
	call_user_func_array(array($cmd, "bind_param"), $params);
	if (!$cmd->execute()) {
		// Failed to reset the password
		echo "Could not reset password";
		header('HTTP/1.0 500 Could not reset password');
		die();
	}

	Utils::TrackEvent(
		'session',
		'resetpassword',
		'',
		'',
		'',
		'',
		$_SERVER['HTTP_REFERER'],
		'',
		$_SERVER['HTTP_REFERER']
	);

	// Remove the password from the object before we return it
	unset($u->passhash);

	// Done
	echo $u->toJson();
}
