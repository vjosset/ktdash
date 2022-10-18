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
		<?php
			include "header.shtml";
			$pagetitle = $myRoster->rostername . " - " . ($myRoster->userid == 'prebuilt' ? "Pre-Built " : "") . $myRoster->killteamname . " KillTeam";
			$pagedesc  = $myRoster->rostername . " - View and import " . ($myRoster->userid == 'prebuilt' ? "Pre-Built " : "") . $myRoster->killteamname . " KillTeam: \r\n" . $myRoster->opList;
			$pageimg   = "https://beta.ktdash.app/api/rosterportrait.php?rid={$myRoster->rosterid}";
			$pageurl   = "https://beta.ktdash.app/roster.php?rid={$myRoster->rosterid}";
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
			<h1>
				<i class="fas fa-users fa-fw"></i>
				&nbsp;
				<?php 
				if (!$ismine) {
				?>
					<a class="navloader" href="/rosters.php?uid=<?php echo $myRoster->userid ?>"><?php echo $myRoster->username ?></a>'s
				<?php
				}?>
				{{ myRoster.rostername }}
			</h1>
			<div class="row">
				<div class="col-7">
					<a ng-href="/killteam.php?fa=<?php echo $myRoster->factionid ?>&kt=<?php echo $myRoster->killteamid ?>"><?php echo $myRoster->killteamname ?></a>&nbsp;&nbsp;
				</div>
				<div class="col-5" style="text-align: right;">
					<div class="col-12" ng-if="!loading && <?php echo $ismine > 0 ? "true" : "false" ?>">
						<i class="pointer far fa-plus-square fa-fw" ng-click="initAddOp(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Operative"></i>
						<i class="pointer fas fa-edit fa-fw" ng-click="initEditRoster(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Rename Roster"></i>
						<i class="pointer fas fa-print fa-fw" ng-click="initPrintRoster(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Roster"></i>
						<i class="pointer far fa-question-circle fa-fw" id="myrosterhelpbutton" onclick="$('#myrosterhelpmodal').modal('show');"></i>
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
		<div class="ng-cloak container-fluid" ng-hide="loading">
			<?php 
			if ($ismine) {
			?>
			<br/>
			<div ng-if="myRoster.operatives == null || myRoster.operatives.length == 0">
				This roster does not have any operatives yet, <a href="" ng-click="initAddOp(myRoster);" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Operative">add one now</a>
			</div>
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
			<div class="row">
				<div class="col-12 col-md-6 col-xl-4 m-0 p-1" ng-repeat="operative in myRoster.operatives | orderBy: 'seq' track by $index">
					<?php include "templates/op_card.shtml" ?>
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>