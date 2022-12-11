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
		public $notes = "";
		public $operatives = [];
        
        function __construct() {
            $this->TableName = "Roster";
            $this->Keys = ["rosterid"];
			$this->skipfields = [
				"operatives","username","factionname","killteamname",
				"opList","oplist",
				"killteamdescription","archetype",
				"viewcount","importcount"
			];
        }
		
		public function GetRoster($rid) {
			global $dbcon;
			
			// Get the operatives for this team
			$sql = "SELECT * FROM RosterView WHERE rosterid = ? ORDER BY seq";
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
					
					// Reorder operatives so their seqs are always sequential
					$r->reorderOperatives();
					
					// Now load the operatives
					$r->loadOperatives();
					
					// Done
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
			
			// Get the operatives for this team
			$sql = "SELECT * FROM RosterOperativeView WHERE rosterid = ? ORDER BY seq";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "s";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $this->rosterid;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

			$ops = [];
            if ($result = $cmd->get_result()) {
                while ($row = $result->fetch_object()) {
                    $op = RosterOperative::FromRow($row);
					
					// Load the base operative for this RosterOperative
					$op->loadBaseOperative();
					
					// Load the operative's weapons and equipments
					$op->loadWeapons();
					$op->loadEquipments();
					$this->operatives[] = $op;
                }
            }
		}
		
		public function loadKillTeam() {
			//$this->killteam = Killteam::GetKillTeam($this->factionid, $this->killteamid);
			
			// Don't load the whole thing, takes too long (especially for users with many rosters when they open dashboard)
			//	Only pull the base information about the kill team + its ploys and equipment
			$this->killteam = Killteam::FromDB($this->factionid, $this->killteamid);
			
			// Load the ploys
			$this->killteam->loadPloys();
			
			// Load the equipments
			$this->killteam->loadEquipments();
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
	}
?>