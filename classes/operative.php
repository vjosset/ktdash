<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class Operative extends \OFW\OFWObject {
		public $factionid = "";
        public $killteamid = "";
		public $fireteamid = "";
        public $opid = "";
		public $opseq = 0;
		public $opname = "";
		public $description = "";
		public $M = "";
		public $APL = "";
		public $GA = "";
		public $DF = "";
		public $SV = "";
		public $W = "";
		public $keywords = "";
		
		public $weapons = [];
		public $uniqueactions = [];
		public $abilities = [];
        
        function __construct() {
            $this->TableName = "Operative";
            $this->Keys = ["factionid", "killteamid", "fireteamid", "opid"];
			$this->skipfields = ["weapons", "uniqueactions", "abilities"];
        }
		
		function GetOperative($faid, $ktid, $ftid, $opid) {
			$op = Operative::FromDB($faid, $ktid, $ftid, $opid);
			$op->loadAbilities();
			$op->loadUniqueActions();
			$op->loadWeapons();
			
			// Done
			return $op;
		}
		
		public function loadWeapons() {
			$this->weapons = [];
			
			global $dbcon;
			
			$sql = "SELECT W.*, WP.profileid, W.weptype, WP.name, WP.A, WP.BS, WP.D, WP.A, WP.SR, W.isdefault FROM Weapon W INNER JOIN WeaponProfile WP ON WP.killteamid = W.killteamid AND WP.fireteamid = W.fireteamid AND W.opid = WP.opid AND WP.wepid = W.wepid WHERE W.factionid = ? AND W.killteamid = ? AND W.fireteamid = ? AND W.opid = ? ORDER BY W.wepseq, W.weptype DESC, W.wepname, WP.profileid;";
			
			$cmd = $dbcon->prepare($sql);
			if (!$cmd) {
				//There was an error preparing the SQL statement
				echo "Error preparing SQL: " . $dbcon->error;
			}
			
			//Set the parameters
			$cmd->bind_param('ssss', $this->factionid, $this->killteamid, $this->fireteamid, $this->opid);
			
			//Run the query
			if (!$cmd->execute()) {
				//There was an error running the SQL statement
				echo "Error running SQL: " . $dbcon->error;
			}
			
			//Parse the result
			$currwep = null;
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					if ($currwep == null || $currwep->wepid != $row->wepid) {
						// New weapon; not a new profile on the current weapon
						if ($currwep != null) {
							// Put the last weapon in the operative's arsenal
							$this->weapons[] = $currwep;
						}
						
						// Prepare a new weapon
						$currwep = new Weapon();
						$currwep->factionid = $row->factionid;
						$currwep->killteamid = $row->killteamid;
						$currwep->fireteamid = $row->fireteamid;
						$currwep->opid = $row->opid;
						$currwep->wepid = $row->wepid;
						$currwep->wepname = $row->wepname;
						$currwep->weptype = $row->weptype;
						$currwep->isdefault = $row->isdefault;
						$currwep->isselected = $row->isdefault == 1;
					}
					
					// Load the profile
					$pro = new WeaponProfile();
					$pro->factionid = $row->factionid;
					$pro->killteamid = $row->killteamid;
					$pro->fireteamid = $row->fireteamid;
					$pro->opid = $row->opid;
					$pro->wepid = $row->wepid;
					$pro->profileid = $row->profileid;
					$pro->name = $row->name;
					$pro->A = $row->A;
					$pro->BS = $row->BS;
					$pro->D = $row->D;
					$pro->SR = $row->SR;
					
					// Add this profile to the weapon
					$currwep->profiles[] = $pro;
				}
			}
			
			if ($currwep != null) {
				// Put the last weapon in the operative's arsenal
				$this->weapons[] = $currwep;
			}
		}
		
		public function loadAbilities() {
			$this->abilities = [];
			
			global $dbcon;
			
			$sql = "SELECT * FROM Ability WHERE factionid = ? AND killteamid = ? AND fireteamid = ? AND opid = ?";
			
			$cmd = $dbcon->prepare($sql);
			if (!$cmd) {
				//There was an error preparing the SQL statement
				echo "Error preparing SQL: " . $dbcon->error;
			}
			
			//Set the parameters
			$cmd->bind_param('ssss', $this->factionid, $this->killteamid, $this->fireteamid, $this->opid);
			
			//Run the query
			if (!$cmd->execute()) {
				//There was an error running the SQL statement
				echo "Error running SQL: " . $dbcon->error;
			}

			//Parse the result
			$currwep;
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					$ab = Ability::FromRow($row);
					$this->abilities[] = $ab;
				}
			}
		}
		
		public function loadUniqueActions() {
			$this->uniqueactions = [];
			
			global $dbcon;
			
			$sql = "SELECT * FROM UniqueAction WHERE factionid = ? AND killteamid = ? AND fireteamid = ? AND opid = ?";
			
			$cmd = $dbcon->prepare($sql);
			if (!$cmd) {
				//There was an error preparing the SQL statement
				echo "Error preparing SQL: " . $dbcon->error;
			}
			
			//Set the parameters
			$cmd->bind_param('ssss', $this->factionid, $this->killteamid, $this->fireteamid, $this->opid);
			
			//Run the query
			if (!$cmd->execute()) {
				//There was an error running the SQL statement
				echo "Error running SQL: " . $dbcon->error;
			}

			//Parse the result
			$currwep;
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					$ua = UniqueAction::FromRow($row);
					$this->uniqueactions[] = $ua;
				}
			}
		}
	}
?>