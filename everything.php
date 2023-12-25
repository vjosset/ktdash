<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;

	$ktids = ["IMP|INTS", "IMP|PHO", "IMP|HKS", "ORK|KOM", "NEC|HIER", "TYR|HF"];
	$factions = [];

	foreach($ktids as $ktid) {
		$f = explode("|", $ktid)[0];
		$k = explode("|", $ktid)[1];

		$faction = Faction::GetFaction($f);
		$killteam = Killteam::GetKillTeam($f, $k);
		$faction->killteams[] = $killteam;

		$factions[] = $faction;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = "Everything";
		$pagedesc  = "Everything";
		$pagekeywords = "Compendium," . $faction->factionname;
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
	<body ng-app="kt" ng-controller="ktCtrl">
		<?php include "topnav.shtml" ?>

		<?php
			foreach ($factions as $faction) {
				foreach($faction->killteams as $killteam) {
					echo "<a href=\"#$faction->factionid|$killteam->killteamid\">$killteam->killteamname</a> | ";
				}
			}
			echo "<hr/>";
		?>
			<!-- table -->
				<?php
					foreach ($factions as $faction) {
						foreach($faction->killteams as $killteam) {
							echo "<a name=\"$faction->factionid|$killteam->killteamid\" \>";
							echo "<h3>$faction->factionname : $killteam->killteamname</h3>\r\n";
							echo "<h5>Operatives</h5>\r\n";
							echo "<div style=\"columns: 450px;\">";

							foreach($killteam->fireteams as $fireteam) {
								foreach($fireteam->operatives as $op) {
									echo "<table style=\"width: 100%;\">\r\n";
									echo "<tr class=\"line-top-light\">\r\n";
									echo "<th></th>\r\n";
									echo "<th class=\"text-center\">APL</th>\r\n";
									echo "<th class=\"text-center\">M</th>\r\n";
									echo "<th class=\"text-center\">GA</th>\r\n";
									echo "<th class=\"text-center\">DF</th>\r\n";
									echo "<th class=\"text-center\">SV</th>\r\n";
									echo "<th class=\"text-center\">W</th>\r\n";
									echo "</tr>\r\n";

									echo "<tr>\r\n";
									echo "<th><h5>$op->opname</h5></th>\r\n";
									echo "<td class=\"text-center\">$op->APL</td>\r\n";
									echo "<td class=\"text-center\">" . str_replace("[CIRCLE]", "", $op->M) . "</td>\r\n";
									echo "<td class=\"text-center\">$op->GA</td>\r\n";
									echo "<td class=\"text-center\">$op->DF</td>\r\n";
									echo "<td class=\"text-center\">$op->SV</td>\r\n";
									echo "<td class=\"text-center\">$op->W</td>\r\n";
									echo "</tr>\r\n";
									
									echo "<tr>\r\n";
									echo "<th colspan=\"4\">Weapon</th>\r\n";
									echo "<th class=\"text-center\">A</th>\r\n";
									echo "<th class=\"text-center\">BS</th>\r\n";
									echo "<th class=\"text-center\">D</th>\r\n";
									echo "</tr>\r\n";

									foreach($op->weapons as $wep) {
										if (count($wep->profiles) == 1) {
											$pro = $wep->profiles[0];
											echo "<tr>\r\n";
											echo "<td colspan=\"4\">[$wep->weptype] $wep->wepname ($pro->SR)</td>\r\n";
											echo "<td class=\"text-center\">$pro->A</td>\r\n";
											echo "<td class=\"text-center\">$pro->BS</td>\r\n";
											echo "<td class=\"text-center\">$pro->D</td>\r\n";
											echo "</tr>\r\n";
										} else {
											echo "<tr>\r\n";
											echo "<td colspan=\"7\">[$wep->weptype] $wep->wepname ($pro->SR)</td>\r\n";
											echo "</tr>\r\n";
											foreach($wep->profiles as $pro) {
												echo "<tr>\r\n";
												echo "<td colspan=\"4\">&nbsp;&nbsp;&nbsp;&nbsp;$pro->name ($pro->SR)</td>\r\n";
												echo "<td class=\"text-center\">$pro->A</td>\r\n";
												echo "<td class=\"text-center\">$pro->BS</td>\r\n";
												echo "<td class=\"text-center\">$pro->D</td>\r\n";
												echo "</tr>\r\n";
											}
										}
									}
									foreach($op->abilities as $ab) {
										$ab->description = preg_replace('/<em[\s\S]+?\/em>/', '', $ab->description);
										$ab->description = preg_replace('/<i[\s\S]+?\/i>/', '', $ab->description);
										echo "<tr>\r\n";
										echo "<td colspan=\"10\">\r\n";
										echo "<strong>$ab->title:</strong> " . substr($ab->description, 0, 400);
										echo "</td>";
										echo "</tr>\r\n";
									}
									foreach($op->uniqueactions as $ua) {
										$ua->description = preg_replace('/<em[\s\S]+?\/em>/', '', $ua->description);
										$ua->description = preg_replace('/<i[\s\S]+?\/i>/', '', $ua->description);
										echo "<tr>\r\n";
										echo "<td colspan=\"10\">\r\n";
										echo "<strong>$ua->title ($ua->AP AP):</strong> " . substr($ua->description, 0, 400);
										echo "</td>";
										echo "</tr>\r\n";
									}
									echo "</tr>\r\n";
									echo "</table><br/><br/>\r\n";
								}
							}
							echo "</div>\r\n";
							echo "<hr/>\r\n";
							echo "<h5>Equipment</h5>\r\n";
							echo "<div style=\"columns: 450px;\">";
							foreach($killteam->equipments as $eq) {
								if ($eq->eqcategory != "Battle Honour" && $eq->eqcategory != "Rare Equipment" && $eq->eqcategory != "Battle Scar")
								echo "<strong>$eq->eqname</strong> ($eq->eqpts EP)<br/>$eq->eqdescription<br/>\r\n";
							}
							echo "</div><br/><br/><hr/><br/><br/>\r\n";
						}
					}
				?>
			<!-- /table -->
	</body>
</html>