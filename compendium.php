<?php
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
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="init();">
		<?php include "topnav.shtml" ?>
		<script type="text/javascript">
			trackEvent("compendium", "allfactions");
		</script>
		
		<h1 class="cinzel orange">Compendium - Factions</h1>
		
		<div class="card-group">
			<div ng-repeat="faction in factions" class="col-12 col-md-6 col-xl-4">
				<div class="card border-light shadow dark">
					<!-- Portrait -->
					<img class="card-img-top" ng-src="/img/portraits/{{ faction.factionid }}/{{ faction.factionid }}.jpg" style="max-height: 270px; min-height: 270px; object-position: center top; object-fit: cover;" />
					
					<a class="h1 card-title cinzel orange text-center" href="/faction.php?fa={{ faction.factionid }}">
						{{ faction.factionname }}
					</a>
					
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