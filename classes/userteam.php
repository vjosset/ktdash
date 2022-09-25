<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class UserTeam extends \OFW\OFWObject {
		public $userteamid = "";
		public $userid = "";
		public $seq = 0;
		public $userteamname = "";
		public $factionid = "";
		public $killteamid = "";
		public $operatives = [];
        
        function __construct() {
            $this->TableName = "UserTeam";
            $this->Keys = ["userteamid"];
			$this->skipfields = ["operatives"];
        }
		
		public function GetUserTeam($utid) {
			global $dbcon;
			
			// Get the operatives for this team
			$sql = "SELECT * FROM UserTeamView WHERE userteamid = ? ORDER BY seq";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "s";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $utid;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

			$ops = [];
            if ($result = $cmd->get_result()) {
                if ($row = $result->fetch_object()) {
                    $ut = UserTeam::FromRow($row);
					$ut->loadOperatives();
					return $ut;
                }
            }
		}
		
		public function loadOperatives() {
			global $dbcon;
			
			// Get the operatives for this team
			$sql = "SELECT * FROM UserTeamOperativeView WHERE userteamid = ? ORDER BY seq";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "s";
			$params = array();
            $params[] =& $paramtypes;
            $params[] =& $this->userteamid;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

			$ops = [];
            if ($result = $cmd->get_result()) {
                while ($row = $result->fetch_object()) {

                    $op = UserTeamOperative::FromRow($row);
					
					// Load the base operative for this UserTeamOperative
					$op->loadBaseOperative();
					
					// Load the operative's weapons and equipments
					$op->loadWeapons();
					$op->loadEquipments();
					$this->operatives[] = $op;
                }
            }
		}
	}
?>