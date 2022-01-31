<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class Ploy extends \OFW\OFWObject {
		public $factionid = "";
        public $killteamid = "";
		public $ployid = "";
		public $ployname = "";
		public $ploytype = "";
		public $CP = "";
		public $description = "";
        
        function __construct() {
            $this->TableName = "Ploy";
            $this->Keys = ["ployid"];
        }
		
		public function GetPloy($ployid) {
			global $dbcon;
			
			//Get the requested UniqueAction
			$p = Ploy::FromDB($ployid);
			
			return $p;
		}
		
		public function GetPloys() {
			global $dbcon;
			
			$sql = "SELECT * FROM Ploy;";
			
			$cmd = $dbcon->prepare($sql);
			if (!$cmd) {
				//There was an error preparing the SQL statement
				echo "Error preparing SQL: " . $dbcon->error;
			}
			
			//Run the query
			if (!$cmd->execute()) {
				//There was an error running the SQL statement
				echo "Error running SQL: " . $dbcon->error;
			}

			$ploys = [];

			//Parse the result
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					$ploy = Ploy::FromRow($row);
					
					// Add this ploy to the output
					$ploys[] = $ploy;
				}
			}
			
			// Done - Return our array of ploys
			return $ploys;
		}
	}
?>