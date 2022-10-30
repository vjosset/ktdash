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
	
	global $dbcon;
	$sql = "SELECT rosterid, rostername, oplist, notes FROM RosterView WHERE userid = 'prebuilt' AND factionid = ? AND killteamid = ?";
	
	$cmd = $dbcon->prepare($sql);
	$paramtypes = "ss";
	$params = array();
	$params[] =& $paramtypes;
	$params[] =& $factionid;
	$params[] =& $killteamid;
	
	call_user_func_array(array($cmd, "bind_param"), $params);
	$cmd->execute();

	$prebuiltrosters = [];
	if ($result = $cmd->get_result()) {
		while ($row = $result->fetch_object()) {
			$prebuiltrosters[] = $row;
		}
	}
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
				<?php
				if ($prebuiltrosters != null && count($prebuiltrosters) > 0) {
				?>
					<li class="nav-item m-0 p-0" role="presentation">
						<a class="nav-link dark" id="rosters-tab" data-bs-toggle="tab" data-bs-target="#rosters" type="button" role="tab" aria-controls="rosters" aria-selected="false">
							Rosters
						</a>
					</li>
				<?php
				}
				?>
			</ul>
			<div class="tab-content">
				<div class="tab-pane show active" id="ops" role="tabpanel">
					<!-- Operatives -->
			
					<!-- Killteam Composition -->
					<h1 class="pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Killteam Composition" ng-click="showpopup('Kill Team Composition', getKillTeamComp(killteam));">
						Kill Team Composition
						<sup><i class="h5 far fa-question-circle fa-fw"></i></sup>
					</h1>
					
					<div class="row p-0 m-0">
						<div class="m-0 p-0" ng-repeat="fireteam in killteam.fireteams">
							<h3 class="pointer" ng-show="killteam.fireteams.length > 1" ng-click="showpopup('Fire Team Composition', fireteam.fireteamcomp);">
								{{ fireteam.fireteamname }}
								<sup><i class="h5 far fa-question-circle fa-fw"></i></sup>
							</h3>
							
							<div class="card-group collapse show" id="ft_{{ fireteam.fireteamid }}">
								<div class="col-12 col-md-6 col-xl-4 align-items-stretch" ng-repeat="operative in fireteam.operatives">
									<?php include "templates/op_card.shtml" ?>
								</div>
							</div>
							<br/>
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
				
				<?php
				if ($prebuiltrosters != null && count($prebuiltrosters) > 0) {
				?>
					<div class="tab-pane" id="rosters" role="tabpanel">
						<h2>Pre-Built Rosters</h2>
						<ul>
						<!-- Pre-Built Rosters -->
						<?php
						foreach ($prebuiltrosters as $roster) {
						?>
							<li><a href="/roster.php?rid=<?php echo $roster->rosterid ?>"><?php echo $roster->rostername ?></a></li>
						<?php
						}
						?>
						</ul>
					</div>
				<?php
				}
				?>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>


	