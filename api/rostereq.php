<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

Utils::SetApiHeaders();
header("Access-Control-Allow-Methods: OPTIONS, GET, POST, DELETE");

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        // Get the requested roster eq
        GETRosterEq();
        break;
    case "POST":
        // Create a new roster eq
        POSTRosterEq();
        break;
    case "DELETE":
        // Delete an existing roster eq
        DELETERosterEq();
        break;
    default:
        // Invalid verb
        header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
        die();
}

function GETRosterEq()
{
    // Get the requested eq
    $userid = getIfSet($_REQUEST['uid']);
    $rosterid = getIfSet($_REQUEST['rid']);
    $eqid = getIfSet($_REQUEST['toid']);

    if ($userid == null || $userid == '' || strlen($userid) > 10) {
        // No userid specified - fail
        header('HTTP/1.0 404 Invalid userid');
        die();
    } elseif ($rosterid == null || $rosterid == '' || strlen($rosterid) > 10) {
        // No rosterid specified - fail
        header('HTTP/1.0 404 Invalid rosterid');
        die();
    } elseif ($eqid == null || $eqid == '' || strlen($eqid) > 10) {
        // No eqid specified - fail
        header('HTTP/1.0 404 Invalid eqid');
        die();
    } else {
        // Try to find this eq
        $rto = RosterEq::FromDB($userid, $rosterid, $eqid);
        if ($rto == null) {
            header('HTTP/1.0 404 Roster Eq not found');
            die();
        } else {
            header('Content-Type: application/json');
            echo json_encode($rto);
        }
    }
}

function DELETERosterEq()
{
    // Check that the user is currently logged in
    if (!Session::IsAuth()) {
        // Not logged in - Return error				
        header('HTTP/1.0 401 Unauthorized - You are not logged in"');
        die();
    } else {
        // Get the current user
        $u = Session::CurrentUser();

        $eq = RosterEq::FromJSON(file_get_contents('php://input'));

        $userid = $eq->userid;
        $rosterid = $eq->rosterid;
        $eqfactionid = $eq->eqfactionid;
        $eqkillteamid = $eq->eqkillteamid;
        $eqid = $eq->eqid;

        if ($userid == null || $userid == '' || strlen($userid) > 20 || $userid != $u->userid) {
            // No userid specified - fail
            header('HTTP/1.0 404 Invalid userid');
            die();
        } elseif ($rosterid == null || $rosterid == '' || strlen($rosterid) > 20) {
            // No rosterid specified - fail
            header('HTTP/1.0 404 Invalid rosterid');
            die();
        } elseif ($eqid == null || $eqid == '' || strlen($eqid) > 20) {
            // No eqid specified - fail
            header('HTTP/1.0 404 Invalid eqid');
            die();
        } else {
            // Try to find this eq
            $rto = RosterEq::FromDB($userid, $rosterid, $eqfactionid, $eqkillteamid, $eqid);
            if ($rto == null) {
                header('HTTP/1.0 404 Roster Eq not found');
                die();
            } else {
                // Check that current user owns this roster
                if ($userid != $u->userid) {
                    // Not theirs - fail
                    header('HTTP/1.0 403 This is not your roster');
                    die();
                } else {
                    $rto->DBDelete();
                    header('HTTP/1.0 202 OK');
					echo '{"success": "OK"}';
                }
            }
        }
    }
}

function POSTRosterEq()
{
    // Check that the user is currently logged in
    if (!Session::IsAuth()) {
        // Not logged in - Return error				
        header('HTTP/1.0 401 Unauthorized - You are not logged in"');
        die();
    } else {
        // Get the current user
        $u = Session::CurrentUser();

        $eq = RosterEq::FromJSON(file_get_contents('php://input'));

        $userid = $eq->userid;
        $rosterid = $eq->rosterid;
        $eqfactionid = $eq->eqfactionid;
        $eqkillteamid = $eq->eqkillteamid;
        $eqid = $eq->eqid;

        if ($userid == null || $userid == '' || strlen($userid) > 20 || $userid != $u->userid) {
            // No userid specified - fail
            header('HTTP/1.0 404 Invalid userid');
            die();
        } elseif ($rosterid == null || $rosterid == '' || strlen($rosterid) > 20) {
            // No rosterid specified - fail
            header('HTTP/1.0 404 Invalid rosterid');
            die();
        } elseif ($eqid == null || $eqid == '' || strlen($eqid) > 20) {
            // No eqid specified - fail
            header('HTTP/1.0 404 Invalid eqid');
            die();
        } else {
            // Commit to DB
            $eq->DBSave();

            // All done, return the RosterEq object
            header('Content-Type: application/json');
            echo json_encode($eq);
        }
    }
}
