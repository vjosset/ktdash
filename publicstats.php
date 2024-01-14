<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	$me = Session::CurrentUser();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = "Stats";
			$pagedesc  = "Stats";
			$pagekeywords = "";
			$pageimg   = "";
			$pageurl   = "https://ktdash.app/publicstats.php";
			include "og.php";
		?>
		<style>
		<?php include "css/styles.css"; ?>
		</style>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl">
		<?php
			include "topnav.shtml";
		?>
		
		<div class="p-2">
			<!-- Totals -->
			<div class="container">
				<h2 class="text-center">Totals</h2>
				<?php
					$sql =
						"SELECT 'Users' AS CountType, COUNT(*) AS Total FROM User WHERE userid NOT IN ('prebuilt') UNION
						SELECT 'Rosters', COUNT(*) AS Total FROM Roster WHERE userid NOT IN ('prebuilt') UNION
						SELECT 'RosterOps', COUNT(*) AS Total FROM RosterOperative WHERE userid NOT IN ('prebuilt') UNION
						SELECT 'SpotlightCount', COUNT(*) AS Total FROM Roster WHERE spotlight = 1";
					$cmd = $dbcon->prepare($sql);
					
					// Load the stats
					$cmd->execute();
					
					echo "<table style=\"width: 100%;\">";

					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							?>
							<tr><th><?php echo $row->CountType ?></th><td style="text-align: right;"><?php echo number_format($row->Total) ?></td></tr>
							<?php
						}
					}
					
					echo "</table>";
				?>
			</div>
			<hr/>
			
			<!-- Roster Stats -->
			<div class="row m-0 p-0">
				<h2 class="col-12 m-0 p-0 text-center">Roster Stats</h2>
				
				<div class="col-12 col-md-6 m-0 p-0">
					<h3>Most Viewed Rosters</h3>
					<?php
						$sql =
							"SELECT U.username, R.rostername, KT.killteamname, CONCAT('https://ktdash.app/r/', rosterid, '/g') AS rosterlink, CONCAT('https://ktdash.app/u/', U.username) AS userlink, viewcount
							FROM Roster R
							INNER JOIN User U ON U.userid = R.userid
							INNER JOIN Killteam KT ON KT.factionid = R.factionid AND KT.killteamid = R.killteamid
							WHERE R.userid NOT IN ('prebuilt')
							ORDER BY viewcount DESC
							LIMIT 10;";
						$cmd = $dbcon->prepare($sql);
						
						// Load the stats
						$cmd->execute();
						
						echo "<table style=\"width: 100%;\">
								<tr>
									<th>Roster</th>
									<th style=\"text-align: center;\">Total&nbsp;Views</th>
								</tr>";

						if ($result = $cmd->get_result()) {
							while ($row = $result->fetch_object()) {
								// Got a result
								?>
								<tr class="line-top-light">
									<td>
										<a href="<?php echo $row->rosterlink ?>"><?php echo $row->rostername ?></a><br/>
										<?php echo $row->killteamname ?>
										by&nbsp;<a class="navloader" href="<?php echo $row->userlink ?>"><span class="badge bg-secondary"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $row->username ?></span></a>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($row->viewcount) ?>
									</td>
								</tr>
								<?php
							}
						}
						
						echo "</table><br/><br/>";
					?>
				</div>
				
				<div class="col-12 col-md-6 m-0 p-0">
					<h3>Most Imported Rosters</h3>
					<?php
						$sql =
							"SELECT U.username, R.rostername, KT.killteamname, CONCAT('https://ktdash.app/r/', rosterid) AS rosterlink, CONCAT('https://ktdash.app/u/', U.username) AS userlink, importcount
							FROM Roster R
							INNER JOIN User U ON U.userid = R.userid
							INNER JOIN Killteam KT ON KT.factionid = R.factionid AND KT.killteamid = R.killteamid
							WHERE R.userid NOT IN ('prebuilt')
							ORDER BY importcount DESC
							LIMIT 10;";
						$cmd = $dbcon->prepare($sql);
						
						// Load the stats
						$cmd->execute();
						
						echo "<table style=\"width: 100%;\">
								<tr>
									<th>Roster</th>
									<th style=\"text-align: center;\">Total&nbsp;Imports</th>
								</tr>";

						if ($result = $cmd->get_result()) {
							while ($row = $result->fetch_object()) {
								// Got a result
								?>
								<tr class="line-top-light">
									<td>
										<a href="<?php echo $row->rosterlink ?>"><?php echo $row->rostername ?></a><br/>
										<?php echo $row->killteamname ?>
										by&nbsp;<a class="navloader" href="<?php echo $row->userlink ?>"><span class="badge bg-secondary"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $row->username ?></span></a>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($row->importcount) ?>
									</td>
								</tr>
								<?php
							}
						}
						
						echo "</table><br/><br/>";
					?>
				</div>
			</div>
			
			<hr/>
			
			<!-- User Stats -->
			<div class="row m-0 m-0 p-0">
				<h2 class="col-12 m-0 p-0 text-center">User Stats</h2>
				
				<div class="col-12 col-md-6 m-0 p-0">
					<h3>Most Viewed Users</h3>
					<?php
						$sql =
							"SELECT U.username, CONCAT('https://ktdash.app/u/', U.username) AS userlink, SUM(viewcount) AS viewcount
							FROM Roster R
							INNER JOIN User U ON U.userid = R.userid
							WHERE R.userid NOT IN ('prebuilt')
							GROUP BY U.username, CONCAT('https://ktdash.app/u/', U.username)
							ORDER BY SUM(viewcount) DESC
							LIMIT 10;";
						$cmd = $dbcon->prepare($sql);
						
						// Load the stats
						$cmd->execute();
						
						echo "<table style=\"width: 100%;\">
								<tr>
									<th>User</th>
									<th style=\"text-align: center;\">Total&nbsp;Views</th>
								</tr>";

						if ($result = $cmd->get_result()) {
							while ($row = $result->fetch_object()) {
								// Got a result
								?>
								<tr>
									<td>
										<a class="navloader" href="<?php echo $row->userlink ?>"><span class="badge bg-secondary"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $row->username ?></span></a>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($row->viewcount) ?>
									</td>
								</tr>
								<?php
							}
						}
						
						echo "</table><br/><br/>";
					?>
				</div>
				
				<div class="col-12 col-md-6 m-0 p-0">
					<h3>Most Imported Users</h3>
					<?php
						$sql =
							"SELECT U.username, CONCAT('https://ktdash.app/u/', U.username) AS userlink, SUM(importcount) AS importcount
							FROM Roster R
							INNER JOIN User U ON U.userid = R.userid
							WHERE R.userid NOT IN ('prebuilt')
							GROUP BY U.username, CONCAT('https://ktdash.app/u/', U.username)
							ORDER BY SUM(importcount) DESC
							LIMIT 10;";
						$cmd = $dbcon->prepare($sql);
						
						// Load the stats
						$cmd->execute();
						
						echo "<table style=\"width: 100%;\">
								<tr>
									<th>User</th>
									<th style=\"text-align: center;\">Total&nbsp;Imports</th>
								</tr>";

						if ($result = $cmd->get_result()) {
							while ($row = $result->fetch_object()) {
								// Got a result
								?>
								<tr>
									<td>
										<a class="navloader" href="<?php echo $row->userlink ?>"><span class="badge bg-secondary"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $row->username ?></span></a>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($row->importcount) ?>
									</td>
								</tr>
								<?php
							}
						}
						
						echo "</table><br/><br/>";
					?>
				</div>
				
				<div class="col-12 col-md-6 m-0 p-0">
					<h3>Most Spotlighted Users</h3>
					<?php
						$sql =
							"SELECT U.username, CONCAT('https://ktdash.app/u/', U.username) AS userlink, COUNT(DISTINCT R.rosterid) AS spotlightcount
							FROM Roster R
							INNER JOIN User U ON U.userid = R.userid
							WHERE R.userid NOT IN ('prebuilt') AND R.spotlight = 1
							GROUP BY U.username, CONCAT('https://ktdash.app/u/', U.username)
							ORDER BY COUNT(DISTINCT R.rosterid) DESC
							LIMIT 10;";
						$cmd = $dbcon->prepare($sql);
						
						// Load the stats
						$cmd->execute();
						
						echo "<table style=\"width: 100%;\">
								<tr>
									<th>User</th>
									<th style=\"text-align: center;\">Spotlight&nbsp;Count</th>
								</tr>";

						if ($result = $cmd->get_result()) {
							while ($row = $result->fetch_object()) {
								// Got a result
								?>
								<tr>
									<td>
										<a class="navloader" href="<?php echo $row->userlink ?>"><span class="badge bg-secondary"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $row->username ?></span></a>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($row->spotlightcount) ?>
									</td>
								</tr>
								<?php
							}
						}
						
						echo "</table><br/><br/>";
					?>
				</div>
			</div>
			<br/>
			<hr/>
			
			<!-- KillTeam Stats -->
			<div class="row m-0 m-0 p-0">
				<h2 class="col-12 m-0 p-0 text-center">KillTeam Stats</h2>
				
				<div class="col-12 col-md-6 m-0 p-0">
					<h3>Most Rosters</h3>
					<?php
						$sql =
							"SELECT KT.killteamname, CONCAT('https://ktdash.app/fa/', KT.factionid, '/kt/', KT.killteamid) AS killteamlink, SUM(CASE WHEN R.rosterid IS NULL THEN 0 ELSE 1 END) AS rostercount, SUM(R.spotlight) AS spotlightcount
							FROM Killteam KT
							LEFT JOIN Roster R
							ON  R.factionid = KT.factionid AND R.killteamid = KT.killteamid AND R.rostername != 'Sample Team: Intercessors'
							GROUP BY KT.killteamname, KT.factionid, KT.killteamid
							ORDER BY SUM(CASE WHEN R.rosterid IS NULL THEN 0 ELSE 1 END) DESC;";
						$cmd = $dbcon->prepare($sql);
						
						// Load the stats
						$cmd->execute();
						
						echo "<table style=\"width: 100%;\">
								<tr>
									<th>KillTeam</th>
									<th style=\"text-align: center;\">Total&nbsp;Rosters</th>
									<th style=\"text-align: center;\">Spotlight&nbsp;Count</th>
								</tr>";

						if ($result = $cmd->get_result()) {
							while ($row = $result->fetch_object()) {
								// Got a result
								?>
								<tr>
									<td>
										<a class="navloader" href="<?php echo $row->killteamlink ?>"><?php echo $row->killteamname ?></a>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($row->rostercount) ?>
									</td>
									<td style="text-align: center;">
										<?php echo number_format($row->spotlightcount) ?>
									</td>
								</tr>
								<?php
							}
						}
						
						echo "</table><br/><br/>";
					?>
				</div>
			</div>
			
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>