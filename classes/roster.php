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
			$this->skipfields = ["operatives","username","factionname","killteamname","opList","oplist"];
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
                    $ut = Roster::FromRow($row);
					$ut->loadOperatives();
					return $ut;
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
				  ON  S.rosteropid = R.rosteropid
				SET
					RO.seq = S.rownum - 1 
				WHERE R.rosterid = ?;";
			
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