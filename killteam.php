<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested faction id
	$factionid = $_REQUEST['factionid'];
	if ($factionid == null || $factionid == '') {
		$factionid = $_REQUEST['faid'];
	}
	if ($factionid == null || $factionid == '') {
		$factionid = $_REQUEST['fa'];
	}
	
	// Get the requested killteam id
	$killteamid = $_REQUEST['killteamid'];
	if ($killteamid == null || $killteamid == '') {
		$killteamid = $_REQUEST['ktid'];
	}
	if ($killteamid == null || $killteamid == '') {
		$killteamid = $_REQUEST['kt'];
	}
	
	$faction = Faction::GetFaction($factionid);
	$killteam = KillTeam::GetKillTeam($factionid, $killteamid);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = $killteam->killteamname;
		$pagedesc  = $killteam->description;
		$pageimg   = "https://ktdash.app/img/portraits/". $factionid . "/" . $killteamid . "/" . $killteamid . ".png";
		$pageurl   = "https://ktdash.app/killteam.php?fa=" . $factionid . "&kt=" . $killteamid;
		
		include "og.php"
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="init();">
		<?php include "topnav.shtml" ?>
			
		<!-- Dialogs -->
		<?php include "templates/dialogs.shtml" ?>
		
		<script type="text/javascript">
			trackEvent("compendium", "killteam", GetReqFAid() + "/" + GetReqKTid());
		</script>
		
		<!-- All Factions -->
		<div ng-repeat="faction in factions">
			<!-- All Killteams -->
			<div ng-repeat="killteam in faction.killteams">
				<h1 class="cinzel orange p-2">
					<a class="h1 cinzel orange" href="/faction.php?fa={{ faction.factionid }}">{{ faction.factionname }}</a>
					:
					{{ killteam.killteamname }}
				</h1>
				
				<div class="row container-fluid p-0 m-0">
					<div class="col-12 col-sm-5 col-lg-4"
						style="overflow: auto; 
						background-repeat: no-repeat; background-size: cover;
						background-position: center;"
						ng-style="{ 'background-image': 'url(/img/portraits/{{ faction.factionid }}/{{ killteam.killteamid }}/{{ killteam.killteamid }}.png)' }">
						&nbsp;
						<br/><br/><br/><br/>
						<br/><br/><br/><br/>
					</div>
					<div class="col-12 col-sm-7 col-lg-8 oswald">
						<p style="text-align:justify;" ng-bind-html="killteam.description"></p>
					</div>
				</div>
				<br/>
				
				<!-- Killteam Composition -->
				<h2 class="cinzel" aria-expanded="true" data-bs-toggle="collapse" data-bs-target="#killteamcomp"><i class="fas fa-chevron-down fa-fw"></i>KillTeam Composition</h2>
				<p id="killteamcomp" class="oswald collapse" ng-bind-html="killteam.killteamcomp"></p> <!-- style="-webkit-columns: 40px 3; -moz-columns: 60px 3; columns: 60px 3;"></p -->
				
				<br/>
				<ul class="nav nav-tabs oswald dark" id="mytabs" role="tablist">
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
						<!-- Operatives -->
						<div class="row p-0 m-0">
							<div ng-repeat="fireteam in killteam.fireteams">
								<div ng-show="killteam.fireteams.length > 1" class="cinzel" ng-click="showpopup('FireTeam Composition', fireteam.fireteamcomp);">
									<span class="h3">{{ fireteam.fireteamname }}</span>
									<sup class="small h6"><i class="far fa-question-circle fa-fw"></i></sup>
								</div>
								
								<div class="card-group">
									<div class="col-12 col-md-6 col-xl-4 p-0 m-0" ng-repeat="operative in fireteam.operatives">
										<?php include "templates/op_comp.shtml" ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="ploys" role="tabpanel">
						<!-- Strategic Ploys -->
						<div class="h3 cinzel">Strategic Ploys</div>
						<div class="row p-0 m-0" ng-repeat="ploy in killteam.ploys.strat">
							<div class="col-12 col-lg-6">
								<?php include "templates/ploy.shtml" ?>
							</div>
						</div>
						<div class="h3 cinzel">Tactical Ploys</div>
						<div class="row p-0 m-0" ng-repeat="ploy in killteam.ploys.tac">
							<div class="col-12 col-lg-6">
								<?php include "templates/ploy.shtml" ?>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="eqs" role="tabpanel">
						<!-- Equipment -->
						<div class="row p-0 m-0">
							<div ng-repeat="eq in killteam.equipments" class="col-12 col-lg-6 col-xl-4">
								<?php include "templates/eq.shtml" ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>


	