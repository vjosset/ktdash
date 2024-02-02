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
	
	$rid = getIfSet($_REQUEST['r'], '');
	if ($rid == null || $rid == '') {
		$rid = getIfSet($_REQUEST['rid']);
	}
	if ($rid == null || $rid == '') {
		$rid = getIfSet($_REQUEST['rosterid']);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = "Dashboard";
			$pagedesc  = "KillTeam Game Dashboard";
			$pagekeywords = "Dashboard, track, VP, CP, TP";
			$pageimg   = "https://ktdash.app/img/dashboard.png";
			$pageurl   = "https://ktdash.app/dashboard";
			include "og.php";
		?>
		<style>
		<?php include "css/styles.css"; ?>
		</style>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initDashboard('<?php echo $rid ?>')">
		<!-- style="
			background-color: rgba(32, 32, 32, 0.9);
			background-attachment:fixed;
			background-image: url(/api/rosterportrait.php?rid={{ dashboardroster.rosterid }});
			background-position: top center;
			background-size: cover;
			background-blend-mode: multiply;"-->
		<?php
			include "topnav.shtml";
			include "templates/dialogs.shtml";
		?>
		
		<script type="text/javascript">
			// Pre-load current user
			document.body.setAttribute("currentuser", JSON.stringify(<?php echo json_encode($me) ?>));
		</script>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading...
			</div>
		</h3>
		
		<div class="ng-cloak" ng-hide="loading">
			<ul ng-if="dashboardopponentroster != null" class="nav nav-tabs" id="maintabs" role="tablist">
				<li class="nav-item m-0 p-0 dark" role="presentation">
					<a class="nav-link active dark" id="mydash-tab" data-bs-toggle="tab" data-bs-target="#mydash" type="button" role="tab" aria-controls="mydash" aria-selected="true">
						{{ dashboardroster.rostername }}
					</a>
				</li>
				<li class="nav-item m-0 p-0 dark" role="presentation">
					<a class="nav-link dark" id="opponentdash-tab" data-bs-toggle="tab" data-bs-target="#opponentdash" type="button" role="tab" aria-controls="opponentdash" aria-selected="false">
						{{ dashboardopponentroster == null ? "Opponent" : dashboardopponentroster.rostername }}
					</a>
				</li>
			</ul>
			<div class="tab-content p-0 m-0">
				<div class="tab-pane show active p-0 m-0" id="mydash" role="tabpanel">
					<div class="orange row p-0 m-0">
						<h1 class="col-11 p-0 m-0">
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
						<div class="col-1 text-end">
							<a role="button" class="text-end" id="dashactions" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fas fa-ellipsis-h fa-fw"></i>
							</a>
							<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dashactions">
								<li><a class="pointer dropdown-item p-1" onclick="$('#dashboardopponentmodal').modal('show');"><i class="fas fa-people-arrows fa-fw"></i> Select Opponent</a></li>
								<li><a class="pointer dropdown-item p-1" onclick="$('.opinfo').removeClass('show');"><i class="fas fa-compress-arrows-alt fa-fw"></i> Collapse All</a></li>
								<li><a class="pointer dropdown-item p-1" onclick="$('.opinfo').addClass('show');"><i class="fas fa-expand-arrows-alt fa-fw"></i> Expand All</a></li>
								<li><a class="pointer dropdown-item p-1" ng-click="initSelectRosterOps(dashboardroster);"><i class="fas fa-edit fa-fw"></i> Select Operatives</a></li>
								<li><a class="pointer dropdown-item p-1 navloader" href="/r/{{ dashboardroster.rosterid }}"><i class="fas fa-users fa-fw"></i> Go To Roster</a></li>
								<li><a class="pointer dropdown-item p-1 navloader" href="/r/{{ dashboardroster.rosterid }}/g" data-bs-toggle="tooltip" data-bs-placement="top" title="Gallery"><i class="fas fa-images fa-fw"></i> Roster Gallery</a></li>
								<li><a class="pointer dropdown-item p-1" ng-click="resetDash(dashboardroster);"><i class="fas fa-undo-alt fa-fw"></i> Reset Dashboard</a></li>
							</ul>
						</div>
					</div>
					<div class="orange">
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
								<h3 class="col-4" touch-action="manipulation">
									<span class="pointer small" ng-click="updateCP(-1, dashboardroster);"><i class="far fa-minus-square fa-fw"></i></span>
									
									<span ng-bind="dashboardroster.CP"></span>
									
									<span class="pointer small" ng-click="updateCP(1, dashboardroster);"><i class="far fa-plus-square fa-fw"></i></span>
								</h3>
								<h3 class="col-4" touch-action="manipulation">
									<span class="pointer small" ng-click="updateTP(-1, dashboardroster);"><i class="far fa-minus-square fa-fw"></i></span>
									
									<span ng-bind="dashboardroster.TP"></span>
									
									<span class="pointer small" ng-click="updateTP(1, dashboardroster);"><i class="far fa-plus-square fa-fw"></i></span>
								</h3>
								<h3 class="col-4" touch-action="manipulation">
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
						<!-- li class="nav-item m-0 p-0 dark" role="presentation">
							<a class="nav-link dark" id="eq-tab" data-bs-toggle="tab" data-bs-target="#eqs" type="button" role="tab" aria-controls="eqs" aria-selected="false">
								Equip
							</a>
						</li -->
						<li class="nav-item m-0 p-0 dark" role="presentation">
							<a class="nav-link dark" id="t-tab" data-bs-toggle="tab" data-bs-target="#tacops" type="button" role="tab" aria-controls="tacops" aria-selected="false">
								TacOps
							</a>
						</li>
						<li class="nav-item m-0 p-0 dark" role="presentation">
							<a class="nav-link dark" id="eq-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab" aria-controls="notes" aria-selected="false">
								Notes
							</a>
						</li>
					</ul>
					<div class="tab-content p-0 m-0">
						<div class="tab-pane show active" id="ops" role="tabpanel">
							<!-- Archetype -->
							<h6 class="d-inline">Archetype</h6>: <small ng-bind="getRosterArchetype(dashboardroster)"></small>
							
							<!-- Equipment Points -->
							<small ng-show="totalEqPts(dashboardroster) > 0">({{ totalEqPts(dashboardroster) }} EP)</small>
							
							<!-- Operatives -->
							<div class="row p-0 m-0">
								<div ng-if="!operative.hidden" class="col-12 col-md-6 col-xl-4 col-xxl-3 m-0 p-0" ng-repeat="operative in dashboardroster.operatives track by $index">
									<?php include "templates/op_card.shtml" ?>
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
						<!-- div class="tab-pane" id="eqs" role="tabpanel">
							<div class="row p-0 m-0">
								<div ng-repeat="eq in dashboardroster.killteam.equipments track by $index" class="col-12 col-lg-6 col-xl-4">
									<h4 class="text-center line-top-light" ng-if="$index > 0 && dashboardroster.killteam.equipments[$index].eqcategory != dashboardroster.killteam.equipments[$index - 1].eqcategory">
										{{ eq.eqcategory }}
									</h4>
									<div class="line-top-light">
										<h5 class="d-inline">{{ eq.eqname }}</h5>
										<h5 class="d-inline float-end text-end" ng-if="eq.eqpts > '0'">{{ eq.eqpts }} EP&nbsp;&nbsp;</h5>
										<em class="d-inline float-end text-end" ng-if="eq.eqpts == '0'">{{ eq.eqcategory }}&nbsp;&nbsp;</em>
									</div>
									<p class="oswald p-1" style="text-align: justify;" ng-bind-html="eq.eqdescription"></p>
								</div>
							</div>
						</div -->
						<div class="tab-pane" id="tacops" role="tabpanel">
							<!-- TacOps -->
							<div class="row p-0 m-0">
								<!-- Active TacOps -->
								<h3 class="text-center line-top-light">
									Active TacOps
								</h3>
								<div ng-repeat="tacop in dashboardroster.tacops track by $index" class="col-12 col-lg-6 col-xl-4" ng-if="tacop.active" ng-true-value="1" ng-false-value="0">
									<div class="line-top-light">
										<h5 class="d-inline">
											<input type="checkbox" id="{{ tacop.tacopid }}-active" ng-model="tacop.active" ng-true-value="1" ng-false-value="0" ng-change="activateTacOp(dashboardroster, tacop, tacop.active)" />
											{{ tacop.title }}
										</h5>
										<div class="float-end">
											<input type="checkbox" id="{{ tacop.tacopid }}-VP1" ng-model="tacop.VP1" ng-true-value="1" ng-false-value="0" ng-change="setTacOpScore(dashboardroster, tacop, tacop.VP1, tacop.VP2);" /> VP 1
											&nbsp;&nbsp;
											<input type="checkbox" id="{{ tacop.tacopid }}-VP2" ng-model="tacop.VP2" ng-true-value="1" ng-false-value="0" ng-change="setTacOpScore(dashboardroster, tacop, tacop.VP1, tacop.VP2);" /> VP 2
										</div>
									</div>
									<em class="d-inline">{{ tacop.archetype }} {{ tacop.tacopseq }}&nbsp;&nbsp;</em>
									<p class="oswald p-1" style="text-align: justify;" ng-bind-html="tacop.description"></p>
								</div>
							</div>
							<div class="row p-0 m-0">
								<!-- Inactive TacOps -->
								<h3 class="text-center line-top-light">
									Inactive TacOps
								</h3>
								<div ng-repeat="tacop in dashboardroster.tacops track by $index" class="col-12 col-lg-6 col-xl-4" ng-if="!tacop.active">
									<!-- h4 class="text-center line-top-light" ng-if="$index == 0 || ($index > 0 && dashboardroster.tacops[$index].archetype != dashboardroster.tacops[$index - 1].archetype)">
										{{ tacop.archetype }}
									</h4 -->
									<div class="line-top-light">
										<h5 class="d-inline">
											<input type="checkbox" id="{{ tacop.tacopid }}-active" ng-model="tacop.active" ng-change="activateTacOp(dashboardroster, tacop, tacop.active)" />
											{{ tacop.title }}
										</h5>
										<em class="d-inline float-end text-end">{{ tacop.archetype }} {{ tacop.tacopseq }}&nbsp;&nbsp;</em>
									</div>
									<p class="oswald p-1" style="text-align: justify;" ng-bind-html="tacop.description"></p>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="notes" role="tabpanel">
							<div class="row p-0 m-0">
								<textarea style="border: 1px solid #CCC; width: 100%; color: #EEE;" rows="15" class="darkcard d-block" ng-model="dashboardroster.notes" ng-change="commitRoster(dashboardroster);"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="opponentdash" role="tabpanel">
					<div ng-if="!dashboardopponentroster">
						<br/>
						&nbsp;&nbsp;&nbsp;<a class="pointer btn btn-primary" onclick="$('#dashboardopponentmodal').modal('show');"><i class="fas fa-people-arrows fa-fw"></i> Select Opponent</a>
					</div>
					<div  ng-if="dashboardopponentroster">
						<div class="orange p-0 m-0">
							<h3 class="d-inline">
								<a href="/r/{{ dashboardopponentroster.rosterid }}" target="_blank">{{ dashboardopponentroster.rostername }}</a>
							</h3>
								by
								<a href="/u/{{ dashboardopponentroster.username }}" target="_blank">
									<span class="badge bg-secondary"><i class="fas fa-user fa-fw"></i>&nbsp;{{ dashboardopponentroster.username }}</span>
								</a>
							</h3>
						</div>
						<div class="orange">
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
										<span ng-bind="dashboardopponentroster.CP"></span>
									</h3>
									<h3 class="col-4">
										<span ng-bind="dashboardopponentroster.TP"></span>
									</h3>
									<h3 class="col-4">
										<span ng-bind="dashboardopponentroster.VP"></span>
									</h3>
								</div>
							</center>
						</div>
						
						<!-- Resource Point tracker -->
						<div class="container-fluid" ng-if="RPLabels[dashboardopponentroster.factionid][dashboardopponentroster.killteamid]">
							<div class="h5 cinzel">
								{{ RPLabels[dashboardopponentroster.factionid][dashboardopponentroster.killteamid]["Label"] }}
								&nbsp;&nbsp;&nbsp;&nbsp;
								<span ng-bind="dashboardopponentroster.RP"></span>
							</div>
						</div>
						
						<ul class="nav nav-tabs" id="mytabs" role="tablist">
							<li class="nav-item m-0 p-0 dark" role="presentation">
								<a class="nav-link active dark" id="opponentop-tab" data-bs-toggle="tab" data-bs-target="#opponentops" type="button" role="tab" aria-controls="ops" aria-selected="true">
									Operatives
								</a>
							</li>
							<li class="nav-item m-0 p-0 dark" role="presentation">
								<a class="nav-link dark" id="opponentploy-tab" data-bs-toggle="tab" data-bs-target="#opponentploys" type="button" role="tab" aria-controls="ploys" aria-selected="false">
									Ploys
								</a>
							</li>
							<li class="nav-item m-0 p-0 dark" role="presentation">
								<a class="nav-link dark" id="opponenteq-tab" data-bs-toggle="tab" data-bs-target="#opponenteqs" type="button" role="tab" aria-controls="eqs" aria-selected="false">
									Equip
								</a>
							</li>
						</ul>
						<div class="tab-content p-0 m-0">
							<div class="tab-pane show active" id="opponentops" role="tabpanel">
								<!-- Archetype -->
								<h6 class="d-inline">Archetype</h6>: <small ng-bind="getRosterArchetype(dashboardopponentroster)"></small>
							
								<!-- Equipment Points -->
								<small ng-show="totalEqPts(dashboardopponentroster) > 0">({{ totalEqPts(dashboardopponentroster) }} Eq Pts)</small>
								
								<!-- Operatives -->
								<div class="row p-0 m-0">
									<div ng-if="!operative.hidden" class="col-12 col-md-6 col-xl-4 col-xxl-3 m-0 p-0" ng-repeat="operative in dashboardopponentroster.operatives track by $index">
										<?php include "templates/op_card.shtml" ?>
									</div>
								</div>
							</div>
							<div class="tab-pane m-0 p-0" id="opponentploys" role="tabpanel">
								<div class="row container-fluid m-0 p-0">
									<div class="col-xs-12 col-md-6">
										<!-- Strategic Ploys -->
										<h3>Strategic Ploys</h3>
										<ANY ng-repeat="ploy in dashboardopponentroster.killteam.ploys.strat track by $index">
											<?php include "templates/ploy.shtml" ?>
										</ANY>
									</div>
									<div class="col-xs-12 col-md-6">
										<!-- Tactical Ploys -->
										<h3>Tactical Ploys</h3>
										<ANY ng-repeat="ploy in dashboardopponentroster.killteam.ploys.tac track by $index">
											<?php include "templates/ploy.shtml" ?>
										</ANY>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="opponenteqs" role="tabpanel">
								<!-- Equipment -->
								<div class="row p-0 m-0">
									<div ng-repeat="eq in dashboardopponentroster.killteam.equipments track by $index" class="col-12 col-lg-6 col-xl-4">
										<h4 class="text-center line-top-light" ng-if="$index > 0 && dashboardopponentroster.killteam.equipments[$index].eqcategory != dashboardopponentroster.killteam.equipments[$index - 1].eqcategory">
											{{ eq.eqcategory }}
										</h4>
										<div class="line-top-light">
											<h5 class="d-inline">{{ eq.eqname }}</h5>
											<h5 class="d-inline float-end text-end" ng-if="eq.eqpts > '0'">{{ eq.eqpts }} EP&nbsp;&nbsp;</h5>
											<em class="d-inline float-end text-end" ng-if="eq.eqpts == '0'">{{ eq.eqcategory }}&nbsp;&nbsp;</em>
										</div>
										<p class="oswald p-1" style="text-align: justify;" ng-bind-html="eq.eqdescription"></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>