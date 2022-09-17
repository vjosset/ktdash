<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class PlayerTeam extends \OFW\OFWObject {
		public $playerteamid = "";
		public $playerid = "";
		public $seq = 0;
		public $playerteamname = "";
		public $factionid = "";
		public $killteamid = "";
        
        function __construct() {
            $this->TableName = "PlayerTeam";
            $this->Keys = ["playerteamid"];
			$this->skipfields = [];
        }
		
		public function GetPlayerTeam($ptid) {
			global $dbcon;
			
			//Get the requested PlayerTeam
			$pt = PlayerTeam::FromDB($ptid);
			
			return $pt;
		}
	}
?>