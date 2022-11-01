<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class User extends \OFW\OFWObject {
        public $userid = "";
        public $username = "";
		public $rosters = [];
        
        function __construct() {
            $this->TableName = "User";
            $this->Keys = ["userid"];
			$this->skipfields = ["rosters"];
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
            $instance->userid = CommonUtils\shortId(5);
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
		
		public function loadRosters() {
			global $dbcon;
			
			// Get the teams for this user
			$sql = "SELECT * FROM RosterView WHERE userid = ? ORDER BY seq";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "s";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $this->userid;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                while ($row = $result->fetch_object()) {
					$ut = Roster::FromRow($row);
					$ut->loadOperatives();
					$ut->loadKillTeam();
					$this->rosters[] = $ut;
                }
            }
		}
		
		public function reorderRosters() {
			global $dbcon;
			
			// Always put new rosters first, pushing all other rosters down
			// First, reorder the user's rosters starting at 0 (row_number() starts at 1 so we use "- 1")
			$sql =
				"UPDATE
					Roster AS R
				  JOIN
					( SELECT rosterid, row_number() OVER (PARTITION BY userid ORDER BY seq) AS rownum
					  FROM Roster
					  WHERE userid = ?
					) AS S
				  ON  S.rosterid = R.rosterid
				SET
					R.seq = S.rownum - 1 
				WHERE R.userid = ?;";
			
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "ss";
			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $this->userid;
			$params[] =& $this->userid;

			call_user_func_array(array($cmd, "bind_param"), $params);
			$cmd->execute();
		}
	}
?>
