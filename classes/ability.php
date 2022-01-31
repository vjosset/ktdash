<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class Ability extends \OFW\OFWObject {
		public $factionid = "";
		public $killteamid = "";
		public $fireteamid = "";
        public $opid = "";
		public $abilityid = "";
        public $title = "";
		public $description = "";
        
        function __construct() {
            $this->TableName = "Ability";
            $this->Keys = ["killteamid", "fireteamid", "opid", "abilityid"];
        }
		
		public function GetAbility($opid, $title) {
			global $dbcon;
			
			//Get the requested ability
			$ab = Ability::FromDB($opid, $title);
			
			return $ab;
		}
		
		public function GetAbilities() {
			global $dbcon;
			
			$sql = "SELECT * FROM Ability;";
			
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

			$factions = [];

			//Parse the result
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					$ab = Ability::FromRow($row);
					
					// Add this faction to the output
					$abs[] = $ab;
				}
			}
			
			// Done - Return our array of factions
			return $abs;
		}
	}
?>