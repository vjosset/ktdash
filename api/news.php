<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

Utils::SetApiHeaders();
header("Access-Control-Allow-Methods: OPTIONS, GET");

switch ($_SERVER['REQUEST_METHOD']) {
	case "GET":
		//Get the requested killteam
		GETNews();
		break;
	case "OPTIONS":
		echo "";
		break;
	default:
		//Invalid verb
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function GETNews()
{
  global $dbcon;
	$max = getIfSet($_REQUEST['max'], 1000);

  $sql = "SELECT * FROM News ORDER BY date DESC LIMIT ?;";
  
  $cmd = $dbcon->prepare($sql);

  $paramtypes = "i";

  $params = array();
  $params[] =& $paramtypes;
  $params[] =& $max;

  call_user_func_array(array($cmd, "bind_param"), $params);
  $cmd->execute();

  $output = [];
  if ($result = $cmd->get_result()) {
    while ($row = $result->fetch_object()) {
      // Got a result
      $output[] = $row;
    }
  }

  // All done
  echo json_encode($output);
}
