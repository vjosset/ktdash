<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested roster id
	$rid = $_REQUEST['r'];
	if ($rid == null || $rid == '') {
		$rid = $_REQUEST['rid'];
	}
	if ($rid == null || $rid == '') {
		$rid = $_REQUEST['rosterid'];
	}
	
	$myRoster = Roster::GetRoster($rid);
	$myRoster->loadOperatives();
	$me = Session::CurrentUser();
	$ismine = $me != null && $me->userid == $myRoster->userid;
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		<title><?php echo $myRoster->rostername ?> | KTDash.app</title>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRoster('<?php echo $myRoster->rosterid ?>');">
		<?php include "topnav.shtml" ?>
			
		<!-- Dialogs -->
		<?php include "templates/dialogs.shtml" ?>
		
		<div class="orange container-fluid">
			<h1 style="display: inline;"><span class="fas fa-users fa-fw"></span>&nbsp;
				<!-- ?php echo $ismine ? "" : $myRoster->username . "'s " ? --><!-- ?php echo $myRoster->rostername ? -->
				<!-- span ng-if="!<?php echo $ismine ? "true" : "false" ?>"><?php echo $myRoster->username . ($myRoster->userid == "prebuilt" ? "" : "'s ") ?></span -->
				<span>{{ myRoster.rostername }}</span>
			</h1>
			<div class="row">
				<div class="col-7">
					<a ng-href="/killteam.php?fa=<?php echo $myRoster->factionid ?>&kt=<?php echo $myRoster->killteamid ?>"><?php echo $myRoster->killteamname ?></a>&nbsp;&nbsp;
				</div>
				<div class="col-5" style="text-align: right;">
					<div class="col-12" ng-if="!loading && <?php echo $ismine > 0 ? "true" : "false" ?>">
						<i class="pointer far fa-plus-square fa-fw" ng-click="initAddOp(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Operative"></i>
						<i class="pointer fas fa-edit fa-fw" ng-click="initRenameRoster(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Rename Roster"></i>
						<i class="pointer fas fa-print fa-fw" ng-click="initPrintRoster(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Roster"></i>
					</div>
					<div class="col-12" ng-if="!loading && !<?php echo $ismine > 0 ? "true" : "false" ?>">
						<?php
							if ($me != null) {
								// User is logged in
								?>
								<a href="" ng-click="cloneRoster(myRoster);"><i class="far fa-plus-square fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Import Roster"></i> Add to My Rosters</a>
								<?php
							} else {
								// User is not logged in
								?>
								<a href="/login.htm"><i class="fas fa-lock fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Log in to import"></i> Log In to Import</a>
								<?php
							}
						?>
						&nbsp;&nbsp;
					</div>
				</div>
			</div>
		</div>
		
		<div>
			<!-- loadWaiter -->
			<h3 class="center" ng-show="loading">
				<br/>
				<div>
					<i class="fas fa-undo-alt fa-fw rotate" ></i>
					<br />
					Loading Roster...
				</div>
			</h3>
			<?php 
			if ($ismine) {
			?>
			<br/>
			<div ng-hide="loading" ng-if="myRoster.operatives == null || myRoster.operatives.length == 0">
				This roster does not have any operatives yet, <a href="" ng-click="initAddOp(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Operative">add one now</a>
			</div>
			<?php
			}
			?>
			<?php 
			if ($ismine) {
			?>
			<h3 class="pointer" aria-expanded="true" data-bs-toggle="collapse" data-bs-target="#killteamcomp" data-bs-toggle="tooltip" data-bs-placement="top" title="Expand Killteam Composition">
				<i class="fas fa-chevron-down fa-fw"></i>&nbsp;KillTeam Composition
			</h3>
			<div id="killteamcomp" class="collapse">
				<p ng-bind-html="myRoster.killteam.killteamcomp"></p>
				<div ng-if="myRoster.killteam.fireteams.length > 1" ng-repeat="fireteam in myRoster.killteam.fireteams track by $index">
					<h5>{{ fireteam.fireteamname }}</h5>
					<p ng-bind-html="fireteam.fireteamcomp"></p>
				</div>
			</div>
			<?php
			}
			?>
			
			<!-- Show this roster -->
			<div ng-hide="loading" ng-if="myRoster.operatives.length > 0">
				<div class="row p-0 m-0">
					<div class="col-12 col-md-6 col-xl-4 p-0 m-0" ng-repeat="operative in myRoster.operatives track by $index">
						<?php include "templates/op_card.shtml" ?>
					</div>
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>