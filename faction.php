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
	
	if ($factionid == null || $factionid == '') {
		// No faction id passed in - Just get the first one
		$faction = Faction::GetFactions()[0];
	} else {
		// A faction ID was passed in - Get it
		$faction = Faction::GetFaction($factionid);
	}
	
	if ($faction == null) {
		// Faction not found - Go to compendium
		header("Location: /compendium.php");
		exit;
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = $faction->factionname;
		$pagedesc  = $faction->description;
		$pagekeywords = "Compendium," . $faction->factionname;
		$pageimg   = "https://ktdash.app/img/portraits/". $factionid . "/" . $factionid . ".jpg";
		$pageurl   = "https://ktdash.app/faction.php?fa=" . $factionid;
		
		include "og.php"
		?>
		
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initFaction();"
		style="
			background-color: rgba(32, 32, 32, 0.9);
			background-attachment:fixed;
			background-image: url(<?php echo "/img/portraits/". $factionid . "/" . $factionid . ".jpg" ?>);
			background-position: top center;
			background-size: cover;
			background-blend-mode: multiply;">
		<?php include "topnav.shtml" ?>
		
		<h1 class="orange"><?php echo $faction->factionname ?></h1>
	
		<div class="row" style="padding: 0 0 0 0; margin: 0 0 0 0;">
			<div class="col-12 col-sm-5 col-lg-4 center pointer"
				style="overflow: hidden; 
				background-repeat: no-repeat; background-size: cover;
				background-position: top;
				background-image: url('/img/portraits/<?php echo $factionid ?>/<?php echo $factionid ?>.jpg')"
				onclick="document.location.href = '/faction.php?fa=<?php echo $factionid ?>">
				<br/><br/><br/><br/>
				<br/><br/><br/><br/>
			</div>
			<div class="col-12 col-sm-7 col-lg-8 oswald">
				<p style="text-align:justify;">
					<?php echo $faction->description ?>
				</p>
			</div>
		</div>
		<br/><br/>
			
		<h1>KillTeams</h1>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading...
			</div>
		</h3>
		
		<div ng-hide="loading">
			<div class="card-group">
				<div ng-repeat="killteam in faction.killteams" class="col-12 col-md-6 col-xl-4 p-1">
					<div class="card border-light shadow darkcard h-100">
						<!-- Portrait -->
						<img class="card-img-top" ng-src="/img/portraits/{{ faction.factionid }}/{{ killteam.killteamid }}/{{ killteam.killteamid }}.png" style="max-height: 270px; min-height: 270px; object-position: center top; object-fit: cover;" />
						
						<h2 class="card-title orange text-center">
							<a class="navloader" href="/killteam.php?fa={{ faction.factionid }}&kt={{ killteam.killteamid }}">
								{{ killteam.killteamname }}
							</a>
						</h2>
						
						<p class="card-text p-2 m-0 oswald" style="text-align:justify;" ng-bind-html="killteam.description"></p>
						
						<p class="card-text p-2 m-0 oswald">
							<!-- a href="killteam.htm?fa={{ faction.factionid }}&kt={{ killteam.killteamid }}" class="btn btn-primary">Read More</a -->
						</p>
					</div>
					<br/>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>