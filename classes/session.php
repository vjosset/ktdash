<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';

class Session extends \OFW\OFWObject
{
	public $sessionid = "";
	public $userid = "";
	public $lastactivity = "";

	const CookieID = "asid";
	const CookieSeparator = "|";
	const CookieExpiration = 7 * 24 * 60 * 60;

	function __construct()
	{
		$this->TableName = "Session";
		$this->Keys = ["sessionid"];
	}

	public static function Login($username, $password)
	{
		Session::Logout();
		global $dbcon;

		// Hash the passed-in password
		$passhash = hash('sha256', $password);

		// Check for a match for email and password
		$sql = "SELECT * FROM User WHERE username = ?;";

		$paramtypes = "s";
		$params = array();
		$params[] =& $paramtypes;
		$params[] =& $username;

		$cmd = $dbcon->prepare($sql);
		call_user_func_array(array($cmd, "bind_param"), $params);
		if (!$cmd->execute()) {
			// Log in failed - Do nothing (user will remain null)
		}

		$user = null;
		if ($result = $cmd->get_result()) {
			if ($row = $result->fetch_object()) {
				// Get the user object
				$user = User::FromRow($row);

				// Check the password
				if ($user->passhash == $passhash) {
					// Password is correct, but is using old sha256 (unsafe)
					// We need to update the password to a properly salted and hashed value
					$user->passhash = password_hash($password, PASSWORD_DEFAULT);
					$sql = "UPDATE User SET passhash = ? WHERE userid = ?;";
					$paramtypes = "ss";
					$params = array();
					$params[] =& $paramtypes;
					$params[] =& $user->passhash;
					$params[] =& $user->userid;

					$cmd = $dbcon->prepare($sql);
					call_user_func_array(array($cmd, "bind_param"), $params);
					if (!$cmd->execute()) {
						// Failed to update the password
						echo "Could not rehash password";
					}
				}

				// Now validate the password
				if (!password_verify($password, $user->passhash)) {
					// Incorrect password
					$user = null;
				} else {
					// Clear the passhash from the user
					unset($user->passhash);

					// Set the session
					$session = new Session();
					$session->sessionid = CommonUtils\shortId();
					$session->userid = $user->userid;
					$session->lastactivity = CommonUtils\Now();

					// Save to DB
					$session->DBSave();

					$cookie_options = array(
						'expires' => time() + (self::CookieExpiration),
						'path' => '/',
						'domain' => 'ktdash.app',
						'secure' => true,
						'httponly' => true,
						'samesite' => 'None'
					);
					setcookie(self::CookieID, $session->sessionid . self::CookieSeparator . $session->userid, $cookie_options);

					$_COOKIE[self::CookieID] = $session->sessionid . self::CookieSeparator . $session->userid;
				}
			}
		}

		// Done - Will return null if authentication failed
		return $user;
	}

	public static function Logout()
	{
		if (empty($_COOKIE[self::CookieID])) {
			// Session ID is not set - Not logged in
		} else {
			// Delete this session
			// Get the session ID and user ID from the cookie
			list($sessionid, $userid) = explode(self::CookieSeparator, $_COOKIE[self::CookieID]);

			// Check the DB for the specified session ID
			$session = Session::FromDB($sessionid);

			if ($session == null) {
				// Session not found
			} else {
				// Delete this session
				$session->DBDelete();
			}

			// Delete the cookie
			//setcookie(
			//	'asid',
			//	'',
			//	time() - (60 * 60),
			//	'/',
			//	'ktdash.app',
			//	true, // TLS-only
			//	true  // http-only
			//);

			$cookie_options = array(
				'expires' => 1,
				'path' => '/',
				'domain' => 'ktdash.app',
				'secure' => true,
				'httponly' => true,
				'samesite' => 'None'
			);
			setcookie(self::CookieID, self::CookieSeparator, $cookie_options);
			$_COOKIE[self::CookieID] = '';
		}
	}

	public static function IsAuth()
	{
		return Session::CurrentUser() != null;
	}

	public static function CurrentUser()
	{
		if (empty($_COOKIE[self::CookieID])) {
			// Session ID is not set - Not logged in
			Session::Logout();
			return null;
		}

		// Get the session ID and user ID from the cookie
		list($sessionid, $userid) = explode(self::CookieSeparator, $_COOKIE[self::CookieID]);

		// Check the DB for the specified session ID
		$session = Session::FromDB($sessionid);

		if ($session == null || $session->userid != $userid) {
			// Session not found or mismatch between user ID and session ID
			Session::Logout();
			return null;
		}

		// Get the user for this session ID
		$user = User::FromDB($session->userid);

		// Clear the email and passhash from the user
		unset($user->email);
		unset($user->passhash);

		// Update the lastactivity on this session
		$session->lastactivity = CommonUtils\Now();
		$session->DBSave();

		// Update the cookie expiration
		// Set the cookie
		//setcookie(
		//	'asid',
		//	$session->sessionid . self::CookieSeparator . $session->userid,
		//	time() + (self::CookieExpiration),
		//	'/',
		//	'ktdash.app',
		//	true, // TLS-only
		//	true  // http-only
		//);

		$cookie_options = array(
			'expires' => time() + (self::CookieExpiration),
			'path' => '/',
			'domain' => 'ktdash.app',
			'secure' => true,
			'httponly' => true,
			'samesite' => 'None'
		);
		setcookie(self::CookieID, $session->sessionid . self::CookieSeparator . $session->userid, $cookie_options);

		// Done
		return $user;
	}
}
