<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

Utils::SetApiHeaders();
header("Access-Control-Allow-Methods: OPTIONS, GET");

switch ($_SERVER['REQUEST_METHOD']) {
	case "GET":
		//Get the stats
		GETStats();
		break;
	default:
		//Invalid verb
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function GETStats()
{
  $output = null;
	global $dbcon;

  // Totals
  $sql =
  "SELECT 'Users' AS CountType, COUNT(*) AS Count FROM User WHERE userid NOT IN ('prebuilt', 'vince') UNION
  SELECT 'Rosters', COUNT(*) AS RosterCount FROM Roster WHERE userid NOT IN ('prebuilt', 'vince') UNION
  SELECT 'RosterOps', COUNT(*) AS RosterOpCount FROM RosterOperative WHERE userid NOT IN ('prebuilt', 'vince')";
  $cmd = $dbcon->prepare($sql);

  $cmd->execute();

  $output->totals = [];
  if ($result = $cmd->get_result()) {
    while ($row = $result->fetch_object()) {
      // Got a result
      $output->totals[] = $row;
    }
  }

  // Most viewed rosters
  $output->mostviewedrosters = [];
  $sql =
  "SELECT U.username, R.rostername, KT.killteamname, KT.edition, CONCAT('https://ktdash.app/r/', rosterid, '/g') AS rosterlink, CONCAT('https://ktdash.app/u/', U.username) AS userlink, viewcount
  FROM Roster R
  INNER JOIN User U ON U.userid = R.userid
  INNER JOIN Killteam KT ON KT.factionid = R.factionid AND KT.killteamid = R.killteamid
  WHERE R.userid NOT IN ('prebuilt')
  ORDER BY viewcount DESC
  LIMIT 10;";
  $cmd = $dbcon->prepare($sql);

  $cmd->execute();

  if ($result = $cmd->get_result()) {
    while ($row = $result->fetch_object()) {
      $output->mostviewedrosters[] = $row;
    }
  }

  // Most imported rosters
  $output->mostimportedrosters = [];
  $sql =
  "SELECT U.username, R.rostername, KT.killteamname, KT.edition, CONCAT('https://ktdash.app/r/', rosterid) AS rosterlink, CONCAT('https://ktdash.app/u/', U.username) AS userlink, importcount
    FROM Roster R
    INNER JOIN User U ON U.userid = R.userid
    INNER JOIN Killteam KT ON KT.factionid = R.factionid AND KT.killteamid = R.killteamid
    WHERE R.userid NOT IN ('prebuilt')
    ORDER BY importcount DESC
    LIMIT 10;";
  $cmd = $dbcon->prepare($sql);

  $cmd->execute();

  if ($result = $cmd->get_result()) {
    while ($row = $result->fetch_object()) {
      $output->mostimportedrosters[] = $row;
    }
  }

  // Most viewed users
  $output->mostviewedusers = [];
  $sql =
  "SELECT U.username, CONCAT('https://ktdash.app/u/', U.username) AS userlink, SUM(viewcount) AS viewcount
    FROM Roster R
    INNER JOIN User U ON U.userid = R.userid
    WHERE R.userid NOT IN ('prebuilt')
    GROUP BY U.username, CONCAT('https://ktdash.app/u/', U.username)
    ORDER BY SUM(viewcount) DESC
    LIMIT 10;";
  $cmd = $dbcon->prepare($sql);

  $cmd->execute();

  if ($result = $cmd->get_result()) {
    while ($row = $result->fetch_object()) {
      $output->mostviewedusers[] = $row;
    }
  }

  // Most imported users
  $output->mostimportedusers = [];
  $sql =
  "SELECT U.username, CONCAT('https://ktdash.app/u/', U.username) AS userlink, SUM(importcount) AS importcount
    FROM Roster R
    INNER JOIN User U ON U.userid = R.userid
    WHERE R.userid NOT IN ('prebuilt')
    GROUP BY U.username, CONCAT('https://ktdash.app/u/', U.username)
    ORDER BY SUM(importcount) DESC
    LIMIT 10;";
  $cmd = $dbcon->prepare($sql);

  $cmd->execute();

  if ($result = $cmd->get_result()) {
    while ($row = $result->fetch_object()) {
      $output->mostimportedusers[] = $row;
    }
  }

  // Most spotlighted users
  $output->mostspotlightedusers = [];
  $sql =
  "SELECT U.username, CONCAT('https://ktdash.app/u/', U.username) AS userlink, COUNT(DISTINCT R.rosterid) AS spotlightcount
    FROM Roster R
    INNER JOIN User U ON U.userid = R.userid
    WHERE R.userid NOT IN ('prebuilt') AND R.spotlight = 1
    GROUP BY U.username, CONCAT('https://ktdash.app/u/', U.username)
    ORDER BY COUNT(DISTINCT R.rosterid) DESC
    LIMIT 10;";
  $cmd = $dbcon->prepare($sql);

  $cmd->execute();

  if ($result = $cmd->get_result()) {
    while ($row = $result->fetch_object()) {
      $output->mostspotlightedusers[] = $row;
    }
  }

  // Killteamstats
  $output->killteamstats = [];
  $sql =
  "SELECT KT.killteamname, KT.edition, CONCAT('https://ktdash.app/fa/', KT.factionid, '/kt/', KT.killteamid) AS killteamlink, SUM(CASE WHEN R.rosterid IS NULL THEN 0 ELSE 1 END) AS rostercount, SUM(R.spotlight) AS spotlightcount
							FROM Killteam KT
							LEFT JOIN Roster R
							ON  R.factionid = KT.factionid AND R.killteamid = KT.killteamid AND R.rostername != 'Sample Team: Intercessors'
							GROUP BY KT.killteamname, KT.factionid, KT.killteamid, KT.edition
							ORDER BY SUM(CASE WHEN R.rosterid IS NULL THEN 0 ELSE 1 END) DESC;";
  $cmd = $dbcon->prepare($sql);

  $cmd->execute();

  if ($result = $cmd->get_result()) {
    while ($row = $result->fetch_object()) {
      $output->killteamstats[] = $row;
    }
  }

  // Done
  echo json_encode($output);
}
