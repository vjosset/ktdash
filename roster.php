<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested roster id
	$rid = getIfSet($_REQUEST['r'], '');
	if ($rid == null || $rid == '') {
		$rid = getIfSet($_REQUEST['rid']);
	}
	if ($rid == null || $rid == '') {
		$rid = getIfSet($_REQUEST['rosterid']);
	}
	
	$myRoster = Roster::GetRoster($rid);
	if ($myRoster == null) {
		// Roster not found
		//	Send them to login I guess?
		header("Location: /login.htm");
		exit;
	}
	$myRoster->loadOperatives();
	$me = Session::CurrentUser();
	$ismine = $me != null && $me->userid == $myRoster->userid;
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = $myRoster->rostername . " - " . ($myRoster->userid == 'prebuilt' ? "Pre-Built " : "") . $myRoster->killteamname . " KillTeam". ($ismine ? "" : (" by " . $myRoster->username));
			$pagedesc  = $myRoster->rostername . " - View and import " . ($myRoster->userid == 'prebuilt' ? "Pre-Built " : "") . $myRoster->killteamname . " KillTeam: \r\n" . $myRoster->oplist;
			$pageimg   = "https://ktdash.app/api/rosterportrait.php?rid={$myRoster->rosterid}";
			$pageurl   = "https://ktdash.app/roster.php?rid={$myRoster->rosterid}";
			include "og.php";
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRoster('<?php echo $myRoster->rosterid ?>');"
		style="
			background-color: rgba(32, 32, 32, 0.9);
			background-attachment:fixed;
			background-image: url(/api/rosterportrait.php?rid=<?php echo $myRoster->rosterid ?>);
			background-position: top center;
			background-size: cover;
			background-blend-mode: multiply;">
		<?php
			include "topnav.shtml";
			include "templates/dialogs.shtml";
		?>
		
		<div class="orange container-fluid">
			<h1 class="pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Killteam Composition" ng-click="showpopup('Kill Team Composition', getKillTeamComp(myRoster));te('roster', 'killteamcomp', '', myRoster.rosterid);">
				<i class="fas fa-users fa-fw"></i>
				&nbsp;
				<?php echo $myRoster->rostername ?>
				<sup><i class="h5 fas fa-info-circle fa-fw"></i></sup>
			</h1>
			<div class="row">
				<div class="col-7">
					<a class="navloader" ng-href="/killteam.php?fa=<?php echo $myRoster->factionid ?>&kt=<?php echo $myRoster->killteamid ?>">
						<?php echo $myRoster->killteamname ?>
						<br class="d-inline d-sm-none" />
						<?php if (!$ismine) { ?>
						by&nbsp;<a class="navloader" href="/rosters.php?uid=<?php echo $myRoster->userid ?>"><span class="badge bg-dark"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $myRoster->username ?></span></a>
						<?php }
						else {?>
						<span ng-show="totalEqPts(myRoster) > 0">({{ totalEqPts(myRoster) }} Eq Pts)</span>
						<?php }?>
					</a>
				</div>
				<div class="col-5 text-end">
					<div class="col-12" ng-if="!loading && <?php echo $ismine > 0 ? "true" : "false" ?>">
						<i class="pointer far fa-plus-square fa-fw" ng-click="initAddOp(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Operative"></i>
						<i class="pointer fas fa-edit fa-fw" ng-click="initEditRoster(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Rename Roster"></i>
						<i class="pointer fas fa-file-alt fa-fw" ng-click="showpopup(myRoster.rostername, getRosterTextDescription(myRoster));"></i>
						<!-- i class="pointer fas fa-print fa-fw" ng-click="initPrintRoster(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Roster"></i -->
						<i ng-if="settings['display'] == 'list'" class="pointer far fa-id-card fa-fw" ng-click="setSetting('display', 'card');"></i>
						<i ng-if="settings['display'] == 'card' || settings['display'] == null" class="pointer fas fa-list fa-fw" ng-click="setSetting('display', 'list');"></i>
						<i class="pointer far fa-question-circle fa-fw" id="myrosterhelpbutton" onclick="$('#myrosterhelpmodal').modal('show');te('roster', 'help');"></i>
					</div>
					<div class="col-12" ng-if="!loading && !<?php echo $ismine > 0 ? "true" : "false" ?>">
						<?php
							if ($me != null) {
								// User is logged in
								?>
								<a href="" ng-click="cloneRoster(myRoster);"><i class="fas fa-file-import fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Import Roster"></i>
								<span class="d-none d-md-inline">Add to My Rosters</span></a>
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
		
		<!-- Help Box -->
		<div class="modal fade oswald" id="myrosterhelpmodal" tabindex="-1" role="dialog" aria-labelledby="myrosterhelpmodallabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content dark">
					<div class="modal-header orange">
						<h5 class="modal-title cinzel" id="myrosterhelpmodallabel"><i class="pointer far fa-question-circle fa-fw"></i> My Roster - Help</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="m-0 modal-body dark">
						Manage your Roster and Operatives here.
						<br/>
						<img width="100%" src="/img/RosterHelp.jpg" /><br/>
						<h6 class="d-inline fa-fw">1:</h6>&nbsp;&nbsp;<i class="fas fa-edit fa-fw"></i> Change Operative Portrait</br>
						<h6 class="d-inline fa-fw">2:</h6>&nbsp;&nbsp;<i class="fas fa-arrow-up fa-fw"></i> Move Operative Up</br>
						<h6 class="d-inline fa-fw">3:</h6>&nbsp;&nbsp;<i class="fas fa-arrow-down fa-fw"></i> Move Operative Down</br>
						<h6 class="d-inline fa-fw">4:</h6>&nbsp;&nbsp;<i class="fas fa-edit fa-fw"></i> Edit Operative (name, weapons, and equipment)</br>
						<h6 class="d-inline fa-fw">5:</h6>&nbsp;&nbsp;<i class="fas fa-trash-alt fa-fw"></i> Delete Operative
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
				Loading Roster...
			</div>
		</h3>
		
		<!-- Show this roster and its operatives -->
		<div class="ng-cloak p-0 m-1" ng-hide="loading">
			<div ng-if="myRoster.operatives == null || myRoster.operatives.length == 0">
				This roster does not have any operatives yet
				<?php 
				if ($ismine) {
				?>
				<a href="" ng-click="initAddOp(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Operative">add one now</a>
				<?php
				}
				?>
			</div>
			
			<!--
			<i class="fas fa-eye fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="View Count"></i> {{ myRoster.viewcount }}
			<i class="fas fa-file-import fa-fw" data-bs-toggle="tooltip" data-bs-placement="top" title="Import Count"></i> {{ myRoster.importcount }}
			-->
			
			<!-- Show this roster's operatives -->
			<div class="row p-0 m-0">
				<div ng-if="settings['display'] == 'card' || settings['display'] == null" class="col-12 col-md-6 col-xl-4 m-0 p-0" ng-repeat="operative in myRoster.operatives | orderBy: 'seq' track by $index">
					<?php include "templates/op_card.shtml" ?>
				</div>
				<div ng-if="settings['display'] == 'list'" class="col-12 col-md-6 col-xl-4 m-0 p-0" ng-repeat="operative in myRoster.operatives | orderBy: 'seq' track by $index">
					<?php include "templates/op_list.shtml" ?>
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>