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
		<style>
		<?php include "css/styles.css"; ?>
		</style>
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
						echo "\r\n<!-- " . floor(microtime(true) * 1000) . " - Get UserCounts -->\r\n";
						$cmd->execute();
						echo "\r\n<!-- " . floor(microtime(true) * 1000) . " - Got UserCounts -->\r\n";
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
					echo "\r\n<!-- " . floor(microtime(true) * 1000) . " - Get Totals -->\r\n";
					$cmd->execute();
					echo "\r\n<!-- " . floor(microtime(true) * 1000) . " - Got Totals -->\r\n";
					
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
					$sql = "SELECT CAST(datestamp AS Date) AS Date, SUM(CASE WHEN action = 'signup' THEN 1 ELSE 0 END) AS SignupCount, COUNT(DISTINCT userip) AS UserCount, COUNT(DISTINCT userip) AS UserCount, SUM(CASE WHEN eventtype = 'page' THEN 1 ELSE 0 END) AS PageViews FROM Event WHERE userip != '68.80.166.102' AND datestamp > DATE_ADD(CURDATE(), INTERVAL -7 day) GROUP BY CAST(datestamp AS Date) ORDER BY 1 DESC;";
					$cmd = $dbcon->prepare($sql);
					
					// Load the stats
					echo "\r\n<!-- " . floor(microtime(true) * 1000) . " - Get Stats -->\r\n";
					$cmd->execute();
					echo "\r\n<!-- " . floor(microtime(true) * 1000) . " - Got Stats -->\r\n";
					
					echo "<table style=\"width: 100%;\">";
					echo "<tr><th>Date</th><th style=\"text-align: right;\">S</th><th style=\"text-align: right;\">U</th><th style=\"text-align: right;\">P</th></tr>";

					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							?>
							<tr>
								<th><?php echo $row->Date ?></th>
								<td style="text-align: right;"><?php echo number_format($row->SignupCount) ?></td>
								<td style="text-align: right;"><?php echo number_format($row->UserCount) ?></td>
								<td style="text-align: right;"><?php echo number_format($row->PageViews) ?></td>
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
					$sql = "
						SELECT E.maxdatestamp AS datestamp, R.factionid, R.killteamid, KT.killteamname, R.hascustomportrait AS rosterportrait, COUNT(RO.opid) AS opcount, SUM(RO.hascustomportrait) AS opportraitcount, U.username, U.userid, R.rosterid, R.rostername, R.spotlight
						FROM 
						(
							SELECT MAX(datestamp) AS maxdatestamp, userid, var1 FROM Event WHERE action IN ('portrait', 'opportrait') AND userip != '68.80.166.102' AND label = 'custom'
							GROUP BY userid, var1
							ORDER BY 1 DESC LIMIT 40
						) E
						INNER JOIN User U ON U.userid = E.userid
						INNER JOIN Roster R ON R.rosterid = E.var1
						INNER JOIN RosterOperative RO ON RO.userid = R.userid AND RO.rosterid = R.rosterid
						INNER JOIN Killteam KT ON KT.factionid = R.factionid AND KT.killteamid = R.killteamid
						GROUP BY E.maxdatestamp, U.username, U.userid, R.rosterid, R.hascustomportrait, R.rostername, R.spotlight, R.factionid, R.killteamid, KT.killteamname
						ORDER BY 1 DESC LIMIT 40;";
					$cmd = $dbcon->prepare($sql);
						
					// Load the stats
					echo "\r\n<!-- " . floor(microtime(true) * 1000) . " - Get Portraits -->\r\n";
					$cmd->execute();
					echo "\r\n<!-- " . floor(microtime(true) * 1000) . " - Got Portraits -->\r\n";
					
					echo "<div>";
					if ($result = $cmd->get_result()) {
						while ($row = $result->fetch_object()) {
							// Got a result
							?>
							<strong><?php echo $row->datestamp ?></strong><br/>
							<div class="ps-3">
							<?php
							if ($row->spotlight == 1) {
							?>
								<i class="fas fa-star fa-fw text-small" data-bs-toggle="tooltip" data-bs-placement="top" title="Spotlight"></i>
							<?php
							}
							?>
							<h6 class="d-inline"><a href="/r/<?php echo $row->rosterid ?>/g" target="_blank"><?php echo $row->rostername ?></a></h6>
							(<?php echo number_format($row->rosterportrait) ?> &nbsp;&nbsp;&nbsp; <?php echo number_format($row->opportraitcount) ?>/<?php echo number_format($row->opcount) ?>)
							<br/>
							<a href="/fa/<?php echo $row->factionid ?>/kt/<?php echo $row->killteamid ?>" target="_blank"><?php echo $row->killteamname ?></a>
							by&nbsp;<a class="navloader" href="/u/<?php echo $row->username ?>"><span class="badge bg-secondary"><i class="fas fa-user fa-fw"></i>&nbsp;<?php echo $row->username ?></span></a>
							</div>
							<?php
						}
					}
					echo "</div>"
				?>
			</div>
			<br/>
			
			<!-- Event Log -->
			<?php if (false) {?>
				<div class="line-top-light">
					<h2>Event Log</h2>
					<?php
						$sql = "SELECT * FROM EventLogView WHERE ActionLog != '' AND userip != '68.80.166.102' ORDER BY 1 DESC LIMIT 200";
						$cmd = $dbcon->prepare($sql);
							
						// Load the stats
						echo "\r\n<!-- " . floor(microtime(true) * 1000) . " - Get Events -->\r\n";
						$cmd->execute();
						echo "\r\n<!-- " . floor(microtime(true) * 1000) . " - Got Events -->\r\n";

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
			<?php
			}
			?>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>