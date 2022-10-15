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
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = ($ismine ? "My" : $myUser->username . "'s") . " Rosters";
		
		include "og.php"
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRosters('<?php echo $uid ?>');">
		<?php include "topnav.shtml" ?>
			
		<!-- Dialogs -->
		<?php include "templates/dialogs.shtml" ?>
		
		<h1 class="orange"><span class="fas fa-users fa-fw"></span>&nbsp;<?php echo ($ismine ? "My" : $myUser->username) ?> Rosters</h1>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<br/>
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Rosters...
			</div>
		</h3>
		<br/>
		<!-- Show this player's rosters -->
		<div class="container-fluid" ng-hide="loading">
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
					<i id="myrostershelpbutton" class="far fa-question-circle fa-fw" onclick="$('#myrostershelp').modal('show');"></i>
				</span>
			</div>
			<br/>
			<br/>
				<?php
			} ?>
			
			<div class="row p-0 m-0">
				<div class="col-12 col-md-6 col-xl-4 p-0 m-0" ng-repeat="myRoster in myRosters | orderBy: 'seq'">
					<?php include "templates/roster_card.shtml" ?>
					<div class="row">
						<div class="col-7">
							<h3 id="myRoster.rosterid"><a href="/roster.php?rid={{ myRoster.rosterid }}">
								{{ myRoster.rostername }}
							</a></h3>
							<?php
							if ($ismine) {
							?>
							<button class="btn btn-primary" ng-click="initDeploy(myRoster);">Deploy!</button>
							<?php
						} ?>
						</div>
						<div class="col-5" style="text-align: right;">
							<a class="float-end" ng-href="/killteam.php?fa={{myRoster.factionid}}&kt={{myRoster.killteamid}}">{{myRoster.killteamname}}</a><br/>
							<?php
							if ($ismine) {
							?>
							<i class="pointer fas fa-arrow-up fa-fw" ng-click="moveRosterUp(myRoster, myRoster.seq);"></i>
							<i class="pointer fas fa-arrow-down fa-fw" ng-click="moveRosterDown(myRoster, myRoster.seq);"></i>
							<i class="pointer fas fa-edit fa-fw" ng-click="initRenameRoster(myRoster);"></i>
							<i class="pointer fas fa-share-square fa-fw" ng-click="trackEvent('myRosters', 'getshareurl'); showShareRoster(myRoster);"></i>
							<i class="pointer far fa-copy fa-fw" ng-click="cloneRoster(myRoster, $index);"></i>
							<!-- i class="pointer fas fa-print fa-fw" ng-click="initPrintRoster(myRoster);"></i -->
							<i class="pointer fas fa-trash-alt fa-fw" ng-click="initDeleteRoster(myRoster);"></i>
							<?php
							}
							?>
						</div>
					</div>
					<p ng-model="myRoster.notes"></p>
					<div>
						{{ myRoster.opList }}
					</div>
					<p>
						<em>{{ myRoster.notes }}</em>
					</p>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>