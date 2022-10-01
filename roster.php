<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested user team id
	$utid = $_REQUEST['ut'];
	if ($utid == null || $utid == '') {
		$utid = $_REQUEST['utid'];
	}
	if ($utid == null || $utid == '') {
		$utid = $_REQUEST['rosterid'];
	}
	
	$myRoster = Roster::GetRoster($utid);
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
			<div class="row">
				<div class="col-7">
					<h1 style="display: inline;"><span class="fas fa-users fa-fw"></span>&nbsp;<?php echo $ismine ? "" : $myRoster->username . "'s " ?><?php echo $myRoster->rostername ?></h1>
				</div>
				<div class="col-5" style="text-align: right;">
					<a ng-href="/killteam.php?fa=<?php echo $myRoster->factionid ?>&kt=<?php echo $myRoster->killteamid ?>"><?php echo $myRoster->killteamname ?></a>&nbsp;&nbsp;
					<div class="col-12" ng-if="!loading && <?php echo $ismine > 0 ? "true" : "false" ?>">
						<i class="far fa-plus-square fa-fw" ng-click="initAddOp(myRoster);"></i>
						<i class="fas fa-edit fa-fw" ng-click="initRenameTeam(myRoster);"></i>
						<i class="fas fa-share-square fa-fw" ng-click="trackEvent('myRoster', 'getshareurl'); showShareRoster(myRoster);"></i>
						<i class="fas fa-print fa-fw" ng-click="initPrintRoster(myRoster);"></i>
						&nbsp;&nbsp;
					</div>
					<div class="col-12" ng-if="!loading && !<?php echo $ismine > 0 ? "true" : "false" ?>">
						<?php
							if ($me != null) {
								// User is logged in
								?>
								<a href="" ng-click="initImportRoster(myRoster);"><i class="far fa-plus-square fa-fw"></i> Add to My Rosters</a>
								<?php
							} else {
								// User is not logged in
								?>
								<a href="/login.htm"><i class="fas fa-lock fa-fw"></i> Log In to Import Roster</a>
								<?php
							}
						?>
						&nbsp;&nbsp;
					</div>
				</div>
			</div>
		</div>
		
		<div class="container-fluid">
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
				This roster does not have any operatives yet, <a href="" ng-click="initAddOp(myRoster);">add one now</a>
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
				<div ng-repeat="myOp in myRoster.operatives track by $index" style="display: none;">
					<div class="row">
						<div class="col-7">
							<h3 style="display: inline;">{{myOp.opname}}</h3>
						</div>
						<div class="col-5" style="text-align: right;">
							{{myOp.baseoperative.opname}}<br/>
							<div ng-show="<?php echo $ismine > 0 ? "true" : "false" ?>">
								<i class="fas fa-arrow-up fa-fw" ng-click="moveOpUp(team, operative, $index);"></i>
								<i class="fas fa-arrow-down fa-fw" ng-click="moveOpDown(team, operative, $index);"></i>
								<i class="fas fa-edit fa-fw" ng-click="initEditOp(operative, team);"></i>
								<!-- a ng-href="/operative.php?fa={{ operative.factionid }}&kt={{ operative.killteamid }}&ft={{ operative.fireteamid }}&op={{ operative.opid }}&opname={{ operative.opname }}&weps={{ operative.wepids}}" target="_blank"><i class="fas fa-print fa-fw"></i></a -->
								<i class="fas fa-trash-alt fa-fw" ng-click="initRemoveOp(operative, team);"></i>
							</div>
						</div>
					</div>
					
					<div class="container-fluid">
						<span ng-repeat="weapon in myOp.weapons">				
							<ANY ng-switch="weapon.weptype" class="fas fa-fw">
							  <ANY ng-switch-when="R">&#x2295;</ANY>
							  <ANY ng-switch-when="M">&#x2694;</ANY>
							  <ANY ng-switch-default>&#x26ED;</ANY>
							</ANY>
							{{ weapon.wepname }}
							{{$last ? '' : ', '}}							
						</span>
						<br/>
						<span ng-repeat="eq in myOp.equipments" class="d-inline">				
							{{ eq.eqname }}
							{{$last ? '' : ', '}}							
						</span>
					</div>
					
					<hr ng-if="!$last" style="margin-left: 10px; margin-right: 10px;" />
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>