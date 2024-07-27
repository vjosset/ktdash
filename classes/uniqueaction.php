<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';

class UniqueAction extends \OFW\OFWObject
{
	public $factionid = "";
	public $killteamid = "";
	public $fireteamid = "";
	public $opid = "";
	public $uniqueactionid = "";
	public $title = "";
	public $description = "";

	function __construct()
	{
		$this->TableName = "UniqueAction";
		$this->Keys = ["factionid", "killteamid", "fireteamid", "opid", "uniqueactionid"];
	}

	public static function GetUniqueAction($opid, $title)
	{
		global $dbcon;

		//Get the requested UniqueAction
		$ab = UniqueAction::FromDB($opid, $title);

		return $ab;
	}

	public static function GetUniqueActions()
	{
		global $dbcon;

		$sql = "SELECT * FROM UniqueAction;";

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
				$ua = UniqueAction::FromRow($row);

				// Add this faction to the output
				$uas[] = $ua;
			}
		}

		// Done - Return our array of factions
		return $uas;
	}
}
?>