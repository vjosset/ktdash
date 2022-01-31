<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    use OFW;
    
    class Player extends \OFW\OFWObject {
        public $playerid = "";
        public $playername = "";
		public $playerteams = [];
        
        function __construct() {
            $this->TableName = "Player";
            $this->Keys = ["playerid"];
			$this->skipFields = ["playerteams"];
        }
        
        public function __get($field) {
            switch( $field ) {
                default:
                    throw new Exception( 'Invalid property: ' . $field );
            }
        }

        public function NewPlayer($n, $p) {
            //Check if there is a player with this name
            if (Player::FromName($n)) {
                //There is a player with that name already
                header('HTTP/1.0 500 Server Error - PlayerName already taken');
                die("PlayerName already taken!");
            }

            $instance = new self();
            $instance->playerid = CommonUtils\shortId();
            $instance->playername = $n;
            $instance->passhash = hash('sha256', $p);

            $instance->DBSave();

            //Done
            return $instance;
        }

        public function FromName($playername) {
            // Get the player with the specified playername
            global $dbcon;
			
            $sql = "SELECT * FROM Player WHERE playername = ?";

            $cmd = $dbcon->prepare($sql);

            $paramtypes = "s";

            $params = array();
            $params[] =& $paramtypes;
            $params[] =& $playername;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                if ($row = $result->fetch_object()) {
                    $u = Player::FromRow($row);
                    return $u;
                }
            }

            //Player not found
            return null;
        }
		
		public function loadPlayerTeams() {
			// Loads this player's teams (from PlayerTeam table)
            global $dbcon;
			
            $sql = "SELECT * FROM PlayerTeam WHERE playerid = ?";

            $cmd = $dbcon->prepare($sql);

            $paramtypes = "s";

            $params = array();
            $params[] =& $paramtypes;
            $params[] =& $this->playerid;

            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                if ($ptrow = $result->fetch_object()) {
                    $pt = PlayerTeam::FromRow($ptrow);
					
					// Load the killteam for this playerteam
					$pt->killteam = KillTeam::FromDB($pt->factionid, $pt->killteamid);
			
					// Load its ploys
					$pt->killteam->loadPloys();
					
					// Load its equipments
					$pt->killteam->loadEquipments();
					
					// Load the operatives for this PlayerTeam
					$pt->loadOperatives();
					
					// Load the archetype for this PlayerTeam
					$pt->loadArchetype();
                    
					// Add this team to this player
					$this->playerteams[] = $pt;
                }
            }

            // Player not found
            return null;
		}
	}
?>
