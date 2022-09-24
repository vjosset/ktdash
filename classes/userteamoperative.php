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
	}
?>