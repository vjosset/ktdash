<?php
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
		// User not found
		header("Location: /login.htm");
		exit;
	}
	$myUser->loadRosters();
	$myRosters = $myUser->rosters;
	$ismine = ($me != null && $me->userid == $uid);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			if ($uid == 'prebuilt') {
				$pagetitle = "Pre-Built Rosters";
				$pagedesc = "View and Import Pre-Built KillTeam Rosters";
			} else {
				$pagetitle = ($ismine ? "My" : (ucwords($myUser->username) . "'s")) . " Rosters";
				$pagedesc = "View and Import " . ucwords($myUser->username) . "'s KillTeam Rosters";
			}
			
			if (count($myRosters) > 0) {
				$pageimg   = "https://ktdash.app/api/rosterportrait.php?rid={$myRosters[0]->rosterid}";
			} else {
				$pageimg   = "https://ktdash.app/img/og/Home.png";
			}
			$pageurl   = "https://ktdash.app/rosters.php?uid={$uid}";
			include "og.php";
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRosters('<?php echo $uid ?>');">
		<?php
			include "topnav.shtml";
			include "templates/dialogs.shtml";
		?>
		
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
						<li><a class="pointer dropdown-item p-1" ng-href="/rosters.php?uid=prebuilt"><i class="fas fa-users fa-fw"></i> Pre-Built Rosters</a></li>
						<li ng-if="settings['display'] == 'list'"><a class="pointer dropdown-item p-1" ng-click="setSetting('display', 'card');"><i class="pointer far fa-id-card fa-fw"></i> Show Portraits</a></li>
						<li ng-if="settings['display'] == 'card' || settings['display'] == null" ng-click="setSetting('display', 'list');"><a class="pointer dropdown-item p-1"><i class="pointer fas fa-list fa-fw"></i> Hide Portraits</a></li>
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
		<div class="m-0 p-1 ng-cloak" ng-hide="loading">
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
					<div ng-if="settings['display'] == 'card' || settings['display'] == null" class="col-12 col-md-6 col-xl-4 m-0 p-0" ng-repeat="myRoster in myRosters | orderBy: 'seq'">
						<?php include "templates/roster_card.shtml" ?>
					</div>
					<div ng-if="settings['display'] == 'list'" class="col-12 col-md-6 col-xl-4 m-0 p-0" ng-repeat="myRoster in myRosters | orderBy: 'seq'">
						<?php include "templates/roster_list.shtml" ?>
					</div>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>