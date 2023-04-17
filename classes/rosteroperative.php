<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class RosterOperative extends \OFW\OFWObject {
		public $rosterid = "";
		public $userid = "";
		public $rosteropid = "";
		public $seq = 0;
		public $opname = "";
		public $hascustomportrait = 0;
		
		public $factionid = "";
		public $killteamid = "";
		public $fireteamid = "";
		public $opid = "";
		
		public $wepids = "";
		public $eqids = "";
		
		public $curW = 0;
		public $activated = 0;
		public $hidden = 0;
		public $notes = "";
		
		public $baseoperative = null;
		public $weapons = [];
		public $equipments = [];
        
        function __construct() {
            $this->TableName = "RosterOperative";
            $this->Keys = ["rosteropid"];
			$this->skipfields = [
				"baseoperative", "weapons", "equipments",
				"M", "APL", "GA", "DF", "SV", "W",
				"username", "rostername", "factionname", "optype",
				"killteamname", "fireteamname", "killteam", "fireteam",
				"archetype",
				"isInjured","isinjured",
				"keywords", "abilities", "uniqueactions",
				"timestamp", "usedefaultportrait"
			];
        }
		
		public function GetRosterOperative($roid) {
			//Get the requested RosterOperative
			$op = RosterOperative::GetRosterOperativeRow($roid);
			
			if ($op == null) {
				// Not found
				return null;
			}
			
			// Load the base operative for this RosterOperative
			$op->loadBaseOperative();
			
			// Load the operative's weapons and equipments
			$op->loadWeapons();
			$op->loadEquipments();
			
			// Done
			return $op;
		}
		
		public function GetRosterOperativeRow($roid) {
			//Get the requested RosterOperative
			global $dbcon;
			$sql = "SELECT * FROM RosterOperativeView WHERE rosteropid = ? ORDER BY seq";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "s";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $roid;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

			$op = null;
            if ($result = $cmd->get_result()) {
                while ($row = $result->fetch_object()) {
                    $op = RosterOperative::FromRow($row);
                }
            }
			
			// Done
			return $op;
		}
		
		public function loadBaseOperative() {
			// Load this RosterOperative base operative
			$this->baseoperative = Operative::GetOperative($this->factionid, $this->killteamid, $this->fireteamid, $this->opid);
			$this->abilities = $this->baseoperative->abilities;
			$this->uniqueactions = $this->baseoperative->uniqueactions;
		}
		
		public function loadWeapons() {
			global $dbcon;
			
			// Get the weapons for this operative
			$sql = "SELECT * FROM Weapon WHERE factionid = ? AND killteamid = ? AND fireteamid = ? AND opid = ? AND CONCAT(',', ?, ',') LIKE CONCAT('%,', wepid, ',%') ORDER BY wepseq, weptype DESC";
			
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "sssss";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $this->factionid;
            $params[] =& $this->killteamid;
            $params[] =& $this->fireteamid;
            $params[] =& $this->opid;
            $params[] =& $this->wepids;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                while ($row = $result->fetch_object()) {
                    $wep = Weapon::FromRow($row);
					$wep->loadWeaponProfiles();
					$this->weapons[] = $wep;
                }
            }
		}
		
		public function loadEquipments() {
			global $dbcon;
			
			// Get the equipments for this operative
			$sql = "SELECT * FROM Equipment WHERE ((factionid = ? AND killteamid = ?) OR (factionid = 'ALL' AND killteamid = 'ALL')) AND CONCAT(',', ?, ',') LIKE CONCAT('%,', eqid, ',%') ORDER BY eqseq";
			
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "sss";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $this->factionid;
            $params[] =& $this->killteamid;
            $params[] =& $this->eqids;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();
			
			$this->equipments = [];

            if ($result = $cmd->get_result()) {
                while ($row = $result->fetch_object()) {
                    $eq = Equipment::FromRow($row);
					
					// Get the sub-info if it's a weapon
					if (strpos($eq->eqtype, 'Weapon') !== false) {
						$eq->weapon = Weapon::FromDB($eq->factionid, $eq->killteamid, 'EQ', 'EQ', $eq->eqid);
						if ($eq->weapon != null) {
							$eq->weapon->loadWeaponProfiles();
						}
					}
					
					$this->equipments[] = $eq;
                }
            }
		}
	}
?>