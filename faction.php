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
	
	if ($factionid == null || $factionid == '') {
		// No faction id passed in - Just get the first one
		$faction = Faction::GetFactions()[0];
	} else {
		// A faction ID was passed in - Get it
		$faction = Faction::GetFaction($factionid);
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = $faction->factionname;
		$pagedesc  = $faction->description;
		$pageimg   = "https://ktdash.app/img/portraits/". $factionid . "/" . $factionid . ".jpg";
		$pageurl   = "https://ktdash.app/faction.php?fa=" . $factionid;
		
		include "og.php"
		?>
		
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="init();">
		<?php include "topnav.shtml" ?>
		<script type="text/javascript">
			trackEvent("compendium", "faction", GetReqFAid());
		</script>
		
		<div class="p-0 m-0 container-fluid" ng-repeat="faction in factions">
			<h1 class="cinzel orange">{{ faction.factionname }}</h1>
			
			<div class="row" style="padding: 0 0 0 0; margin: 0 0 0 0;">
				<div class="col-12 col-sm-5 col-lg-4 center pointer"
					style="overflow: hidden; 
					background-repeat: no-repeat; background-size: cover;
					background-position: top;"
					ng-style="{ 'background-image': 'url(/img/portraits/{{ faction.factionid }}/{{ faction.factionid }}.jpg)' }"
				ng-click="document.location.href = '/faction.php?fa=' + faction.factionid">
					<br/><br/><br/><br/>
					<br/><br/><br/><br/>
				</div>
				<div class="col-12 col-sm-7 col-lg-8 oswald">
					<p style="text-align:justify;" ng-bind-html="faction.description"></p>
				</div>
			</div>
			<br/><br/>
			
			<h1 class="cinzel dark">KillTeams</h1>
			
			<div ng-repeat="faction in factions">
				<div class="card-group">
					<div ng-repeat="killteam in faction.killteams" class="col-12 col-md-6 col-xl-4">
						<div class="card border-light shadow darkcard">
							<!-- Portrait -->
							<img class="card-img-top" ng-src="/img/portraits/{{ faction.factionid }}/{{ killteam.killteamid }}/{{ killteam.killteamid }}.png" style="max-height: 270px; min-height: 270px; object-position: center top; object-fit: cover;" />
							
								<a class="h3 card-title cinzel orange text-center" href="/killteam.php?fa={{ faction.factionid }}&kt={{ killteam.killteamid }}">
									{{ killteam.killteamname }}
								</a>
							
							<p class="card-text p-2 m-0 oswald" style="text-align:justify;" ng-bind-html="killteam.description"></p>
							
							<p class="card-text p-2 m-0 oswald">
								<!-- a href="killteam.htm?fa={{ faction.factionid }}&kt={{ killteam.killteamid }}" class="btn btn-primary">Read More</a -->
							</p>
						</div>
						<br/>
					</div>
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>