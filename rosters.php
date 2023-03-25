<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested user id
	$uid = getIfSet($_REQUEST['uid']);
	if ($uid == null || $uid == '') {
		$uid = getIfSet($_REQUEST['userid']);
	}
	
	$me = Session::CurrentUser();
	if (($uid == null || $uid == '') && $me != null) {
		$uid = $me->userid;
	}
	
	if ($uid == null || $uid == '') {
		// No user id specified, not logged in
		//	No idea what they expect to see here; send them to login page
		header("Location: /login.htm");
		exit;
	}
	
	$myUser = User::FromDB($uid);
	
	if ($myUser == null) {
		// No match on user ID, try to find based on user name
		$u = User::FromName($uid);
		
		if ($u == null) {
			// User not found
			header("Location: /login.htm");
			exit;
		}
		
		$uid = $u->userid;
		$myUser = $u;
	}
	$myUser->loadRosters(0);
	$myRosters = $myUser->rosters;
	$ismine = ($me != null && $me->userid == $uid);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = "";
			$pagedesc = "";
			$pagekeywords = "";
			$pageimg = "";
			
			if ($uid == 'prebuilt') {
				$pagetitle = "Pre-Built Rosters";
				$pagedesc = "View and Import Pre-Built KillTeam Rosters";
				$pagekeywords = "Prebuilt,sample,rosters,teams,import";
			} else {
				$pagetitle = ($ismine ? "My" : (ucwords($myUser->username) . "'s")) . " Rosters";
				$pagedesc = "View and Import " . ucwords($myUser->username) . "'s KillTeam Rosters";
				$pagekeywords = $myUser->username . ",rosters,teams,import";
			}
			
			if (count($myRosters) > 0) {
				$pageimg   = "https://ktdash.app/api/rosterportrait.php?rid={$myRosters[0]->rosterid}";
			} else {
				$pageimg   = "https://ktdash.app/img/og/Home.png";
			}
			$pageurl   = "https://ktdash.app/u/{$myUser->username}";
			include "og.php";
		?>
		
		<?php
			if (count($myRosters) > 0)
			{
			?>
			<link rel="preload" href="/api/rosterportrait.php?rid=<?php echo $myRosters[0]->rosterid ?>" as="image">
			<?php
			}
		?>
		
		<style>
		<?php include "css/styles.css"; ?>
		</style>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRosters('<?php echo $uid ?>');">
		<?php
			include "topnav.shtml";
			include "templates/dialogs.shtml";
		?>
		
		<script type="text/javascript">
			// Pre-load rosters data straight on this page instead of XHR round-trip to the API
			document.body.setAttribute("myRosters", JSON.stringify(<?php echo json_encode($myRosters) ?>));
			
			// Pre-load current user
			document.body.setAttribute("currentuser", JSON.stringify(<?php echo json_encode($me) ?>));
		</script>
		
		<div class="row m-0 p-1 orange container-fluid">
			<h1 class="col-11 m-0 p-0">
				<?php echo ($ismine ? "My" : ($uid == 'prebuilt' ? 'Pre-Built ' : (ucwords($myUser->username) . "'s "))) ?> Rosters
			</h1>
			<div class="col-1 h3 m-0 p-0 align-text-top text-end" ng-if="MODE == 'MyRosters'">
				<div class="btn-group">
					<a role="button" id="rostersactions" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fas fa-ellipsis-h fa-fw"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="rostersactions">
						<li><a class="pointer dropdown-item p-1" ng-click="initNewRoster();"><i class="far fa-plus-square fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Operative"></i>  Add New Roster</a></li>
						<li><a class="pointer dropdown-item p-1 navloader" ng-href="/u/KTDash"><i class="fas fa-users fa-fw"></i> Pre-Built Rosters</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		<!-- Help Box -->
		<div class="modal fade oswald" id="myrostershelpmodal" tabindex="-1" role="dialog" aria-labelledby="myrostershelpmodallabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content dark">
					<div class="modal-header orange">
						<h5 class="modal-title cinzel" id="myrostershelpmodallabel"><i class="far fa-question-circle fa-fw"></i> My Rosters - Help</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="m-0 modal-body dark">
						Manage your Rosters here.
						<br/>
						<img width="100%" src="/img/RostersHelp.jpg" /><br/>
						<h6 class="d-inline fa-fw">1:</h6>&nbsp;&nbsp; <i class="fas fa-edit fa-fw"></i> Change Team Portrait</br>
						<h6 class="d-inline fa-fw">2:</h6>&nbsp;&nbsp; <i class="fas fa-edit fa-fw"></i> Rename Roster and Edit Notes</br>
						<h6 class="d-inline fa-fw">3:</h6>&nbsp;&nbsp; <i class="fas fa-arrow-up fa-fw"></i> Move Roster Up</br>
						<h6 class="d-inline fa-fw">4:</h6>&nbsp;&nbsp; <i class="fas fa-arrow-down fa-fw"></i> Move Roster Down</br>
						<h6 class="d-inline fa-fw">5:</h6>&nbsp;&nbsp; <i class="fas fa-share-square fa-fw"></i> Share Roster/Generate Link</br>
						<h6 class="d-inline fa-fw">6:</h6>&nbsp;&nbsp; <i class="far fa-copy fa-fw"></i> Clone Roster</br>
						<h6 class="d-inline fa-fw">7:</h6>&nbsp;&nbsp; <i class="fas fa-trash-alt fa-fw"></i> Delete Roster
					</div>
				</div>
			</div>
		</div>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<br/>
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Rosters...
			</div>
		</h3>
		
		<!-- Show this player's rosters -->
		<div class="m-0 p-0 ng-cloak" ng-hide="loading">
			<div ng-if="myRosters.length < 1" class="m-0 p-0">
				<span ng-if="MODE == 'MyRosters'">You don't have any Rosters yet.</span>
				<span ng-if="MODE == 'Rosters'">This user doesn't have any Rosters yet.</span>
				<?php
				if ($ismine) {
				?>
				Build a <a href="#" ng-click="initNewRoster();">new roster</a>
				or import a <a class="navloader" href="rosters.php?uid=prebuilt">pre-built roster</a>
				<?php
				}
				?>
				<br/>
			</div>
			
			<div class="m-0 p-0">
				<div ng-if="myRosters.length > 0" class="row p-0 m-0">
					<div class="col-12 col-md-6 col-lg-4 m-0 p-0" ng-repeat="myRoster in myRosters | orderBy: 'seq'">
						<?php include "templates/roster_card.shtml" ?>
					</div>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>