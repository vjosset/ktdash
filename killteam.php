<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested faction id
	$factionid = getIfSet($_REQUEST['factionid']);
	if ($factionid == null || $factionid == '') {
		$factionid = getIfSet($_REQUEST['faid']);
	}
	if ($factionid == null || $factionid == '') {
		$factionid = getIfSet($_REQUEST['fa']);
	}
	
	// Get the requested killteam id
	$killteamid = getIfSet($_REQUEST['killteamid']);
	if ($killteamid == null || $killteamid == '') {
		$killteamid = getIfSet($_REQUEST['ktid']);
	}
	if ($killteamid == null || $killteamid == '') {
		$killteamid = getIfSet($_REQUEST['kt']);
	}
	
	$faction = Faction::GetFaction($factionid);
	$killteam = KillTeam::GetKillTeam($factionid, $killteamid);
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = $killteam->killteamname . " | " . $faction->factionname;
		$pagedesc  = $killteam->description;
		$pageimg   = "https://ktdash.app/img/portraits/". $factionid . "/" . $killteamid . "/" . $killteamid . ".png";
		$pageurl   = "https://ktdash.app/killteam.php?fa=" . $factionid . "&kt=" . $killteamid;
		
		include "og.php"
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initKillteam();"
		style="
			background-color: rgba(32, 32, 32, 0.9);
			background-attachment:fixed;
			background-image: url(<?php echo "/img/portraits/". $factionid . "/" . $killteamid . "/" . $killteamid . ".png" ?>);
			background-position: top center;
			background-size: cover;
			background-blend-mode: multiply;">
		<?php include "topnav.shtml" ?>
			
		<!-- Dialogs -->
		<?php include "templates/dialogs.shtml" ?>
		
		<h1 class="orange">
			<a href="/faction.php?fa=<?php echo $factionid ?>"><?php echo $faction->factionname ?></a>
			:
			<?php echo $killteam->killteamname ?>
		</h1>
		
		<div class="row container-fluid p-0 m-0">
			<div class="col-12 col-sm-5 col-lg-4"
				style="overflow: auto; 
				background-repeat: no-repeat; background-size: cover;
				background-position: top;
				background-image: url('/img/portraits/<?php echo $factionid ?>/<?php echo $killteamid ?>/<?php echo $killteamid ?>.png')">
				&nbsp;
				<br/><br/><br/><br/>
				<br/><br/><br/><br/>
			</div>
			<div class="col-12 col-sm-7 col-lg-8 oswald">
				<p style="text-align:justify;">
					<?php echo $killteam->description ?>
				</p>
			</div>
		</div>
		<br/>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading...
			</div>
		</h3>
			
		<div ng-hide="loading">
			<!-- Killteam Composition -->
			<h2 class="pointer" aria-expanded="true" data-bs-toggle="collapse" data-bs-target="#killteamcomp"><i class="fas fa-chevron-down fa-fw"></i>KillTeam Composition</h2>
			<p id="killteamcomp" class="collapse" ng-bind-html="killteam.killteamcomp"></p> <!-- style="-webkit-columns: 40px 3; -moz-columns: 60px 3; columns: 60px 3;"></p -->
			
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
							<div class="pointer" ng-show="killteam.fireteams.length > 1">
								<i class="h3 fas fa-chevron-down fa-fw" aria-expanded="true" data-bs-toggle="collapse" data-bs-target="#ft_{{ fireteam.fireteamid }}"></i>
								<span ng-click="showpopup('FireTeam Composition', fireteam.fireteamcomp);">
									<h3 style="display: inline;">{{ fireteam.fireteamname }}</h3>
									<sup class="small h6"><i class="far fa-question-circle fa-fw"></i></sup>
								</span>
							</div>
							
							<div class="card-group collapse show" id="ft_{{ fireteam.fireteamid }}">
								<div class="col-12 col-md-6 col-xl-4 p-0 m-0 align-items-stretch" ng-repeat="operative in fireteam.operatives">
									<?php include "templates/op_card.shtml" ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane m-0 p-0" id="ploys" role="tabpanel">
					<div class="row container-fluid m-0 p-0">
						<div class="col-xs-12 col-md-6">
							<!-- Strategic Ploys -->
							<h3>Strategic Ploys</h3>
							<ANY ng-repeat="ploy in killteam.ploys.strat">
								<?php include "templates/ploy.shtml" ?>
							</ANY>
						</div>
						<div class="col-xs-12 col-md-6">
							<!-- Tactical Ploys -->
							<h3>Tactical Ploys</h3>
							<ANY ng-repeat="ploy in killteam.ploys.tac">
								<?php include "templates/ploy.shtml" ?>
							</ANY>
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
		
		<?php include "footer.shtml" ?>
	</body>
</html>


	