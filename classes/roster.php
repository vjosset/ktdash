<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class Roster extends \OFW\OFWObject {
		public $rosterid = "";
		public $userid = "";
		public $seq = 0;
		public $rostername = "";
		public $factionid = "";
		public $killteamid = "";
		public $ployids = "";
		public $tacopids = "";
		public $notes = "";
		public $operatives = [];
		public $tacops = [];
        
        function __construct() {
            $this->TableName = "Roster";
            $this->Keys = ["rosterid"];
			$this->skipfields = [
				"operatives","username","factionname","killteamname",
				"opList","oplist",
				"killteamdescription","archetype",
				"viewcount","importcount",
				"tacops"
			];
        }
		
		public function GetRoster($rid) {
			global $dbcon;
			global $perf;
			
			header("GetRoster1: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
			
			// Get the operatives for this team
			$sql = "SELECT * FROM RosterView WHERE rosterid = ? ORDER BY seq";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "s";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $rid;

            call_user_func_array(array($cmd, "bind_param"), $params);
			$perf .= floor(microtime(true) * 1000) . " - Roster::GetRoster()::RunSQL\r\n";
            $cmd->execute();

			header("GetRoster2: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
			$ops = [];
            if ($result = $cmd->get_result()) {
                if ($row = $result->fetch_object()) {
					$perf .= floor(microtime(true) * 1000) . " - Roster::GetRoster()::FromRow\r\n";
					header("GetRoster3: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
                    $r = Roster::FromRow($row);
					
					// Reorder operatives so their seqs are always sequential
					//$perf .= floor(microtime(true) * 1000) . " - Roster::GetRoster()::ReorderOperatives\r\n";
					//$r->reorderOperatives();
					
					// Now load the operatives
					$perf .= floor(microtime(true) * 1000) . " - Roster::GetRoster()::LoadOperatives\r\n";
					header("GetRoster4: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
					$r->loadOperatives();
			
					header("GetRoster5: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
					$r->loadTacOps();
					
					// Done
					header("GetRoster6: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
					return $r;
                }
            }
		}
		
		public function GetRosterRow($rid) {
			global $dbcon;
			
			// Get the operatives for this team
			$sql = "SELECT * FROM Roster WHERE rosterid = ? ORDER BY seq";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "s";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $rid;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

			$ops = [];
            if ($result = $cmd->get_result()) {
                if ($row = $result->fetch_object()) {
                    $r = Roster::FromRow($row);
					
					// Done
					return $r;
                }
            }
		}
		
		public function loadOperatives() {
			global $dbcon;
			
			header("LoadOps1: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
			// Get the operatives for this team
			$sql = "SELECT * FROM RosterOperativeView WHERE rosterid = ? ORDER BY seq";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "s";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $this->rosterid;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

			header("LoadOps2: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
			$ops = [];
            if ($result = $cmd->get_result()) {
                while ($row = $result->fetch_object()) {
                    $op = RosterOperative::FromRow($row);
					
					// Load the base operative for this RosterOperative
					$op->loadBaseOperative();
					
					// Load the operative's weapons and equipments
					$op->loadWeapons();
					$op->loadEquipments();
					
					// Append the operative to this roster
					$this->operatives[] = $op;
                }
            }
			header("LoadOps3: " . date("H:i:s.") . substr(microtime(FALSE), 2, 3));
		}
		
		public function loadKillTeam() {
			// Don't load the whole thing, takes too long (especially for users with many rosters when they open dashboard)
			//	Only pull the base information about the kill team + its ploys and equipment
			$this->killteam = Killteam::FromDB($this->factionid, $this->killteamid);
			
			// Load the ploys
			$this->killteam->loadPloys();
			
			// Load the equipments
			$this->killteam->loadEquipments();
		}
		
		public function loadFaction() {
			// Don't load the whole thing, takes too long (especially for users with many rosters when they open dashboard)
			//	Only pull the base information about the kill team + its ploys and equipment
			$this->faction = Faction::FromDB($this->factionid);
		}
		
		public function loadTacOps() {
			// Load the TacOps for this roster
			// TBD: Bespoke TacOps
			//		OR T.archetype = CONCAT(A.factionid, '-', A.killteamid, '-', A.fireteamid)
			global $dbcon;
			$sql = "SELECT DISTINCT
						T.*,
						CASE WHEN CONCAT('/', R.tacopids, '/') LIKE CONCAT('%,', T.tacopid, ',%') THEN 1 ELSE 0 END AS active
					FROM
						TacOp T
						INNER JOIN
						(
							SELECT DISTINCT F.archetype, F.factionid, F.killteamid, F.fireteamid
							FROM RosterOperative RO
							INNER JOIN Fireteam F
								ON  F.fireteamid = RO.fireteamid
							WHERE rosterid = ?
						) A
							ON  CONCAT('/', A.archetype, '/') LIKE CONCAT('%/', T.archetype, '/%')
							OR T.tacopid LIKE CONCAT(A.factionid, '-', A.killteamid, '-', A.fireteamid, '-%')
						INNER JOIN Roster R
							ON  R.rosterid = ?
					ORDER BY T.tacopid, T.tacopseq;
					";
			
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "ss";
			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $this->rosterid;
			$params[] =& $this->rosterid;

			call_user_func_array(array($cmd, "bind_param"), $params);
			$cmd->execute();
			
            if ($result = $cmd->get_result()) {
                while ($row = $result->fetch_object()) {
                    $t = TacOp::FromRow($row);
					$this->tacops[] = $t;
                }
            }
		}
		
		public function reorderOperatives() {
			global $dbcon;
			
			$sql =
				"UPDATE
					RosterOperative AS RO
				  JOIN
					( SELECT rosteropid, row_number() OVER (PARTITION BY rosterid ORDER BY seq) AS rownum
					  FROM RosterOperative
					  WHERE rosterid = ?
					) AS S
				  ON  S.rosteropid = RO.rosteropid
				SET
					RO.seq = S.rownum - 1 
				WHERE RO.rosterid = ?;";
			
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "ss";
			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $this->rosterid;
			$params[] =& $this->rosterid;

			call_user_func_array(array($cmd, "bind_param"), $params);
			$cmd->execute();
		}
		
		function GetNewRosterId() {
			global $dbcon;
			$rosterid = CommonUtils\shortId(8);
			$isdup = true;

			// Check that this ID is unique and keep generating IDs until it is
			while ($isdup) {
				// Check for dups
				$sql = "SELECT * FROM Roster WHERE rosterid = ?";
				$cmd = $dbcon->prepare($sql);
				$paramtypes = "s";
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $rosterid;

				call_user_func_array(array($cmd, "bind_param"), $params);
				$cmd->execute();

				if ($result = $cmd->get_result()) {
					if ($row = $result->fetch_object()) {
						$isdup = true;
					} else {
						$isdup = false;
					}
				}
			}

			return $rosterid;
		}
	}
?>