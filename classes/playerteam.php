<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class PlayerTeam extends \OFW\OFWObject {
		public $playerid = "";
		public $playerteamid = "";
		public $playerteamname = "";
		public $factionid = "";
		public $killteamid = "";
		public $operatives = [];
        
        function __construct() {
            $this->TableName = "PlayerTeam";
            $this->Keys = ["playerid", "playerteamid"];
			$this->skipfields = ["operatives"];
        }
		
		function loadArchetype() {
			// Get the archetypes for all the fireteams that are part of this player team
            global $dbcon;
			
			$sql = "SELECT DISTINCT FT.archetype FROM PlayerTeamOperative PTO INNER JOIN Fireteam FT ON FT.factionid = PTO.factionid AND FT.killteamid = PTO.killteamid AND FT.fireteamid = PTO.fireteamid WHERE PTO.playerid = ? AND PTO.playerteamid = ?";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "ss";
			
			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $this->playerid;
			$params[] =& $this->playerteamid;
			
			// Load the archetypes
            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

			$arch = "";
            if ($result = $cmd->get_result()) {
                while ($arow = $result->fetch_object()) {
					if (strlen($arch) > 0) {
						$arch .= "/";
					}
					$arch .= $arow->archetype;
				}
			}
			
			// OK, now only keep distinct archetypes
			// First, split
			$archs = explode("/", $arch);
			
			// Now keep only distinct ones
			$archs = array_unique($archs);
			
			// Now combine into one string, "/" separated
			$this->archetype = implode("/", $archs);
		}
		
		function loadOperatives() {
			// Get the operatives for this playerteams
            global $dbcon;
			
			$sql = "SELECT * FROM PlayerTeamOperative WHERE playerid = ? AND playerteamid = ?";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "ss";
			
			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $this->playerid;
			$params[] =& $this->playerteamid;
			
			// Load the operatives
            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                while ($oprow = $result->fetch_object()) {
					// Got an operative
					$op = PlayerTeamOperative::FromRow($oprow);
					$op->loadOperative();
					$this->operatives[] = $op;
				}
			}
		}
	}
?>