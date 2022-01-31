<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class Killteam extends \OFW\OFWObject {
		public $factionid = "";
        public $killteamid = "";
        public $killteamname = "";
		public $description = "";
		
		public $ploys = null;
		public $equipments = null;
        
        function __construct() {
            $this->TableName = "Killteam";
            $this->Keys = ["factionid", "killteamid"];
			$this->skipfields = ["operatives", "ploys", "equipments"];
        }
		
		public function GetKillteam($factionid, $killteamid) {
			global $dbcon;
			
			// Get the requested Killteam
			$killteam = Killteam::FromDB($factionid, $killteamid);
			
			// Load its fireteams
			$killteam->loadFireteams();
			
			// Load its ploys
			$killteam->loadPloys();
			
			// Load its equipments
			$killteam->loadEquipments();
			
			return $killteam;
		}
		
		public function GetKillteams() {
			global $dbcon;
			
			$sql = "SELECT * FROM Killteam ORDER BY killteamname;";
			
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

			$killteams = [];

			//Parse the result
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					$killteam = Killteam::FromRow($row);
					
					// Load its fireteams
					$killteam->loadFireteams();
					
					//Load its ploys
					$killteam->loadPloys();
					
					//Load its equipments
					$killteam->loadEquipments();
					
					// Add this faction to the output
					$killteams[] = $killteam;
				}
			}
			
			
			// Done - Return our array of killteams
			return $killteams;
		}

		public function loadFireteams() {
			$this->fireteams = [];
			
			global $dbcon;
			
			$sql = "SELECT * FROM Fireteam WHERE factionid = ? AND killteamid = ? ORDER BY fireteamname;";
			
			$cmd = $dbcon->prepare($sql);
			if (!$cmd) {
				//There was an error preparing the SQL statement
				echo "Error preparing SQL: " . $dbcon->error;
			}
			
			//Set the parameters
			$cmd->bind_param('ss', $this->factionid, $this->killteamid);
			
			//Run the query
			if (!$cmd->execute()) {
				//There was an error running the SQL statement
				echo "Error running SQL: " . $dbcon->error;
			}

			//Parse the result
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					$ft = Fireteam::FromRow($row);
					$ft->loadOperatives();
					
					$this->fireteams[] = $ft;
				}
			}
		}

		public function loadPloys() {
			global $dbcon;
			
			$this->ploys = new stdClass();
			$this->ploys->strat = [];
			$this->ploys->tac = [];
						
			$sql = "SELECT * FROM Ploy WHERE factionid = ? AND killteamid = ?;";
			
			$cmd = $dbcon->prepare($sql);
			if (!$cmd) {
				//There was an error preparing the SQL statement
				echo "Error preparing SQL: " . $dbcon->error;
			}
			
			//Set the parameters
			$cmd->bind_param('ss', $this->factionid, $this->killteamid);
			
			//Run the query
			if (!$cmd->execute()) {
				//There was an error running the SQL statement
				echo "Error running SQL: " . $dbcon->error;
			}

			//Parse the result
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					//echo "Got ploy " . $row->ployid;
					$p = Ploy::FromRow($row);
					
					if ($p->ploytype == "S") {
						// Strategic ploys
						$this->ploys->strat[] = $p;
					} else {
						// Tactical ploys
						$this->ploys->tac[] = $p;
					}
				}
			}
		}

		public function loadEquipments() {
			global $dbcon;
			
			$this->equipments = [];
						
			$sql = "SELECT * FROM Equipment WHERE factionid = ? AND killteamid = ?;";
			
			$cmd = $dbcon->prepare($sql);
			if (!$cmd) {
				//There was an error preparing the SQL statement
				echo "Error preparing SQL: " . $dbcon->error;
			}
			
			//Set the parameters
			$cmd->bind_param('ss', $this->factionid, $this->killteamid);
			
			//Run the query
			if (!$cmd->execute()) {
				//There was an error running the SQL statement
				echo "Error running SQL: " . $dbcon->error;
			}

			//Parse the result
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					$e = Equipment::FromRow($row);
					$this->equipments[] = $e;
				}
			}
		}
	}
?>