<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class Weapon extends \OFW\OFWObject {
		public $factionid = "";
		public $killteamid = "";
		public $fireteamid = "";
		public $opid = "";
        public $wepid = "";
		public $wepseq = 0;
        public $wepname = "";
		public $weptype = "";
		
		public $profiles = [];
        
        function __construct() {
            $this->TableName = "Weapon";
            $this->Keys = ["factionid", "killteamid", "fireteamid", "opid", "wepid"];
			$this->skipfields = ["profiles"];
        }
		
		public function GetWeapon($weaponid) {
			global $dbcon;
			
			//Get the current user id
			$weapon = Weapon::FromDB($weaponid);
			
			// Done
			return $weapon;
		}
		
		public function GetWeapons() {
			global $dbcon;
			
			$sql = "SELECT * FROM Weapon;";
			
			$cmd = $dbcon->prepare($sql);
			if (!$cmd) {
				//There was an error preparing the SQL statement
				echo "Error preparing SQL: " . $dbcon->error;
			}
			
			//Run the query
			if (!$cmd->execute()) {
				//There was an error running the SQL statement
				echo "Error running SQL: " . $dbcon->error;
			}

			$weapons = [];

			//Parse the result
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					$weapon = Weapon::FromRow($row);
					
					// Add this weapon to the output
					$weapons[] = $weapon;
				}
			}
			
			// Done - Return our array of weapons
			return $weapons;
		}
		
		function loadWeaponProfiles() {
            global $dbcon;
			
			// Get the profiles for this weapon
			$sql = "SELECT * FROM WeaponProfile WHERE factionid = ? AND killteamid = ? AND fireteamid = ? AND opid = ? AND wepid = ?";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "sssss";
			
			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $this->factionid;
			$params[] =& $this->killteamid;
			$params[] =& $this->fireteamid;
			$params[] =& $this->opid;
			$params[] =& $this->wepid;
			
			// Load the operative
            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                while ($wprow = $result->fetch_object()) {
					// Got a weapon profile
					$pro = WeaponProfile::FromRow($wprow);
					$this->profiles[] = $pro;
				}
			}
		}
	}
?>