<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';

class Killteam extends \OFW\OFWObject
{
	public $factionid = "";
	public $killteamid = "";
	public $edition = "";
	public $killteamname = "";
	public $description = "";
	public $customkeyword = "";

	public $ploys = null;
	public $equipments = null;

	function __construct()
	{
		$this->TableName = "Killteam";
		$this->Keys = ["factionid", "killteamid"];
		$this->skipfields = ["operatives", "ploys", "equipments", "rosters"];
	}

	public static function GetKillteam($factionid, $killteamid)
	{
		$log = "";
		global $dbcon;

		// Get the requested Killteam
		$log .= "row: " . microtime(true);
		$killteam = Killteam::FromDB($factionid, $killteamid);

		if ($killteam != null) {
			// Load its fireteams
			$killteam->loadFireteams();

			// Load its ploys
			$killteam->loadPloys();

			// Load its equipments
			$killteam->loadEquipments();

			// Load its tacops
			$killteam->loadTacOps();

			// Load its "spotlighted" rosters
			$killteam->loadRosters();
		}

		return $killteam;
	}

	public static function GetKillteams($edition)
	{
		global $dbcon;

		if (!$edition) {
			$edition = '';
		}

		$sql = "SELECT * FROM Killteam WHERE ? IN ('', edition) ORDER BY killteamname;";

		$cmd = $dbcon->prepare($sql);
		if (!$cmd) {
			//There was an error preparing the SQL statement
			echo "Error preparing SQL: " . $dbcon->error;
		}
		
		$cmd->bind_param('s', $edition);

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

				// Load its "spotlighted" rosters
				$killteam->loadRosters();

				// Add this faction to the output
				$killteams[] = $killteam;
			}
		}


		// Done - Return our array of killteams
		return $killteams;
	}

	public function loadFireteams()
	{
		$this->fireteams = [];

		global $dbcon;

		$sql = "SELECT * FROM Fireteam WHERE factionid = ? AND killteamid = ? ORDER BY seq, fireteamname;";

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

	public function loadPloys()
	{
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

	public function loadEquipments()
	{
		global $dbcon;

		$this->equipments = [];

		$sql = "SELECT * FROM Equipment WHERE (factionid = ? AND killteamid = ?) OR (factionid = ? AND killteamid = 'ALL') ORDER BY eqseq, eqname;";

		$cmd = $dbcon->prepare($sql);
		if (!$cmd) {
			//There was an error preparing the SQL statement
			echo "Error preparing SQL: " . $dbcon->error;
		}

		//Set the parameters
		$cmd->bind_param('sss', $this->factionid, $this->killteamid, $this->edition);

		//Run the query
		if (!$cmd->execute()) {
			//There was an error running the SQL statement
			echo "Error running SQL: " . $dbcon->error;
		}

		//Parse the result
		if ($result = $cmd->get_result()) {
			while ($row = $result->fetch_object()) {
				$eq = Equipment::FromRow($row);

				//If this is a weapon, add the weapon as a nested object
				if (strpos($eq->eqtype, 'Weapon') !== false) {
					$wep = Weapon::FromDB($row->factionid, $row->killteamid, 'EQ', 'EQ', $row->eqid);
					if ($wep != null) {
						$wep->loadWeaponProfiles();
						$eq->weapon = $wep;
					}
				}
				$this->equipments[] = $eq;
			}
		}
	}

	public function loadTacOps()
	{
		global $dbcon;

		$this->tacops = [];

		// First, get all the archetypes for the fireteams in this killteam
		$sql = "SELECT GROUP_CONCAT(DISTINCT archetype SEPARATOR '/') AS archetypes FROM Fireteam WHERE factionid = ? AND killteamid = ?;";
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

		//Parse the archetypes
		$archetypes = "";
		if ($result = $cmd->get_result()) {
			$archetypes = '/' . $result->fetch_object()->archetypes . '/';
		}

		$sql = "SELECT * FROM TacOp WHERE edition = ? AND (tacopid LIKE CONCAT(?, '-', ?, '%') OR ? LIKE CONCAT('%/', archetype, '/%')) ORDER BY tacopid, tacopseq;";

		$cmd = $dbcon->prepare($sql);
		if (!$cmd) {
			//There was an error preparing the SQL statement
			echo "Error preparing SQL1: " . $dbcon->error;
		}

		//Set the parameters
		$cmd->bind_param('ssss', $this->edition, $this->factionid, $this->killteamid, $archetypes);

		//Run the query
		if (!$cmd->execute()) {
			//There was an error running the SQL statement
			echo "Error running SQL2: " . $dbcon->error;
		}

		//Parse the result
		if ($result = $cmd->get_result()) {
			while ($row = $result->fetch_object()) {
				$t = TacOp::FromRow($row);
				$this->tacops[] = $t;
			}
		}
	}

	public function loadRosters()
	{
		global $dbcon;

		$me = Session::CurrentUser();

		$this->rosters = [];

		/*
			vpnts - DW_Dagon (Dino squad)
			i8oGH - Smoerkniven (pro)
			BLWaM - Mendejo (pro)
			jXat0 - Tak231 (Femmarines)
		*/
		$sql = "SELECT DISTINCT CASE R.userid WHEN ? THEN 10 WHEN 'prebuilt' THEN 9 WHEN 'vince' THEN 8 WHEN 'tim' THEN 7 WHEN 'jXat0' THEN 6 WHEN 'BLWaM' THEN 6 WHEN 'i8oGH' THEN 6 WHEN 'vpnts' THEN 5 ELSE CASE WHEN notes = '' THEN 1 ELSE 2 END END AS seq, R.rosterid, U.username, R.rostername, R.userid, R.oplist, R.notes, R.killteamid, R.factionid, K.killteamname, R.spotlight, R.viewcount, R.importcount, R.hascustomportrait FROM RosterView R INNER JOIN User U ON U.userid = R.userid INNER JOIN Killteam K ON K.factionid = R.factionid AND K.killteamid = R.killteamid WHERE R.factionid = ? AND R.killteamid = ? AND (R.userid IN (?, 'prebuilt') OR spotlight = 1) ORDER BY 1 DESC, R.hascustomportrait DESC LIMIT 100;";

		$cmd = $dbcon->prepare($sql);
		if (!$cmd) {
			//There was an error preparing the SQL statement
			echo "Error preparing SQL: " . $dbcon->error;
		}

		//Set the parameters
		$userid = $me == null ? 'prebuilt' : $me->userid;
		$cmd->bind_param('ssss', $userid, $this->factionid, $this->killteamid, $userid);

		//Run the query
		if (!$cmd->execute()) {
			//There was an error running the SQL statement
			echo "Error running SQL: " . $dbcon->error;
		}

		//Parse the result
		if ($result = $cmd->get_result()) {
			while ($row = $result->fetch_object()) {
				$r = Roster::FromRow($row);

				$this->rosters[] = $r;
			}
		}
	}
}
