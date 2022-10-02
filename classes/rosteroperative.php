<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class RosterOperative extends \OFW\OFWObject {
		public $rosterid = "";
		public $userid = "";
		public $rosteropid = "";
		public $seq = 0;
		public $opname = "";
		
		public $factionid = "";
		public $killteamid = "";
		public $fireteamid = "";
		public $opid = "";
		
		public $wepids = "";
		public $eqids = "";
		
		public $curW = 0;
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
				"username", "rostername", "factionname", "killteamname", "fireteamname", "optype",
				"keywords", "abilities", "uniqueactions"
			];
        }
		
		public function GetRosterOperative($roid) {
			global $dbcon;
			
			//Get the requested RosterOperative
			$ro = RosterOperative::FromDB($roid);
			
			// Load the base operative for this RosterOperative
			$ro->loadBaseOperative();
			
			// Load this operative's weapons and equipments
			$ro->loadWeapons();
			$ro->loadEquipments();
			
			return $ro;
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
			$sql = "SELECT * FROM Weapon WHERE factionid = ? AND killteamid = ? AND fireteamid = ? AND opid = ? AND CONCAT(',', ?, ',') LIKE CONCAT('%,', wepid, ',%') ORDER BY wepseq";
			
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
                    $op = Weapon::FromRow($row);
					$op->loadWeaponProfiles();
					$this->weapons[] = $op;
                }
            }
		}
		
		public function loadEquipments() {
			global $dbcon;
			
			// Get the equipments for this operative
			$sql = "SELECT * FROM Equipment WHERE factionid = ? AND killteamid = ? AND CONCAT(',', ?, ',') LIKE CONCAT('%,', eqid, ',%') ORDER BY eqseq";
			
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
					$this->equipments[] = $eq;
                }
            }
		}
		
		/* COMMENTED OUT - UI SHOULD DO THIS WITH "PUTS" FOR THE USERTEAMOPERATIVES
		public function move($inc) {
			global $dbcon;
			
			if ($inc == 1) {
				// Moving down (higher seq)
				$sql = "SELECT MAX(seq) AS maxseq FROM RosterOperative WHERE rosterid = ?;";
				
				$cmd = $dbcon->prepare($sql);
				$paramtypes = "s";
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $this->rosterid;

				call_user_func_array(array($cmd, "bind_param"), $params);
				$cmd->execute();

				$maxseq = -1;
				if ($result = $cmd->get_result()) {
					if ($row = $result->fetch_object()) {
						$maxseq = $row->maxseq;
					}
				}
				
				if ($this->seq == $maxseq) {
					// Already last, nothing to move
				} else {
					// Not yet at the bottom (seq maxseq), swap seq with the following operative
					$sql  = "UPDATE RosterOperative SET seq = seq + 101 WHERE rosterid = ? AND seq = ?;";
					$sql .= "UPDATE RosterOperative SEQ seq = seq -   1 WHERE rosterid = ? AND Seq = ?;";
					$sql .= "UPDATE RosterOperative SET seq = seq - 100 WHERE rosterid = ? AND seq = ?;";
					
					$cmd = $dbcon->prepare($sql);
					$paramtypes = "sssss";
					$params = array();
					$params[] =& $paramtypes;
					$params[] =& $this->rosterid;
					$params[] =& $this->seq;
					$params[] =& $this->rosterid;
					$params[] =& $this->seq - 1;
					$params[] =& $this->rosterid;
					$params[] =& $this->seq + 101;

					call_user_func_array(array($cmd, "bind_param"), $params);
					$cmd->execute();
				}
			} else if ($inc == -1) {
				// Moving up (lower seq)
				if ($this->seq == 0) {
					// Already at the top (seq 0), nothing to do
				} else {
					// Not yet at the top (seq 0), swap seqs with previous operative
					$sql  = "UPDATE RosterOperative SET seq = seq +  99 WHERE rosterid = ? AND seq = ?;";
					$sql .= "UPDATE RosterOperative SEQ seq = seq +   1 WHERE rosterid = ? AND Seq = ?;";
					$sql .= "UPDATE RosterOperative SET seq = seq - 100 WHERE rosterid = ? AND seq = ?;";
					
					$cmd = $dbcon->prepare($sql);
					$paramtypes = "sssss";
					$params = array();
					$params[] =& $paramtypes;
					$params[] =& $this->rosterid;
					$params[] =& $this->seq;
					$params[] =& $this->rosterid;
					$params[] =& $this->seq + 1;
					$params[] =& $this->rosterid;
					$params[] =& $this->seq + 99;

					call_user_func_array(array($cmd, "bind_param"), $params);
					$cmd->execute();
				}
			}			
		}
		*/
	}
?>