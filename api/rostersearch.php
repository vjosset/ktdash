<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;
global $perf;

Utils::SetApiHeaders();
header("Access-Control-Allow-Methods: OPTIONS, GET");

switch ($_SERVER['REQUEST_METHOD']) {
	case "GET":
		// Get the requested roster/user team
		header('Content-Type: application/json');
		GETRosterSearch();
		break;
	case "OPTIONS":
		echo "";
		break;
	default:
		// Invalid verb
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function GETRosterSearch()
{
	// Get the requested roster
	$term = getIfSet($_REQUEST['term']);

  if (strlen($term) < 3) {
		header('HTTP/1.0 400 Please enter at least 3 characters to search');
		die();
  }

  // Find matching rosters
  global $dbcon;
  $sql = "SELECT * FROM RosterView WHERE rosterid = ? OR username LIKE CONCAT('%', ?, '%') OR rostername LIKE CONCAT('%', ?, '%') LIMIT 10;";
          
  $cmd = $dbcon->prepare($sql);

  $paramtypes = "sss";

  $params = array();
  $params[] =& $paramtypes;
  $params[] =& $term;
  $params[] =& $term;
  $params[] =& $term;

  call_user_func_array(array($cmd, "bind_param"), $params);
  $cmd->execute();

  $rosters = [];

  if ($result = $cmd->get_result()) {
    while ($row = $result->fetch_object()) {
      $rosters[] = $row;
    }
  }

  // Done
  echo json_encode($rosters);
}
