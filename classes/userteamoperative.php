<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class PlayerTeamOperative extends \OFW\OFWObject {
		public $playerteamid = "";
		public $playerid = "";
		public $playerteamopid = "";
		public $seq = 0;
		public $opname = "";
		public $factionid = "";
		public $killteamid = "";
		public $fireteamid = "";
		public $opid = "";
		public $wepids = "";
		public $eqids = "";
		public $currw = 0;
		public $notes = "";
        
        function __construct() {
            $this->TableName = "PlayerTeamOperative";
            $this->Keys = ["playerteamopid"];
			$this->skipfields = ["weapons", "equipments"];
        }
		
		public function GetPlayerTeamOperative($ptoid) {
			global $dbcon;
			
			//Get the requested PlayerTeamOperative
			$pto = PlayerTeamOperative::FromDB($ptoid);
			
			return $pto;
		}
		
		public function LoadWeapons() {
			// [TBD]
		}
		
		public function LoadEquipments() {
			// [TBD]
		}
	}
?>