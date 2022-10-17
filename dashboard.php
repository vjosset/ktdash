<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	$me = Session::CurrentUser();
	
	if ($me == null) {
		// Not logged in, send them to login page
		header("Location: /login.htm");
		exit;
	}
	
	$uid = Session::CurrentUser()->userid;
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = "Dashboard";
			$pagedesc  = $myRoster->rostername . " - View and import " . ($myRoster->userid == 'prebuilt' ? "Pre-Built " : "") . $myRoster->killteamname . " KillTeam: \r\n" . $myRoster->opList;
			$pageimg   = "https://beta.ktdash.app/img/dashboard.png";
			$pageurl   = "https://beta.ktdash.app/dashboard.php";
			include "og.php";
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initSession();initDashboard()"
		style="
			background-color: rgba(32, 32, 32, 0.9);
			background-attachment:fixed;
			background-image: url(/api/rosterportrait.php?rid={{ dashboardroster.rosterid }});
			background-position: top center;
			background-size: cover;
			background-blend-mode: multiply;">
		<?php
			include "topnav.shtml";
			include "templates/dialogs.shtml";
		?>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading...
			</div>
		</h3>
		
		<div class="ng-cloak">
			<!-- Header/Title - Team selection and CP/VP/TP tracker -->
			<div class="container-fluid orange">
				<div class="row">
					<div class="col-8">
						<!-- Roster Selector -->
						<h1>
							<div class="dropdown">
								<div ng-if="dashboardroster == null || dashboardroster.rostername == ''">Select a Team</div>
								<button class="btn dropdown-toggle orange form-control text-start" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-target="#rosterselect">
									<h3 class="d-inline">{{ dashboardroster.rostername }}</h3>
								</button>
								<div class="dropdown-menu" id="rosterselect">
									<a class="dropdown-item" type="button" ng-repeat="roster in currentuser.rosters" ng-click="selectDashboardRoster(roster);">
										{{ roster.rostername }}
									</a>
								</div>
							</div>
						</h1>
					</div>
					<div class="col-4 text-end">				
						<a class="pointer" ng-click="resetDash(dashboardroster);">
							<i class="fas fa-undo-alt fa-fw"></i>
						</a>
					</div>
				</div>
				
				<!-- Trackers -->
				<center class="container">
					<div class="row">
						<h3 class="col-4">
							CP
						</h3>
						<h3 class="col-4">
							Turn
						</h3>
						<h3 class="col-4">
							VP
						</h3>
					</div>
					<div class="row">
						<h3 class="col-4">
							<span class="pointer small float-start" ng-click="updateCP(-1, dashboardroster);"><i class="far fa-minus-square fa-fw"></i></span>
							
							<span ng-bind="dashboardroster.CP"></span>
							
							<span class="pointer small float-end" ng-click="updateCP(1, dashboardroster);"><i class="far fa-plus-square fa-fw"></i></span>
						</h3>
						<h3 class="col-4">
							<span class="pointer small float-start" ng-click="updateTP(-1, dashboardroster);"><i class="far fa-minus-square fa-fw"></i></span>
							
							<span ng-bind="dashboardroster.TP"></span>
							
							<span class="pointer small float-end" ng-click="updateTP(1, dashboardroster);"><i class="far fa-plus-square fa-fw"></i></span>
						</h3>
						<h3 class="col-4">
							<span class="pointer small float-start" ng-click="updateVP(-1, dashboardroster);"><i class="far fa-minus-square fa-fw"></i></span>
							
							<span ng-bind="dashboardroster.VP"></span>
							
							<span class="pointer small float-end" ng-click="updateVP(1, dashboardroster);"><i class="far fa-plus-square fa-fw"></i></span>
						</h3>
					</div>
				</center>
			</div>
			
			
			<!-- Resource Point tracker -->
			<div class="cinzel container-fluid cinzel" ng-if="dashboardroster.killteamid == 'NOV' || dashboardroster.killteamid == 'VDT'">
				<div class="h5">
					{{ RPLabels[dashboardroster.factionid][dashboardroster.killteamid]["Label"] }}
					&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="small" ng-click="updateRP(-1);commitTeams();"><i class="far fa-minus-square fa-fw"></i></span>
					
					<span ng-bind="dashboardroster.RP"></span>
					
					<span class="small" ng-click="updateRP(1);commitTeams();"><i class="far fa-plus-square fa-fw"></i></span>
				</div>
			</div>
			
			<ul class="nav nav-tabs dark" id="mytabs" role="tablist">
				<li class="nav-item m-0 p-0" role="presentation">
					<a class="nav-link active dark" id="op-tab" data-bs-toggle="tab" data-bs-target="#ops" type="button" role="tab" aria-controls="ops" aria-selected="true">
						Operatives
					</a>
				</li>
				<li class="nav-item m-0 p-0" role="presentation">
					<a class="nav-link dark" id="ploy-tab" data-bs-toggle="tab" data-bs-target="#ploys" type="button" role="tab" aria-controls="ploys" aria-selected="false">
						Ploys
					</a>
				</li>
				<li class="nav-item m-0 p-0" role="presentation">
					<a class="nav-link dark" id="eq-tab" data-bs-toggle="tab" data-bs-target="#eqs" type="button" role="tab" aria-controls="eqs" aria-selected="false">
						Equip
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane show active" id="ops" role="tabpanel">
					<!-- KillTeam Comp popup -->
					<!-- h3 class="cinzel" ng-click="showpopup(dashboard.myteam.killteam.killteamname + ' - KillTeam Composition', dashboard.myteam.killteam.killteamcomp);" -->
					
					<!-- Operative Selector -->
					<h3 class="pointer" ng-click="initSelectRosterOps(dashboardroster);">
						<i class="text-small fas fa-edit fa-fw"></i>Select Operatives <sup class="small"></sup>
					</h3>
					
					<!-- Archetype -->
					<h6 class="d-inline">Archetype</h6>: <small ng-bind="getRosterArchetype(dashboardroster)"></small>
					
					<!-- Operatives -->
					<div class="row p-0 m-0">
						<div class="col-12 col-md-6 col-xl-4 p-0 m-0" ng-repeat="operative in dashboardroster.operatives track by $index" ng-if="!operative.hidden">
							<?php include "templates/op_card.shtml" ?>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="ploys" role="tabpanel">
					<!-- Strategic Ploys -->
					<div class="h3 cinzel">Strategic Ploys</div>
					<div class="row p-0 m-0" ng-repeat="ploy in dashboardroster.killteam.ploys.strat">
						<div class="col-12 col-lg-6">
							<?php include "templates/ploy.shtml" ?>
						</div>
					</div>
					<div class="h3 cinzel">Tactical Ploys</div>
					<div class="row p-0 m-0" ng-repeat="ploy in dashboardroster.killteam.ploys.tac">
						<div class="col-12 col-lg-6">
							<?php include "templates/ploy.shtml" ?>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="eqs" role="tabpanel">
					<!-- Equipment -->
					<div class="row p-0 m-0">
						<div ng-repeat="eq in dashboardroster.killteam.equipments" class="col-12 col-lg-6 col-xl-4">
							<?php include "templates/eq.shtml" ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>