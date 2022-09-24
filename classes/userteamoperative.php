<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class UserTeamOperative extends \OFW\OFWObject {
		public $userteamid = "";
		public $userid = "";
		public $userteamopid = "";
		public $seq = 0;
		public $opname = "";
		public $factionid = "";
		public $killteamid = "";
		public $opid = "";
		public $wepids = "";
		public $eqids = "";
		public $currw = 0;
		public $notes = "";
		public $weapons = [];
		public $equipments = [];
        
        function __construct() {
            $this->TableName = "UserTeamOperative";
            $this->Keys = ["userteamopid"];
			$this->skipfields = ["weapons", "equipments"];
        }
		
		public function GetUserTeamOperative($utoid) {
			global $dbcon;
			
			//Get the requested UserTeamOperative
			$uto = UserTeamOperative::FromDB($utoid);
			
			// Load this operative's weapons and equipments
			$uto->loadWeapons();
			$uto->loadEquipments();
			
			return $uto;
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
			// [TBD]
		}
		
		/* COMMENTED OUT - UI SHOULD DO THIS WITH "PUTS" FOR THE USERTEAMOPERATIVES
		public function move($inc) {
			global $dbcon;
			
			if ($inc == 1) {
				// Moving down (higher seq)
				$sql = "SELECT MAX(seq) AS maxseq FROM UserTeamOperative WHERE userteamid = ?;";
				
				$cmd = $dbcon->prepare($sql);
				$paramtypes = "s";
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $this->userteamid;

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
					$sql  = "UPDATE UserTeamOperative SET seq = seq + 101 WHERE userteamid = ? AND seq = ?;";
					$sql .= "UPDATE UserTeamOperative SEQ seq = seq -   1 WHERE userteamid = ? AND Seq = ?;";
					$sql .= "UPDATE UserTeamOperative SET seq = seq - 100 WHERE userteamid = ? AND seq = ?;";
					
					$cmd = $dbcon->prepare($sql);
					$paramtypes = "sssss";
					$params = array();
					$params[] =& $paramtypes;
					$params[] =& $this->userteamid;
					$params[] =& $this->seq;
					$params[] =& $this->userteamid;
					$params[] =& $this->seq - 1;
					$params[] =& $this->userteamid;
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
					$sql  = "UPDATE UserTeamOperative SET seq = seq +  99 WHERE userteamid = ? AND seq = ?;";
					$sql .= "UPDATE UserTeamOperative SEQ seq = seq +   1 WHERE userteamid = ? AND Seq = ?;";
					$sql .= "UPDATE UserTeamOperative SET seq = seq - 100 WHERE userteamid = ? AND seq = ?;";
					
					$cmd = $dbcon->prepare($sql);
					$paramtypes = "sssss";
					$params = array();
					$params[] =& $paramtypes;
					$params[] =& $this->userteamid;
					$params[] =& $this->seq;
					$params[] =& $this->userteamid;
					$params[] =& $this->seq + 1;
					$params[] =& $this->userteamid;
					$params[] =& $this->seq + 99;

					call_user_func_array(array($cmd, "bind_param"), $params);
					$cmd->execute();
				}
			}			
		}
		*/
	}
?>