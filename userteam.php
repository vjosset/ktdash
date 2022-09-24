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
		$utid = $_REQUEST['userteamid'];
	}
	
	$myTeam = UserTeam::GetUserTeam($utid);
	$myTeam->loadOperatives();
	$me = Session::CurrentUser();
	$ismine = $me != null && $me->userid == $myTeam->userid;
	echo "<!-- Mine: $ismine -->";
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		<title><?php echo $myTeam->userteamname ?> | KTDash.app</title>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initMyTeam('<?php echo $myTeam->userteamid ?>');">
		<?php include "topnav.shtml" ?>
		
		<div class="container">
			<div class="orange">
				<div class="row">
					<div class="col-7">
						<h1 style="display: inline;"><?php echo $myTeam->userteamname ?></h1>
					</div>
					<div class="col-5" style="text-align: right;">
						<a ng-href="/killteam.php?fa=<?php echo $myTeam->factionid ?>&kt=<?php echo $myTeam->killteamid ?>"><?php echo $myTeam->killteamname ?></a>&nbsp;&nbsp;
						<div class="col-12" ng-if="!loading && <?php echo $ismine > 0 ? "true" : "false" ?>">
							<i class="far fa-plus-square fa-fw" ng-click="initAddOp(myTeam);"></i>
							<i class="fas fa-edit fa-fw" ng-click="initRenameTeam(myTeam);"></i>
							<i class="fas fa-share-square fa-fw" ng-click="trackEvent('myTeam', 'getshareurl'); showShareTeam(myTeam);"></i>
							<!-- i class="fas fa-print fa-fw" ng-click="initPrintTeam(myTeam);"></i -->
							<i class="fas fa-trash-alt fa-fw" ng-click="initDeleteTeam(myTeam);"></i>
							&nbsp;&nbsp;
						</div>
						<div class="col-12" ng-if="!loading && !<?php echo $ismine > 0 ? "true" : "false" ?>">
							<a href="" ng-click="initImportTeam(myTeam);"><i class="far fa-plus-square fa-fw"></i> Add to My Teams</a>
							&nbsp;&nbsp;
						</div>
					</div>
				</div>
			</div>
			
			<!-- loadWaiter -->
			<h3 class="center" ng-show="loading">
				<div>
					<i class="fas fa-undo-alt fa-fw rotate" ></i>
					<br />
					Loading Team...
				</div>
			</h3>
			
			<!-- Show this team -->
			<div class="container-fluid" ng-hide="loading">
				<div class="container-fluid" ng-repeat="myOp in myTeam.operatives track by $index">
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
								<i class="fas fa-trash-alt fa-fw" ng-click="initRemoveOperative(operative, team);"></i>
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
		<!--#include virtual="/footer.shtml" -->
	</body>
</html>