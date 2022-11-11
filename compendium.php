<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get all the factions
	$factions = Faction::GetFactions();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = "Compendium";
		$pagedesc  = "All KillTeam 2021 factions";
		$pageimg   = "https://ktdash.app/img/og/Compendium.png";
		$pageurl   = "https://ktdash.app/compendium.php";
		
		include "og.php"
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initCompendium();">
		<?php include "topnav.shtml" ?>
		
		<h1 class="cinzel orange">Compendium - Factions</h1>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Factions...
			</div>
		</h3>
		
		<div class="card-group" ng-hide="loading">
			<div ng-repeat="faction in factions" class="col-12 col-md-6 col-xl-4 p-1">
				<div class="card border-light shadow darkcard">
					<!-- Portrait -->
					<img class="card-img-top" ng-src="/img/portraits/{{ faction.factionid }}/{{ faction.factionid }}.jpg" style="max-height: 270px; min-height: 270px; object-position: center top; object-fit: cover;" />
					
					<h1 class="card-title orange text-center">
						<a class="navloader" href="/faction.php?fa={{ faction.factionid }}">
							{{ faction.factionname }}
						</a>
					</h1>
					
					<p class="card-text p-2 m-0 oswald" style="text-align:justify;" ng-bind-html="faction.description"></p>
					
					<!-- p class="card-text p-2 m-0 oswald">
						<a href="faction.htm?factionid={{ faction.factionid }}" class="btn btn-primary">View KillTeams</a>
					</p -->					
				</div>
				<br/>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>