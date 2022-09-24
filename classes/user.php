<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    use OFW;
    
    class User extends \OFW\OFWObject {
        public $userid = "";
        public $username = "";
		public $userteams = [];
        
        function __construct() {
            $this->TableName = "User";
            $this->Keys = ["userid"];
			$this->skipfields = ["userteams"];
        }
        
        public function __get($field) {
            switch( $field ) {
                default:
                    throw new Exception('Invalid property: ' . $field);
            }
        }

        public function NewUser($n, $p) {
            // Check if there is a user with this name
            if (User::FromName($n)) {
                // There is a user with that name already
                header('HTTP/1.0 500 Server Error - UserName already taken');
                die("UserName already taken!");
            }

            $instance = new self();
            $instance->userid = CommonUtils\shortId();
            $instance->username = $n;
            $instance->passhash = hash('sha256', $p);

            $instance->DBSave();

            // Done
            return $instance;
        }

        public function FromName($username) {
            global $dbcon;
            // Get the user with the specified username
            $sql = "SELECT * FROM User WHERE username = ?";

            $cmd = $dbcon->prepare($sql);

            $paramtypes = "s";

            $params = array();
            $params[] =& $paramtypes;
            $params[] =& $username;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                if ($row = $result->fetch_object()) {
                    $u = User::FromRow($row);
                    return $u;
                }
            }

            // User not found
            return null;
        }
		
		/* GetUserTeams()
		** Returns an array of all the teams for the current user
		*/
		public function loadUserTeams() {
			global $dbcon;
			
			// Get the teams for this user
			$sql = "SELECT * FROM UserTeam WHERE userid = ? ORDER BY seq";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "s";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $this->userid;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                while ($row = $result->fetch_object()) {
					$ut = UserTeam::FromRow($row);
					$ut->loadOperatives();
					$this->userteams[] = $ut;
                }
            }
		}
	}
?>
