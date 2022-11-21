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
			$pagedesc  = "KillTeam Game Dashboard";
			$pageimg   = "https://ktdash.app/img/dashboard.png";
			$pageurl   = "https://ktdash.app/dashboard.php";
			include "og.php";
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initDashboard()"
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
		
		<div class="ng-cloak" ng-hide="loading">
			<!-- Header/Title - Team selection and CP/VP/TP tracker -->
			<div class="container-fluid orange">
				<div class="row">
					<div class="col-11">
						<!-- Roster Selector -->
						<h1>
							<div class="dropdown">
								<div ng-if="dashboardroster == null || dashboardroster.rostername == ''">Select a Team</div>
								<button class="btn dropdown-toggle orange form-control text-start" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-target="#rosterselect">
									<h3 class="d-inline">{{ dashboardroster.rostername }}</h3>
								</button>
								<div class="dropdown-menu dropdown-menu-dark" id="rosterselect">
									<a class="dropdown-item" type="button" ng-repeat="roster in currentuser.rosters track by $index" ng-click="selectDashboardRoster(roster);">
										{{ roster.rostername }}
									</a>
								</div>
							</div>
						</h1>
					</div>
			
					<div class="col-1 m-0 p-0 align-text-top text-end">
						<div class="btn-group">
							<a role="button" id="dashactions" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fas fa-ellipsis-h fa-fw"></i>
							</a>
							<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dashactions">
								<li><a class="pointer dropdown-item p-1 navloader" href="/roster.php?rid={{ dashboardroster.rosterid }}"><i class="fas fa-users fa-fw"></i> Go To Roster</a></li>
								<li><a class="pointer dropdown-item p-1" ng-click="initSelectRosterOps(dashboardroster);"><i class="fas fa-edit fa-fw"></i> Select Operatives</a></li>
								<li><a class="pointer dropdown-item p-1 navloader" href="/rostergallery.php?rid={{ dashboardroster.rosterid }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Gallery"><i class="fas fa-images fa-fw"></i> Roster Gallery</a></li>
								<li><a class="pointer dropdown-item p-1" ng-click=" resetDash(dashboardroster);"><i class="fas fa-undo-alt fa-fw"></i> Reset Dashboard</a></li>
							</ul>
						</div>
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
							<span class="pointer small" ng-click="updateCP(-1, dashboardroster);"><i class="far fa-minus-square fa-fw"></i></span>
							
							<span ng-bind="dashboardroster.CP"></span>
							
							<span class="pointer small" ng-click="updateCP(1, dashboardroster);"><i class="far fa-plus-square fa-fw"></i></span>
						</h3>
						<h3 class="col-4">
							<span class="pointer small" ng-click="updateTP(-1, dashboardroster);"><i class="far fa-minus-square fa-fw"></i></span>
							
							<span ng-bind="dashboardroster.TP"></span>
							
							<span class="pointer small" ng-click="updateTP(1, dashboardroster);"><i class="far fa-plus-square fa-fw"></i></span>
						</h3>
						<h3 class="col-4">
							<span class="pointer small" ng-click="updateVP(-1, dashboardroster);"><i class="far fa-minus-square fa-fw"></i></span>
							
							<span ng-bind="dashboardroster.VP"></span>
							
							<span class="pointer small" ng-click="updateVP(1, dashboardroster);"><i class="far fa-plus-square fa-fw"></i></span>
						</h3>
					</div>
				</center>
			</div>
			
			<!-- Resource Point tracker -->
			<div class="container-fluid" ng-if="RPLabels[dashboardroster.factionid][dashboardroster.killteamid]">
				<div class="h5 cinzel">
					{{ RPLabels[dashboardroster.factionid][dashboardroster.killteamid]["Label"] }}
					&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="small" ng-click="updateRP(-1, dashboardroster);"><i class="far fa-minus-square fa-fw"></i></span>
					
					<span ng-bind="dashboardroster.RP"></span>
					
					<span class="small" ng-click="updateRP(1, dashboardroster);"><i class="far fa-plus-square fa-fw"></i></span>
				</div>
			</div>
			
			<ul class="nav nav-tabs" id="mytabs" role="tablist">
				<li class="nav-item m-0 p-0 dark" role="presentation">
					<a class="nav-link active dark" id="op-tab" data-bs-toggle="tab" data-bs-target="#ops" type="button" role="tab" aria-controls="ops" aria-selected="true">
						Operatives
					</a>
				</li>
				<li class="nav-item m-0 p-0 dark" role="presentation">
					<a class="nav-link dark" id="ploy-tab" data-bs-toggle="tab" data-bs-target="#ploys" type="button" role="tab" aria-controls="ploys" aria-selected="false">
						Ploys
					</a>
				</li>
				<li class="nav-item m-0 p-0 dark" role="presentation">
					<a class="nav-link dark" id="eq-tab" data-bs-toggle="tab" data-bs-target="#eqs" type="button" role="tab" aria-controls="eqs" aria-selected="false">
						Equip
					</a>
				</li>
			</ul>
			<div class="tab-content p-0 m-0">
				<div class="tab-pane show active" id="ops" role="tabpanel">
					<!-- Archetype -->
					<h6 class="d-inline">Archetype</h6>: <small ng-bind="getRosterArchetype(dashboardroster)"></small>
					
					<!-- Operatives -->
					<div class="row p-0 m-0">
						<div ng-if="!operative.hidden && (settings['display'] == 'card' || settings['display'] == null)" class="col-12 col-md-6 col-xl-4 m-0 p-0" ng-repeat="operative in dashboardroster.operatives track by $index">
							<?php include "templates/op_card.shtml" ?>
						</div>
						<div ng-if="!operative.hidden && settings['display'] == 'list'" class="col-12 col-md-6 col-xl-4 m-0 p-0" ng-repeat="operative in dashboardroster.operatives track by $index">
							<?php include "templates/op_list.shtml" ?>
						</div>
					</div>
				</div>
				<div class="tab-pane m-0 p-0" id="ploys" role="tabpanel">
					<div class="row container-fluid m-0 p-0">
						<div class="col-xs-12 col-md-6">
							<!-- Strategic Ploys -->
							<h3>Strategic Ploys</h3>
							<ANY ng-repeat="ploy in dashboardroster.killteam.ploys.strat track by $index">
								<?php include "templates/ploy.shtml" ?>
							</ANY>
						</div>
						<div class="col-xs-12 col-md-6">
							<!-- Tactical Ploys -->
							<h3>Tactical Ploys</h3>
							<ANY ng-repeat="ploy in dashboardroster.killteam.ploys.tac track by $index">
								<?php include "templates/ploy.shtml" ?>
							</ANY>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="eqs" role="tabpanel">
					<!-- Equipment -->
					<div class="row p-0 m-0">
						<div ng-repeat="eq in dashboardroster.killteam.equipments track by $index" class="col-12 col-lg-6 col-xl-4">
							<?php include "templates/eq.shtml" ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>