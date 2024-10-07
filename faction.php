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
	
	$factionid = strtoupper($factionid);
	
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
	
	$faction->loadKillTeams();
	
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = $faction->factionname;
		$pagedesc  = $faction->description;
		$pagekeywords = $faction->factionname;
		$pageimg   = "https://ktdash.app/img/portraits/". $factionid . "/" . $factionid . ".jpg";
		$pageurl   = "https://ktdash.app/fa/" . $factionid;
		
		include "og.php"
		?>
		<style>
		<?php include "css/styles.css"; ?>
		</style>
		<?php
		foreach($faction->killteams as $killteam) {
		?>
		<link rel="preload" href="/img/portraits/<?php echo $faction->factionid ?>/<?php echo $killteam->killteamid ?>/<?php echo $killteam->killteamid ?>.jpg" as="image">
		<?php
		}
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl"
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
				onclick="document.location.href = '/faction/<?php echo $factionid ?>">
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
		
		<div>
			<div class="card-group">
				<?php
				$killteams = $faction->killteams;
				foreach($killteams as $killteam)
				{
				?>
				<div class="col-12 col-md-6 col-xl-4 p-1">
					<div class="card darkcard h-100">
						<!-- Portrait -->
						<img class="card-img-top" src="/img/portraits/<?php echo $faction->factionid ?>/<?php echo $killteam->killteamid ?>/<?php echo $killteam->killteamid ?>.jpg" style="max-height: 270px; min-height: 270px; object-position: center top; object-fit: cover;" />
						
						<h2 class="card-title orange text-center">
							<a class="navloader" href="/fa/<?php echo $faction->factionid ?>/kt/<?php echo $killteam->killteamid ?>">
								<?php echo $killteam->killteamname ?> <sup><?php echo $killteam->edition ?></sup>
							</a>
						</h2>
						
						<p class="card-text p-2 m-0 oswald" style="text-align:justify;">
						<?php echo $killteam->description ?>
						</p>
					</div>
					<br/>
				</div>
				<?php
				}
				?>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>