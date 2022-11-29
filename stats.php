<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	$me = Session::CurrentUser();
	if ($me == null || $me->userid != 'vince') {
		// They shouldn't be here
		header('HTTP/1.0 403 Not Authorized');
		header("Location: https://ktdash.app/rosters.php");
		die();
	}
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
			$pageurl   = "https://ktdash.app/stats.php";
			include "og.php";
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl">
		<?php
			include "topnav.shtml";
		?>
		
		<div class="orange container-fluid">
			<div class="row">
				<h1 class="col-6 m-0 p-1">
					<a class="navloader" onclick="window.location.reload();">Stats</a>
				</h1>
				<h1 class="col-6 m-0 p-1 text-end h2">
					<!-- Activity -->
					<?php
						$sql = "SELECT COUNT(DISTINCT userid, userip) AS UserCount30Minute, COUNT(*) AS EventCount30Minute FROM Event WHERE userip != '68.80.166.102' AND datestamp > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -30 minute);";
						$cmd = $dbcon->prepare($sql);
						
						// Load the stats
						$cmd->execute();

						if ($result = $cmd->get_result()) {
							while ($row = $result->fetch_object()) {
								// Got a result
								?>
								<i class="fas fa-users"></i> <?php echo number_format($row->UserCount30Minute) ?>
								<i class="fas fa-bolt"></i> <?php echo number_format($row->EventCount30Minute) ?>
								<?php
							}
						}
					?>
				</h1>
			</div>
			<span class="small p-0"><?php echo date("Y-m-d H:i:s") ?></span>
		</div>
		
		<div class="p-2">
			<!-- Totals -->
			<div>
				<h2>Totals</h2>
				<?php
					$sql =
						"SELECT 'Users' AS CountType, COUNT(*) AS Count FROM User WHERE userid NOT IN ('prebuilt', 'vince') UNION
						SELECT 'Rosters', COUNT(*) AS RosterCount FROM Roster WHERE userid NOT IN ('prebuilt', 'vince') UNION
						SELECT 'RosterOps', COUNT(*) AS RosterOpCount FROM RosterOperative WHERE userid NOT IN ('prebuilt', 'vince')";
					$cmd = $dbcon->prepare($sql);
					
					// Load the stats
					$cmd->execute();
					
					echo "<table style=\"width: 100%;\">";

					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							?>
							<tr><th><?php echo $row->CountType ?></th><td style="text-align: right;"><?php echo number_format($row->Count) ?></td></tr>
							<?php
						}
					}
					
					echo "</table>";
				?>
			</div>
			<br/>
			
			<!-- Signups -->
			<div class="line-top-light">
				<h2>Stats</h2>
				<?php
					$sql = "SELECT CAST(datestamp AS Date) AS Date, SUM(CASE WHEN action = 'signup' THEN 1 ELSE 0 END) AS SignupCount, COUNT(DISTINCT userip) AS UserCount FROM Event WHERE userip != '68.80.166.102' GROUP BY CAST(datestamp AS Date) ORDER BY 1 DESC;";
					$cmd = $dbcon->prepare($sql);
					
					// Load the stats
					$cmd->execute();
					
					echo "<table style=\"width: 100%;\">";
					echo "<tr><th>Date</th><th style=\"text-align: right;\">Signups</th><th style=\"text-align: right;\">Users</th></tr>";

					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							?>
							<tr>
								<th><?php echo $row->Date ?></th>
								<td style="text-align: right;"><?php echo number_format($row->SignupCount) ?></td>
								<td style="text-align: right;"><?php echo number_format($row->UserCount) ?></td>
							</tr>
							<?php
						}
					}
					
					echo "</table>";
				?>
			</div>
			<br/>
			
			<!-- Recent Portraits (Data) -->
			<div class="line-top-light">
				<h2>Recent Portraits</h2>
				<?php
					$sql = "SELECT MAX(datestamp) AS datestamp, COUNT(*) AS Count, var1, url FROM Event WHERE action IN ('portrait', 'opportrait') AND userip != '68.80.166.102' AND label = 'custom' GROUP BY var1, url ORDER BY 1 DESC LIMIT 20";
					$cmd = $dbcon->prepare($sql);
						
					// Load the stats
					$cmd->execute();
					
					echo "<table style=\"width: 100%;\">";

					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							?>
							<tr>
								<th><?php echo $row->datestamp ?></th>
								<td style="text-align: right;"><?php echo number_format($row->Count) ?>&nbsp;&nbsp;&nbsp;</td>
								<td><a href="/rostergallery.php?rid=<?php echo $row->var1 ?>" target="_blank"><?php echo $row->var1 ?></td>
							</tr>
							<?php
						}
					}
					
					echo "</table>";
				?>
			</div>
			<br/>
			
			<!-- Event Log -->
			<div class="line-top-light">
				<h2>Event Log</h2>
				<?php
					$sql = "SELECT * FROM EventLogView WHERE ActionLog != '' AND userid != 'vince' ORDER BY 1 DESC LIMIT 200";
					$cmd = $dbcon->prepare($sql);
						
					// Load the stats
					$cmd->execute();

					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							?>
							<strong><?php echo explode(' ', $row->datestamp)[1] ?></strong><br/>
							<?php echo $row->ActionLog ?><br/>
							<?php
						}
					}
				?>
			</div>
			
			<!-- Recent Portraits (Pictures) -->
			<div class="line-top-light m-0 p-0 d-none">
				<h2>Recent Portraits</h2>
				<div class="row m-0 p-0">
				<?php
					//$sql = "SELECT datestamp, action, userid, var1, var2, var1 FROM Event WHERE action IN ('portrait', 'opportrait') AND userip != '68.80.166.102' AND label = 'custom' ORDER BY 1 DESC LIMIT 50";
					//$cmd = $dbcon->prepare($sql);
						
					// Load the stats
					//$cmd->execute();

					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							if ($row->action == 'opportrait') {
								// Operative
								?>
								<!-- div class="col-12 col-md-6 col-lg-4 col-xl-3 pointer" style="overflow: hidden;">
									<a href="/roster.php?rid=<?php //echo $row->var1 ?>" target="_blank">
										<h4><?php //echo $row->datestamp ?></h4>
										<img
											src="/api/operativeportrait.php?roid=<?php //echo $row->var2 ?>"
											style="height: 100%; width: 100%; min-height: 150px; max-height: 400px; object-fit:cover; object-position:50% 0%; display:block;" />
									</a>
								</div -->
								<?php
							} else{
								// Roster
								?>
								<!-- div class="col-12 col-md-6 col-lg-4 col-xl-3 pointer" style="overflow: hidden;">
									<a href="/roster.php?rid=<?php //echo $row->var1 ?>" target="_blank">
										<h4><?php //echo $row->datestamp ?></h4>
										<img
											src="/api/rosterportrait.php?rid=<?php //echo $row->var1 ?>"
											style="height: 100%; width: 100%; min-height: 150px; max-height: 400px; object-fit:cover; object-position:50% 0%; display:block;" />
									</a>
										</a>
								</div -->
								<?php
							}
						}
					}
				?>
				</div>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>