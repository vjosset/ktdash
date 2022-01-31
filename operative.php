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
	
	// Get the requested killteam id
	$killteamid = $_REQUEST['killteamid'];
	if ($killteamid == null || $killteamid == '') {
		$killteamid = $_REQUEST['ktid'];
	}
	if ($killteamid == null || $killteamid == '') {
		$killteamid = $_REQUEST['kt'];
	}
	
	// Get the requested fireteam id
	$fireteamid = $_REQUEST['fireteamid'];
	if ($fireteamid == null || $fireteamid == '') {
		$fireteamid = $_REQUEST['ftid'];
	}
	if ($fireteamid == null || $fireteamid == '') {
		$fireteamid = $_REQUEST['ft'];
	}
	
	// Get the requested operative id
	$opid = $_REQUEST['opid'];
	if ($opid == null || $opid == '') {
		$opid = $_REQUEST['op'];
	}
	
	// Get the requested operative name
	$opname = $_REQUEST['opname'];
	
	// Get the requested weapons list
	$weps = $_REQUEST['weps'];
	
	$faction = Faction::GetFaction($factionid);
	$killteam = KillTeam::GetKillTeam($factionid, $killteamid);
	$fireteam = FireTeam::GetFireTeam($factionid, $killteamid, $fireteamid);
	$op = Operative::GetOperative($factionid, $killteamid, $fireteamid, $opid);
	
	// Check for name override
	if ($opname != "" && $opname != null) {
		$op->optype = $op->opname;
		$op->opname = $opname;
	}
	
	// Now select the weapons
	if ($weps != '' && $weps != null) {
		$wepids = explode(',', $weps);
		
		for ($wepnum = count($op->weapons) - 1; $wepnum >= 0; $wepnum--) {
			if (!in_array($op->weapons[$wepnum]->wepid, $wepids)) {
				// This weapon is not in the list of selected weapons - Remove it
				array_splice($op->weapons, $wepnum, 1);
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = $op->opname;
		$pagedesc  = $op->description;
		$pageimg   = "https://ktdash.app/img/portraits/$factionid/$killteamid/$fireteamid/$opid.jpg";
		$pageurl   = "https://ktdash.app/operative.php?fa=$factionid&kt=$killteamid&ft=$fireteamid&op=$opid";
		
		include "og.php"
		?>
	</head>
	<body>
		<script type="text/javascript">
			trackEvent("compendium", "operative", <?php echo '"' . "$factionid/$killteamid/$fireteamid/$opid" . '"' ?>);
		</script>
		
		<a name="<?= $op->opid ?>"></a>
		<center>
			<div style="max-width: 450px;">
				<div class="card border-light shadow dark">
					
					<!-- Portrait -->
					<img class="card-img-top" src="/img/portraits/<?= "$factionid/$killteamid/$fireteamid/$opid" ?>.jpg" style="max-height: 220px; min-height: 220px; object-position: center top; object-fit: cover;" />
					
					<div class="card-title dark p-1">
						<div class="text-center cinzel dark">
							<h4><?= $op->opname ?></h4>
							<?php 
							if ($op->optype != "" && $op->optype != null) {
								?>
									<em class="oswald small"><?= $op->optype ?></em>
								<?php
							}
							?>
						</div>
					</div>
					
					<!-- Characteristics/Stats -->
					<center>
						<table width="100%" class="text-center cinzel">
							<tr class="h3 orange">
								<td width="16%">M</td>
								<td width="16%">APL</td>
								<td width="16%">GA</td>
								<td width="16%">DF</td>
								<td width="16%">SV</td>
								<td width="16%">W</td>
							</tr>
							<tr class="h3">
								<td><?= replaceDistance($op->M) ?></td>
								<td><?= replaceDistance($op->APL) ?></td>
								<td><?= replaceDistance($op->GA) ?></td>
								<td><?= replaceDistance($op->DF) ?></td>
								<td>&nbsp;<?= replaceDistance($op->SV) ?></td>
								<td><?= replaceDistance($op->W) ?></td>
							</tr>
						</table>
					</center>
					
					<!-- Weapons List-->
					<table class="m-1">
						<tr class="h6 cinzel line-top-light">
							<td>
								Weapons
							</td>
							<td class="text-center">
								&nbsp;&nbsp;A&nbsp;&nbsp;
							</td>
							<td class="text-center">
								&nbsp;&nbsp;BS&nbsp;&nbsp;
							</td>
							<td class="text-center">
								&nbsp;&nbsp;D&nbsp;&nbsp;
							</td>
						</tr>
						<tbody class="oswald">
							<?php
								foreach ($op->weapons as $wep) {
									if (count($wep->profiles) < 2) {
										// Single profile
										?>
										<tr>
											<td>
												<?= $wep->weptype == "R" ? "&#x2295;" : "&#x2694;" ?> 
												<?= $wep->wepname ?>
												<div class="d-inline" style="font-style:italic;">
													<?php
													if ($wep->profiles[0]->SR != "") {
														echo "(" . replacedistance($wep->profiles[0]->SR) . ")";
													}
													?>
												</div>
											</td>
											<td class="text-center h5">
												&nbsp;&nbsp;<?= $wep->profiles[0]->A ?>&nbsp;&nbsp;
											</td>
											<td class="text-center h5">
												&nbsp;&nbsp;&nbsp;<?= $wep->profiles[0]->BS ?>&nbsp;&nbsp;
											</td>
											<td class="text-center h5">
												&nbsp;&nbsp;<?= $wep->profiles[0]->D ?>&nbsp;&nbsp;
											</td>
										</tr>
										<?php
									} else {
										// Multi profile
										?>
										<tr>
											<td colspan="4">
												<?= $wep->weptype == "R" ? "&#x2295;" : "&#x2694;" ?> 
												<?= $wep->wepname ?>
											</td>
										</tr>
										<?php
										foreach ($wep->profiles as $pro) {
											?>
											<tr>
												<td>
													&nbsp;&nbsp;&nbsp;&nbsp;
													- <?= $pro->name ?>
													<div class="d-inline" style="font-style:italic;">
														<?php
														if ($pro->SR != "") {
															echo "(" . replacedistance($pro->SR) . ")";
														}
														?>
													</div>
												</td>
												<td class="text-center h5">
													&nbsp;&nbsp;<?= $pro->A ?>&nbsp;&nbsp;
												</td>
												<td class="text-center h5">
													&nbsp;&nbsp;&nbsp;<?= $pro->BS ?>&nbsp;&nbsp;
												</td>
												<td class="text-center h5">
													&nbsp;&nbsp;<?= $pro->D ?>&nbsp;&nbsp;
												</td>
											</tr>
											<?php
										}
									}
								}
							?>
						</tbody>
					</table>
					
					<?php
					if (count($op->abilities) > 0) {
						?>
							<!-- Abilities -->
							<div class="m-1 text-start">
								<h6 class="cinzel line-top-light">Abilities</h6>
								<?php
									foreach ($op->abilities as $ab) {
										?>
											<div class="oswald">
												<?= $ab->title ?>
											</div>	
										<?php
									}
								?>
							</div>
						<?php
					}
					?>
					
					<?php
					if (count($op->uniqueactions) > 0) {
						?>
							<!-- Unique Actions -->
							<div class="m-1 text-start">
								<h6 class="cinzel line-top-light">Unique Actions</h6>
								<?php
									foreach ($op->uniqueactions as $ua) {
										?>
											<div class="oswald">
												<?= $ua->title ?> (<?= $ua->AP?> AP)
											</div>	
										<?php
									}
								?>
							</div>
						<?php
					}
					?>
					
					<!-- Keywords -->
					<div class="m-1 line-top-light small text-start">
						<em class="small"><?= htmlspecialchars($op->keywords) ?></em>
					</div>
				</div>
			</div>
		</center>
	</body>
</html>


	