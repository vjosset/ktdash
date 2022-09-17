<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class Player extends \OFW\OFWObject {
		public $playerid = "";
		public $playername = "";
		public $passhash = "";
        
        function __construct() {
            $this->TableName = "Player";
            $this->Keys = ["playerid"];
			$this->skipfields = [];
        }
		
		public function GetPlayer($pid) {
			global $dbcon;
			
			//Get the requested Player
			$p = Player::FromDB($pid);
			
			return $p;
		}
	}
?>