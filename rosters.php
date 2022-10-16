<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested user id
	$uid = $_REQUEST['uid'];
	if ($uid == null || $uid == '') {
		$uid = $_REQUEST['userid'];
	}
	if ($uid == null || $uid == '') {
		$uid = Session::CurrentUser()->userid;
	}
	
	if ($uid == null || $uid == '') {
		// No user id specified, not logged in
		//	No idea what they expect to see here; send them to login page
		header("Location: /login.htm");
		exit;
	}
	
	$myUser = User::FromDB($uid);
	$myUser->loadRosters();
	$myRosters = $myUser->rosters;
	$me = Session::CurrentUser();
	$ismine = ($me != null && $me->userid == $uid);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			if ($uid == 'prebuilt') {
				$pagetitle = "Pre-Built KillTeam Rosters";
			}
			else {
				$pagetitle = ucwords($myUser->username) . "'s KillTeam Rosters";
			}
			
			$pagedesc  = "View and import " . $pagetitle;
			$pageimg   = "https://beta.ktdash.app/img/og/Home.png";
			$pageurl   = "https://beta.ktdash.app/roster.php?rid={$myRoster->rosterid}";
			include "og.php";
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRosters('<?php echo $uid ?>');">
		<?php
			include "topnav.shtml";
			include "templates/dialogs.shtml";
		?>
		
		<h1 class="orange container-fluid"><span class="fas fa-users fa-fw"></span>&nbsp;<?php echo ($ismine ? "My" : $myUser->username) ?> Rosters</h1>
		
		<!-- Help Box -->
		<div class="modal fade oswald" id="myrostershelpmodal" tabindex="-1" role="dialog" aria-labelledby="myrostershelpmodallabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content dark">
					<div class="modal-header orange">
						<h5 class="modal-title cinzel" id="myrostershelpmodallabel">My Rosters - Help</h5>
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
		<div class="container-fluid ng-cloak" ng-hide="loading">
			<div ng-if="myRosters.length < 1" >
				<span ng-if="MODE == 'MyRosters'">You don't have any Rosters yet.</span>
				<span ng-if="MODE == 'Rosters'">This user doesn't have any Rosters yet.</span>
			</div>
			<?php
				if ($ismine) {
				?>
			<div>
				<span class="float-start">
					Build a <a href="#" ng-click="initNewRoster();">new roster</a>
					or import a <a href="rosters.php?uid=prebuilt">pre-built roster</a>
				</span>
				<span class="float-end">
					<i id="myrostershelpbutton" class="pointer far fa-question-circle fa-fw" onclick="$('#myrostershelpmodal').modal('show');"></i>
				</span>
			</div>
			<br/>
			<br/>
				<?php
			} ?>
			
			<div ng-if="myRosters.length > 0" class="row">
				<div class="col-12 col-md-6 col-xl-4 m-0 p-1" ng-repeat="myRoster in myRosters | orderBy: 'seq'">
					<?php include "templates/roster_card.shtml" ?>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>