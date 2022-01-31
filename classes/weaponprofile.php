<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class WeaponProfile extends \OFW\OFWObject {
		public $factionid = "";
		public $killteamid = "";
		public $fireteamid = "";
		public $opid = "";
        public $wepid = "";
		public $profileid = "";
		public $name = "";
		public $A = "";
		public $BS = "";
		public $D = "";
		public $SR = "";
        
        function __construct() {
            $this->TableName = "WeaponProfile";
            $this->Keys = ["factionid", "killteamid", "fireteamid", "opid", "wepid", "profileid"];
			$this->skipfields = [];
        }
	}
?>