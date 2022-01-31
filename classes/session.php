<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    use OFW;
    
    class Session extends \OFW\OFWObject {
        public $sessionid = "";
        public $playerid = "";
		public $lastactivity = "";
		
		const CookieID = "asid";
		const CookieSeparator = "|";
		const CookieExpiration = 2 * 24 * 60 * 60;
        
        function __construct() {
            $this->TableName = "Session";
            $this->Keys = ["sessionid"];
        }
		
		public function Login($username, $password) {
            Session::Logout();
            global $dbcon;

            //Hash the passed-in password
            $passhash = hash('sha256', $password);

            //Check for a match for email and password
            $sql = "SELECT * FROM Player WHERE playername = ? AND passhash = ?;";

            $paramtypes = "ss";
            $params = array();
            $params[] =& $paramtypes;
            $params[] =& $username;
            $params[] =& $passhash;

            $cmd = $dbcon->prepare($sql);
            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            $player = null;
            if ($result = $cmd->get_result()) {
                if ($row = $result->fetch_object()) {
					//Get the player object
                    $player = Player::FromRow($row);

                    //Clear the passhash from the player
                    unset($player->passhash);
                    
                    //Set the session
					$session = new Session();
					$session->sessionid = CommonUtils\shortId();
					$session->playerid = $player->playerid;
					$session->lastactivity = CommonUtils\Now();
					
					//Save to DB
					$session->DBSave();
					
					//Set the cookie
					setcookie(
						'asid',
						$session->sessionid . self::CookieSeparator . $session->playerid,
						time() + (self::CookieExpiration),
						'/',
						'ktdash.app',
						true, // TLS-only
						true  // http-only
					);
					
					$_COOKIE['asid'] = $session->sessionid . self::CookieSeparator . $session->playerid;
                }
            }

            //Done - Will return null if authentication failed
            return $player;
        }

        public function Logout() {
			if (empty($_COOKIE[self::CookieID])) {
				//Session ID is not set - Not logged in
			} else {
				//Delete this session
				//Get the session ID and user ID from the cookie
				list($sessionid, $playerid) = explode(self::CookieSeparator, $_COOKIE[self::CookieID]);
				
				//Check the DB for the specified session ID
				$session = Session::FromDB($sessionid);
				
				if ($session == null) {
					//Session not found
				} else {
					//Delete this session
					$session->DBDelete();
				}
				
				//Delete the cookie
				setcookie(
					'asid',
					'',
					time() - (60 * 60),
					'/',
					'ktdash.app',
					true, // TLS-only
					true  // http-only
				);
				$_COOKIE['asid'] = '';
			}
        }

        public function IsAuth() {
            return Session::CurrentPlayer() != null;
        }

        public function CurrentPlayer() {
			if (empty($_COOKIE[self::CookieID])) {
				// Session ID is not set - Not logged in
				Session::Logout();
				return null;
			}
			
			// Get the session ID and player ID from the cookie
			list($sessionid, $playerid) = explode(self::CookieSeparator, $_COOKIE[self::CookieID]);
			
			// Check the DB for the specified session ID
			$session = Session::FromDB($sessionid);
			
			if ($session == null || $session->playerid != $playerid) {
				// Session not found or mismatch between player ID and session ID
				Session::Logout();
				return null;
			}
			
			// Get the player for this session ID
			$player = Player::FromDB($session->playerid);

			// Clear the email and passhash from the player
			unset($player->passhash);
			
			// Update the lastactivity on this session
			$session->lastactivity = CommonUtils\Now();
			$session->DBSave();
			
			// Load this player's teams
			$player->loadPlayerTeams();
			
			// Update the cookie expiration
			// Set the cookie
			setcookie(
				'asid',
				$session->sessionid . self::CookieSeparator . $session->playerid,
				time() + (self::CookieExpiration),
				'/',
				'ktdash.app',
				true, // TLS-only
				true  // http-only
			);
			
			// Done
			return $player;
        }
	}
?>