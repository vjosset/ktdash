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
		$pagetitle = "Factions";
		$pagedesc  = "All KillTeam factions";
		$pagekeywords = "All Factions";
		$pageimg   = "https://ktdash.app/img/og/Compendium.png";
		$pageurl   = "https://ktdash.app/allfactions";
		
		include "og.php"
		?>
		<style>
		<?php include "css/styles.css"; ?>
		</style>
		<?php
		foreach($factions as $faction) {
			$faction->loadKillTeams('');
		?>
		<link rel="preload" href="/img/portraits/<?php echo $faction->factionid ?>/<?php echo $faction->factionid ?>.jpg" as="image">
		<?php
		}
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl">
		<?php include "topnav.shtml" ?>
		
		<h1 class="cinzel orange"><span class="fas fa-book-dead fa-fw"></span> Factions</h1>
		
		<div class="card-group">
			<?php 
			foreach($factions as $faction) {
			?>
				<div class="col-12 col-md-6 col-xl-4 p-1">
					<div class="card darkcard h-100">
						<!-- Portrait -->
						<img class="card-img-top" src="/img/portraits/<?php echo $faction->factionid ?>/<?php echo $faction->factionid ?>.jpg" style="max-height: 270px; min-height: 270px; object-position: center top; object-fit: cover;" />
						
						<h1 class="card-title orange text-center">
							<a class="navloader" href="/fa/<?php echo $faction->factionid ?>">
								<?php echo $faction->factionname ?>
							</a>
						</h1>
						
						<p class="card-text p-2 m-0 oswald" style="text-align:justify;">
						<?php echo $faction->description ?>
						</p>
						
						<!-- p class="card-text p-2 m-0 oswald">
							<a href="faction.htm?factionid={{ faction.factionid }}" class="btn btn-primary">View KillTeams</a>
						</p -->	

						<div class="card-footer m-0 p-1 line-top-light">
							<!-- KillTeams -->
							<div style="column-width: 150px;">
							<?php 
							$preved = '';
							foreach($faction->killteams as $killteam) {
								if ($killteam->edition != $preved) {
									?>
										<h6 ng-if="settings['edition'] == '' || settings['edition'] == '<?php echo $killteam->edition ?>'" class="span"><?php echo $killteam->edition ?></h6>
									<?php
								}
								$preved = $killteam->edition;
							?>
								<a ng-if="settings['edition'] == '' || settings['edition'] == '<?php echo $killteam->edition ?>'" class="navloader" href="/fa/<?php echo $faction->factionid ?>/kt/<?php echo $killteam->killteamid ?>"><?php echo $killteam->killteamname ?></a><br/>
							<?php
							}
							?>
							</div>
						</div>				
					</div>
					<br/>
				</div>
			<?php
			}
			?>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>