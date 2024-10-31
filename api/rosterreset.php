<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;
global $perf;

Utils::SetApiHeaders();
header("Access-Control-Allow-Methods: OPTIONS, POST");

switch ($_SERVER['REQUEST_METHOD']) {
	case "POST":
		// Reset a roster's dashboard info
		header('Content-Type: application/json');
		ResetRoster();
		break;
	case "OPTIONS":
		echo "";
		break;
	default:
		// Invalid verb
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function RESETRoster()
{
	// Check that the user is currently logged in
	if (!Session::IsAuth()) {
		// Not logged in - Return error				
		header('HTTP/1.0 401 Unauthorized - You are not logged in"');
		die();
	} else {
		// Get the current user
		$u = Session::CurrentUser();

		// Get the requested roster
		$rid = getIfSet($_REQUEST['rid']);
		$roster = Roster::GetRosterRow($rid);

		if ($roster == null) {
			// Roster not found
			header('HTTP/1.0 404 Roster not found');
			die();
		}

		// Validate the roster's owner
		if ($roster->userid == $u->userid) {
			// Current user owns this roster, OK to reset
			global $dbcon;

			// Update the roster's game trackers to their default values (from input)
			$VP = getIfSet($_REQUEST['VP'], 0);
			$CP = getIfSet($_REQUEST['CP'], 0);

			$sql = "UPDATE Roster SET VP =  ?, CP =  ?, TP = 1, RP = 0, ployids = '', tacopids = '' WHERE rosterid = ?;";
						
			$cmd = $dbcon->prepare($sql);

			$paramtypes = "dds";

			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $VP;
			$params[] =& $CP;
			$params[] =& $rid;

			call_user_func_array(array($cmd, "bind_param"), $params);
			$cmd->execute();

			// Reset roster equipment?
			$reseteq = getIfSet($_REQUEST['reseteq'], 0);
			if ($reseteq == 1) {
				$sql = "DELETE FROM RosterEquipment WHERE rosterid = ?;";
							
				$cmd = $dbcon->prepare($sql);
	
				$paramtypes = "s";
	
				$params = array();
				$params[] =& $paramtypes;
				$params[] =& $rid;
	
				call_user_func_array(array($cmd, "bind_param"), $params);
				$cmd->execute();
			}

			// Reset the operatives' wounds to full health
			$order = getIfSet($_REQUEST['order'], 'engage');

			$sql = "UPDATE RosterOperative RO
				INNER JOIN Operative O ON O.factionid = RO.factionid AND O.killteamid = RO.killteamid AND O.fireteamid = RO.fireteamid AND O.opid = RO.opid
				SET curW = W, oporder = ?, activated = 0, isinjured = 0 WHERE rosterid = ?;";
						
			$cmd = $dbcon->prepare($sql);

			$paramtypes = "ss";

			$params = array();
			$params[] =& $paramtypes;
			$params[] =& $order;
			$params[] =& $rid;

			call_user_func_array(array($cmd, "bind_param"), $params);
			$cmd->execute();

			// Get the latest version of this roster
			$roster = Roster::GetRoster($rid);
			$roster->loadKillTeam();

			// Done
			echo json_encode($roster);
		} else {
			// Roster belongs to someone else
			header('HTTP/1.0 404 Roster not found');
			die();
		}
	}
}
