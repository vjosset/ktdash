<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class PlayerTeamOperative extends \OFW\OFWObject {
		public $playerid = "";
		public $playerteamid = "";
		public $playerteamopid = "";
		public $opname = "";
		public $factionid = "";
		public $killteamid = "";
		public $fireteamid = "";
		public $opid = "";
		public $wepids = "";
        
        function __construct() {
            $this->TableName = "PlayerTeamOperative";
            $this->Keys = ["playerid", "playerteamid", "playerteamopid"];
			$this->skipfields = ["weapons", "optype", "description", "M", "APL", "GA", "DF", "SV", "W", "keywords"];
        }
		
		function loadOperative() {
            global $dbcon;
			
			// Get the operative for this playerteamoperative
			$sql = "SELECT * FROM Operative WHERE factionid = ? AND killteamid = ? AND fireteamid = ? AND opid = ?";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "ssss";
			
			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $this->factionid;
			$params[] =& $this->killteamid;
			$params[] =& $this->fireteamid;
			$params[] =& $this->opid;
			
			// Load the operative
            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                if ($oprow = $result->fetch_object()) {
					// Got an operative
					// Copy the operative's values/characteristics
					$this->optype = $oprow->opname;
					$this->description = $oprow->description;
					$this->M = $oprow->M;
					$this->APL = $oprow->APL;
					$this->GA = $oprow->GA;
					$this->DF = $oprow->DF;
					$this->SV = $oprow->SV;
					$this->W = $oprow->W;
					$this->keywords = $oprow->keywords;
				}
			}
			
			// Now get this operative's weapons
			$this->weapons = [];
			
			$sql = "SELECT * FROM Weapon WHERE factionid = ? AND killteamid = ? AND fireteamid = ? AND opid = ? AND CONCAT(',', ?, ',') LIKE CONCAT('%,', wepid, ',%')";
			$cmd = $dbcon->prepare($sql);
			$paramtypes = "sssss";
			
			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $this->factionid;
			$params[] =& $this->killteamid;
			$params[] =& $this->fireteamid;
			$params[] =& $this->opid;
			$params[] =& $this->wepids;
			
			// Load the operative
            call_user_func_array(array($cmd, "bind_param"), $params);
            $cmd->execute();

            if ($result = $cmd->get_result()) {
                while ($weprow = $result->fetch_object()) {
					$wep = Weapon::FromRow($weprow);
					
					// Get this weapon's profiles
					$wep->loadWeaponProfiles();
					$this->weapons[] = $wep;
				}
			}
		}
	}
?>