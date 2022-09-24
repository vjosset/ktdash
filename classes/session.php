<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    use OFW;
    
    class Session extends \OFW\OFWObject {
        public $sessionid = "";
        public $userid = "";
		public $lastactivity = "";
		
		const CookieID = "asid";
		const CookieSeparator = "|";
		const CookieExpiration = 7 * 24 * 60 * 60;
        
        function __construct() {
            $this->TableName = "Session";
            $this->Keys = ["sessionid"];
        }
		
		public function Login($username, $password) {
            \CommonUtils\debug("    Session:LogIn()");
			
            Session::Logout();
            global $dbcon;
			
            // Hash the passed-in password
            $passhash = hash('sha256', $password);

            // Check for a match for email and password
            $sql = "SELECT * FROM User WHERE username = ? AND passhash = ?;";
            \CommonUtils\debug("    $sql");
            \CommonUtils\debug("    $username");
            \CommonUtils\debug("    $passhash");

            $paramtypes = "ss";
            $params = array();
            $params[] =& $paramtypes;
            $params[] =& $username;
            $params[] =& $passhash;

            $cmd = $dbcon->prepare($sql);
            call_user_func_array(array($cmd, "bind_param"), $params);
            if (!$cmd->execute()) {
				// Log in failed
				\CommonUtils\debug("    Login Failed");
			}

            $user = null;
            if ($result = $cmd->get_result()) {
				\CommonUtils\debug("    Got Result");
				
				\CommonUtils\debug("    Result: " . json_encode($result));
                if ($row = $result->fetch_object()) {
					\CommonUtils\debug("    Fetched object");
					// Get the user object
                    $user = User::FromRow($row);
					
					\CommonUtils\debug("    Got user " . $user->username);

                    // Clear the passhash from the user
                    unset($user->passhash);
                    
                    // Set the session
					$session = new Session();
					$session->sessionid = CommonUtils\shortId();
					$session->userid = $user->userid;
					$session->lastactivity = CommonUtils\Now();
					
					// Save to DB
					\CommonUtils\debug("    Committing Session");
					$session->DBSave();
					
					// Set the cookie
					setcookie(
						'asid',
						$session->sessionid . self::CookieSeparator . $session->userid,
						time() + (self::CookieExpiration),
						'/',
						'ktdash.app',
						true, // TLS-only
						true  // http-only
					);
					
					$_COOKIE['asid'] = $session->sessionid . self::CookieSeparator . $session->userid;
                }
            }

            // Done - Will return null if authentication failed
            return $user;
        }

        public function Logout() {
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
				setcookie(
					'asid',
					'',
					time() - (60 * 60),
					'/',
					'killteam.vjosset.comkillteam.vjosset.com',
					true, // TLS-only
					true  // http-only
				);
				$_COOKIE['asid'] = '';
			}
        }

        public function IsAuth() {
            return Session::CurrentUser() != null;
        }

        public function CurrentUser() {
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
			setcookie(
				'asid',
				$session->sessionid . self::CookieSeparator . $session->userid,
				time() + (self::CookieExpiration),
				'/',
				'ktdash.app',
				true, // TLS-only
				true  // http-only
			);
			
			// Done
			return $user;
        }
	}
?>