<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';

class Fireteam extends \OFW\OFWObject
{
	public $factionid = "";
	public $killteamid = "";
	public $fireteamid = "";
	public $seq = 0;
	public $fireteamname = "";
	public $archetype = "";
	public $description = "";
	public $killteammax = 0;

	public $operatives = [];

	function __construct()
	{
		$this->TableName = "Fireteam";
		$this->Keys = ["factionid", "killteamid", "fireteamid"];
		$this->skipfields = ["operatives"];
	}

	public static function GetFireteam($fid)
	{
		global $dbcon;

		//Get the requested object
		$ft = Fireteam::FromDB($fid);
		if ($ft != null) {
			$ft->loadOperatives();
		}

		return $ft;
	}

	public function loadOperatives()
	{
		$this->operatives = [];

		global $dbcon;

		$sql = "SELECT * FROM Operative WHERE factionid = ? AND killteamid = ? AND fireteamid = ? ORDER BY opseq, opname;";

		$cmd = $dbcon->prepare($sql);
		if (!$cmd) {
			//There was an error preparing the SQL statement
			echo "Error preparing SQL: " . $dbcon->error;
		}

		//Set the parameters
		$cmd->bind_param('sss', $this->factionid, $this->killteamid, $this->fireteamid);

		//Run the query
		if (!$cmd->execute()) {
			//There was an error running the SQL statement
			echo "Error running SQL: " . $dbcon->error;
		}

		//Parse the result
		if ($result = $cmd->get_result()) {
			while ($row = $result->fetch_object()) {
				$op = Operative::FromRow($row);
				$op->loadWeapons();
				$op->loadAbilities();
				$op->loadUniqueActions();

				$this->operatives[] = $op;
			}
		}
	}
}
?>