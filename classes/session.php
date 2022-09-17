<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class Session extends \OFW\OFWObject {
		public $sessionid = "";
		public $playerid = "";
		public $lastactivity = "";
        
        function __construct() {
            $this->TableName = "Session";
            $this->Keys = ["sessionid"];
			$this->skipfields = [];
        }
		
		public function GetSession($sid) {
			global $dbcon;
			
			//Get the requested Session
			$s = Session::FromDB($sid);
			
			return $s;
		}
	}
?>