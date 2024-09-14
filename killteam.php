<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
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
	
	$factionid = strtoupper($factionid);
	$killteamid = strtoupper($killteamid);
	
	$faction = Faction::GetFaction($factionid);
	
	if ($faction == null) {
		// Faction not found - Go to compendium
		header("Location: /compendium.php");
		exit;
	}
	$killteam = KillTeam::GetKillTeam($factionid, $killteamid);
	
	if ($killteam == null) {
		header('HTTP/1.0 404 KillTeam Not Found');
		die();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = $killteam->killteamname . " Kill Team";
		$pagedesc  = str_replace("\n", " ", str_replace("\r", " ", $killteam->description));
		$pagekeywords = "Compendium," . $faction->factionname . "," . $killteam->killteamname;
		$pageimg   = "https://ktdash.app/img/portraits/". $factionid . "/" . $killteamid . "/" . $killteamid . ".jpg";
		$pageurl   = "https://ktdash.app/fa/" . $factionid . "/kt/" . $killteamid;
		
		include "og.php"
		?>
		<style>
		<?php include "css/styles.css"; ?>
		</style>
		
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initKillteam('<?php echo $factionid ?>', '<?php echo $killteamid ?>');"
		style="
			background-color: rgba(32, 32, 32, 0.9);
			background-attachment:fixed;
			background-image: url(<?php echo "/img/portraits/". $factionid . "/" . $killteamid . "/" . $killteamid . ".jpg" ?>);
			background-position: top center;
			background-size: cover;
			background-blend-mode: multiply;">
		<?php include "topnav.shtml" ?>
			
		<!-- Dialogs -->
		<?php include "templates/dialogs.shtml" ?>
		
		<script type="text/javascript">
			// Pre-load killteam data straight on this page instead of XHR round-trip to the API
			document.body.setAttribute("faction", JSON.stringify(<?php echo json_encode($faction) ?>));
			document.body.setAttribute("killteam", JSON.stringify(<?php echo json_encode($killteam) ?>));
		</script>
		
		<h1 class="orange">
			<a class="navloader" href="/fa/<?php echo $factionid ?>"><?php echo $faction->factionname ?></a>
			:
			<?php echo $killteam->killteamname ?>
		</h1>
		
		<div class="row container-fluid p-0 m-0">
			<div class="col-12 col-sm-5 col-lg-4"
				style="overflow: auto; 
				background-repeat: no-repeat; background-size: cover;
				background-position: top;
				background-image: url('/img/portraits/<?php echo $factionid ?>/<?php echo $killteamid ?>/<?php echo $killteamid ?>.jpg')">
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
			
		<div class="ng-cloak" ng-hide="loading">
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
				<li class="nav-item m-0 p-0 dark" role="presentation">
					<a class="nav-link dark" id="to-tab" data-bs-toggle="tab" data-bs-target="#tacops" type="button" role="tab" aria-controls="tacops" aria-selected="false">
						TacOps
					</a>
				</li>
				<li class="nav-item m-0 p-0 dark" role="presentation" ng-if="killteam.rosters.length > 0">
					<a class="nav-link dark" id="rosters-tab" data-bs-toggle="tab" data-bs-target="#rosters" type="button" role="tab" aria-controls="rosters" aria-selected="false">
						Rosters
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<!-- Operatives -->
				<div class="tab-pane show active" id="ops" role="tabpanel">
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
								<div class="col-12 col-md-6 col-xl-4 col-xxl-3" ng-repeat="operative in fireteam.operatives">
									<?php include "templates/op_card.shtml" ?>
								</div>
							</div>
							<br/>
						</div>
					</div>
				</div>
				
				<!-- Ploys -->
				<div class="tab-pane m-0 p-0" id="ploys" role="tabpanel">
					<div class="row container-fluid m-0 p-0">
						<div class="col-xs-12 col-md-6">
							<!-- Strategic Ploys -->
							<h3>{{ killteam.edition == 'kt21' ? 'Strategic Ploys' : 'Strategy Ploys' }}</h3>
							<ANY ng-repeat="ploy in killteam.ploys.strat">
								<?php include "templates/ploy.shtml" ?>
							</ANY>
						</div>
						<div class="col-xs-12 col-md-6">
							<!-- Tactical Ploys -->
							<h3>{{ killteam.edition == 'kt21' ? 'Tactical Ploys' : 'Firefight Ploys' }}</h3>
							<ANY ng-repeat="ploy in killteam.ploys.tac">
								<?php include "templates/ploy.shtml" ?>
							</ANY>
						</div>
					</div>
				</div>
				
				<!-- Equipment -->
				<div class="tab-pane" id="eqs" role="tabpanel">
					<div class="row p-0 m-0">
						<div ng-repeat="eq in killteam.equipments track by $index" class="col-12 col-lg-6 col-xl-4" ng-if="settings['shownarrative'] == 'y' || (eq.eqcategory != 'Battle Honour' && eq.eqcategory != 'Battle Scar' && eq.eqcategory != 'Rare Equipment')">
							<h4 class="text-center line-top-light" ng-if="$index > 0 && killteam.equipments[$index].eqcategory != killteam.equipments[$index - 1].eqcategory">
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
			
				<!-- TacOps -->
				<div class="tab-pane" id="tacops" role="tabpanel">
					<div class="m-0 p-0">
						<div ng-if="killteam.tacops.length > 0" class="row p-0 m-0">
							<div class="col-12 col-md-6 col-xl-4 m-0 p-0" ng-repeat="tacop in killteam.tacops track by $index">
								<div class="line-top-light">
									<h5 class="d-inline">
										{{ tacop.title }}
									</h5>
									<em class="d-inline float-end text-end">{{ tacop.archetype }} {{ tacop.tacopseq }}&nbsp;&nbsp;</em>
								</div>
								<p class="oswald p-1" style="text-align: justify;" ng-bind-html="tacop.description"></p>
							</div>
						</div>
					</div>
				</div>
			
				<!-- Rosters -->
				<div class="tab-pane" id="rosters" role="tabpanel">
					<div class="m-0 p-0">
						<div ng-if="killteam.rosters.length > 0" class="row p-0 m-0">
							<div class="col-12 col-md-6 col-lg-4 col-xl-3 m-0 p-0" ng-repeat="myRoster in killteam.rosters track by $index">
								<?php include "templates/roster_card.shtml" ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>


	